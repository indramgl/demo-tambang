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

### Learnings
- PHP 8.4.20 is installed on the dev machine (not PHP 8.5 as planned) — CI4 v4.7.4 requires PHP ^8.2, so 8.4 is compatible
- Xdebug v3.5.1 is pre-installed with PHP — no additional installation needed
- CI4 `.htaccess` uses standard `mod_rewrite` syntax — OpenLitespeed supports this natively, no rewrite rule modifications needed
- `composer create-project` cannot install into a non-empty directory — scaffold to temp dir then copy files
- PowerShell on Windows does not support `&&` or `head` — use `;` for command chaining and `Select-Object -First` for truncation