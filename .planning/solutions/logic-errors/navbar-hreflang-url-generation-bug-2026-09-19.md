---
title: Navbar hreflang generates broken URLs with ltrim(getPath())
date: 2026-09-19
category: logic-errors/
module: frontend
problem_type: logic_error
severity: high
tags: [navbar, hreflang, locale, url-generation, ltrim, localeUrl]
---

# Navbar Hreflang Generates Broken URLs

## Problem

`app/Views/layouts/navbar.php` generated language switcher URLs using `ltrim(service('uri')->getPath(), '/')`, which preserves the current locale prefix. For a page at `/id/sejarah`, this produces `base_url('en/' . 'id/sejarah')` = `http://site/en/id/sejarah` — a broken URL. The correct URL should be `http://site/en/sejarah`.

## Symptoms

- Language switcher links point to wrong URLs (e.g., `/en/id/home` instead of `/en/home`)
- hreflang tags in `<head>` have incorrect locale-prefixed URLs
- Broken URLs cause 404 errors or serve wrong locale content
- The pattern appears in both `navbar.php` and `main.php` hreflang tags

## What Didn't Work

- `ltrim(service('uri')->getPath(), '/')` — preserves locale prefix, producing broken URLs
- Inline logic in navbar.php — couples view to URI manipulation
- Controller passes `pathMap` — requires manual maintenance per route

## Solution

Add `localeUrl(string $locale): string` method to `Home` controller that uses CI4's `URI` class to swap the locale segment:

```php
protected function localeUrl(string $locale): string
{
    $uri = service('uri');
    $uri->setSegment(1, $locale);
    return base_url($uri->getPath());
}
```

Pass `$localeUrls` array from controller to views. Update `navbar.php` and `main.php` to iterate `$localeUrls` instead of constructing URLs manually:

```php
<!-- navbar.php -->
<?php foreach ($localeUrls as $lang => $url): ?>
    <a href="<?= $url ?>" hreflang="<?= esc($lang) ?>"><?= esc($lang) ?></a>
<?php endforeach; ?>
```

## Why This Works

`service('uri')` returns the current URI object. `setSegment(1, $locale)` replaces the locale segment (segment 1) while preserving the rest of the path. `base_url($uri->getPath())` generates the correct locale-prefixed URL. This is cleaner, more maintainable, and produces correct URLs.

## Prevention

- Never use `ltrim(getPath())` for locale URL construction — it preserves the current locale
- Always use `URI::setSegment()` to swap locale segments
- Pass locale URLs from controller, not constructed in views
- Verify hreflang tags generate correct URLs by inspecting page source

## Related

- `integration-issues/rendering-pipeline-removal` — locale URL generation works with CI4 view rendering
- `logic-errors/missing-about-tentang-page` — route mapping consistency
