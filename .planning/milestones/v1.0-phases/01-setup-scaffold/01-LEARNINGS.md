---
phase: 01
phase_name: Setup & Scaffold
extracted: 2026-09-08
plan_count: 1
summary_count: 1
missing_artifacts: VERIFICATION.md, UAT.md, SECURITY.md
---

# Phase 01: Setup & Scaffold — Learnings

## Decisions

### D1: Decoupled Local/Production Architecture
**What:** Use `php spark serve` for local dev and OpenLitespeed + PHP-FPM on VPS, rather than matching production locally.
**Why:** CI4's built-in server handles auto-reload without extra tooling; OpenLitespeed is the production web server per DEC-001; decoupling avoids Windows/Unix dev environment friction.
**Source:** `01-PLAN.md` (Wave 1, Task 1.2), `01-CONTEXT.md` (Local Dev Environment, VPS Architecture), `01-DISCUSSION-LOG.md` (Local Dev Environment Setup)

### D2: Standard CI4 .env Pattern
**What:** `.env.example` committed, `.env` gitignored, VPS has its own `.env`.
**Why:** CI4's built-in pattern is well-documented, works for both local and VPS, and avoids environment-specific configuration drift.
**Source:** `01-CONTEXT.md` (Local Dev Environment), `01-DISCUSSION-LOG.md` (.env Management)

### D3: Xdebug + CI4 Error Pages for Debugging
**What:** Xdebug for step debugging locally, CI4 error pages for quick diagnostics.
**Why:** Xdebug provides full step debugging capability; CI4 error pages give instant visual diagnostics without setup overhead.
**Source:** `01-CONTEXT.md` (Local Dev Environment), `01-DISCUSSION-LOG.md` (Debugging)

### D4: Static-First Architecture
**What:** Markdown content served through CI4 views as templates — no CMS, no database, no dynamic content.
**Why:** Company profile website is inherently static; eliminates CMS/database complexity and attack surface.
**Source:** `01-PLAN.md` (Out of Scope), `01-CONTEXT.md` (Scope, Code Context)

### D5: Git-Based Deployment
**What:** `git pull origin master` on VPS for deployment.
**Why:** Simplest deployment model; no CI/CD pipeline needed for a static site; aligns with VPS traditional hosting approach.
**Source:** `01-CONTEXT.md` (VPS Architecture), `01-PLAN.md` (Wave 3, Task 3.1)

### D6: Multilingual via URL Path Routing
**What:** 6 languages (ID, EN, ZH, FR, ES, JA) served via URL path segments (`/id/`, `/en/`, etc.).
**Why:** URL-based routing is CI4-native and simplest to implement for a static multilingual site.
**Source:** `01-PLAN.md` (Tasks), `01-CONTEXT.md` (Code Context)

## Lessons

### L1: PHP Version May Differ from Plan
**What happened:** PHP 8.4.20 was installed on the dev machine, not PHP 8.5 as planned. CI4 v4.7.4 requires PHP ^8.2, so 8.4 is compatible.
**Why it matters:** Always verify actual PHP version before planning; the plan assumed 8.5 but 8.4 works fine for CI4 v4.7.4. Future plans should check `php -v` first.
**Source:** `01-PLAN.md` (Task 2.3 notes), CHANGELOG.md (Learnings)

### L2: PowerShell Limitations on Windows
**What happened:** PowerShell 5.1 does not support `&&` for command chaining or `head` for output truncation. Required workarounds (`;` for chaining, `Select-Object -First` for truncation).
**Why it matters:** Shell scripts written for Unix shells won't work on Windows PowerShell. Future automation should account for this or use Bash/WSL.
**Source:** `01-DISCUSSION-LOG.md`, CHANGELOG.md (Learnings)

### L3: `composer create-project` Requires Empty Directory
**What happened:** `composer create-project` cannot install into a non-empty directory. Had to scaffold to a temp directory then copy files.
**Why it matters:** This is a CI4-specific gotcha. Future scaffolding should always start from an empty directory or use a temp dir as intermediate.
**Source:** CHANGELOG.md (Learnings)

### L4: `.gitignore` Must Be Created First
**What happened:** `.gitignore` was identified as HIGH priority and created before any other code. This prevented sensitive files from being committed.
**Why it matters:** `.gitignore` is the first line of defense against accidentally committing secrets (`.env`, vendor files, IDE configs). Always create it before any other file.
**Source:** `01-PLAN.md` (Task 1.1), `01-CONTEXT.md` (.gitignore Strategy)

### L5: VPS Provisioning Is an External Blocker
**What happened:** REQ-004 (VPS deploy pipeline) was blocked because no VPS was provisioned. This is an external dependency, not a code issue.
**Why it matters:** External blockers can't be solved with code changes. They need to be tracked separately and planned for in the next phase. The 6/7 delivery rate reflects this reality.
**Source:** `01-PLAN.md` (Risks), `v1.0-MILESTONE-AUDIT.md`, `01-SUMMARY.md`

## Patterns

### P1: Decoupled Local/Production Web Servers
**When to use:** When local dev environment differs significantly from production (e.g., Windows dev, Linux VPS). Use the best tool for each environment.
**Source:** `01-CONTEXT.md` (VPS Architecture), `01-DISCUSSION-LOG.md` (Local Dev Environment Setup)

### P2: Git-Based Deployment Pipeline
**When to use:** For static sites or simple deployments where CI/CD is overkill. Push to GitHub, pull on server.
**Source:** `01-CONTEXT.md` (VPS Architecture), `01-PLAN.md` (Wave 3)

### P3: Standard CI4 .env Pattern for Environment Management
**When to use:** Any CI4 project that needs environment-specific configuration (local, staging, production).
**Source:** `01-CONTEXT.md` (Local Dev Environment), `01-DISCUSSION-LOG.md` (.env Management)

### P4: Markdown Content in CI4 Views for Static Pages
**When to use:** For static content sites where content is written in markdown and rendered through CI4 view templates.
**Source:** `01-CONTEXT.md` (Code Context), `01-PLAN.md` (Out of Scope — no CMS)

## Surprises

### S1: PHP 8.4 Installed Instead of PHP 8.5
**What was surprising:** The plan assumed PHP 8.5, but the dev machine has PHP 8.4.20. This was a planning assumption that didn't match reality.
**Impact:** Minor — CI4 v4.7.4 is compatible with PHP 8.4. No code changes needed, but future plans should verify the actual PHP version first.
**Source:** `01-PLAN.md` (Task 2.3), CHANGELOG.md (Learnings)

### S2: PowerShell Lacks Unix Shell Conveniences
**What was surprising:** PowerShell 5.1 on Windows doesn't support `&&` for chaining or `head` for truncation, requiring different syntax than expected.
**Impact:** Slowed down some automation tasks; required learning PowerShell-specific alternatives.
**Source:** CHANGELOG.md (Learnings)

### S3: `composer create-project` Fails on Non-Empty Directories
**What was surprising:** The standard Composer command refuses to install into a directory that already has files, which wasn't anticipated in the plan.
**Impact:** Required an extra step (scaffold to temp dir, then copy). A minor workflow disruption.
**Source:** CHANGELOG.md (Learnings)

---

*Extracted from Phase 01 artifacts on 2026-09-08*