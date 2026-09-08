# Tech Stack Overview

**Researched:** 2026-09-07
**Updated:** 2026-09-07 (post new-project ceremony + ideation)

## Languages & Runtime
- **PHP 8.5** — CodeIgniter 4 framework runtime
- **Composer** — dependency manager

## Frameworks
- **CodeIgniter 4** (PHP MVC framework)
- No frontend framework (static content, vanilla HTML/CSS/JS)

## Key Libraries & Dependencies
- `codeigniter4/framework` (Composer)
- `wildbit/postmark-php` (email delivery for contact form)
- Parsedown or CommonMark (markdown → HTML conversion)
- SQLite extension (PHP)

## Build Configuration
- **Web Server:** OpenLitespeed with PHP-FPM
- **OS:** Ubuntu 26.04
- **VPS:** IDCloudhost (2 vCPU, 4GB RAM, 40GB Storage)

## Environment Variables
- `.env` for app.baseURL, database config, Postmark API key
- `.env` includes: app.baseURL, database.host, database.user, database.password, postmark.api_key

## Current State
- Git repo (`master` branch) with 8+ commits (planning artifacts)
- `.planning/codebase/` directory exists with 7 research docs
- `.planning/` has PROJECT.md, REQUIREMENTS.md, ROADMAP.md, config.json, notes/, research/, phases/
- No source code yet — codebase is in planning/pre-scaffold phase
- design.md pending from OpenDesign (blocks Phase 3)

## Recommended Next Step
Scaffold CI4 project on VPS (Phase 1). Re-run this research after source code is added.

## Design Reference
- **design.md** — to be provided by OpenDesign, will drive frontend implementation
- Not yet delivered, noted as blocking dependency