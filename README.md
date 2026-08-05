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
