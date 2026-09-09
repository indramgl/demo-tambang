# Ideation — Company Profile Website

**Date:** 2026-09-08
**Focus:** open-ended (PT Indah Tambang Raya Semesta)
**Mode:** scan (parallel, 4 lenses)

## Top Ideas

### 1. Bilingual MVP (ID + EN First)
**Impact:** high | **Evidence:** 36 empty page variants (6 pages × 6 languages), `App.php` `$supportedLocales = ['en']` only, `Routes.php` has no locale routing
**Summary:** Start with Indonesia + English only. Add ZH/FR/ES/JA later as content is ready. No architecture change needed — just copy templates + translate. Cuts initial surface area by 67%.
**Scope:** small

### 2. Convention-Based Multilingual Router
**Impact:** high | **Evidence:** `Routes.php` has only `$routes->get('/', 'Home::index')` — one hardcoded route; `design.md` specifies `{locale}` group pattern; `app/Views/pages/` already has 6 language subdirs per page
**Summary:** Replace the single hardcoded route with a convention-based router that auto-discovers page directories from `app/Views/pages/` and language codes from subdirectories. Adding a new page means creating a directory — no `Routes.php` edit needed.
**Scope:** medium

### 3. BaseController Page Render Method
**Impact:** high | **Evidence:** `Home.php` has only `index()` returning `view('welcome_message')`; `BaseController.php` has empty `initController()`; `design.md` routes all 6 pages through `Home::methodName`
**Summary:** Add a `renderPage(string $page, array $data = []): string` method to `BaseController` that handles locale detection, markdown resolution, Parsedown conversion, and layout wrapping. All future page controllers call `$this->renderPage('sejarah')` instead of reimplementing this pipeline.
**Scope:** small

### 4. App.php Locale Configuration Fix
**Impact:** high | **Evidence:** `app/Config/App.php` line 103: `$supportedLocales = ['en']` — only English; `PROJECT.md` says "Indonesia (utama)" is primary; `design.md` section 5.1 shows `/id/` as default URL path
**Summary:** The CI4 locale config only declares English, but the project needs 6 languages with Indonesian as primary. A user hitting the root URL gets English — a direct UX mismatch. Fix: set `$defaultLocale = 'id'` and `$supportedLocales = ['id', 'en', 'zh', 'fr', 'es', 'ja']`.
**Scope:** small

### 5. Content Manifest Registry
**Impact:** medium | **Evidence:** No index of what content exists where; `vps-provisioning.md` references translation JSON files that don't exist yet; `CONVENTIONS.md` defines naming patterns but no single source of truth
**Summary:** Create a `content-manifest.json` at project root listing every page, its available languages, and file paths. A CLI helper (`php spark content:manifest`) generates and validates this from the directory tree. Router, SEO checker, deploy script, and translation workflow all read from this single manifest.
**Scope:** small

### 6. Markdown-to-HTML Pre-Render Pipeline
**Impact:** medium | **Evidence:** Project uses markdown content files served through CI4 PHP runtime; OpenLitespeed has static page cache enabled (`vps-provisioning.md`); `PROJECT.md` states "Statis, tanpa CMS/database"
**Summary:** Add a pre-render step to the deploy pipeline that converts all `.md` files to static `.html` files served directly by OpenLitespeed, bypassing PHP entirely for page renders. A `composer post-install-cmd` script runs Parsedown on each markdown file and writes rendered HTML to `public/content/`.
**Scope:** medium

### 7. Pre-commit Content Validator
**Impact:** medium | **Evidence:** 36+ content file variants across 6 pages × 6 languages; `CONVENTIONS.md` defines naming patterns but no enforcement; `design.md` specifies hreflang tags in `<head>`
**Summary:** Create a git pre-commit hook that validates: (1) markdown files have consistent frontmatter, (2) hreflang links are complete for all 6 languages, (3) no `.env` or secret files are staged, (4) internal links resolve to existing content, (5) translation completeness — every page has all 6 language variants or is explicitly marked as ID-only.
**Scope:** medium

### 8. design.md Is Not a Blocker — Start Building Templates Now
**Impact:** medium | **Evidence:** `design.md` already exists in repo (436 lines) with detailed specs for every page layout, component, and responsive breakpoint; `CONCERNS.md` and `STATE.md` mark it as "pending" but it's already present; `PROJECT.md` says "Design mengikuti design.md dari OpenDesign"
**Summary:** The design.md is not "pending delivery" — it already exists in the repo with comprehensive specifications. The team can begin building HTML/CSS structure and page templates now using the existing design.md, and apply design updates as template replacements when OpenDesign delivers revisions.
**Scope:** medium

---

## Eliminated Ideas (with reasons)

| Idea | Lens | Reason |
|------|------|--------|
| Multilingual Content Sync Workflow | pain | Merged into "Content Manifest Registry" and "Bilingual MVP" — same problem, better solution |
| Locale-Aware Routing Implementation | pain | Merged into "Convention-Based Multilingual Router" — same idea, better framing |
| App.php Locale Configuration Mismatch | pain | Merged into "App.php Locale Configuration Fix" — same issue |
| Content Format Specification for Operators | pain | Too minor; can be done ad-hoc when content is actually being prepared |
| Deploy Health Check Script | pain | Merged into "Deploy Script with Health Check" (leverage lens) |
| Internal Link Validator for Multilingual Pages | pain | Merged into "Pre-commit Content Validator" — same validation, better placement |
| Hreflang Tag Auto-Generation | pain | Merged into "Pre-commit Content Validator" — hreflang is part of the validator's scope |
| Operator Onboarding Guide | pain | Nice-to-have but not high priority; can be added when content editing begins |
| VPS Provisioning Script | leverage | Large scope; VPS doesn't exist yet (REQ-004 blocked). Better to defer until Phase 1 is complete |
| Challenge: "$defaultLocale = 'en' is correct" | assumption-breaking | Merged into "App.php Locale Configuration Fix" |
| Challenge: "Static markdown files per language is the right content model" | assumption-breaking | Merged into "Bilingual MVP" and "Content Manifest Registry" |
| Challenge: "VPS with git pull deployment is the right model" | assumption-breaking | Large scope; defers to Phase 5. Git pull is fine for v1.0 |
| Challenge: "Locale-prefixed routing should follow design.md's group pattern" | assumption-breaking | Merged into "Convention-Based Multilingual Router" |
| Challenge: "No database is the right choice" | assumption-breaking | SQLite schema decision can be deferred to Phase 4 (contact form) |
| Challenge: "One Home controller for all pages is sufficient" | assumption-breaking | Merged into "BaseController Page Render Method" — separate controllers naturally follow from the render method |
| Design Token → CSS Auto-Generation | leverage | Valid idea but lower priority — CSS can be manually maintained until design tokens stabilize |

---

## Scan Context

- Codebase: CI4 scaffold with minimal custom code (app/Config/*.php only)
- Git: 10+ commits, mostly documentation
- Previous ideation: `20260907-ideation-company-profile.md` (2026-09-07) — 10 ideas, 5 eliminated
- Concerns: no .gitignore (resolved), design.md blocker (stale — design.md already exists in repo)
- Open questions: VPS provider, 6 languages spec, contact form email, portfolio/IR format

---

*Ideation generated 2026-09-08*