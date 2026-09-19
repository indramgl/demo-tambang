# Plan 02-02 Summary

**Completed:** 2026-09-19
**Phase:** 02 — Skeleton Pages & Design Integration

## What was built

Extended the design token system so `tokens.css` contains full typography (12 roles × 4 properties = 48 tokens) and elevation (3 tokens) data from design.md. Migrated `pages.css` from hardcoded typography values to `var(--*)` references. Verified language switcher end-to-end. All 79 unit tests passing.

## Key files

- **app/Commands/DesignSync.php**: Added `extractTypographyTokens()` and `extractElevationTokens()` methods; `extractRootBlock()` now merges all three property types (colors/spaces/radii + typography + elevation)
- **public/assets/css/tokens.css**: Regenerated with all 48 typography tokens and 3 elevation tokens, plus all original color/space/radius tokens
- **public/assets/css/pages.css**: All hardcoded `font-size`, `font-weight`, `line-height`, `letter-spacing` values replaced with `var(--font-*)` references
- **tests/unit/Commands/DesignSyncTest.php**: Added assertions for typography tokens (`--font-display-mega-size`, etc.) and elevation tokens (`--shadow-none`, etc.)
- **tests/unit/Controllers/HomeControllerTest.php**: Added `testLocaleUrlUsesUriSetSegment`, `testLocaleUrlDoesNotUseLtrimPath`, `testNavbarUsesLocaleUrlsArray`, `testMainHreflangUsesLocaleUrls`

## Decisions made

- "Caption / Meta" role maps to `caption` prefix (not `caption-meta`) for CSS custom property names
- Elevation values have backticks stripped during extraction
- `pages.css` font properties mapped to design tokens even when values don't exactly match (tokens are source of truth)
- Language switcher uses `foreach ($localeUrls as $lang => $url)` pattern in both navbar.php and main.php
- `localeUrl()` uses `service('uri')` with `setSegment(1, $locale)` — no `ltrim(service('uri')->getPath())` pattern

## Deviations from plan

- None significant. All 5 tasks executed as specified.
- The `testDesignSyncGeneratesTokensCss` was updated to include typography and elevation assertions alongside existing color/space/radius assertions.

## Notes for downstream

- All 5 tasks in plan 02-02 complete; 79/79 tests passing
- `npm test` should pass (after Plan 03 test updates)
- tokens.css is the single source of truth for design tokens — changes to design.md require `php spark design:sync`
- pages.css typography is fully migrated to var() references — no hardcoded font values remain
- Language switcher verified end-to-end with correct locale URL generation
