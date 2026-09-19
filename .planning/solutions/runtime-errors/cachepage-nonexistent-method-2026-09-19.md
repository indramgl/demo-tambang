---
title: cachePage(3600) is a non-existent CI4 method
date: 2026-09-19
category: runtime-errors/
module: backend
problem_type: runtime_error
severity: high
tags: [ci4, cache, cachepage, method-not-found, runtime, controller]
---

# cachePage(3600) — Non-Existent CI4 Method

## Problem

`Home::page()` calls `$this->cachePage(3600)` to enable CI4 page caching, but `cachePage()` does not exist as a method on `CodeIgniter\Controller` or the project's `BaseController`. This will cause a `BadMethodCallException` on every page request, making the application completely unavailable (500 error).

## Symptoms

- Every page load throws `Call to undefined method App\Controllers\Home::cachePage()`
- Application returns 500 Internal Server Error for all pages
- The `PageCache` filter in `app/Config/Filters.php` is registered but not used

## What Didn't Work

- Calling `$this->cachePage(3600)` — method doesn't exist in CI4's controller hierarchy
- Assuming CI4 has a `cachePage()` method — it does not; the correct approach uses `$this->cache->save()` or the `cache` filter

## Solution

Replace `$this->cachePage(3600)` with CI4's actual caching mechanism. The `PageCache` filter is already registered in `Filters.php` and handles caching at the filter level. Alternatively, use `$this->cache->save()` for explicit caching:

```php
// Option A: Use the PageCache filter (already registered)
// No code needed — the filter handles caching automatically

// Option B: Use explicit cache save
$this->cache->save($this->response->getBody(), 3600);
return view(...);
```

Also remove the `PageCache` entry from `$required['after']` in `Filters.php` if you want to avoid double-caching with OpenLitespeed.

## Why This Works

CI4's response caching is handled by the `PageCache` filter (registered in `Filters.php`), not by a `cachePage()` controller method. The filter intercepts the response and caches it. The `$this->cache` service provides application-level caching for custom use cases.

## Prevention

- Verify CI4 API methods exist before using them — check `vendor/codeigniter4/framework/system/Controller.php`
- The `PageCache` filter in `Filters.php` already handles page-level caching
- Use `$this->cache->save()` for explicit application-level caching
- Test by running `php spark serve` and checking for 500 errors

## Related

- `best-practices/controller-refactoring-and-test-quality` — test suite should verify runtime behavior
- `integration-issues/rendering-pipeline-removal` — CI4 page cache complements the architecture
