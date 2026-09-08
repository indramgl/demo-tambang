---
version: v1.0
created: 2026-09-08
status: ready
---

# Milestone Context: v1.0 — Setup & Scaffold

## Goals

- CI4 project scaffolded via Composer with working routing
- VPS-ready deployment pipeline (Git pull from GitHub)
- Basic project structure functional enough to deploy to staging

## Must-Have Features

- Composer-initiated CodeIgniter 4 project with `composer create-project`
- `.gitignore` created BEFORE any code (HIGH priority — CONCERNS.md #1)
- CI4 app running locally via `php spark serve` for testing
- Basic CI4 app deployable to VPS via Git pull
- `.gitignore` and initial CI4 config (app.baseURL, database, etc.)
- Directory structure for multilingual pages (`app/Views/pages/{halaman}/{bahasa}.md`)
- Git remote configured and pushing to `https://github.com/indramgl/demo-tambang.git`

## Local Development Approach

- **Local testing**: `php spark serve` (CI4 built-in PHP development server)
- **Production server**: OpenLitespeed + PHP-FPM on IDCloudhost VPS
- These are decoupled — local dev does NOT require OpenLitespeed

## Anti-Goals

- **No design integration** — design.md from OpenDesign not yet available; no styling/templates touched
- **No contact form / email delivery** — that's Phase 4
- **No CMS, admin panel, or dynamic features** — static content only
- **No portfolio/IR documents** — save for Phase 3+
- **No multilingual routing yet** — language structure only defined, not implemented

## Constraints

- **Scope**: Solo developer, ~2-3 days
- **Quality bar**: Prototype — get the foundation right, polish comes later
- **Off-limits areas**: `.planning/` (completed), design/templates, contact forms, portfolio/IR, database logic
- **Architecture constraints**: VPS traditional (IDCloudhost), OpenLitespeed + PHP-FPM, password SSH (demo), no firewall/backup/monitoring

## Open Questions

- Exact VPS installation path (TBD during installation)
- Whether to start CI4 project before or after VPS setup
- design.md from OpenDesign still pending (blocks Phase 3, not this phase)
- CI4 PHP 8.5 compatibility still needs verification on VPS (OpenLitespeed)
- `.gitignore` must be created first — before any `composer install`

## Dependencies

- design.md not needed for v1.0
- VPS provisioning not strictly required for local scaffold but blocks staging deployment
- No external APIs or services needed this milestone
