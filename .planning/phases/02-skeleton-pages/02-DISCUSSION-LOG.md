# Phase 02: Skeleton Pages & Design Integration - Discussion Log

**Gathered:** 2026-09-19
**Mode:** deep

## Prior Decisions (from standard mode, 2026-09-08)

### 1. Locale Filter Implementation
- **Custom filter class** ← SELECTED
- Invalid locales redirect to `/id/` with 302
- Filter sets CI4 locale via `$request->setLocale()`

### 2. Default Locale Redirect
- **Route-level redirect** ← SELECTED
- Keeps `$defaultLocale = 'en'` in App.php

### 3. View Rendering Pipeline
- **Pre-render during deploy** ← PREVIOUSLY SELECTED (now superseded)

### 4. Design Token Integration
- **Auto-generate tokens.css from design.md** ← SELECTED
- CLI command (`php spark design:sync`)

---

## Deep Discussion Decisions (2026-09-19)

### 1. Rendering Pipeline

#### Previous Decision vs. New Decision
- **Previous:** Pre-render markdown during deploy → static HTML files in `public/content/`
- **New:** CI4 view rendering — `Home::page()` calls `view()` directly

**Rationale:** Pre-rendering pipeline was unnecessarily complex. The flat `.php` views already contain all page content and extend `layouts/main`. Switching to CI4 view rendering simplifies the architecture, removes the `RenderPages` command and `public/content/` directory, and leverages CI4's built-in view system.

**Alternatives considered:**
- Keep pre-render but change source to .php views — rejected, adds unnecessary complexity
- Hybrid approach with both .php templates and markdown content — rejected, adds unnecessary complexity

**Impact:** Remove `RenderPages` command, remove `public/content/` directory, remove `getRenderedContent()` from `Home.php`. `Home::page()` now calls `view("pages/{$view}", ['title' => $title, 'locale' => $locale])`.

### 2. Markdown Subdirectories

#### Previous Decision vs. New Decision
- **Previous:** Markdown files as primary content source, pre-rendered to HTML
- **New:** Markdown files kept as reference documentation only

**Rationale:** Flat `.php` views are canonical. The markdown subdirectories with placeholder content are no longer part of the rendering pipeline. They serve as documentation of what content exists per locale.

**Alternatives considered:**
- Delete markdown files entirely — rejected, user chose to keep as reference
- Use markdown as content source with .php templates — rejected, adds complexity

**Impact:** `app/Views/pages/about/` subdirectories (empty, no `page.md` files) should be removed. All other markdown subdirectories kept as reference.

### 3. Layout Section Rendering Bug

#### `<?= $content ?>` vs `<?= $this->renderSection('content') ?>`
- **Selected:** Fix `main.php` to use `<?= $this->renderSection('content') ?>`

**Rationale:** Child views (home.php, history.php, etc.) use `$this->section('content')` and `$this->endSection()`. In CI4, sections are rendered with `$this->renderSection()`. The current `<?= $content ?>` is a bug — it tries to echo a variable that doesn't exist. This was masked by `Home::page()` passing `$content` as a variable, but with the new CI4 view rendering approach, the bug must be fixed.

**Impact:** All child views already work correctly with `$this->section('content')`. Only `main.php` needs to change. `Home::page()` no longer passes `$content`.

### 4. Navbar Language Switcher

#### Broken hreflang URL Generation
- **Current:** `ltrim(service('uri')->getPath(), '/')` produces broken URLs like `/id/id/current-path`
- **Selected:** `localeUrl()` method on `Home` controller using CI4 URI class

**Rationale:** The navbar needs to generate correct URLs for each locale while preserving the current page path. Using CI4's `URI` class to swap the locale segment (segment 1) is the cleanest approach. A controller method keeps the logic out of the view and makes it testable.

**Alternatives considered:**
- Inline logic in navbar.php — rejected, couples view to URI logic
- Controller passes pathMap — rejected, requires manual maintenance per route

**Impact:** Add `localeUrl(string $targetLocale): string` method to `Home` controller. Update `navbar.php` to call `localeUrl('en')`, `localeUrl('zh')`, etc.

### 5. Design Token Extension

