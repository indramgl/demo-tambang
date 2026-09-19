---
phase: 2
phase_name: Skeleton Pages & Design Integration
extracted: 2026-09-19
sources:
  - .planning/phases/02-skeleton-pages/02-CONTEXT.md
  - .planning/STATE.md
  - .planning/ROADMAP.md
  - design.md
  - .planning/DECISIONS.md
  - .planning/solutions/best-practices/controller-refactoring-and-test-quality-2026-09-19.md
  - .planning/solutions/integration-issues/missing-content-pipeline-2026-09-19.md
  - .planning/solutions/ui-bugs/css-class-contract-break-2026-09-19.md
  - CI4 Docs: Views (https://codeigniter.com/user_guide/outgoing/views.html)
  - CI4 Docs: View Layouts (https://codeigniter.com/user_guide/outgoing/view_layouts.html)
  - CI4 Docs: Web Page Caching (https://codeigniter.com/user_guide/general/caching.html)
  - CI4 Docs: Working with URIs (https://codeigniter.com/user_guide/libraries/uri.html)
  - app/Controllers/Home.php, app/Views/layouts/main.php, app/Config/Routes.php, app/Commands/DesignSync.php, public/assets/css/tokens.css, public/assets/css/pages.css, app/Config/Filters.php, app/Filters/Locale.php
---

# Phase 02: Skeleton Pages & Design Integration — Research

**Phase goal:** CI4 app serves 7 skeleton pages in 6 languages via URL path routing, with design.md tokens applied to CI4 views. Rendering pipeline switches from pre-render markdown to CI4 view rendering.

---

## Don't Hand-Roll

| Problem | Recommended solution | Why |
|---------|---------------------|-----|
| Layout section rendering | Use `$this->renderSection('content')` in `main.php` layout | CI4's native layout system handles section injection. `<?= $content ?>` is a bug — it expects a PHP variable that is never set when views use `$this->section('content')`. The CI4 docs confirm `renderSection()` is the correct method for layout placeholders. |
| Page caching | Use `$this->cachePage($seconds)` in controller + CI4 `PageCache` filter | CI4 has built-in per-page caching via `$this->cachePage()`. The `PageCache` filter is already aliased in `Filters.php` and listed in `$required`. No need to build a custom cache layer. |
| Locale URL swapping | Use CI4 `URI` class (`service('uri')`) to get current path, swap segment 1 | The `URI` class provides `getSegment()`, `setPath()`, and `getPath()` methods. Building URLs manually with string concatenation is fragile. The CI4 URI class handles encoding, baseURL resolution, and segment manipulation correctly. |
| Typography/elevation token extraction | Extend `DesignSync` command with `extractTableTokens()` calls for sections 1.2 and 1.5 | `DesignSync` already has `extractTableTokens()` for space (1.3) and radius (1.4) tokens. The same method can be reused for typography table (1.2) and elevation table (1.5) by passing the correct section number and regex patterns. |
| View rendering pipeline | Use `view("pages/{$view}", ['title' => $title, 'locale' => $locale])` — no `getRenderedContent()`, no `public/content/` | CI4's `view()` function natively renders PHP templates. The pre-render pipeline (markdown → HTML files) is unnecessary complexity. The deep discussion confirmed CI4 view rendering as the canonical approach. |

---

## Common Pitfalls

### 1. Layout Bug: `<?= $content ?>` vs `<?= $this->renderSection('content') ?>`

**What goes wrong:** `main.php` uses `<?= $content ?>` but child views use `$this->section('content')` / `$this->endSection()`. In CI4's layout system, `$content` is never a defined variable — content is injected via `renderSection()`. This means all page content renders as empty.

**Why:** CI4 view layouts use `renderSection()` as a placeholder method on the layout view, and `section()`/`endSection()` blocks in child views. The `$content` variable pattern is from a different templating system, not CI4.

**How to avoid:** Replace `<?= $content ?>` with `<?= $this->renderSection('content') ?>` in `main.php`. Remove `'content' => $content` from the controller's `view()` call parameters. Verify all child views use `$this->section('content')` and `$this->endSection()`.

### 2. Removing `RenderPages` and `public/content/` Without Cleaning Up References

**What goes wrong:** The `RenderPages` command and `public/content/` directory are artifacts of the old pre-render pipeline. If they're removed but references remain in `Home::getRenderedContent()`, routes, or composer scripts, the app breaks with missing files or methods.

**Why:** The deep discussion decision (2026-09-19) explicitly states to switch to CI4 view rendering. The `getRenderedContent()` method reads from `public/content/{page}/{locale}.html` which won't exist.

**How to avoid:** Remove `getRenderedContent()` entirely from `Home.php`. Remove `RenderPages.php` command. Remove any `public/content/` references from routes, config, or composer scripts. Verify `Home::page()` calls `view()` directly with no content-file dependency.

### 3. `localeUrl()` Broken URL Generation

**What goes wrong:** `navbar.php` uses `base_url('en/' . ltrim(service('uri')->getPath(), '/'))` which produces URLs like `/en/id/current-path` (double locale segment) because `getPath()` already includes the locale segment.

**Why:** `service('uri')->getPath()` returns the full path including the locale segment (e.g., `/id/about`). Prepending `en/` creates `/en/id/about`.

**How to avoid:** Implement `localeUrl(string $locale)` method on `Home` controller that uses `service('uri')` to get the current URI, replaces segment 1 with the target locale, and rebuilds the URL. Use `$uri->setSegment(1, $locale)` to swap the locale segment, then cast to string or use `$uri->getPath()`.

### 4. DesignSync Token Extraction Incomplete

**What goes wrong:** `DesignSync` currently extracts only colors (1.1), spaces (1.3), and radii (1.4). Typography (1.2) and elevation (1.5) are not extracted, leaving `tokens.css` incomplete.

**Why:** The `extractTableTokens()` method exists and works for space/radius tokens. It needs to be called for sections 1.2 (typography) and 1.5 (elevation) with appropriate regex patterns. The typography table has a different structure (6 columns) than space/radius tables (2 columns), requiring careful cell parsing.

**How to avoid:** Add three new `extractTableTokens()` calls in `DesignSync::extractRootBlock()`:
- Section 1.2 with regex `/^--font/` or similar for typography tokens (font-size, font-weight, line-height, letter-spacing per role)
- Section 1.5 with regex `/^--shadow/` for elevation tokens
- Build proper CSS custom property names from the design.md table cells

**Typography table structure:** Has 6 columns (Peran, Font, Ukuran, Weight, Line Height, Letter Spacing). Each row maps to multiple CSS custom properties like `--font-display-mega-size`, `--font-display-mega-weight`, etc.

**Elevation table structure:** Has 3 columns (Level, Nilai, Penggunaan). Maps to `--shadow-none: none`, `--shadow-focus: 0 0 0 0.125rem ring`, `--shadow-raised: 0 24px 64px rgba(17, 24, 39, 0.12)`.

### 5. `pages.css` Hardcoded Typography Values

**What goes wrong:** `pages.css` has hardcoded `font-size`, `font-weight`, `line-height`, `letter-spacing` values throughout (e.g., `.hero-title { font-size: 3rem; font-weight: 500; }`). These should reference `var(--*)` tokens from `tokens.css`.

**Why:** Design.md specifies typography tokens that should be the single source of truth. Hardcoded values in CSS create drift — if design.md changes, `pages.css` won't reflect it.

**How to avoid:** Map each hardcoded typography value in `pages.css` to the corresponding `var(--*)` reference:
- `.hero-title` → `var(--font-display-hero-size)`, `var(--font-display-hero-weight)`, etc.
- `.stat-number` → `var(--font-card-title-size)`, etc.
- Create a mapping document from design.md typography roles to CSS class names

**Critical note:** Design.md typography section 1.2 uses role-based naming (Display Mega, Display Hero, Section Heading, etc.) while `pages.css` uses class-based naming (`.hero-title`, `.stat-number`). The mapping must be explicit.

### 6. `about.php` Page and `tentang` Route Missing

**What goes wrong:** The about page doesn't exist. `PAGE_MAP` has 7 entries but no `about`. `Routes.php` has no `tentang` route.

**Why:** The deep discussion decision specifies `tentang` as the slug, route `/id/tentang`, PAGE_MAP entry `'about' => ['Tentang Kami', 'about']`, and `app/Views/pages/about.php`.

**How to avoid:** Add `'about' => ['Tentang Kami', 'about']` to `PAGE_MAP`. Add `$routes->get('tentang', 'Home::page/about')` to `Routes.php`. Create `app/Views/pages/about.php` following the same pattern as other pages (extends `layouts/main`, uses `$this->section('content')`).

### 7. PageNotFoundException Not Thrown for Unknown Slugs

**What goes wrong:** `Home::page()` uses `self::PAGE_MAP[$slug] ?? ['Beranda', 'home']` which silently falls back to home for unknown slugs instead of returning 404.

**Why:** The deep discussion decision specifies unknown slugs should throw `PageNotFoundException`.

**How to avoid:** Replace the null coalescing fallback with a lookup that throws `CodeIgniter\Exceptions\PageNotFoundException` if the slug is not found in `PAGE_MAP`.

### 8. OpenLitespeed + CI4 Page Cache Two-Layer Conflicts

**What goes wrong:** Both CI4 page cache (`$this->cachePage()`) and OpenLitespeed page cache can serve stale content or conflict with each other.

**Why:** CI4 caches rendered output at the application level. OpenLitespeed caches at the reverse proxy level. If CI4 cache is invalidated but OpenLitespeed cache isn't, users see stale pages.

**How to avoid:** Configure CI4 `cachePage()` with reasonable TTLs that align with OpenLitespeed cache settings. Use `Cache::erase()` in `Cache.php` config. The `PageCache` filter in `Filters.php` already handles CI4-level caching. OpenLitespeed cache purging should be triggered on deploy (git pull) via a post-deploy hook or cache purge API.

---

## Existing Patterns in This Codebase

### CI4 View Layout Pattern
- **Where:** All `app/Views/pages/*.php` files
- **How it works:** Each view starts with `<?= $this->extend('layouts/main') ?>`, then `<?= $this->section('content') ?>`, content HTML, then `<?= $this->endSection() ?>`
- **When to reuse:** Every new page view must follow this exact pattern
- **Current views confirmed:** `home.php`, `history.php`, `vision-mission.php`, `services.php`, `contact.php`, `portfolio.php`, `investor.php` all follow this pattern

### PAGE_MAP Controller Pattern
- **Where:** `app/Controllers/Home.php`
- **How it works:** `private const PAGE_MAP` maps slugs to `[title, view]` pairs. `Home::page(string $slug)` looks up the map and returns `view("pages/{$view}", ...)`
- **When to reuse:** Add new pages by adding one entry to `PAGE_MAP`, one route in `Routes.php`, and one view file

### CSS Custom Property Token System
- **Where:** `public/assets/css/tokens.css` → `main.css` imports via `@import 'tokens.css'`
- **How it works:** `:root` block defines CSS custom properties. All other CSS files reference them via `var(--*)`.
- **Current tokens:** Colors, spaces, radii — confirmed in `tokens.css`

### DesignSync Command Pattern
- **Where:** `app/Commands/DesignSync.php`
- **How it works:** Reads `design.md`, extracts `:root` block and table tokens, writes to `public/assets/css/tokens.css`
- **Method reuse:** `extractTableTokens($content, $section, $propRegex)` can be called for sections 1.2 and 1.5

### Locale Filter Pattern
- **Where:** `app/Filters/Locale.php` + `app/Config/Filters.php` alias `'locale' => \App\Filters\Locale::class`
- **How it works:** Validates locale segment against `['id', 'en', 'zh', 'fr', 'es', 'ja']`, redirects invalid to `/id/`, sets `$request->setLocale()`
- **When to reuse:** The locale filter is already working correctly — no changes needed

### Navbar Include Pattern
- **Where:** `app/Views/layouts/navbar.php`
- **How it works:** Included via `$this->include('layouts/navbar')` in `main.php`
- **Current state:** Has broken hreflang URL generation — needs `localeUrl()` method from controller

---

## Recommended Approach

The rendering pipeline switches from pre-render markdown to CI4 view rendering. Every task in this phase must reflect this fundamental change.

### 1. Fix Layout Bug in `main.php`
Replace `<?= $content ?>` with `<?= $this->renderSection('content') ?>`. Remove `$content` from the `view()` call in `Home::page()`. Verify all 7 existing views already use `$this->section('content')` and `$this->endSection()` — confirmed they do.

### 2. Refactor `Home::page()` Controller
- Add `PageNotFoundException` import (`use CodeIgniter\Exceptions\PageNotFoundException`)
- Replace `[$title, $view] = self::PAGE_MAP[$slug] ?? ['Beranda', 'home']` with a lookup that throws `PageNotFoundException` if slug not found
- Remove `getRenderedContent()` method entirely
- Remove `'content' => $content` from `view()` parameters
- Keep `['title' => $title, 'locale' => $locale]` as the only view data
- Add `'about' => ['Tentang Kami', 'about']` to `PAGE_MAP`

### 3. Add About Page
- Add `$routes->get('tentang', 'Home::page/about')` to `Routes.php` inside the locale group
- Create `app/Views/pages/about.php` following existing view patterns (extends layouts/main, section content, breadcrumb + hero + content)

### 4. Add `localeUrl()` Method to `Home` Controller
```php
protected function localeUrl(string $locale): string
{
    $uri = service('uri');
    $uri->setSegment(1, $locale);
    return base_url($uri->getPath());
}
```
Update `navbar.php` to call `localeUrl('en')`, `localeUrl('zh')`, etc. instead of the broken `base_url('en/' . ltrim(service('uri')->getPath(), '/'))` pattern.

### 5. Extend DesignSync for Typography and Elevation Tokens
Add three new `extractTableTokens()` calls in `DesignSync::extractRootBlock()`:
- Section 1.2 (typography): Extract font-size, font-weight, line-height, letter-spacing per role into `--font-{role}-{property}` tokens
- Section 1.5 (elevation): Extract `--shadow-none`, `--shadow-focus`, `--shadow-raised` tokens
- The `extractTableTokens()` method already exists and handles markdown table parsing — it just needs the right section number and regex

### 6. Update `tokens.css` with New Tokens
After running `php spark design:sync`, `tokens.css` should contain:
- All existing tokens (colors, spaces, radii)
- New typography tokens from section 1.2 (e.g., `--font-display-mega-size: 8.50rem`, etc.)
- New elevation tokens from section 1.5 (e.g., `--shadow-none: none`, `--shadow-focus: 0 0 0 0.125rem ring`, `--shadow-raised: 0 24px 64px rgba(17, 24, 39, 0.12)`)

### 7. Update `pages.css` to Use `var(--*)` References
Replace all hardcoded typography values in `pages.css` with `var(--*)` references mapped from design.md typography roles. Key mappings:
- `.hero-title` → `var(--font-display-hero-size)`, `var(--font-display-hero-weight)`, `var(--font-display-hero-line-height)`, `var(--font-display-hero-letter-spacing)`
- `.hero-subtitle` → `var(--font-body-large-size)`, etc.
- `.timeline-year` → `var(--font-sub-heading-size)`, etc.
- `.service-card h3` → `var(--font-feature-title-size)`, etc.
- `.stat-number` → `var(--font-card-title-size)`, etc.
- `.cta h2` → `var(--font-section-heading-size)`, etc.
- `.breadcrumb` → `var(--font-caption-size)`, etc.

### 8. Remove `RenderPages` Command and `public/content/`
- Delete `app/Commands/RenderPages.php`
- Remove `public/content/` directory if it exists
- Verify no references to `RenderPages` or `public/content/` remain in routes, config, or composer.json scripts

### 9. Enable CI4 Page Caching
- Add `$this->cachePage(3600)` (or appropriate TTL) in `Home::page()` method
- Verify `PageCache` filter is in `$required` in `Filters.php` (already confirmed — it is)
- Configure `app/Config/Cache.php` with appropriate cache engine (file or redis)
- OpenLitespeed page cache: enable on VPS, configure cache purging on deploy

### 10. Remove Empty `about/` Markdown Subdirectories
- Delete `app/Views/pages/about/` subdirectories if they exist (they're empty reference-only)

---

## Confidence Levels

| Task | Confidence | Source |
|------|-----------|--------|
| Layout bug fix (`renderSection`) | **High** | CI4 docs confirm `renderSection()` is the correct method; current code confirmed broken |
| Controller refactor (`PageNotFoundException`) | **High** | Explicitly stated in deep discussion decisions; `PAGE_MAP` pattern is confirmed working |
| `localeUrl()` using CI4 URI class | **High** | CI4 URI class docs confirm `setSegment()` and `getPath()` methods exist |
| DesignSync extension for typography/elevation | **High** | `extractTableTokens()` method exists and is reusable; sections 1.2/1.5 tables exist in design.md |
| `pages.css` var(--*) migration | **Medium** | Mapping requires judgment calls on which CSS class maps to which design role; risk of missing some classes |
| About page creation | **High** | Explicitly specified in deep discussion; all patterns exist |
| CI4 page caching | **High** | CI4 docs confirm `$this->cachePage()` and `PageCache` filter; `Filters.php` already configured |
| Remove `RenderPages`/`public/content/` | **High** | Explicitly decided in deep discussion; no references should remain |
| OpenLitespeed two-layer caching | **Medium** | Requires VPS-level configuration not yet implemented; CI4-side caching is high confidence |

---

## Key CI4 API References

- **`$this->renderSection('name')`**: Called in layout views to output content from child views' `$this->section('name')` blocks. Confirmed in CI4 View Layouts docs.
- **`$this->extend('layout_name')`**: Called at top of child view to specify which layout to extend. Confirmed in CI4 View Layouts docs.
- **`$this->section('name')` / `$this->endSection()`**: Wraps content in child views that should be injected into the layout's `renderSection('name')` call.
- **`$this->include('view_name')`**: Includes a partial view within a section. Used for navbar/footer includes.
- **`$this->cachePage($seconds)`**: Enables per-page caching in controller methods. Confirmed in CI4 Web Page Caching docs.
- **`service('uri')`**: Returns the current `SiteURI` instance. Confirmed in CI4 URI docs.
- **`$uri->setSegment($n, $value)` / `$uri->getPath()`**: URI manipulation methods for locale URL swapping. Confirmed in CI4 URI docs.
- **`PageNotFoundException`**: Thrown for unknown routes/pages. Standard CI4 exception class.
- **`view('name', $data, ['cache' => 60])`**: Third parameter option for view-level caching (alternative to `$this->cachePage()`).

---

## Design Token Mapping Reference

### Typography Roles → CSS Custom Properties (to add to tokens.css)

| Design.md Role | Token Prefix Examples |
|---------------|---------------------|
| Display Mega | `--font-display-mega-size: 8.50rem; --font-display-mega-weight: 500; --font-display-mega-line-height: 1.00; --font-display-mega-letter-spacing: -2.72px` |
| Display Hero | `--font-display-hero-size: 5.00rem; --font-display-hero-weight: 500; --font-display-hero-line-height: 1.00; --font-display-hero-letter-spacing: -0.8px` |
| Section Heading | `--font-section-heading-size: 3.00rem; --font-section-heading-weight: 500; --font-section-heading-line-height: 1.21; --font-section-heading-letter-spacing: -0.48px` |
| Sub-heading | `--font-sub-heading-size: 2.50rem; --font-sub-heading-weight: 500; --font-sub-heading-line-height: 1.20; --font-sub-heading-letter-spacing: -0.4px` |
| Card Title | `--font-card-title-size: 2.00rem; --font-card-title-weight: 500; --font-card-title-line-height: 1.19; --font-card-title-letter-spacing: -0.32px` |
| Feature Title | `--font-feature-title-size: 1.50rem; --font-feature-title-weight: 400; --font-feature-title-line-height: 1.33; --font-feature-title-letter-spacing: normal` |
| Nav / UI | `--font-nav-ui-size: 1.25rem; --font-nav-ui-weight: 500; --font-nav-ui-line-height: 1.40; --font-nav-ui-letter-spacing: normal` |
| Body Large | `--font-body-large-size: 1.13rem; --font-body-large-weight: 400; --font-body-large-line-height: 1.56; --font-body-large-letter-spacing: -0.09px` |
| Body | `--font-body-size: 1.00rem; --font-body-weight: 400; --font-body-line-height: 1.50; --font-body-letter-spacing: 0.24px` |
| Body Semibold | `--font-body-semibold-size: 1.00rem; --font-body-semibold-weight: 600; --font-body-semibold-line-height: 1.50; --font-body-semibold-letter-spacing: 0.16px` |
| Body Bold Link | `--font-body-bold-link-size: 1.00rem; --font-body-bold-link-weight: 700; --font-body-bold-link-line-height: 1.50; --font-body-bold-link-letter-spacing: 0.24px` |
| Caption / Meta | `--font-caption-size: 0.75rem; --font-caption-weight: 400; --font-caption-line-height: 1.50; --font-caption-letter-spacing: 0.16px` |

### Elevation Tokens (to add to tokens.css)

| Level | Token Name | Value |
|-------|-----------|-------|
| Flat | `--shadow-none` | `none` |
| Focus | `--shadow-focus` | `0 0 0 0.125rem` |
| Raised | `--shadow-raised` | `0 24px 64px rgba(17, 24, 39, 0.12)` |

---

*Research completed: 2026-09-19*
*Phase: 02-skeleton-pages*
*All deep discussion decisions reflected in recommended approach.*
