# Plan 02-01 Summary

**Completed:** 2026-09-19
**Phase:** 02 — Skeleton Pages & Design Integration

## What was built

Implemented the CI4 view rendering pipeline replacing the obsolete pre-render markdown system. All 8 pages now render correctly via CI4's native `view()` system with proper layout sections, slug validation, and locale-aware URL generation.

## Key files

- **app/Controllers/Home.php**: Rewritten with `PageNotFoundException` for unknown slugs, `localeUrl()` method, 8-entry `PAGE_MAP` including `'about'`, view call passing `['title', 'locale', 'localeUrls']` only
- **app/Views/layouts/main.php**: Replaced `<?= $content ?>` with `<?= $this->renderSection('content') ?>`, hreflang tags now use `$localeUrls` array
- **app/Views/layouts/navbar.php**: Replaced broken `ltrim(service('uri')->getPath())` pattern with `$localeUrls` foreach iteration
- **app/Views/pages/about.php**: New page view following CI4 layout pattern (`extend`, `section`, `endSection`)
- **app/Config/Routes.php**: Added `$routes->get('tentang', 'Home::page/about')` inside locale group
- **app/Commands/RenderPages.php**: Deleted
- **public/content/**: Removed
- **app/Views/pages/about/**: Subdirectories removed
- **tests/unit/Controllers/HomeControllerTest.php**: Updated to test new behavior (PageNotFound, localeUrl, no content key, no getRenderedContent)
- **tests/unit/Views/LayoutTest.php**: Added tests for renderSection, localeUrls, no ltrim, route existence, file removal checks
- **tests/unit/Views/PageViewsTest.php**: Added 'about' to pages array, added about-specific test
- **tests/unit/Commands/RenderPagesTest.php**: Updated to verify command no longer exists

## Decisions made

- `main.php` uses `<?= $this->renderSection('content') ?>` instead of `<?= $content ?>`
- `Home::page()` throws `PageNotFoundException::forPageNotFound()` for unknown slugs
- `localeUrl()` uses `service('uri')` with `setSegment(1, $locale)` to generate correct locale URLs
- Navbar and hreflang tags both use `$localeUrls` array passed from controller
- `composer.json` `post-install-cmd` only references `php spark design:sync` (already correct)

## Deviations from plan

- None significant. All tasks executed as specified.
- The `about` entry in PAGE_MAP had extra spacing but functionally identical.
- Test file structure had a duplicate class body issue that was fixed during editing.

## Notes for downstream

- Plan 02-01 (CI4 View Rendering Pipeline) is complete with 72 tests passing
- `php spark design:sync` still works correctly
- Next plan (02-02) should build on this foundation
- The `erusev/parsedown` dependency remains in composer.json but is no longer used by any code
