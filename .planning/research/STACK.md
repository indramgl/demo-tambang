# STACK.md — v2.0 Research

**Researched:** 2026-09-08
**Scope:** v2.0 Skeleton Pages & Design Integration

## Technology Stack (Verified)

### PHP 8.4 + CodeIgniter 4
- **CI4 v4.7.4** (latest stable as of 2026-09)
- **PHP requirement:** ^8.2 (PHP 8.4 is compatible)
- **Confidence:** HIGH — verified via CI4 composer.json on GitHub

### CI4 Multilingual Routing
- **Route groups with `{locale}`:** CI4 supports `$routes->group('{locale}', ...)` for locale-prefixed routing
- **`{locale}` is a reserved placeholder** — cannot be used as a custom regex placeholder
- **Locale filter:** Custom filter can validate locale against supported list
- **`url_to()` helper** supports locale as the last parameter since v4.3.0
- **Confidence:** HIGH — confirmed via CI4 4.7.4 routing documentation

### CI4 Localization
- **`app/Config/App.php`** has `$supportedLocales`, `$defaultLocale`, `$negotiateLocale`
- **`app/Language/`** directory for language files (messages, validation, etc.)
- **CI4 Language class** loads language files by locale
- **Confidence:** HIGH — standard CI4 feature

### Design Integration
- **CSS custom properties** from design.md `:root` — applied via `public/assets/css/main.css`
- **Revolut Design System 2.0** tokens: colors, typography, spacing, border-radius, elevation
- **Mobile-first responsive:** 4 breakpoints (400px, 720px, 1024px, 1280px)
- **Flat design:** No shadows, no bold headings, pill buttons
- **Confidence:** HIGH — design.md is comprehensive and CI4 views support CSS custom properties natively

### Static Page Templates
- **CI4 view rendering:** `return view('pages/home', $data)` renders `app/Views/pages/home.php`
- **Layout templates:** `$this->include('layouts/main')` for shared header/footer
- **Markdown rendering:** Parsedown/CommonMark for converting `.md` content to HTML
- **View decorator pattern:** CI4 supports view decorators for layout wrapping
- **Confidence:** HIGH — standard CI4 view system

### VPS Deployment
- **IDCloudhost** — Ubuntu 26.04, OpenLitespeed, PHP-FPM
- **Deployment:** Git pull from GitHub `master`
- **SSL:** Let's Encrypt
- **Domain:** tambang.indramgl.web.id
- **Confidence:** HIGH — same stack as v1.0

## Key Decisions
- Local dev: `php spark serve` (not OpenLitespeed)
- Production: OpenLitespeed + PHP-FPM on VPS
- CI4 `.htaccess` works on OpenLitespeed without modification
- Multilingual routing via `{locale}` route group
- Static content: markdown files in `app/Views/pages/{halaman}/{bahasa}.md`
- Design tokens as CSS custom properties in `:root`

## Confidence Levels
- CI4 multilingual routing: HIGH
- CI4 localization: HIGH
- Design token integration: HIGH
- Static page templates: HIGH
- VPS deployment: HIGH