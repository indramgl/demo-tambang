# Phase 01 — Setup & Scaffold: Plan

**Status:** Ready for review
**Created:** 2026-09-08
**Mode:** deep

---

## Goal

CI4 project scaffolded and deployable to staging VPS. Local dev with `php spark serve`. No design integration, no contact form, no CMS — pure infrastructure.

---

## Must-Haves

1. CI4 scaffolded and `php spark serve` returns 200 on `localhost:8080`
2. Git remote configured and `git push origin master` succeeds
3. VPS deploy pipeline tested — `git pull origin master` + OpenLitespeed serves app
4. Multilingual directory structure exists for all 6 languages (ID, EN, ZH, FR, ES, JA)
5. PHP 8.5 + CI4 + OpenLitespeed compatibility verified

---

## Decisions Applied

| Decision | Mapped Tasks |
|----------|-------------|
| DEC-001: OpenLitespeed on VPS, `php spark serve` for local, decoupled architecture | 1.2, 1.3, 2.1, 2.5, 2.6, 3.1 |
| DEC-001: Standard CI4 .env pattern | 1.1 |
| DEC-001: Xdebug + CI4 error pages | 2.6 |

---

## Waves

### Wave 1 — Foundation (Day 1)

#### Task 1.1 — Verify `.gitignore` (REQ-002)
- **Action:** Verify `.gitignore` exists and covers all required patterns
- **Files:** `.gitignore`
- **Verify:** `test-path .gitignore` returns true; file contains `.env`, `vendor/`, `writable/`, `.opencode/`, IDE config patterns
- **Done:** `.gitignore` committed and pushed

#### Task 1.2 — Scaffold CI4 via Composer (REQ-001)
- **Action:** Run `composer create-project codeigniter4/appstarter` to scaffold the project
- **Files:** `app/`, `public/`, `vendor/`, `composer.json`, `.env.example`
- **Verify:** `composer create-project` exits 0; CI4 directory structure exists; `php spark serve` starts without errors
- **Done:** CI4 project scaffolded, directory structure verified

#### Task 1.3 — Configure Git Remote (REQ-007)
- **Action:** Add GitHub remote and verify push access
- **Files:** `.git/config`
- **Verify:** `git remote -v` shows origin as `https://github.com/indramgl/demo-tambang.git`; `git push origin master` succeeds
- **Done:** Git remote configured, push to GitHub confirmed

### Wave 2 — Local Validation (Day 2)

#### Task 2.1 — Verify `php spark serve` (REQ-003) — implements DEC-001 local dev
- **Action:** Start CI4 dev server and confirm the welcome page renders
- **Files:** `app/`, `public/`
- **Verify:** `php spark serve` starts on `localhost:8080`; HTTP GET returns 200 with CI4 welcome page
- **Done:** Local dev server confirmed working

#### Task 2.2 — Create Multilingual Directory Structure (REQ-005)
- **Action:** Create `app/Views/pages/{halaman}/{bahasa}.md` directories for all 6 languages
- **Files:** `app/Views/pages/`
- **Verify:** Directories exist for ID, EN, ZH, FR, ES, JA under `app/Views/pages/{halaman}/`
- **Done:** All 6 language directories created

#### Task 2.3 — Verify PHP 8.5 Compatibility (REQ-006 part a)
- **Action:** Check PHP version and CI4 requirements
- **Files:** N/A (system check)
- **Verify:** `php -v` reports PHP 8.5.x; CI4 v4.7.4 requires PHP ^8.2 — version satisfies requirement
- **Done:** PHP 8.5 confirmed compatible with CI4 v4.7.4

#### Task 2.4 — Verify CI4 Application Compatibility (REQ-006 part b)
- **Action:** Run CI4 built-in checks and confirm routing works
- **Files:** `app/`, `public/`
- **Verify:** `php spark list` shows routes; no PHP errors or warnings; CI4 error pages render correctly
- **Done:** CI4 application runs without compatibility errors

#### Task 2.5 — Verify OpenLitespeed Rewrite Rules (REQ-006 part c) — implements DEC-001 VPS architecture
- **Action:** Validate CI4 `.htaccess` works with OpenLitespeed rewrite rules
- **Files:** `.htaccess`, `public/.htaccess`
- **Verify:** OpenLitespeed rewrite module active; CI4 `.htaccess` rewrite rules parse without errors; URL rewriting functions correctly
- **Done:** OpenLitespeed + CI4 rewrite rules confirmed compatible

#### Task 2.6 — Configure Xdebug for Local Debugging (CONTEXT.md decision)
- **Action:** Install and configure Xdebug with CI4 error pages for step debugging
- **Files:** `php.ini` (Xdebug config), CI4 error handler
- **Verify:** `php -m | grep xdebug` returns a result; `xdebug.mode=debug` is set; CI4 error pages display step-debug links
- **Done:** Xdebug configured and working with CI4 error pages

### Wave 3 — VPS Deploy (Day 3)

#### Task 3.1 — Test VPS Deploy Pipeline (REQ-004) — implements DEC-001 VPS architecture
- **Action:** Push to GitHub, pull on VPS, verify app serves via OpenLitespeed + PHP-FPM
- **Files:** VPS document root (`/var/www/html/` or configured path)
- **Verify:** `git pull origin master` succeeds on VPS; OpenLitespeed serves the app correctly; PHP-FPM processes requests; HTTPS via Let's Encrypt
- **Done:** Full deploy pipeline tested and working

---

## Vertical Slices

Each wave is a demoable increment:

- **Wave 1 demo:** CI4 project scaffolded, git remote configured, `.gitignore` in place
- **Wave 2 demo:** Local dev server running, multilingual structure created, PHP/CI4/OpenLitespeed compatibility verified, Xdebug configured
- **Wave 3 demo:** Full deploy pipeline tested — push to GitHub, pull on VPS, app serves via OpenLitespeed + PHP-FPM

---

## Risks

| Risk | Mitigation |
|------|------------|
| OpenLitespeed rewrite rules may need tuning | CI4 `.htaccess` uses standard `mod_rewrite` — OpenLitespeed supports this natively; validate in Task 2.5 |
| PHP 8.5 + CI4 compatibility unverified on actual VPS | Research confirmed CI4 v4.7.4 requires PHP ^8.2; PHP 8.5 satisfies this; validate in Task 2.3 |
| VPS provisioning not yet started | Blocks REQ-004; start provisioning in parallel with Wave 2 |

---

## Out of Scope (v1)

- Design integration (design.md pending)
- Contact form / email
- CMS / admin panel
- Portfolio / IR content
- Database logic
- User authentication
- Blog / news

---

## Notes

- `.gitignore` (REQ-002) is already complete — Task 1.1 is a verification step
- Phase 1 estimated at 2-3 days (solo, prototype quality)
- design.md from OpenDesign blocks Phase 3, not v1.0