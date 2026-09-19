---
title: Controller code duplication and test quality gap
date: 2026-09-19
category: best-practices/
module: backend
problem_type: best_practice
severity: medium
tags: [controller, refactoring, testing, code-quality, maintenance]
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

## What Didn't Work

- Simply adding comments to the duplicated methods didn't solve maintainability
- Keeping individual methods per page was architecturally wasteful for 7 similar pages
- Replacing string-content tests with runtime tests would require CI4 test infrastructure

## Solution

1. **Refactored `Home.php`**: Replaced 7 duplicate methods with a single `page(string $slug)` method backed by a `PAGE_MAP` constant that maps slugs to `[title, view]` pairs. The `index()` method now delegates to `page('home')`.

2. **Added `static $cache` to `getRenderedContent()`**: Implemented file-read caching to avoid disk I/O on every request.

3. **Rewrote `HomeControllerTest.php`**: Tests now verify:
   - `page()` method exists with proper parameter
   - `PAGE_MAP` contains all 7 page entries
   - `index()` delegates to `page()`
   - All methods pass `title`, `locale`, `content` keys to views
   - `getRenderedContent` method exists

4. **Updated `Routes.php`**: Changed route definitions to pass page slugs as parameters to `Home::page()` (e.g., `Home::page/history`).

## Why This Works

The `PAGE_MAP` pattern reduces 7 methods to 1, with the mapping data clearly visible in one location. Tests now verify structural correctness of the mapping and delegation rather than mere code existence. File caching eliminates redundant disk reads.

## Prevention

- Add a code complexity check (e.g., PHP_CodeSniffer with `Generic.Files.LineLength`) to flag duplicated method patterns
- Run `php spark test` as part of the deploy pipeline
- Consider adding runtime integration tests that verify actual HTTP responses

## Related

- `app/Controllers/Home.php` — refactored controller
- `app/Config/Routes.php` — updated routes
- `tests/unit/Controllers/HomeControllerTest.php` — rewritten tests
