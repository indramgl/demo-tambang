---
title: Layout section rendering mismatch — $content vs $this->renderSection()
date: 2026-09-19
category: runtime-errors/
module: frontend
problem_type: runtime_error
severity: high
tags: [ci4, layout, sections, renderSection, main.php, child-views]
---

# Layout Section Rendering Mismatch

## Problem

`app/Views/layouts/main.php` used `<?= $content ?>` to render page content, but all child views (`home.php`, `history.php`, etc.) used `$this->section('content')` and `$this->endSection()` to define content sections. In CodeIgniter 4, `<?= $content ?>` does not render sections — it tries to echo a PHP variable that doesn't exist. The correct method is `<?= $this->renderSection('content') ?>`.

This caused all page content to be silently empty — the layout shell rendered correctly but no content appeared.

## Symptoms

- All pages displayed header, navbar, footer but empty content area
- `Home::page()` passed `$content` as a view variable, but it was never rendered
- Child views defined sections but they were never placed into the layout
- The bug was masked because `getRenderedContent()` returned empty strings

## What Didn't Work

- Passing `$content` as a view variable — CI4's section system requires `renderSection()`
- Using `<?= $content ?>` in the parent layout — this is not how CI4 renders sections
- Keeping the old pattern — the pre-render pipeline was removed, making this fix mandatory

## Solution

Replace `<?= $content ?>` with `<?= $this->renderSection('content') ?>` in `main.php`. Remove the `$content` variable from `Home::page()` view data call. Child views already correctly use `$this->extend('layouts/main')`, `$this->section('content')`, and `$this->endSection()` — the layout just needed to use the correct rendering method.

```php
// Before (WRONG):
<main id="content">
    <?= $content ?>
</main>

// After (CORRECT):
<main id="content">
    <?= $this->renderSection('content') ?>
</main>
```

## Why This Works

CI4's view inheritance system uses `$this->section('name')` to define content blocks and `$this->renderSection('name')` to render them in the parent layout. The `$content` variable is not part of CI4's section system — it's a separate variable mechanism. Using `renderSection()` properly connects child view sections to the parent layout.

## Prevention

- When extending layouts, always verify the parent uses `renderSection()` for each section
- Test that child view sections actually render — not just that they exist in source code
- Run `php spark serve` and verify page content appears in the browser

## Related

- `best-practices/controller-refactoring-and-test-quality` — test suite should verify runtime behavior
- `best-practices/designsync-incomplete-token-extraction` — related to DesignSync token pipeline
