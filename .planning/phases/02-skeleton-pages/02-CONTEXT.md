# Phase 02: Skeleton Pages & Design Integration - Context

**Gathered:** 2026-09-19
**Mode:** deep
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
- **CI4 view rendering** — no pre-render during deploy
- `Home::page()` calls `view("pages/{$view}", ['title' => $title, 'locale' => $locale])`
- Remove `getRenderedContent()` method and `public/content/` directory entirely
- Remove `RenderPages` command
- OpenLitespeed page cache + CI4 page cache for performance

### Layout Section Rendering
- **Fix `main.php`** — replace `<?= $content ?>` with `<?= $this->renderSection('content') ?>`
- Remove `$content` variable from `Home::page()` parameters
- All child views (home.php, history.php, etc.) use `$this->section('content')` and `$this->endSection()`
- `footer.php` remains simple static footer

### Design Token Integration
- **Auto-generate `tokens.css`** from design.md `:root` block via CLI command (`php spark design:sync`)
- **Extended to typography tokens** — extract font-size, font-weight, line-height, letter-spacing from design.md section 1.2 table into tokens.css
- **Extended to elevation tokens** — extract `--shadow-none`, `--shadow-focus`, `--shadow-raised` from design.md section 1.5 (despite anti-shadow rule, tokens available for future design changes)
- `tokens.css` included in `public/assets/css/main.css`
- Single source of truth: design.md → tokens.css → main.css
- Sync runs as Composer `post-install-cmd` or pre-deploy hook
- Update `pages.css` to use `var(--*)` references for typography values (replace hardcoded font-size, font-weight, line-height, letter-spacing)

### Navbar Language Switcher
- **`localeUrl()` method on `Home` controller** — uses CI4 `URI` class to swap locale segment while preserving current path
- `navbar.php` calls `localeUrl('en')`, `localeUrl('zh')`, etc.
- Correct URL generation: `/id/current-path` → `/en/current-path`

### Page Structure
- **Flat `.php` views are canonical** — `app/Views/pages/home.php`, `history.php`, etc. contain all page layout and content
- **Markdown subdirectories kept as reference** — `app/Views/pages/*/*/page.md` are documentation only, not used in rendering
- **Implement about page** — `tentang` slug, route `/id/tentang`, add to PAGE_MAP, create `app/Views/pages/about.php`
- **Remove empty `about/` markdown subdirectories** — no `page.md` files exist

### Controller Refactoring
- **Full refactor of `Home::page()`** with slug validation
- Unknown slugs throw `PageNotFound` exception
- Remove `getRenderedContent()` entirely
- `Home::page(string $slug)` validates against PAGE_MAP, returns 404 if not found

### Caching Strategy
- **CI4 page cache** (`$this->cache`) alongside OpenLitespeed page cache
- Two-layer caching: CI4 application-level cache + OpenLitespeed reverse proxy cache
- Cache invalidation on content change via CI4 cache clearing

### About Page
- **Slug:** `tentang` (Indonesian kebab-case following convention: sejarah, visi-misi, layanan)
- **Route:** `$routes->get('tentang', 'Home::page/about')` in Routes.php
- **PAGE_MAP entry:** `'about' => ['Tentang Kami', 'about']`
- **View:** `app/Views/pages/about.php` following same pattern as other pages

### 404 Handling
- Unknown slugs throw `CodeIgniter\Exceptions\PageNotFoundException`
- Custom 404 view can be added later if needed

</decisions>

<specifics>
## Specific Ideas

- Switch from pre-render markdown to CI4 view rendering — user chose this over pre-render for simpler architecture
- Keep markdown files as reference documentation — not deleted, not used in pipeline
- Fix `main.php` layout bug (`<?= $content ?>` → `<?= $this->renderSection('content') ?>`)
- Extend DesignSync for full typography coverage — prevents drift between design.md and CSS
- Elevation tokens extracted but currently unused per anti-shadow rule — kept for future flexibility
- `tentang` as about page slug — follows Indonesian naming convention
- `localeUrl()` controller method for clean navbar language switching
- CI4 page cache + OpenLitespeed two-layer caching — addresses concern about losing static page cache performance

