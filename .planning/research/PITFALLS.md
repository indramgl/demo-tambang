# PITFALLS.md — v1.0 Research

**Researched:** 2026-09-08
**Scope:** v1.0 Setup & Scaffold capabilities

## Known Pitfalls

### 1. No `.gitignore` Before First Commit (HIGH)
- **Risk:** `.env`, `vendor/`, `writable/` leak into GitHub
- **Mitigation:** Create `.gitignore` BEFORE `composer install` or any code
- **Status:** `.gitignore` already created in this session

### 2. OpenLitespeed Cache Configuration
- **Risk:** Static page cache misconfiguration → every request hits PHP-FPM
- **Impact:** With `max_children=5` on 4GB RAM, concurrent requests can exhaust PHP-FPM → 502 errors
- **Mitigation:** Configure OpenLitespeed static page cache during VPS provisioning
- **Status:** Open — validate during Phase 1

### 3. CI4 `public/` Directory as Document Root
- **Risk:** CI4's `index.php` is inside `public/`, not project root
- **Impact:** OpenLitespeed must be configured to point to `public/` as document root
- **Mitigation:** Standard CI4 deployment — set document root to `/public`
- **Status:** Known, standard configuration

### 4. PHP 8.5 + CI4 Edge Cases
- **Risk:** CI4 4.x may have untested edge cases on PHP 8.5
- **Impact:** Deprecation warnings or runtime errors
- **Mitigation:** Test locally with `php spark serve` first; check CI4 changelog for PHP 8.5 notes
- **Status:** Monitor during Phase 1

### 5. VPS Password SSH Auth (Demo)
- **Risk:** Brute-force attack on staging server
- **Impact:** Server compromise, credential leak
- **Mitigation:** Intentional for demo — SSH key auth required before production
- **Status:** Known — documented in CONCERNS.md

### 6. `php spark serve` Limitations
- **Risk:** Built-in PHP server is single-threaded, not production-grade
- **Impact:** Cannot test concurrent requests, caching, or PHP-FPM behavior locally
- **Mitigation:** Local dev is for code/auth only; integration testing on VPS staging
- **Status:** Expected limitation