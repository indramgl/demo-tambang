# Architecture — Research

**Researched:** 2026-09-07
**Updated:** 2026-09-07 (post new-project ceremony + ideation)

## Current State
The repository at `C:\Coding\perusahaan-tambang` is a **pre-scaffold project** with planning artifacts only. No source code exists yet.

- Git branch `master` with 8+ commits (all planning docs)
- `.planning/codebase/` exists with 7 research docs
- `.planning/phases/phase-0-setup/` exists (pause-work handoff)
- `.planning/notes/vps-provisioning.md` contains VPS specs
- Remote: `https://github.com/indramgl/demo-tambang.git`

## Architecture Pattern
**Traditional PHP Monolith on VPS** — single-server deployment with OpenLitespeed + PHP-FPM.

Not serverless, not microservices, not SPA.

## Layers
```
┌─────────────────────────────┐
│  CDN / Static Cache        │
│  (OpenLitespeed page cache) │
├─────────────────────────────┤
│  OpenLitespeed + PHP-FPM    │
│  (Ubuntu 26.04, 2 vCPU)    │
├─────────────────────────────┤
│  CI4 Application            │
│  (app/ + public/ + vendor/) │
├─────────────────────────────┤
│  SQLite (optional)          │
├─────────────────────────────┤
│  Contact Form (Postmark)    │
└─────────────────────────────┘
```

## Data Flow
1. User → OpenLitespeed (static cache) → PHP bootstrap → CI4 routing → view
2. Contact form → PHP controller → Postmark API → email delivery
3. Language switch → URL segment (`/id/`, `/en/`) → load corresponding content

## Key Abstractions
- **Static-first content** — markdown files as source of truth
- **CI4 views as templates** — single template per page
- **Translation JSON** — `app/Views/lang/{halaman}.{bahasa}.json` (flat key-value)
- **Fallback mechanism** — missing translation key → Indonesian

## Dependency Injection
- **None** — CI4 has no DI container in this project scope
- Composer autoload only

## Shared Utilities
- CI4 built-in helpers (URL, Form, Security)
- Custom markdown loader (Parsedown/CommonMark)

## Technology Stack
- PHP 8.5 + CodeIgniter 4 + Composer
- OpenLitespeed + PHP-FPM (max_children=5)
- SQLite (optional, contact form only)
- Postmark (email)
- Let's Encrypt (SSL)
- GitHub (source repo)

## Deployment
- **VPS:** IDCloudhost (Ubuntu 26.04, 2 vCPU, 4GB RAM, 40GB)
- **Method:** Git pull from GitHub `master`
- **SSL:** Let's Encrypt
- **Domain:** tambang.indramgl.web.id
- **OpenLitespeed:** cache level max, static page cache enabled
- **SSH:** password auth (demo), no firewall/backup/monitoring

## Design Reference
- **design.md** from OpenDesign — pending delivery, will drive frontend implementation
- When delivered, integrates into CI4 views as template system
- Blocks Phase 3 (Content Implementation)

## Build Order
1. Scaffold CI4 project on VPS
2. Setup OpenLitespeed + PHP-FPM
3. Create multilingual structure (`/id/`, `/en/`)
4. Implement static pages per language
5. Contact form (Postmark)
6. Deploy

## What Needs to Happen
1. **VPS provisioning** — IDCloudhost, Ubuntu 26.04, OpenLitespeed, PHP 8.5
2. **design.md delivery** — from OpenDesign (blocking dependency)
3. **CI4 scaffold** — Composer project, directory structure
4. **Deployment pipeline** — git pull workflow