# Phase 02: Skeleton Pages & Design Integration - Context

**Gathered:** 2026-09-08
**Mode:** standard
**Status:** Ready for planning

<domain>
## Phase Boundary

CI4 app serves skeleton pages with multilingual routing — all 7 pages accessible in all 6 languages via URL path (`/id/`, `/en/`, etc.). Design.md tokens and components applied to CI4 views. Static HTML pre-rendered during deploy for OpenLitespeed serving.

</domain>

<decisions>
## Implementation Decisions

### Locale Filter Implementation
- **Custom filter class** in `app/Filters/Locale.php` that validates the locale segment against `['id', 'en', 'zh', 'fr', 'es', 'ja']`
- Invalid locales redirect to `/id/` with HTTP 302
- Filter sets CI4 locale via `$request->setLocale()` after validation
- Registered as alias in `app/Config/Filters.php`
- Applied to locale route group in `app/Config/Routes.php`

### Default Locale Redirect
- Route-level redirect from `/` to `/id/` in `Routes.php`
- `$routes->get('/', function() { return redirect()->to('/id/'); })`
- Keeps `$defaultLocale = 'en'` in App.php (CI4 default) — redirect handles the primary locale

### View Rendering Pipeline
- **Pre-render during deploy** — markdown files converted to static HTML during the deploy step
- OpenLitespeed serves static HTML files directly, bypassing PHP for page renders
- Deploy script includes a `php spark render:pages` command that reads markdown, converts via Parsedown, writes to `public/content/`
- No runtime markdown conversion — pure static serving

### Design Token Integration
- **Auto-generate `tokens.css`** from design.md `:root` block via CLI command (`php spark design:sync`)
- `tokens.css` included in `public/assets/css/main.css`
- Single source of truth: design.md → tokens.css → main.css
- Sync runs as Composer `post-install-cmd` or pre-deploy hook

</decisions>

<specifics>
## Specific Ideas

- Pre-render markdown to static HTML during deploy — user chose this over runtime conversion for performance
- Auto-generate tokens.css from design.md — user chose this over manual CSS maintenance for consistency
- Route-level redirect for root URL — user chose this over setting `$defaultLocale = 'id'` in App.php
- Custom filter class for locale validation — user chose this over controller-level validation or Content Negotiation

</specifics>

<canonical_refs>
## Canonical References

- `.planning/ROADMAP.md` — v2.0 Phase 1 tasks and dependencies
- `.planning/MILESTONE-CONTEXT.md` — v2.0 milestone goals and constraints
- `.planning/design.md` — Design tokens, components, layout specs, CI4 implementation notes
- `.planning/DECISIONS.md` — DEC-001 (decoupled local/prod architecture)
- `.planning/KNOWLEDGE.md` — Patterns, lessons, and anti-patterns from v1.0
- `.planning/research/STACK.md` — CI4 multilingual routing and localization research
- `.planning/research/ARCHITECTURE.md` — Multilingual routing architecture
- `.planning/research/PITFALLS.md` — Known pitfalls for locale filter, default locale, hreflang, design token drift

</canonical_refs>

<code_context>
## Existing Code Insights

### Current Routes.php
- Only `$routes->get('/', 'Home::index')` — no locale routing, no filters
- Need to add locale group and redirect route

### Current App.php
- `$defaultLocale = 'en'`, `$negotiateLocale = false`, `$supportedLocales = ['en']`
- Need to update `$supportedLocales` to include all 6 languages
- Root URL redirect handles primary locale (id) instead of changing defaultLocale

### Current Controllers
- `BaseController.php` — empty `initController()`, no shared rendering logic
- `Home.php` — only `index()` method returning `view('welcome_message')`
- Need `renderPage()` method for skeleton page rendering (or pre-render approach)

### Current Views
- `app/Views/welcome_message.php` — CI4 default welcome page
- `app/Views/pages/` — directory exists with language subdirs (from v1.0)
- No layout templates (`layouts/`, `partials/`) yet
- No `public/assets/` directory yet

### Current Assets
- No `public/assets/css/` or `public/assets/js/` directories
- No `main.css`, `components.css`, `pages.css`, `responsive.css` yet

### Established Patterns
- Static-first architecture (markdown content, CI4 views as templates)
- Git-based deployment (pull from GitHub)
- Multilingual directory structure (`app/Views/pages/{halaman}/{bahasa}.md`)
- Decoupled local/prod architecture (php spark serve vs OpenLitespeed)

</code_context>

<deferred>
## Deferred Ideas

- Contact form with Postmark email — Phase 4 feature, not in v2.0 scope
- SQLite database for contact messages — Phase 4 feature, not in v2.0 scope
- Admin panel — explicitly out of scope
- Portfolio/IR content creation — placeholder only, content comes in v3
- Design iteration after skeleton — design.md frozen after v2.0
- VPS deployment (REQ-004) — blocked on VPS provisioning

</deferred>

---
*Phase: 02-skeleton-pages*
*Context gathered: 2026-09-08*