#### Typography Tokens
- **Selected:** Extend `DesignSync` to extract full typography tokens from design.md section 1.2
- **Alternative:** Font-size only — rejected, incomplete
- **Alternative:** Separate typography.css — rejected, adds another file to manage

**Rationale:** Design.md defines 11 typography roles with font-size, font-weight, line-height, and letter-spacing. Currently `pages.css` uses hardcoded values like `font-size: 3rem`, `font-weight: 500`. Adding typography tokens to `tokens.css` ensures a single source of truth and prevents drift.

**Impact:** `DesignSync` command extended to parse section 1.2 table. `tokens.css` includes `--font-size-display-mega`, `--font-size-display-hero`, etc. `pages.css` updated to use `var(--*)` references.

#### Elevation Tokens
- **Selected:** Extract elevation tokens to tokens.css despite anti-shadow rule
- **Alternative:** Skip elevation — rejected, tokens should be available if rule changes
- **Alternative:** Separate elevation.css — rejected, unnecessary complexity

**Rationale:** Design.md section 1.5 defines elevation tokens. Section 7 says "Jangan gunakan shadow" but this is a design decision that could change. Having tokens available ensures consistency if the anti-shadow rule is relaxed in the future.

**Impact:** `tokens.css` includes `--shadow-none`, `--shadow-focus`, `--shadow-raised`. Not currently used in CSS but available.

### 6. About Page Implementation

#### Missing Page
- **Selected:** Implement about page with `tentang` slug
- **Alternative:** Remove empty `about/` directories — rejected, about page is needed
- **Alternative:** Use `about` slug — rejected, doesn't follow Indonesian naming convention
- **Alternative:** Use `profil` slug — rejected, `tentang` is more standard

**Rationale:** The roadmap and design.md reference 7 pages. The `about/` markdown subdirectories exist but have no content files and no route. Adding `about` as a page with `tentang` slug follows the established Indonesian naming pattern (sejarah, visi-misi, layanan, kontak, portofolio, investor).

**Impact:** Add `'about' => ['Tentang Kami', 'about']` to `PAGE_MAP`. Add `$routes->get('tentang', 'Home::page/about')` to Routes.php. Create `app/Views/pages/about.php`. Remove empty `app/Views/pages/about/` subdirectories.

### 7. Controller Refactoring

#### Full Refactor with Validation
- **Selected:** Rewrite `Home::page()` with slug validation and `PageNotFound` exception
- **Alternative:** Minimal refactor — rejected, doesn't address validation gap
- **Alternative:** Delegate to BaseController — rejected, unnecessary complexity

**Rationale:** The current `Home::page()` has a bug — it calls `getRenderedContent()` which reads from the obsolete `public/content/` directory. After switching to CI4 view rendering, the method needs a complete rewrite. Slug validation prevents errors for unknown pages.

**Impact:** `Home::page()` validates slug against `PAGE_MAP`, throws `PageNotFoundException` for unknown slugs, calls `view("pages/{$view}", ['title' => $title, 'locale' => $locale])`.

### 8. Caching Strategy

#### Two-Layer Caching
- **Selected:** CI4 page cache + OpenLitespeed
- **Alternative:** Keep pre-render for OpenLitespeed — rejected, loses simplicity of CI4 views
- **Alternative:** Enable OpenLitespeed page cache only — rejected, doesn't leverage CI4 caching

**Rationale:** Switching from pre-rendered static HTML means OpenLitespeed no longer serves pure static files. CI4's built-in page cache provides application-level caching, while OpenLitespeed's reverse proxy cache provides infrastructure-level caching. This two-layer approach maintains performance.

**Impact:** Implement `$this->cache` in `Home::page()`. Configure OpenLitespeed page caching rules. Cache invalidation on content change.

---

## Areas Skipped (All Clear)

- Route group syntax — CI4's `$routes->group('{locale}', ...)` is well-documented
- CSS custom property support — all modern browsers support them
- Parsedown library availability — no longer needed after removing RenderPages
- Responsive CSS implementation — `responsive.css` has proper breakpoints
- Footer layout — simple and correct

---

## Prior Decisions Applied

- DEC-001: Decoupled local/prod architecture — confirmed (CI4 views work in both environments)
- Static-first architecture — confirmed (CI4 views + page cache serve static-like performance)
- Git-based deployment — confirmed
- No CMS, no database — confirmed

