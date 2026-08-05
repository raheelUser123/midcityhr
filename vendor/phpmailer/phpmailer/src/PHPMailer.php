<?php
namespace PHPMailer\PHPMailer;

/**
 * Small PHPMailer-compatible SMTP transport used by this website.
 * It implements only the methods/properties the project calls.
 */
class PHPMailer
{
    public const ENCRYPTION_STARTTLS = 'tls';
    public const ENCRYPTION_SMTPS = 'ssl';

    public string $Host = 'localhost';
    public int $Port = 25;
    public bool $SMTPAuth = false;
    public string $Username = '';
    public string $Password = '';
    public string $SMTPSecure = '';
    public string $CharSet = 'UTF-8';
    public string $Subject = '';
    public string $Body = '';
    public string $AltBody = '';
    public string $ErrorInfo = '';
    public int $Timeout = 25;
    public bool $SMTPDebug = false;

    private bool $useSmtp = false;
    private bool $isHtml = false;
    private array $from = ['', ''];
    private array $to = [];
    private array $replyTo = [];
    private bool $exceptions;

    public function __construct(bool $exceptions = false)
    {
        $this->exceptions = $exceptions;
    }

    public function isSMTP(): void
    {
        $this->useSmtp = true;
    }

    public function isHTML(bool $isHtml = true): void
    {
        $this->isHtml = $isHtml;
    }

    public function setFrom(string $address, string $name = ''): bool
    {
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            return $this->fail('Invalid From email address.');
        }
        $this->from = [$address, $name];
        return true;
    }

    public function addAddress(string $address, string $name = ''): bool
    {
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            return $this->fail('Invalid recipient email address.');
        }
        $this->to[] = [$address, $name];
        return true;
    }

    public function addReplyTo(string $address, string $name = ''): bool
    {
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            return $this->fail('Invalid reply-to email address.');
        }
        $this->replyTo[] = [$address, $name];
        return true;
    }

    public function clearAllRecipients(): void
    {
        $this->to = [];
    }

    public function clearReplyTos(): void
    {
        $this->replyTo = [];
    }

    public function send(): bool
    {
        try {
            if (!$this->useSmtp) {
                throw new Exception('SMTP transport is not enabled.');
            }
            if ($this->from[0] === '' || $this->to === []) {
                throw new Exception('Sender and at least one recipient are required.');
            }
            $this->smtpSend();
            $this->ErrorInfo = '';
            return true;
        } catch (\Throwable $e) {
            $this->ErrorInfo = $e->getMessage();
            if ($this->exceptions) {
                throw $e instanceof Exception ? $e : new Exception($e->getMessage(), 0, $e);
            }
            return false;
        }
    }

    private function smtpSend(): void
    {
        $host = trim($this->Host);
        if ($host === '') {
            throw new Exception('SMTP host is empty.');
        }

        $transport = strtolower($this->SMTPSecure) === self::ENCRYPTION_SMTPS ? 'ssl://' : '';
        $socket = @stream_socket_client(
            $transport . $host . ':' . $this->Port,
            $errno,
            $errstr,
            $this->Timeout,
            STREAM_CLIENT_CONNECT
        );
        if (!is_resource($socket)) {
            throw new Exception("SMTP connection failed: {$errstr} ({$errno})");
        }

        stream_set_timeout($socket, $this->Timeout);
        try {
            $this->expect($socket, [220]);
            $helo = $_SERVER['SERVER_NAME'] ?? gethostname() ?: 'localhost';
            $this->command($socket, 'EHLO ' . $helo, [250]);

            if (strtolower($this->SMTPSecure) === self::ENCRYPTION_STARTTLS) {
                $this->command($socket, 'STARTTLS', [220]);
                $cryptoOk = @stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
                if ($cryptoOk !== true) {
                    throw new Exception('Could not enable TLS encryption.');
                }
                $this->command($socket, 'EHLO ' . $helo, [250]);
            }

            if ($this->SMTPAuth) {
                $this->command($socket, 'AUTH LOGIN', [334]);
                $this->command($socket, base64_encode($this->Username), [334], false);
                $this->command($socket, base64_encode($this->Password), [235], false);
            }

            $this->command($socket, 'MAIL FROM:<' . $this->from[0] . '>', [250]);
            foreach ($this->to as [$address]) {
                $this->command($socket, 'RCPT TO:<' . $address . '>', [250, 251]);
            }
            $this->command($socket, 'DATA', [354]);

            $message = $this->buildMessage();
            $message = preg_replace('/(?m)^\./', '..', $message) ?? $message;
            fwrite($socket, $message . "\r\n.\r\n");
            $this->expect($socket, [250]);
            $this->command($socket, 'QUIT', [221]);
        } finally {
            fclose($socket);
        }
    }

    private function buildMessage(): string
    {
        $headers = [];
        $headers[] = 'Date: ' . date(DATE_RFC2822);
        $headers[] = 'From: ' . $this->formatMailbox($this->from[0], $this->from[1]);
        $headers[] = 'To: ' . implode(', ', array_map(fn(array $r): string => $this->formatMailbox($r[0], $r[1]), $this->to));
        if ($this->replyTo !== []) {
            $headers[] = 'Reply-To: ' . implode(', ', array_map(fn(array $r): string => $this->formatMailbox($r[0], $r[1]), $this->replyTo));
        }
        $headers[] = 'Subject: ' . $this->encodeHeader($this->Subject);
        $headers[] = 'Message-ID: <' . bin2hex(random_bytes(12)) . '@' . ($_SERVER['SERVER_NAME'] ?? 'localhost') . '>';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-Type: ' . ($this->isHtml ? 'text/html' : 'text/plain') . '; charset=' . $this->CharSet;
        $headers[] = 'Content-Transfer-Encoding: 8bit';
        $headers[] = 'X-Mailer: URDigital Tech SMTP Mailer';

        $body = str_replace(["\r\n", "\r"], "\n", $this->Body);
        $body = str_replace("\n", "\r\n", $body);
        return implode("\r\n", $headers) . "\r\n\r\n" . $body;
    }

    private function formatMailbox(string $email, string $name): string
    {
        return $name === '' ? '<' . $email . '>' : $this->encodeHeader($name) . ' <' . $email . '>';
    }

    private function encodeHeader(string $value): string
    {
        if ($value === '' || preg_match('/^[\x20-\x7E]*$/', $value)) {
            return str_replace(["\r", "\n"], '', $value);
        }
        return '=?UTF-8?B?' . base64_encode(str_replace(["\r", "\n"], '', $value)) . '?=';
    }

    private function command($socket, string $command, array $expected, bool $logCommand = true): string
    {
        if ($this->SMTPDebug && $logCommand) {
            error_log('SMTP C: ' . $command);
        }
        fwrite($socket, $command . "\r\n");
        return $this->expect($socket, $expected);
    }

    private function expect($socket, array $expected): string
    {
        $response = '';
        while (($line = fgets($socket, 515)) !== false) {
            $response .= $line;
            if (strlen($line) < 4 || $line[3] === ' ') {
                break;
            }
        }
        if ($response === '') {
            throw new Exception('SMTP server returned an empty response.');
        }
        $code = (int) substr($response, 0, 3);
        if (!in_array($code, $expected, true)) {
            throw new Exception('SMTP error ' . $code . ': ' . trim($response));
        }
        if ($this->SMTPDebug) {
            error_log('SMTP S: ' . trim($response));
        }
        return $response;
    }

    private function fail(string $message): bool
    {
        $this->ErrorInfo = $message;
        if ($this->exceptions) {
            throw new Exception($message);
        }
        return false;
    }
}
