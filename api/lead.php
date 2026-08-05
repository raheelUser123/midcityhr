<?php
declare(strict_types=1);

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../includes/functions.php';

use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok'=>false,'message'=>'Method not allowed']);
    exit;
}

if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
    http_response_code(403);
    echo json_encode(['ok'=>false,'message'=>'Please refresh and try again.']);
    exit;
}
if (!empty($_POST['website'])) {
    echo json_encode(['ok'=>true,'message'=>'Thank you.']);
    exit;
}

$lead = [
    'name'=>trim($_POST['name'] ?? ''),
    'phone'=>trim($_POST['phone'] ?? ''),
    'email'=>filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL),
    'service'=>trim($_POST['service'] ?? 'General inquiry'),
    'address'=>trim($_POST['address'] ?? ''),
    'message'=>trim($_POST['message'] ?? ''),
    'timeline'=>trim($_POST['timeline'] ?? ''),
    'budget'=>trim($_POST['budget'] ?? ''),
    'contact_method'=>trim($_POST['contact_method'] ?? 'Phone'),
    'context'=>trim($_POST['context'] ?? 'Website form'),
];

if (!$lead['name'] || !$lead['phone'] || !$lead['email'] || !$lead['message']) {
    http_response_code(422);
    echo json_encode(['ok'=>false,'message'=>'Please complete all required fields.']);
    exit;
}

$description = "Name: {$lead['name']}\nPhone: {$lead['phone']}\nEmail: {$lead['email']}\nService: {$lead['service']}\nAddress: {$lead['address']}\nTimeline: {$lead['timeline']}\nBudget: {$lead['budget']}\nPreferred contact: {$lead['contact_method']}\n\nProject details:\n{$lead['message']}";
$cfg = config();
$delivery = ['clickup'=>false, 'admin_email'=>false, 'customer_email'=>false];
$errors = [];

if (!empty($cfg['clickup']['token']) && !empty($cfg['clickup']['list_id'])) {
    $payload = json_encode([
        'name'=>"Website lead — {$lead['name']} — {$lead['service']}",
        'description'=>$description,
        'tags'=>['website-lead']
    ]);
    $ch = curl_init('https://api.clickup.com/api/v2/list/'.rawurlencode($cfg['clickup']['list_id']).'/task');
    curl_setopt_array($ch, [
        CURLOPT_POST=>true,
        CURLOPT_RETURNTRANSFER=>true,
        CURLOPT_TIMEOUT=>12,
        CURLOPT_HTTPHEADER=>['Authorization: '.$cfg['clickup']['token'], 'Content-Type: application/json'],
        CURLOPT_POSTFIELDS=>$payload
    ]);
    $body = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    $delivery['clickup'] = $status >= 200 && $status < 300;
    if (!$delivery['clickup']) {
        $errors['clickup'] = trim("HTTP {$status} {$curlError} {$body}");
        error_log('ClickUp lead failure: '.$errors['clickup']);
    }
}

/** @throws Throwable */
function makeMailer(array $cfg): PHPMailer {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = (string)($cfg['mail']['host'] ?? 'smtp.gmail.com');
    $mail->Port = (int)($cfg['mail']['port'] ?? 587);
    $mail->SMTPAuth = true;
    $mail->Username = (string)($cfg['mail']['username'] ?? '');
    $mail->Password = (string)($cfg['mail']['password'] ?? '');
    $encryption = strtolower((string)($cfg['mail']['encryption'] ?? 'tls'));
    $mail->SMTPSecure = $encryption === 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
    $mail->CharSet = 'UTF-8';
    $mail->Timeout = 20;
    $mail->setFrom(
        (string)($cfg['mail']['from_email'] ?? $cfg['email']),
        (string)($cfg['mail']['from_name'] ?? 'Midcity Handyman & Remodeling')
    );
    return $mail;
}

if (empty($cfg['mail']['username']) || empty($cfg['mail']['password'])) {
    $errors['smtp_config'] = 'SMTP username or password is empty.';
    error_log('SMTP configuration failure: '.$errors['smtp_config']);
} else {
    try {
        $mail = makeMailer($cfg);
        $mail->addAddress((string)$cfg['email'], 'Midcity Handyman & Remodeling');
        $mail->addReplyTo((string)$lead['email'], (string)$lead['name']);
        $mail->isHTML(true);
        $mail->Subject = 'New website lead: '.$lead['name'].' — '.($lead['service'] ?: 'General inquiry');
        $mail->Body = render_email_template($lead);
        $mail->AltBody = $description;
        $delivery['admin_email'] = $mail->send();
    } catch (Throwable $e) {
        $errors['admin_email'] = $e->getMessage();
        error_log('SMTP admin email failure: '.$e->getMessage());
    }

    try {
        $customerMail = makeMailer($cfg);
        $customerMail->addAddress((string)$lead['email'], (string)$lead['name']);
        $customerMail->addReplyTo((string)$cfg['email'], 'Midcity Handyman & Remodeling');
        $customerMail->isHTML(true);
        $customerMail->Subject = 'We received your project request — Midcity Handyman & Remodeling';
        $customerMail->Body = render_customer_email_template($lead);
        $customerMail->AltBody = "Hi {$lead['name']},\n\nWe received your {$lead['service']} request. Our team will review it and contact you to arrange the next step.\n\nCall 1-833-RENO-MHR if you need immediate assistance.";
        $delivery['customer_email'] = $customerMail->send();
    } catch (Throwable $e) {
        $errors['customer_email'] = $e->getMessage();
        error_log('SMTP customer email failure: '.$e->getMessage());
    }
}

$log = [
    'time'=>date(DATE_ATOM),
    'lead'=>$lead,
    'delivery'=>$delivery,
    'errors'=>$errors
];
file_put_contents(__DIR__.'/../data/leads.ndjson', json_encode($log, JSON_UNESCAPED_SLASHES).PHP_EOL, FILE_APPEND|LOCK_EX);

if (!$delivery['clickup'] && !$delivery['admin_email']) {
    http_response_code(502);
    echo json_encode(['ok'=>false,'message'=>'Your request could not be delivered. Please call us directly.']);
    exit;
}

$_SESSION['csrf'] = bin2hex(random_bytes(24));
echo json_encode([
    'ok'=>true,
    'message'=>$delivery['customer_email']
        ? 'Thanks — your request was received and a confirmation email was sent.'
        : 'Thanks — your request was received. Our team will contact you shortly.'
]);
