---
phase: 02
phase_name: Skeleton Pages & Design Integration
extracted: 2026-09-08
sources:
  - .planning/phases/02-skeleton-pages/02-CONTEXT.md
  - .planning/ROADMAP.md
  - .planning/STATE.md
  - .planning/MILESTONE-CONTEXT.md
  - .planning/design.md
  - .planning/KNOWLEDGE.md
  - .planning/research/STACK.md
  - .planning/research/FEATURES.md
  - .planning/research/ARCHITECTURE.md
  - .planning/research/PITFALLS.md
  - .planning/research/SUMMARY.md
  - .planning/DECISIONS.md
---

# Phase 02: Skeleton Pages & Design Integration — Research

## Don't Hand-Roll

### Don't Build a Custom Markdown Parser
- **Use Parsedown or CommonMark** — both are well-maintained PHP markdown parsers. Parsedown is the CI4 community standard.
- **Why:** Rolling a markdown parser introduces security risks (XSS via raw HTML in markdown) and maintenance burden. Parsedown has been battle-tested in CI4 projects.
- **Source:** CI4 documentation, Parsedown GitHub

### Don't Build a Custom Locale Filter from Scratch
- **Use CI4's filter system** — create a class implementing `CodeIgniter\Filters\FilterInterface`. CI4 provides the `before()` and `after()` methods.
- **Why:** CI4's filter system is the standard mechanism for cross-cutting concerns. Custom filters are automatically registered and applied to route groups.
- **Source:** CI4 4.7.4 routing documentation — Controller Filters section

### Don't Manually Maintain CSS Custom Properties
- **Auto-generate tokens.css from design.md** — parse the `:root` CSS block and write it to a standalone file.
- **Why:** Manual maintenance risks drift between design.md and actual CSS. Auto-generation ensures consistency and makes design updates trivial.
- **Source:** design.md section 1 (Design Tokens), CI4 view rendering docs

### Don't Use `{locale}` as a Custom Regex Placeholder
- **`{locale}` is a CI4 reserved placeholder** for localization — it cannot be used in custom route definitions.
- **Why:** CI4 reserves `{locale}` for its built-in localization system. Using it as a custom placeholder causes undefined behavior.
- **Source:** CI4 4.7.4 routing docs — Placeholders section: "Note: `{locale}` cannot be used as a placeholder or other part of the route, as it is reserved for use in localization."

### Don't Render Markdown at Runtime for Static Pages
- **Pre-render during deploy** — convert markdown to static HTML as a build step, not on each request.
- **Why:** Runtime markdown conversion adds PHP overhead per request. For a static company profile site, pre-rendering eliminates this overhead and makes the site CDN-friendly.
- **Source:** v1.0 ideation (Idea #3: Markdown-to-HTML Pre-Render Pipeline), PITFALLS.md

## Common Pitfalls

### 1. Locale Filter Not Applied to All Routes
- **Risk:** If the locale filter is only applied to some routes, pages without the filter won't have locale set, causing inconsistent behavior.
- **Mitigation:** Apply the locale filter to the entire locale route group, not individual routes.
- **Confidence:** HIGH — CI4 filter application to route groups is standard

### 2. OpenLitespeed Static Cache Serving Wrong Locale
- **Risk:** OpenLitespeed's static page cache may serve a cached page for one locale to requests for another locale.
- **Mitigation:** Since locale is in the URL path (`/id/`, `/en/`), OpenLitespeed's cache should naturally vary by URL. Verify during testing.
- **Confidence:** MEDIUM — needs validation on actual VPS

### 3. Hreflang Tags Drift Across 36 Page Variants
- **Risk:** With 7 pages × 6 languages = 36 page variants, hreflang tags must be correct for all. Manual maintenance is error-prone.
- **Mitigation:** Auto-generate hreflang tags in the layout template based on the content manifest and supported locales.
- **Confidence:** HIGH — design.md section 5.2 specifies hreflang requirements

### 4. Design Token Drift Between design.md and CSS
- **Risk:** CSS custom properties in main.css may drift from design.md tokens when design updates are made.
- **Mitigation:** Auto-generate tokens.css from design.md as a pre-deploy step.
- **Confidence:** HIGH — identified in v1.0 ideation and PITFALLS.md

### 5. `{locale}` Reserved Placeholder Conflict
- **Risk:** Using `{locale}` in custom route definitions causes CI4 routing errors.
- **Mitigation:** Only use `{locale}` in route groups (`$routes->group('{locale}', ...)`), never in custom route definitions.
- **Confidence:** HIGH — CI4 4.7.4 routing docs confirm this

## Existing Patterns in This Codebase

### Static-First Architecture
- Markdown content files in `app/Views/pages/{halaman}/{bahasa}.md`
- CI4 views as templates — no CMS, no database
- Git-based deployment (pull from GitHub)
- Source: `01-CONTEXT.md`, `01-PLAN.md`, `PROJECT.md`

### Decoupled Local/Production Architecture
- `php spark serve` for local dev, OpenLitespeed + PHP-FPM for VPS
- Different web servers for each environment
- Source: DEC-001, `01-CONTEXT.md`

### CI4 Standard Patterns
- Route definitions in `app/Config/Routes.php`
- Filters registered in `app/Config/Filters.php`
- Views in `app/Views/` with layout templates in `layouts/`
- Controllers extending `BaseController`
- Source: CI4 4.7.4 documentation, existing codebase

### Design Token Integration
- CSS custom properties in `:root` defined in design.md
- All colors via `var(--*)` — no hardcoded hex values
- Source: design.md section 1, `01-LEARNINGS.md`

## Recommended Approach

### Multilingual Routing (REQ-008)
1. Create `app/Filters/Locale.php` implementing `FilterInterface`
2. `before()` method: validate locale segment against `['id', 'en', 'zh', 'fr', 'es', 'ja']`, redirect to `/id/` if invalid, call `$request->setLocale($locale)`
3. Register filter alias in `app/Config/Filters.php`
4. In `Routes.php`: `$routes->get('/', function() { return redirect()->to('/id/'); })` for root redirect
5. In `Routes.php`: `$routes->group('{locale}', ['filter' => 'locale'], function ($routes) { ... })` for all page routes
6. Update `App.php`: `$supportedLocales = ['id', 'en', 'zh', 'fr', 'es', 'ja']`

### Static Page Templates (REQ-009)
1. Create layout template `app/Views/layouts/main.php` with header, navbar, content area, footer
2. Create page views in `app/Views/pages/` for each page (home, history, vision-mission, services, contact, portfolio, investor)
3. Each page view uses the layout template and renders content for the current locale
4. Controller `Home.php` has methods for each page (index, history, visionMission, services, contact, portfolio, investor)
5. Controller reads markdown file, converts via Parsedown, passes HTML to view
6. Pre-render during deploy: `php spark render:pages` converts all markdown to static HTML in `public/content/`

### Design Integration (REQ-010)
1. Create `public/assets/css/tokens.css` from design.md `:root` block
2. Create `public/assets/css/main.css` with reset, layout, and token imports
3. Create `public/assets/css/components.css` with button, card, form, nav styles per design.md
4. Create `public/assets/css/pages.css` for page-specific styles
5. Create `public/assets/css/responsive.css` with breakpoint media queries
6. Create `php spark design:sync` command to auto-generate tokens.css from design.md
7. Include CSS files in layout template via `base_url('assets/css/main.css')`

### Dependencies
1. REQ-008 (multilingual routing) → before REQ-009 (pages need locale-aware routing)
2. REQ-010 (design integration) → before REQ-009 (templates need design tokens)
3. All three are interdependent — implement together in a single phase