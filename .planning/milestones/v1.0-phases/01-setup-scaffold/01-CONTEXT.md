# Phase 01 — Setup & Scaffold - Context

**Gathered:** 2026-09-08
**Mode:** deep
**Status:** Ready for planning

<domain>
## Phase Boundary

CI4 project scaffolded and deployable to staging VPS. Local dev with `php spark serve`. No design integration, no contact form, no CMS — pure infrastructure.

</domain>

<decisions>
## Implementation Decisions

### Local Dev Environment
- **Hot reload:** `php spark serve` with auto-reload — CI4 built-in server handles file watching
- **.env management:** Standard CI4 .env pattern — `.env.example` committed, `.env` gitignored, VPS has its own `.env`
- **Debugging:** Xdebug + CI4 error pages for step debugging locally

### VPS Architecture
- **Production web server:** OpenLitespeed + PHP-FPM (confirmed via challenge DEC-001)
- **Local dev:** `php spark serve` (decoupled from production web server)
- **Deployment:** Git pull from GitHub `master`

### OpenLitespeed + CI4 Compatibility
- **Rewrite rules:** CI4 `.htaccess` uses Apache `mod_rewrite` syntax — OpenLitespeed supports this natively
- **Document root:** Must point to `public/` directory (CI4 standard)
- **No modification needed** for `.htaccess` on OpenLitespeed

### PHP 8.5 + CI4
- **CI4 v4.7.4** requires PHP ^8.2 — PHP 8.5 is compatible
- **Confidence:** HIGH

### .gitignore Strategy
- **Must be created BEFORE any code** (HIGH priority from CONCERNS.md)
- Covers: `.env`, `vendor/`, `writable/`, `.opencode/`, IDE configs
- Already created in this session

### Scope
- **Anti-goals locked:** No design integration, no contact form, no CMS, no admin panel, no database logic, no portfolio/IR
- **Local/Production decoupled:** Different web servers for local vs VPS

</decisions>

<specifics>
## Specific Ideas

- Xdebug for local debugging — user explicitly chose this over simple dump debugging
- Auto-reload via `php spark serve` — user confirmed over manual restart or external watcher
- Standard CI4 .env pattern — user confirmed over environment variables only or separate .env files

</specifics>

<canonical_refs>
## Canonical References

- `.planning/DECISIONS.md` — DEC-001 (challenge verdict)
- `.planning/REQUIREMENTS.md` — v1.0 requirements (REQ-001 through REQ-007)
- `.planning/ROADMAP.md` — v1.0 roadmap (Phase 1 tasks)
- `.planning/research/STACK.md` — CI4 + OpenLitespeed + PHP 8.5 compatibility verified
- `.planning/research/ARCHITECTURE.md` — architecture compatibility details
- `.planning/codebase/CONCERNS.md` — HIGH risk: no .gitignore, OpenLitespeed concerns

</canonical_refs>

<code_context>
## Existing Code Insights

### No Existing Code
- Repository is pre-scaffold — no source code exists yet
- All planning artifacts are in `.planning/`
- Git repo has 10+ commits of planning docs only

### Established Patterns
- Static-first architecture (markdown content, CI4 views as templates)
- Git-based deployment (pull from GitHub)
- Multilingual directory structure planned (`app/Views/pages/{halaman}/{bahasa}.md`)

### Integration Points
- OpenLitespeed will serve from `public/` directory (CI4 standard)
- PHP-FPM handles PHP execution
- Git pull deploys code to VPS

</code_context>

<deferred>
## Deferred Ideas

- Docker for local dev (could simplify environment setup) — deferred to v2 if needed
- CI4 caching configuration for OpenLitespeed — defer to Phase 5 (Deploy & Test)
- SSH key auth setup for VPS — defer to Phase 5 (production hardening)

</deferred>

---
*Phase: 01-setup-scaffold*
*Context gathered: 2026-09-08*