# Mid City Home Restoration — Custom PHP Website

## Local run

### Recommended
```bash
./start-local.sh
```
Then open `http://127.0.0.1:8000/`.

### Manual
```bash
php -S 127.0.0.1:8000 router.php
```
Run the command inside this website folder. The site also auto-detects a subfolder base path when served from Apache/XAMPP/MAMP.

## Configuration
Set these server environment variables (see `.env.example`):
- `SITE_URL=https://midcityhr.com`
- `CLICKUP_LIST_ID=901110957130`
- `CLICKUP_API_TOKEN=<new token>`
- `LEAD_TO_EMAIL=info@midcityhr.com`
- `MAIL_FROM=website@midcityhr.com`
- `BASE_PATH` only when auto-detection is not suitable

Do not put the ClickUp token in JavaScript, HTML, Git, or a public repository. Configure PHP mail/SMTP on the hosting server for reliable email delivery. The built-in `mail()` function is used as the transport hook.

## Forms
Every lead form:
1. Validates required fields and CSRF token.
2. Creates a ClickUp task when credentials are configured.
3. Sends a branded HTML lead email.
4. Writes delivery status to `data/leads.ndjson` as a fallback/audit log.

## Deployment
Upload the contents of this folder to the domain document root. Apache users can retain `.htaccess`. Confirm PHP cURL is enabled and configure outgoing mail or SMTP at the host.

## Email delivery setup

The lead endpoint now sends two SMTP messages for each valid form submission:

1. An internal lead notification to `LEAD_TO_EMAIL`.
2. A branded confirmation email to the customer.

The PHPMailer-compatible autoloader is required by `api/lead.php`. Do not remove `vendor/autoload.php`.

Recommended production environment values:

```text
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_ENCRYPTION=tls
SMTP_USERNAME=info@midcityhr.com
SMTP_PASSWORD=your_16_character_google_app_password
MAIL_FROM=info@midcityhr.com
LEAD_TO_EMAIL=info@midcityhr.com
```

For Google Workspace/Gmail, `SMTP_USERNAME` and `MAIL_FROM` should normally be the same mailbox that generated the App Password. The account must have 2-Step Verification enabled.

Form delivery results and SMTP error messages are appended to `data/leads.ndjson`. Protect this file from public access.
