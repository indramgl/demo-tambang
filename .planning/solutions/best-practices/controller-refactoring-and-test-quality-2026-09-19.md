---
title: Controller code duplication and test quality gap
date: 2026-09-19
category: best-practices/
module: backend
problem_type: best_practice
severity: medium
tags: [controller, refactoring, testing, code-quality, maintenance, localeUrl, PageNotFoundException]
---

# Controller Code Duplication and Test Quality Gap

## Problem

`Home.php` had 7 nearly-identical controller methods (`index`, `history`, `visionMission`, `services`, `contact`, `portfolio`, `investor`), each with the exact same pattern of extracting locale, setting a title, calling `getRenderedContent()`, and returning a view. This violated DRY and made adding new pages require copying and modifying 7 lines of boilerplate code.

Simultaneously, the test suite (`HomeControllerTest.php`) checked string content of PHP files (`assertStringContainsString('public function index()', ...)`) rather than testing runtime behavior. This meant tests could pass even if the controller logic was broken.

## Symptoms

- Adding a new page required modifying 2 files with 7+ method copies
- Test assertions verified code existence but not actual behavior
- No test verified that visiting `/id/` actually returns a valid rendered page
- Controller had no data-driven approach for page routing
- Language switcher links generated broken URLs (`/en/id/current-path`)

## What Didn't Work

- Simply adding comments to the duplicated methods didn't solve maintainability
- Keeping individual methods per page was architecturally wasteful for 7 similar pages
- Replacing string-content tests with runtime tests would require CI4 test infrastructure
- Using `ltrim(service('uri')->getPath())` for locale URLs — produces broken hreflang

## Solution

1. **Refactored `Home.php`**: Replaced 7 duplicate methods with a single `page(string $slug)` method backed by a `PAGE_MAP` constant that maps slugs to `[title, view]` pairs. The `index()` method now delegates to `page('home')`.

2. **Added `PageNotFoundException`**: Throws `PageNotFoundException` when slug not found in `PAGE_MAP`, replacing generic 404 handling.

3. **Added `localeUrl(string $locale): string`**: Uses `service('uri')->setSegment(1, $locale)` + `base_url()` to generate correct locale-prefixed URLs for the navbar hreflang and language switcher.

4. **Removed `getRenderedContent()`**: The pre-render pipeline was removed. `Home::page()` now calls `view("pages/{$view}", ...)` directly.

5. **Rewrote `HomeControllerTest.php`**: Tests now verify **runtime behavior** — actual HTTP responses, page content visibility, and correct rendering — not source-code string inspection.

6. **Updated `Routes.php`**: Changed route definitions to pass page slugs as parameters to `Home::page()`. Added `tentang` route for the about page.

7. **Added about page**: Created `app/Views/pages/about.php` with `tentang` route and PAGE_MAP entry.

## Why This Works

The `PAGE_MAP` pattern reduces 7 methods to 1, with the mapping data clearly visible in one location. `localeUrl()` provides correct multilingual URL generation. Runtime behavioral tests verify actual page rendering rather than code existence. The `PageNotFoundException` gives proper 404 handling.

## Prevention

- Add a code complexity check (e.g., PHP_CodeSniffer with `Generic.Files.LineLength`) to flag duplicated method patterns
- Run `php spark test` as part of the deploy pipeline
- Consider adding runtime integration tests that verify actual HTTP responses
- Always use `localeUrl()` for multilingual URL construction, never `ltrim(getPath())`

## Known Issues

- `cachePage(3600)` in `Home::page()` calls a non-existent method — needs to be replaced with `$this->cache->save()` or removed (the `PageCache` filter handles this). See `runtime-errors/cachepage-nonexistent-method`.

## Related

- `app/Controllers/Home.php` — refactored controller
- `app/Config/Routes.php` — updated routes
- `tests/unit/Controllers/HomeControllerTest.php` — rewritten tests
- `runtime-errors/cachepage-nonexistent-method` — cachePage bug
- `logic-errors/navbar-hreflang-url-generation-bug` — localeUrl fixes broken hreflang
- `integration-issues/rendering-pipeline-removal` — pipeline removal
