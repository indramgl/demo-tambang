# STATE.md

## Current Position

Phase: 1 — Setup & Scaffold
Plan: —
Status: Planning
Last activity: 2026-09-08 — Milestone v1.0 started

## Last Milestone

None — this is the first milestone.

## Accumulated Context

### Decisions
- DEC-001: v1.0 Challenge Verdict — Reduced scope. Keep OpenLitespeed on VPS, use `php spark serve` for local testing. `.gitignore` must be created first.
- Stack: PHP 8.5 + CodeIgniter 4 + OpenLitespeed + PHP-FPM on IDCloudhost VPS
- Deployment: Git pull from GitHub `master`
- Domain: tambang.indramgl.web.id
- Multilingual: 6 languages (ID, EN, ZH, FR, ES, JA) via URL path routing
- Static content only — no CMS, no database
- Design: design.md from OpenDesign pending (blocks Phase 3)

### Blockers
- design.md from OpenDesign — blocks Phase 3
- CI4 PHP 8.5 + OpenLitespeed compatibility — needs verification during Phase 1
- `.gitignore` must be created before any code is written

### Open Questions
- Exact VPS installation path (TBD during installation)
- CI4 PHP 8.5 + OpenLitespeed compatibility on VPS
- design.md delivery date from OpenDesign
