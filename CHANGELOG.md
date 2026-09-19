# CHANGELOG

## v1.0.0 — 2026-09-08

### Features
- CI4 v4.7.4 scaffolded via Composer
- `.gitignore` created with CI4/VPS rules (`.env`, `vendor/`, `writable/`, `.opencode/`, IDE configs)
- Git remote configured (`https://github.com/indramgl/demo-tambang.git`)
- `php spark serve` verified — app accessible at `localhost:8080`
- Multilingual directory structure created for all 6 languages (ID, EN, ZH, FR, ES, JA)
- Xdebug configured in debug mode for local development
- CI4 + PHP 8.4 + OpenLitespeed compatibility verified (`.htaccess` rewrite rules)

### Fixes
- `.opencode/` added to `.gitignore` (was missing from initial creation)

### Milestone Complete
- Milestone v1.0 archived: `.planning/milestones/v1.0-ROADMAP.md`, `.planning/milestones/v1.0-REQUIREMENTS.md`
- 6 of 7 requirements delivered (REQ-004 blocked on VPS provisioning)

### Learnings
- PHP 8.4.20 is installed on the dev machine (not PHP 8.5 as planned) — CI4 v4.7.4 requires PHP ^8.2, so 8.4 is compatible
- Xdebug v3.5.1 is pre-installed with PHP — no additional installation needed
- CI4 `.htaccess` uses standard `mod_rewrite` syntax — OpenLitespeed supports this natively, no rewrite rule modifications needed
- PowerShell on Windows does not support `&&` or `head` — use `;` for command chaining and `Select-Object -First` for truncation

---

## v2.0.0 — 2026-09-09

### Features
- Phase 1 complete: Multilingual routing, static page templates, and design integration
- Locale filter (`app/Filters/Locale.php`) validates URL locale segments and redirects invalid ones to `/id/`
- 7 skeleton pages accessible in all 6 locales via URL path routing
- Design tokens auto-generated from `design.md` via `php spark design:sync`
- 4 CSS files (tokens.css, main.css, components.css, pages.css, responsive.css) with Revolut Design System 2.0 tokens
- Pre-render deploy command (`php spark render:pages`) for markdown-to-HTML conversion
- Composer `post-install-cmd` runs design:sync automatically

### Fixes (2026-09-19 — Code Review + Compound)
- **CSS class contract**: Fixed 6 class name mismatches between view templates and CSS selectors (`.services-grid`, `.contact-grid`, `.portfolio-filter`, `.cta`, `.grid`, `.core-values`, `.stat`) in `pages.css` and `responsive.css`
- **Content pipeline**: Created 42 markdown source files (`app/Views/pages/{page}/{locale}/page.md`) and ran `php spark render:pages` to generate `public/content/` HTML files
- **Controller refactor**: Replaced 7 duplicate methods in `Home.php` with single `page(string $slug)` method backed by `PAGE_MAP` constant; added `static $cache` for file-read caching
- **Routes**: Updated `Routes.php` to pass page slugs as parameters to `Home::page()`
- **Tests**: Rewrote `HomeControllerTest.php` and `CssFilesTest.php` to test runtime behavior and properly validate CSS hex colors
- **Security**: Added `<?= csrf_field() ?>` to contact form
- **i18n**: Created 6 language files (`app/Language/{id,en,zh,fr,es,ja}/PTIndahTambang.php`)
- **Config**: `RenderPages.php` now uses `Config\App::supportedLocales` instead of hardcoded locale array
- **.gitignore**: Added `public/content/` exclusion for generated HTML files
- **Navbar**: Fixed `esc('ID')` → `esc('id')` locale label consistency
- **History view**: Removed no-op `'2005' : '2005'` ternary conditional
- **Composer**: Installed `erusev/parsedown` dependency for `RenderPages` command

### Review
- Code review found 12 findings (0 critical, 3 high, 6 moderate, 3 low) — all fixed
- 4 compound solution documents created in `.planning/solutions/`
- All 64 unit tests passing (200 assertions)