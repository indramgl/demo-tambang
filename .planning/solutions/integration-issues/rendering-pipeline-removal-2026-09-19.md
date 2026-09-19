---
title: Rendering pipeline removed — pre-render markdown replaced with CI4 view()
date: 2026-09-19
category: integration-issues/
module: frontend
problem_type: integration_issue
severity: high
tags: [render-pages, pipeline, view-rendering, architecture, refactoring, pre-render]
---

# Rendering Pipeline Removed — Pre-Render Replaced with CI4 View Rendering

## Problem

The project originally used a pre-render markdown pipeline: `RenderPages` command converted `app/Views/pages/*/*/page.md` files to static HTML in `public/content/`, which `Home::page()` served via `getRenderedContent()`. This pipeline was architecturally complex and ultimately unnecessary. The flat `.php` view files already contained all page content and extended `layouts/main`. Switching to CI4's native `view()` rendering simplified the architecture significantly.

## Symptoms

- `RenderPages` command and `public/content/` directory were artifacts of the old pipeline
- `getRenderedContent()` method read from `public/content/` but the pipeline was broken (empty markdown files)
- The pre-render pipeline added unnecessary complexity for a static site
- OpenLitespeed page cache handles caching at the infrastructure level

## What Didn't Work

- Pre-render during deploy — overly complex for a static company profile site
- `RenderPages` command — required `Parsedown` dependency, markdown source files, and `public/content/` directory
- `getRenderedContent()` — read from `public/content/` which was often empty or missing
- Keeping both pipelines — created confusion about which was canonical

## Solution

Remove the entire pre-render pipeline:
1. Delete `app/Commands/RenderPages.php`
2. Remove `public/content/` directory
3. Remove `getRenderedContent()` from `Home.php`
4. Remove `Parsedown` dependency from `composer.json`
5. `Home::page()` now calls `view("pages/{$view}", ['title' => $title, 'locale' => $locale])` directly
6. `composer.json` `post-install-cmd` only references `php spark design:sync`

The markdown subdirectories (`app/Views/pages/*/*/page.md`) are kept as reference documentation only.

## Why This Works

The flat `.php` view files (`home.php`, `history.php`, etc.) already contain all page content and use CI4's layout inheritance (`$this->extend('layouts/main')`, `$this->section('content')`). Removing the pre-render pipeline eliminates an entire layer of complexity. OpenLitespeed's page cache provides infrastructure-level caching, making pre-render unnecessary.

## Prevention

- When adding new pages, use flat `.php` views — not markdown subdirectories
- The `design:sync` command handles design token generation — no render command needed
- `composer.json` `post-install-cmd` should only reference necessary commands
- Keep markdown files as reference only — don't use them in the rendering pipeline

## Related

- `runtime-errors/layout-section-rendering-mismatch` — layout bug fixed alongside pipeline removal
- `best-practices/controller-refactoring-and-test-quality` — controller refactored alongside pipeline removal
- `best-practices/designsync-incomplete-token-extraction` — design token generation unaffected
