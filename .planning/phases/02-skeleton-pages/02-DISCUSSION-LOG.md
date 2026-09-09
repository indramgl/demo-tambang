# Phase 02: Skeleton Pages & Design Integration - Discussion Log

**Gathered:** 2026-09-08
**Mode:** standard

## Gray Areas Discussed

### 1. Locale Filter Implementation

#### Custom Filter vs Controller-Level vs Content Negotiation
- **Option A: Custom filter class** ← **SELECTED**
  - `app/Filters/Locale.php` validates locale segment against supported list
  - Invalid locales redirect to `/id/` with 302
  - Sets CI4 locale via `$request->setLocale()`
  - Registered in `app/Config/Filters.php`
  - Applied to locale route group in `Routes.php`
- **Option B: Controller-level validation**
  - Simpler but mixes routing concerns with controller logic
  - Not recommended for a cross-cutting concern like locale validation
- **Option C: Content Negotiation (CI4 built-in)**
  - Uses Accept-Language header instead of URL segment
  - Less explicit than URL-based routing, harder to debug

**Rationale:** Custom filter is the standard CI4 pattern for cross-cutting concerns. It's reusable, testable, and keeps routing logic separate from controller logic.

#### Invalid Locale Handling: Redirect vs 404
- **Option A: Redirect to default locale** ← **SELECTED**
  - Invalid URLs like `/xx/page` redirect to `/id/` with 302
  - User-friendly, handles typos gracefully
- **Option B: Return 404**
  - More explicit but less forgiving for typos
  - Could confuse users who mistype a locale code

**Rationale:** Redirect is more user-friendly. A typo in the locale code shouldn't result in a 404 — it should gracefully fall back to the default locale.

#### Filter Auto-Set Locale vs Controller Handles Locale
- **Option A: Yes, set locale in filter** ← **SELECTED**
  - Filter calls `$request->setLocale()` after validation
  - CI4 localization system handles language strings automatically
  - Clean separation of concerns
- **Option B: No, let controller handle locale**
  - Controller reads locale from URL and handles localization manually
  - More control but more boilerplate in every controller

**Rationale:** Setting locale in the filter leverages CI4's built-in localization system and avoids repeating the locale-setting logic in every controller.

#### Filter Registration: Filters.php vs Inline in Routes.php
- **Option A: Register in Filters.php** ← **SELECTED**
  - Standard CI4 pattern for filter registration
  - Reusable across multiple route groups
  - Clean separation of filter definition and usage
- **Option B: Define inline in Routes.php**
  - Less reusable but simpler for a single filter
  - Not the CI4 convention

**Rationale:** Registering in Filters.php follows CI4 conventions and makes the filter reusable if needed in other contexts.

### 2. Default Locale Redirect Strategy

#### Root URL Handling: Route Redirect vs Default Locale Change vs Both
- **Option A: Route-level redirect** ← **SELECTED**
  - `$routes->get('/', function() { return redirect()->to('/id/'); })` in Routes.php
  - Simple, explicit, works with CI4's redirect helper
  - Keeps `$defaultLocale = 'en'` in App.php (CI4 default)
- **Option B: Set `$defaultLocale = 'id'` in App.php**
  - Root URL serves Indonesian content directly without redirect
  - Changes CI4's default behavior, may affect other locale features
- **Option C: Both approaches**
  - Redundant — the redirect already handles the primary locale

**Rationale:** Route-level redirect is the simplest and most explicit approach. It doesn't change CI4's default locale configuration, avoiding potential side effects with other locale-aware features.

### 3. View Rendering Pipeline (Markdown → HTML)

#### Rendering Approach: Controller + Parsedown vs Custom View Handler vs Pre-Render During Deploy
- **Option A: Controller reads markdown + Parsedown**
  - Runtime conversion on every request
  - Full control, but adds PHP overhead per request
- **Option B: Custom view handler for .md files**
  - CI4-native approach but adds complexity
  - Would need custom view class or file extension handling
- **Option C: Pre-render during deploy (static HTML)** ← **SELECTED**
  - Markdown files converted to static HTML during deploy step
  - OpenLitespeed serves static files directly — no PHP overhead
  - Fastest performance, aligns with static-first architecture
  - Requires build step in deploy script

**Rationale:** Pre-rendering during deploy is the best fit for a static company profile site. It eliminates PHP overhead for page renders, aligns with the OpenLitespeed static page cache, and makes the site CDN-friendly. The build step runs once per deploy, not per request.

### 4. Design Token Integration into CI4 Views

#### CSS Custom Property Management: Auto-Generate vs Manual vs Runtime Injection
- **Option A: Auto-generate tokens.css from design.md** ← **SELECTED**
  - CLI command (`php spark design:sync`) parses design.md `:root` block
  - Generates `tokens.css` that gets included in `main.css`
  - Single source of truth: design.md → tokens.css → main.css
  - Sync runs as Composer `post-install-cmd` or pre-deploy hook
  - Prevents drift between design.md and actual CSS
- **Option B: Manual CSS with design.md as reference**
  - Simple but risks drift between design.md and CSS
  - Manual updates required every time design tokens change
- **Option C: Runtime injection from design.md**
  - PHP helper reads design.md CSS block and injects as `<style>` tag
  - No build step needed but adds runtime overhead
  - Not suitable for production performance

**Rationale:** Auto-generating tokens.css from design.md ensures a single source of truth and prevents the design drift that was flagged as a risk in v1.0. It's a build-time concern, not a runtime one.

---

## Areas Skipped (All Clear)

- Route group syntax — CI4's `$routes->group('{locale}', ...)` is well-documented and standard
- Parsedown library availability — widely used, Composer-installable
- CSS custom property support — all modern browsers support CSS custom properties

---

## Prior Decisions Applied

- DEC-001: Decoupled local/prod architecture — confirmed (pre-render during deploy keeps this pattern)
- Static-first architecture — confirmed (pre-rendered HTML is static)
- Git-based deployment — deploy script includes pre-render step
- No CMS, no database — confirmed (out of scope)

---

## Deferred Ideas

- Contact form with Postmark email — Phase 4
- SQLite database for contact messages — Phase 4
- Admin panel — out of scope
- Portfolio/IR content creation — v3
- Design iteration after skeleton — design.md frozen after v2.0
- VPS deployment (REQ-004) — blocked on VPS provisioning

---

*Phase: 02-skeleton-pages*
*Discussion log: 2026-09-08*