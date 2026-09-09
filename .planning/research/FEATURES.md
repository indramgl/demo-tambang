# FEATURES.md — v2.0 Research

**Researched:** 2026-09-08
**Scope:** v2.0 Skeleton Pages & Design Integration

## New Features for v2.0

### REQ-008: Multilingual Routing
- **What:** CI4 routes handle `/id/`, `/en/`, `/zh/`, `/fr/`, `/es/`, `/ja/` URL segments
- **How:** `$routes->group('{locale}', ['filter' => 'locale'], ...)` in `app/Config/Routes.php`
- **Locale filter:** Custom filter validates locale against `['id', 'en', 'zh', 'fr', 'es', 'ja']`
- **Default locale:** Indonesian (`id`) for root URL `/`
- **Language switcher:** Navbar component with links that preserve current page, change locale segment
- **Hreflang tags:** Auto-generated in `<head>` based on current page and locale
- **Source:** design.md section 5, CI4 routing docs

### REQ-009: Static Page Templates
- **What:** CI4 views render markdown content as HTML pages with consistent layout
- **How:** Controller reads markdown file, converts via Parsedown/CommonMark, passes to view
- **Layout:** `layouts/main.php` wraps all pages with header, navbar, content, footer
- **Partials:** `hero.php`, `breadcrumb.php`, `features.php`, `cta.php` reusable components
- **Per-page views:** `home.php`, `history.php`, `vision-mission.php`, `services.php`, `contact.php`, `portfolio.php`, `investor.php`
- **Source:** design.md section 4, CI4 view docs

### REQ-010: Design Integration
- **What:** Apply design.md from OpenDesign to CI4 views/templates
- **How:** CSS custom properties from design.md `:root` in `public/assets/css/main.css`
- **Components:** Buttons (pill, primary, secondary, outlined, ghost), Cards (flat, 20px radius), Navigation, Form fields
- **Layout:** Container with max-width 1180px, responsive breakpoints, section spacing
- **Typography:** Inter font family, defined sizes/weights per design.md tokens
- **Source:** design.md sections 1-8

## Feature Dependencies
- REQ-008 (multilingual routing) → REQ-009 (page templates need locale-aware routing)
- REQ-010 (design integration) → REQ-009 (templates need design tokens to render correctly)
- All three are interdependent — implement together in a single phase

## Out of Scope for v2.0
- Contact form logic (Phase 4)
- Database/SQLite (Phase 4)
- Admin panel
- Portfolio/IR content creation (placeholder only)
- VPS deployment