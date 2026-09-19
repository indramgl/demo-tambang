# PITFALLS.md — v2.0 Research

**Researched:** 2026-09-08
**Scope:** v2.0 Skeleton Pages & Design Integration

## Known Pitfalls

### 1. `{locale}` is a CI4 Reserved Placeholder
- **Risk:** Cannot use `{locale}` as a custom regex placeholder in routes
- **Impact:** The `{locale}` segment in route groups is handled by CI4's localization system, not as a custom placeholder
- **Mitigation:** Use `{locale}` only in route groups, not in custom route definitions. Validate locale in a custom filter, not in the route pattern.
- **Status:** Known — CI4 4.7.4 routing docs confirm this

### 2. Locale Filter Must Be Custom
- **Risk:** CI4 has no built-in locale filter — must create a custom filter class
- **Impact:** Need to write `app/Filters/Locale.php` that validates the locale segment against the supported list
- **Mitigation:** Create a simple filter that checks `$request->getSegment(1)` against `['id', 'en', 'zh', 'fr', 'es', 'ja']` and redirects to default locale if invalid
- **Status:** Open — needs implementation in Phase 1 of v2.0

### 3. Default Locale Redirect
- **Risk:** Root URL `/` has no locale segment — need to redirect to `/id/`
- **Impact:** Users hitting the root URL get English content (CI4 default) instead of Indonesian
- **Mitigation:** Add a route for `/` that redirects to `/id/`. Set `$defaultLocale = 'id'` in `App.php`.
- **Status:** Known — CI4 default locale is 'en', must override to 'id'

### 4. Markdown File Naming Convention
- **Risk:** The `{halaman}.{bahasa}.md` convention from v1.0 may conflict with CI4's view naming
- **Impact:** CI4 views use `.php` extension; markdown files need a different naming convention
- **Mitigation:** Store markdown files as `{page}/{locale}.md` in `app/Views/pages/` and read them in the controller, not through CI4's view loader directly
- **Status:** Known — v1.0 convention needs adaptation for v2.0

### 5. Hreflang Tag Maintenance
- **Risk:** Hreflang tags must be correct for all 36 page×language combinations
- **Impact:** Wrong hreflang tags cause Google to index the wrong language version, hurting SEO
- **Mitigation:** Auto-generate hreflang tags in the layout template based on the content manifest and supported locales
- **Status:** Known — design.md section 5.2 specifies hreflang requirements

### 6. Design Token Drift
- **Risk:** CSS custom properties in `main.css` may drift from design.md tokens
- **Impact:** Visual inconsistency between design spec and actual rendering
- **Mitigation:** Sync design.md tokens to CSS via a script (`php spark design:sync`) as a pre-deploy hook
- **Status:** Known — identified in v1.0 ideation

### 7. OpenLitespeed Static Cache and Locale
- **Risk:** OpenLitespeed static page cache may serve the wrong locale's cached page
- **Impact:** An Indonesian user might get cached English content
- **Mitigation:** Configure OpenLitespeed cache to vary by URL path (locale segment is in the path, so this should work naturally)
- **Status:** Open — validate during v2.0 testing

### 8. PHP 8.4 + CI4 Compatibility on VPS
- **Risk:** CI4 v4.7.4 requires PHP ^8.2; VPS may have different PHP version
- **Impact:** Compatibility issues if VPS PHP version doesn't match dev environment
- **Mitigation:** Verify PHP version on VPS during provisioning; CI4 v4.7.4 is compatible with PHP 8.4
- **Status:** Open — VPS not yet provisioned (REQ-004 blocked)