</specifics>

<canonical_refs>
## Canonical References

**Downstream agents MUST read these before planning or implementing.**

- `.planning/ROADMAP.md` — v2.0 Phase 1 tasks and dependencies
- `.planning/design.md` — Design tokens, components, layout specs, CI4 implementation notes
- `.planning/DECISIONS.md` — DEC-001 (decoupled local/prod architecture)
- `.planning/research/STACK.md` — CI4 multilingual routing and localization research
- `.planning/research/ARCHITECTURE.md` — Multilingual routing architecture
- `.planning/research/PITFALLS.md` — Known pitfalls for locale filter, default locale, hreflang, design token drift
- `.planning/phases/02-skeleton-pages/02-DISCUSSION-LOG.md` — Full discussion log with all alternatives considered

</canonical_refs>

<code_context>
## Existing Code Insights

### Current Routes.php
- `$routes->group('{locale}', ['filter' => 'locale'], ...)` with locale filter applied
- Routes map URL slugs to `Home::page/{slug}` (e.g., `sejarah` → `Home::page/history`)
- Root URL redirects to `/id/`
- Missing: `tentang` route for about page

### Current Home.php
- `PAGE_MAP` has 7 entries: home, history, vision-mission, services, contact, portfolio, investor
- `getRenderedContent()` reads from `public/content/{page}/{locale}.html` — to be removed
- Needs refactoring: remove getRenderedContent(), add slug validation, throw PageNotFound for unknown slugs

### Current Layout (main.php)
- Uses `<?= $content ?>` — **BUG**: should be `<?= $this->renderSection('content') ?>`
- `navbar.php` uses broken hreflang URL generation with `ltrim(service('uri')->getPath(), '/')`
- `footer.php` is simple static footer

### Current CSS
- `tokens.css` — colors, spaces, radii (via DesignSync) — needs typography and elevation
- `main.css` — reset, base typography, container, section spacing — imports tokens.css
- `components.css` — buttons, cards, nav, form fields — uses CSS custom properties
- `pages.css` — page-specific sections (hero, timeline, services, portfolio, etc.) — has hardcoded typography values
- `responsive.css` — tablet (720px) and mobile (400px) breakpoints

### Current Commands
- `DesignSync` — extracts tokens from design.md to tokens.css — needs extension for typography/elevation
- `RenderPages` — pre-renders markdown to HTML — to be removed (no longer needed)

### Current Views
- 7 flat `.php` views: home.php, history.php, vision-mission.php, services.php, contact.php, portfolio.php, investor.php
- All use `$this->extend('layouts/main')` and `$this->section('content')`
- All have inline hardcoded content with locale checks
- Missing: `about.php` (to be created)

### Markdown Subdirectories
- `app/Views/pages/*/*/page.md` — placeholder content, kept as reference
- `app/Views/pages/about/` subdirectories exist but are empty (no page.md files) — to be removed

### Established Patterns
- Static-first architecture (now via CI4 views instead of pre-rendered HTML)
- Git-based deployment
- Decoupled local/prod architecture
- CSS custom properties via tokens.css

### Integration Points
- `Home::page()` connects routes → controller → views
- `Locale.php` filter connects routing → locale validation
- `DesignSync` command connects design.md → tokens.css
- `navbar.php` connects `localeUrl()` → language switcher URLs
- OpenLitespeed page cache connects → CI4 page cache layer

</code_context>

<deferred>
## Deferred Ideas

- Contact form with Postmark email — Phase 4 feature
- SQLite database for contact messages — Phase 4 feature
- Admin panel — out of scope
- Portfolio/IR content creation — v3
- Design iteration after skeleton — design.md frozen after v2.0
- VPS deployment (REQ-004) — blocked on VPS provisioning
- `public/content/` directory cleanup — obsolete after switching to CI4 view rendering
- `RenderPages` command removal — no longer needed
- `page.md` markdown reference files — kept but not used

</deferred>

---
*Phase: 02-skeleton-pages*
*Context gathered: 2026-09-19*
