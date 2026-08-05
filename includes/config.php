<?php
return [
    'site_name' => 'Midcity Handyman & Remodeling',
    'site_url' => getenv('SITE_URL') ?: 'https://midcityhr.com',

    'phone' => '+1 (833) 736-6647',
    'phone_href' => '+18337366647',

    'email' => getenv('LEAD_TO_EMAIL') ?: 'info@midcityhr.com',

    'mail' => [
        'host' => getenv('SMTP_HOST') ?: 'smtp.gmail.com',
        'port' => getenv('SMTP_PORT') ?: 587,
        'username' => getenv('SMTP_USERNAME') ?: 'info@midcityhr.com',
        'password' => getenv('SMTP_PASSWORD') ?: 'pspjjiedbrytucsg', // Google App Password
        'encryption' => getenv('SMTP_ENCRYPTION') ?: 'tls',
        'from_email' => getenv('MAIL_FROM') ?: 'info@midcityhr.com',
        'from_name' => 'Midcity Handyman & Remodeling',
    ],
    'mail_from' => getenv('MAIL_FROM') ?: 'info@midcityhr.com',

    'clickup' => [
        'token' => getenv('CLICKUP_API_TOKEN') ?: 'pk_87315537_KLOCR5UYJQE40QBQCZZ06WXGOR2GGVUS',
        'list_id' => getenv('CLICKUP_LIST_ID') ?: '901110957130',
    ],
];