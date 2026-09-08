# External Integrations

**Researched:** 2026-09-07
**Updated:** 2026-09-07 (post new-project ceremony + ideation)

## External APIs
- **Postmark** — email delivery service for contact form (`wildbit/postmark-php` PHP SDK)
- **OpenDesign** — design.md reference (blocked, pending delivery)

## Databases
- **SQLite** — lightweight database for contact form submissions only
- Optional — not required for static content
- No ORM, raw PHP SQLite3 extension

## Auth Providers
- **None** — no user authentication required (static site, no login)

## Webhooks
- **None** — no webhook integrations planned

## Message Queues
- **None** — no message broker needed (static content, minimal dynamic processing)

## Hosting & Deployment
- **IDCloudhost** — VPS provider
- **GitHub** — source code repository (`git@github.com:indramgl/demo-tambang.git`)
- **Deployment:** Git pull from `master` branch
- **SSL:** Let's Encrypt (no auto-renew for demo)
- **Domain:** tambang.indramgl.web.id

## Server Configuration
- **Web Server:** OpenLitespeed
- **PHP-FPM:** max_children = 5, PHP 8.5
- **OS:** Ubuntu 26.04
- **SSH:** password auth (open for demo)

## Caching
- **OpenLitespeed:** max cache level, static page cache enabled

## Email Configuration
- **Provider:** Postmark
- **CI4 Dependency:** `wildbit/postmark-php` via Composer
- **Use Case:** Contact form email delivery only
- **No database storage for emails** (direct send approach preferred)

## Current State
- Repository is empty (no source code yet)
- All integrations defined in planning phase, none implemented
- design.md integration blocked on OpenDesign delivery

## Recommended Next Step
Set up VPS + OpenLitespeed + PHP-FPM (Phase 1). Add Postmark dependency during contact form implementation.