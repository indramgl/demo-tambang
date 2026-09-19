---
title: CSS class contract break between views and stylesheets
date: 2026-09-19
category: ui-bugs/
module: frontend
problem_type: ui_bug
severity: high
tags: [css, class-names, views, responsive, design-system]
---

# CSS Class Contract Break Between Views and Stylesheets

## Problem

View PHP templates used class names like `services-grid`, `contact-grid`, `portfolio-filter`, `cta`, `grid`, `core-values` while the corresponding CSS selectors in `pages.css` and `responsive.css` defined `.service-grid`, `.contact-layout`, `.portfolio-grid`, `.cta-section`, `.stat-item`. This meant **all responsive grid layouts, service grids, portfolio grids, contact layouts, and CTA sections rendered unstyled** — the CSS was completely inert for these elements.

## Symptoms

- Service pages displayed as unstyled stacked blocks instead of grids
- Contact form and info sections displayed as a single column regardless of viewport
- Portfolio items displayed as unstyled list
- CTA sections had no centered layout or padding
- Responsive breakpoints at 720px and 400px had no effect on these components

## What Didn't Work

- Adding CSS classes to views to match existing selectors would have required changing 9+ view files
- Renaming view classes to match CSS would have been semantically inconsistent with the design spec
- Manual CSS inspection didn't catch the mismatch because test assertions only checked for class existence in string form

## Solution

Renamed CSS selectors in `public/assets/css/pages.css` and `public/assets/css/responsive.css` to match the view class names:

- `.service-grid` → `.services-grid`
- `.contact-layout` → `.contact-grid`
- `.portfolio-grid` → `.portfolio-filter`
- `.cta-section` → `.cta`
- Added missing `.grid`, `.core-values`, `.stat` class definitions
- Updated responsive media query selectors accordingly

Also added `.stat-item` alias and ensured all grid classes have proper `display: grid` definitions.

## Why This Works

The view templates were designed first per the plan's specification (design.md section 4.3), and CSS should follow the HTML contract. Since the plan explicitly defined these view class names, aligning CSS to them preserves the design intent while making styles functional.

## Prevention

- Add a CSS class contract test that verifies every class name in view files has a corresponding CSS selector
- Integrate a CSS selector validator into the CI pipeline
- Use `impeccable audit` on view templates after any CSS or view changes

## Related

- `public/assets/css/pages.css` — affected CSS file
- `public/assets/css/responsive.css` — affected responsive file
- `app/Views/pages/home.php`, `contact.php`, `services.php`, `portfolio.php`, `history.php`, `vision-mission.php` — affected view files
