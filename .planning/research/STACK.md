# STACK.md — v1.0 Research

**Researched:** 2026-09-08
**Scope:** v1.0 Setup & Scaffold capabilities

## Technology Stack (Verified)

### PHP 8.5 + CodeIgniter 4
- **CI4 v4.7.4** (latest stable as of 2026-09)
- **PHP requirement:** ^8.2 (PHP 8.5 is compatible)
- **Confidence:** HIGH — verified via CI4 composer.json on GitHub

### OpenLitespeed + PHP-FPM
- **OpenLitespeed** supports Apache `mod_rewrite` syntax
- CI4's `.htaccess` works on OpenLitespeed with no modification
- **Confidence:** HIGH — OpenLitespeed is LiteSpeed Enterprise's open-source variant; rewrite module is Apache-compatible

### Local Development
- **`php spark serve`** — CI4 built-in PHP development server
- Serves on `localhost:8080` by default
- No web server configuration needed for local dev
- **Confidence:** HIGH — standard CI4 CLI command

### VPS Deployment
- **IDCloudhost** — Ubuntu 26.04, OpenLitespeed, PHP-FPM
- **Deployment:** Git pull from GitHub `master`
- **SSL:** Let's Encrypt
- **Domain:** tambang.indramgl.web.id

### Database
- **SQLite** (optional, contact form only)
- No relational database needed for v1.0

### Email
- **Postmark** (`wildbit/postmark-php`) — for contact form (Phase 4)
- Not needed for v1.0

## Key Decisions
- Local dev: `php spark serve` (not OpenLitespeed)
- Production: OpenLitespeed + PHP-FPM on VPS
- CI4 `.htaccess` works on OpenLitespeed without modification