---

## Codebase Findings from Deep Discussion

### Critical Bugs Found
1. **Layout rendering bug**: `main.php` uses `<?= $content ?>` but child views use `$this->section('content')` — must fix to `<?= $this->renderSection('content') ?>`
2. **Navbar hreflang bug**: `navbar.php` generates broken URLs (`/id/id/current-path`) — must fix with `localeUrl()` method
3. **Obsolete rendering pipeline**: `Home::page()` reads from `public/content/` but pre-render pipeline is being removed

### Inconsistencies Found
1. **About page**: `app/Views/pages/about/` subdirectories exist but have no `page.md` files, no `about.php`, no route
2. **Empty `about/` directories**: `app/Views/pages/about/EN`, `/ES`, `/FR`, `/ID`, `/JA`, `/ZH` are all empty
3. **`public/content/`**: Contains pre-rendered HTML files that will be obsolete

### Technical Debt
1. **`RenderPages` command**: Will be removed — no longer needed
2. **`DesignSync` command**: Needs extension for typography and elevation tokens
3. **`pages.css`**: Has hardcoded typography values that should use `var(--*)` references

---

## Deferred Ideas

- Contact form with Postmark email — Phase 4
- SQLite database for contact messages — Phase 4
- Admin panel — out of scope
- Portfolio/IR content creation — v3
- Design iteration after skeleton — design.md frozen after v2.0
- VPS deployment (REQ-004) — blocked on VPS provisioning
- `public/content/` directory cleanup — obsolete after switching to CI4 view rendering
- `RenderPages` command removal — no longer needed
- `page.md` markdown reference files — kept but not used

---

## Deep Mode Decision Tree

### Rendering Pipeline Branch
```
Pre-render markdown → CI4 view rendering
  ├── User: "Flat .php views are canonical"
  │   └── Decision: Switch to CI4 view rendering
  │       └── Sub-branch: "What about markdown?" → Keep as reference
  │           └── Sub-branch: "What about RenderPages?" → Remove
  └── User: "Keep pre-render, change source to .php" → Rejected
      └── User: "Hybrid approach" → Rejected
```

### Layout Bug Branch
```
<?= $content ?> vs <?= $this->renderSection('content') ?>
  ├── Decision: Fix main.php to use renderSection()
  │   └── Sub-branch: "What about $content variable?" → Remove from Home::page()
  └── User: "Keep $content variable pattern" → Rejected
```

### Design Token Branch
```
DesignSync token coverage
  ├── Typography: Full tokens in tokens.css (Selected)
  │   └── Sub-branch: "Font-size only?" → Rejected, incomplete
  │   └── Sub-branch: "Separate typography.css?" → Rejected, adds complexity
  └── Elevation: Extract despite anti-shadow rule (Selected)
      └── Sub-branch: "Skip elevation?" → Rejected, future-proofing
```

### Navbar Branch
```
Language switcher URL generation
  ├── Decision: Controller localeUrl() method using CI4 URI class
  │   └── Sub-branch: "Inline in navbar.php?" → Rejected
  │   └── Sub-branch: "Controller passes pathMap?" → Rejected
  └── User: "Inline in navbar.php" → Rejected
      └── User: "Controller passes pathMap" → Rejected
```

### About Page Branch
```
About page implementation
  ├── Decision: Implement with `tentang` slug
  │   └── Sub-branch: "Remove about directory?" → Rejected, about page needed
  │   └── Sub-branch: "Use `about` slug?" → Rejected, doesn't follow convention
  │   └── Sub-branch: "Use `profil` slug?" → Rejected, `tentang` is standard
  └── User: "Remove about directory" → Rejected
```

### Caching Branch
```
Caching strategy after removing pre-render
  ├── Decision: CI4 page cache + OpenLitespeed
  │   └── Sub-branch: "Keep pre-render?" → Rejected, loses CI4 view simplicity
  │   └── Sub-branch: "OpenLitespeed only?" → Rejected, misses CI4 caching
  └── User: "Keep pre-render" → Rejected
      └── User: "OpenLitespeed only" → Rejected
```

---

*Phase: 02-skeleton-pages*
*Discussion log: 2026-09-19*
*Mode: deep*
