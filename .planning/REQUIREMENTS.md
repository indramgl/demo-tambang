# REQUIREMENTS.md — v1.0 Setup & Scaffold

## Project: PT Indah Tambang Raya Semesta — Company Profile Website

---

## v1 Requirements (In Scope)

### REQ-001: CI4 Project Scaffold
- **Description:** Scaffold CodeIgniter 4 project via `composer create-project codeigniter4/appstarter`
- **Success criteria:** `composer create-project` completes without errors, CI4 app runs via `php spark serve`
- **Dependencies:** PHP 8.2+ installed, Composer available

### REQ-002: `.gitignore`
- **Description:** Create `.gitignore` with CI4/VPS rules (`.env`, `vendor/`, `writable/`, `.opencode/`, IDE configs)
- **Success criteria:** `.gitignore` exists and covers all sensitive files
- **Dependencies:** None — must be created before any code

### REQ-003: Local Development Server
- **Description:** CI4 app running locally via `php spark serve` on `localhost:8080`
- **Success criteria:** `php spark serve` starts, app accessible at `localhost:8080`
- **Dependencies:** REQ-001

### REQ-004: Deployable to VPS
- **Description:** Project deployable to IDCloudhost VPS via `git pull origin master`
- **Success criteria:** Git remote configured, push to GitHub, pull on VPS works
- **Dependencies:** REQ-001, REQ-002

### REQ-005: Multilingual Directory Structure
- **Description:** Directory structure for multilingual pages: `app/Views/pages/{halaman}/{bahasa}.md`
- **Success criteria:** Directory structure exists for all 6 languages (ID, EN, ZH, FR, ES, JA)
- **Dependencies:** REQ-001

### REQ-006: CI4 + PHP 8.4 + OpenLitespeed Compatibility
- **Description:** Verify CI4 v4.7.4 works with PHP 8.4 and OpenLitespeed on VPS
- **Success criteria:** No compatibility errors, routing works on OpenLitespeed
- **Dependencies:** REQ-001

### REQ-007: Git Remote Configured
- **Description:** Git remote pointing to `https://github.com/indramgl/demo-tambang.git`, pushing to `master`
- **Success criteria:** `git push origin master` succeeds
- **Dependencies:** None

---

## v2 Requirements (Next Milestone Candidates)

### REQ-008: Multilingual Routing
- **Description:** CI4 routes handle `/id/`, `/en/`, `/zh/`, `/fr/`, `/es/`, `/ja/` URL segments
- **Success criteria:** Language switch works, correct content served per language

### REQ-009: Static Page Templates
- **Description:** CI4 views render markdown content as HTML pages with consistent layout
- **Success criteria:** All 6 pages render correctly in at least ID and EN

### REQ-010: Design Integration
- **Description:** Apply design.md from OpenDesign to CI4 views/templates
- **Success criteria:** Visual design matches OpenDesign spec
- **Dependencies:** design.md delivery from OpenDesign

---

## Out of Scope (v1)

| Item | Reasoning |
|------|-----------|
| Design integration | design.md from OpenDesign not yet delivered — blocks Phase 3 |
| Contact form / email | Phase 4 feature — Postmark integration not needed for scaffold |
| CMS / admin panel | Deliberately excluded — static content only |
| Portfolio / IR content | Phase 3+ content — scaffold has no content yet |
| Database logic | SQLite only for contact form (Phase 4) — not needed for v1 |
| User authentication | Not in scope for company profile website |
| Blog / news | Not in scope — static content only |

---

## Dependencies

1. `php spark serve` working → before REQ-003, REQ-004
2. `.gitignore` created → before REQ-002 (HIGH priority)
3. design.md → REQ-010 (blocks v2)
4. OpenLitespeed on VPS → REQ-006

---

## Open Items

1. Exact VPS installation path (TBD during installation)
2. OpenLitespeed static page cache configuration (validate during provisioning)
3. PHP-FPM `max_children=5` sufficient for staging load
4. CI4 `.htaccess` → OpenLitespeed rewrite rules (expected compatible, needs validation)

---

*Last updated: 2026-09-08*
