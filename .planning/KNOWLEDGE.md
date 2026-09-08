---
updated: 2026-09-08
items: 18
---

# Project Knowledge Base

Aggregated learnings from 1 decision, 3 debug sessions, 1 retrospective, 5 research files, and 1 phase extraction.

---

## Decisions

### DEC-001: v1.0 Challenge Verdict — Setup & Scaffold
**Type:** scope
**Phase:** 01 | **Date:** 2026-09-08
**Choice:** Reduced scope with modification — keep OpenLitespeed on VPS (production), use `php spark serve` for local testing/scaffold development. Decouple local dev from production web server.
**Rationale:** Engineering lens flagged OpenLitespeed + CI4 compatibility and PHP 8.5 compatibility as MEDIUM risks. ROADMAP contradicted itself (Apache/nginx vs OpenLitespeed). Product lens confirmed the scaffold is sound. User resolved the conflict by decoupling local/prod architectures.
**Still active:** yes

---

## Lessons Learned

### 2026-09-08: CI4 Scaffold Fails on Non-Empty Directory
**From:** compounded solution `ci4-scaffold-windows.md`
**What broke:** `composer create-project codeigniter4/appstarter .` fails when the target directory already has files (`.gitignore`, `AGENTS.md`, etc.).
**Root cause:** CI4's `create-project` refuses to overwrite existing files in a non-empty directory.
**Lesson:** Scaffold to a temp directory first, then selectively copy CI4-generated files into the project directory. Preserve existing project files by only copying CI4 output.

### 2026-09-08: Composer Not Pre-Installed on Windows PHP
**From:** compounded solution `composer-install-windows.md`
**What broke:** Composer is not available on fresh Windows PHP installations.
**Root cause:** Windows PHP distributions don't include Composer.
**Lesson:** Install Composer globally using the official installer before running any CI4 scaffold commands. Add PHP directory to PATH for global access.

### 2026-09-08: Xdebug Defaults to Coverage Mode on Windows
**From:** compounded solution `xdebug-config-windows.md`
**What broke:** Xdebug is installed but in `coverage` mode, not `debug` mode needed for step debugging.
**Root cause:** Xdebug v3.x defaults to `coverage` mode; `debug` mode must be explicitly set.
**Lesson:** Change `xdebug.mode` in `php.ini` from `coverage` to `debug` after installing Xdebug. Verify with `php -m | grep xdebug`.

### 2026-09-08: PHP Version May Differ from Plan
**From:** phase 01 learnings (`01-LEARNINGS.md`)
**What happened:** PHP 8.4.20 was installed instead of PHP 8.5 as planned.
**Root cause:** Planning assumption didn't match the actual installed version.
**Lesson:** Always verify `php -v` before planning. CI4 v4.7.4 requires PHP ^8.2, so 8.4 is compatible — but future plans should check the actual version first.

### 2026-09-08: PowerShell Lacks Unix Shell Conveniences
**From:** phase 01 learnings (`01-LEARNINGS.md`)
**What happened:** PowerShell 5.1 on Windows doesn't support `&&` for chaining or `head` for truncation.
**Root cause:** PowerShell syntax differs from Bash.
**Lesson:** Use `;` for command chaining and `Select-Object -First` for truncation in PowerShell. Consider using Bash/WSL for shell scripts.

### 2026-09-08: VPS Provisioning Is an External Blocker
**From:** phase 01 learnings (`01-LEARNINGS.md`)
**What happened:** REQ-004 (VPS deploy pipeline) was blocked because no VPS was provisioned.
**Root cause:** External dependency outside code scope.
**Lesson:** External blockers should be tracked separately. Code tasks can proceed independently of infrastructure provisioning.

---

## Patterns That Work

- **Decoupled Local/Production Architecture:** Use `php spark serve` for local dev and OpenLitespeed + PHP-FPM on VPS. Different web servers for each environment avoid Windows/Unix friction and simplify local setup.
- **Git-Based Deployment Pipeline:** Push to GitHub, pull on VPS. Simplest deployment model for static sites — no CI/CD pipeline needed.
- **Standard CI4 .env Pattern:** `.env.example` committed, `.env` gitignored, VPS has its own `.env`. Prevents configuration drift and secret leaks.
- **Markdown Content in CI4 Views:** Static content written as markdown files in `app/Views/pages/{halaman}/{bahasa}.md`, rendered through CI4 view templates. Eliminates CMS/database complexity.
- **`.gitignore` First:** Always create `.gitignore` before any other file. Prevents accidental commits of `.env`, `vendor/`, `writable/`, and IDE configs.

---

## Anti-Patterns to Avoid

- **Scaffolding CI4 into Non-Empty Directory:** `composer create-project` refuses to install into a directory that already has files. Always scaffold to a temp dir first, then copy selectively.
- **Assuming PHP Version Matches Plan:** The plan assumed PHP 8.5 but 8.4.20 was installed. Always verify the actual PHP version before planning.
- **PowerShell Unix Assumptions:** Writing shell scripts that assume `&&`, `head`, or other Unix utilities will fail on Windows PowerShell. Use PowerShell-native alternatives or Bash/WSL.
- **Skipping `.gitignore`:** Without `.gitignore` created first, sensitive files (`.env`, `vendor/`, `writable/`) risk being committed to GitHub.

---

## Libraries & Tools

| Tool | Use for | Notes |
|------|---------|-------|
| CodeIgniter 4 v4.7.4 | PHP framework | Requires PHP ^8.2; PHP 8.4/8.5 compatible |
| Composer | PHP dependency manager | Not pre-installed on Windows PHP; install globally |
| OpenLitespeed | Production web server on VPS | Supports Apache `mod_rewrite` syntax natively |
| PHP-FPM | PHP process manager | `max_children=5` sufficient for static site on 4GB RAM |
| Xdebug v3.5.1 | PHP debugging | Pre-installed on Windows; set `xdebug.mode=debug` in `php.ini` |
| SQLite | Optional database | Only needed for contact form (Phase 4) |
| Postmark (`wildbit/postmark-php`) | Email for contact form | Phase 4 only, not needed for v1.0 |
| Let's Encrypt | SSL certificates | Domain: `tambang.indramgl.web.id` |
| Parsedown/CommonMark | Markdown → HTML rendering | For multilingual markdown content in CI4 views |

---

## Open Questions

- Exact VPS installation path (TBD during installation) — from `vps-provisioning.md`
- OpenLitespeed static page cache configuration needs validation on VPS — from `PITFALLS.md` and `SUMMARY.md`
- PHP-FPM `max_children=5` sufficient for staging load — from `PITFALLS.md`
- CI4 `.htaccess` → OpenLitespeed rewrite rules (expected compatible, needs validation) — from `REQUIREMENTS.md`
- design.md delivery date from OpenDesign — blocks Phase 3
- Portfolio & Investor Relation: format konten (PDF, gambar, table)? — from `PROJECT.md`
- VPS password SSH auth is open (demo only) — needs SSH key auth before production — from `vps-provisioning.md`
- No firewall configured (demo only) — from `vps-provisioning.md`
- No backup or monitoring configured (demo only) — from `vps-provisioning.md`

---

*Last updated: 2026-09-08*