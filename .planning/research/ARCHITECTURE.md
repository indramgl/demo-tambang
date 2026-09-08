# ARCHITECTURE.md — v1.0 Research

**Researched:** 2026-09-08
**Scope:** v1.0 Setup & Scaffold capabilities

## Architecture Pattern

**Traditional PHP Monolith on VPS** — single-server deployment.

```
┌─────────────────────────────┐
│  CDN / Static Cache        │
│  (OpenLitespeed page cache)│
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

## Local vs Production Decoupling

| Aspect | Local Dev | Production VPS |
|--------|-----------|----------------|
| Web Server | `php spark serve` | OpenLitespeed + PHP-FPM |
| URL | `localhost:8080` | `tambang.indramgl.web.id` |
| SSL | None | Let's Encrypt |
| Config | `.env` local | `.env` on VPS |
| Deployment | N/A | Git pull from GitHub |

## OpenLitespeed + CI4 Compatibility

- OpenLitespeed supports Apache `mod_rewrite` syntax
- CI4's `.htaccess` uses `mod_rewrite` directives
- **No modification needed** — `.htaccess` works as-is on OpenLitespeed
- OpenLitespeed's rewrite engine is Apache-compatible
- **Confidence:** HIGH

## PHP 8.5 Compatibility

- CI4 v4.7.4 requires PHP ^8.2
- PHP 8.5 satisfies this requirement
- **Confidence:** HIGH

## Key Risks
- OpenLitespeed specific configuration (cache levels, page cache) needs validation during Phase 1 provisioning
- PHP-FPM `max_children=5` on 4GB RAM — sufficient for static site load