# ARCHITECTURE.md — v2.0 Research

**Researched:** 2026-09-08
**Scope:** v2.0 Skeleton Pages & Design Integration

## Architecture Pattern

**Traditional PHP Monolith on VPS** — single-server deployment, same as v1.0.

```
┌─────────────────────────────┐
│  CDN / Static Cache        │
│  (OpenLitespeed page cache)│
├─────────────────────────────┤
│  OpenLitespeed + PHP-FPM   │
│  (Ubuntu 26.04, 2 vCPU)   │
├─────────────────────────────┤
│  CI4 Application            │
│  ├── Routes (locale group) │
│  ├── Controllers (Home)    │
│  ├── Views (pages + layouts)│
│  ├── Language files (6)    │
│  └── Assets (CSS/JS)       │
├─────────────────────────────┤
│  Static Content             │
│  (markdown in views dir)   │
└─────────────────────────────┘
```

## Multilingual Routing Architecture

```
Request: /id/sejarah
  ↓
OpenLitespeed → CI4 index.php
  ↓
Routes.php: $routes->group('{locale}', ['filter' => 'locale'], ...)
  ↓
Locale filter validates 'id' against supported list
  ↓
Home::history() called with $locale = 'id'
  ↓
Controller reads app/Views/pages/history/id.md
  ↓
Parsedown converts markdown to HTML
  ↓
View wraps in layouts/main.php with locale-aware hreflang tags
  ↓
Response: HTML page in Indonesian
```

## Key Architectural Decisions

### Route Group Pattern
- `{locale}` is a CI4 reserved placeholder for localization
- Custom `locale` filter validates the segment
- All page routes nested inside the locale group
- Root URL (`/`) redirects to `/id/` (default locale)

### View Rendering Pipeline
1. Controller extracts locale from URL segment
2. Controller resolves markdown file path: `app/Views/pages/{$page}/{$locale}.md`
3. Controller reads markdown content
4. Controller converts markdown to HTML via Parsedown/CommonMark
5. Controller passes HTML + metadata to view
6. View wraps in `layouts/main.php` with hreflang tags and language switcher

### Design Token Integration
- CSS custom properties defined in `:root` in `main.css`
- All colors via `var(--*)` — no hardcoded hex values
- Design tokens from design.md applied directly
- No CSS framework — vanilla CSS with custom properties

### Content Storage
- Markdown files in `app/Views/pages/{halaman}/{bahasa}.md`
- One file per page per language
- CI4 view loader reads the file, converts to HTML
- No database, no CMS

## Local vs Production Decoupling

| Aspect | Local Dev | Production VPS |
|--------|-----------|----------------|
| Web Server | `php spark serve` | OpenLitespeed + PHP-FPM |
| URL | `localhost:8080` | `tambang.indramgl.web.id` |
| SSL | None | Let's Encrypt |
| Config | `.env` local | `.env` on VPS |
| Deployment | N/A | Git pull from GitHub |

## Open Questions
- design.md from OpenDesign — already in repo, may receive updates before v3
- Exact VPS installation path (TBD during installation)
- Portfolio & IR: format konten (PDF, gambar, table)?