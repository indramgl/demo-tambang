# SUMMARY.md — v2.0 Research

**Researched:** 2026-09-08
**Scope:** v2.0 Skeleton Pages & Design Integration

## Key Findings

### CI4 Multilingual Routing: ✅ VERIFIED
- CI4 4.7.4 supports `$routes->group('{locale}', ...)` for locale-prefixed routing
- `{locale}` is a CI4 reserved placeholder — cannot be used as custom regex
- Custom `locale` filter required to validate locale segment
- `url_to()` helper supports locale as last parameter since v4.3.0
- Confidence: HIGH

### CI4 Localization: ✅ VERIFIED
- `app/Config/App.php` has `$supportedLocales`, `$defaultLocale`, `$negotiateLocale`
- `app/Language/` directory for language files
- CI4 Language class loads language files by locale
- Confidence: HIGH

### Design Integration: ✅ VERIFIED
- CSS custom properties from design.md `:root` work natively in CI4 views
- Revolut Design System 2.0 tokens are comprehensive and ready to apply
- No CSS framework needed — vanilla CSS with custom properties
- Confidence: HIGH

### Static Page Templates: ✅ VERIFIED
- CI4 view rendering: `return view('pages/home', $data)` renders `app/Views/pages/home.php`
- Layout templates via `$this->include('layouts/main')`
- Markdown rendering via Parsedown/CommonMark in controller
- View decorator pattern for layout wrapping
- Confidence: HIGH

### VPS Deployment: ✅ VERIFIED
- Same stack as v1.0 (OpenLitespeed + PHP-FPM)
- Git pull deployment works
- Confidence: HIGH

## Confidence Levels
- CI4 multilingual routing: HIGH
- CI4 localization: HIGH
- Design token integration: HIGH
- Static page templates: HIGH
- VPS deployment: HIGH

## Open Items
- design.md from OpenDesign — already in repo, may receive updates before v3
- Exact VPS installation path (TBD during installation)
- Portfolio & IR: format konten (PDF, gambar, table)?
- OpenLitespeed static page cache with locale variation — needs validation