---
title: pages.css uses hardcoded typography values instead of CSS custom properties
date: 2026-09-19
category: ui-bugs/
module: frontend
problem_type: ui_bug
severity: medium
tags: [css, typography, custom-properties, design-tokens, pages.css, var]
---

# pages.css Uses Hardcoded Typography Values

## Problem

`public/assets/css/pages.css` used hardcoded font-size, font-weight, line-height, and letter-spacing values instead of CSS custom property references (`var(--*)`). Design tokens were defined in `tokens.css` but `pages.css` didn't reference them, creating a maintenance gap where design changes to `design.md` wouldn't automatically propagate to page styles.

## Symptoms

- `.hero-title { font-size: 3rem; font-weight: 500; }` instead of `font-size: var(--font-display-hero-size)`
- `.stat-number { font-size: 2.5rem; }` instead of `var(--font-card-title-size)`
- Design token changes to `design.md` wouldn't affect page typography
- Risk of design drift between design.md and CSS

## What Didn't Work

- Hardcoding typography values in pages.css — bypasses the design token system
- Manual CSS maintenance — risks drift between design.md and CSS
- Partial var(--*) usage — some values used tokens, others hardcoded

## Solution

Replace all hardcoded typography values in `pages.css` with `var(--*)` references mapped from design.md typography roles:

```css
/* Before: */
.hero-title {
    font-size: 3rem;
    font-weight: 500;
    line-height: 1.21;
    letter-spacing: -0.48px;
}

/* After: */
.hero-title {
    font-size: var(--font-display-hero-size);
    font-weight: var(--font-display-hero-weight);
    line-height: var(--font-display-hero-line-height);
    letter-spacing: var(--font-display-hero-letter-spacing);
}
```

The `DesignSync` command was extended to extract typography tokens (section 1.2) and elevation tokens (section 1.5) from `design.md`, making all typography values available as CSS custom properties.

## Why This Works

Design tokens in `tokens.css` are the single source of truth. By referencing them with `var(--*)`, any design change to `design.md` propagates automatically through `design:sync` → `tokens.css` → `pages.css`. This eliminates the risk of design drift and ensures consistency across all pages.

## Prevention

- Always use `var(--*)` references in CSS, never hardcoded values
- Run `php spark design:sync` after updating `design.md` to regenerate tokens
- Verify `tokens.css` contains the expected tokens after each design change
- Check `pages.css` for any remaining hardcoded typography values

## Related

- `best-practices/designsync-incomplete-token-extraction` — DesignSync was extended for typography
- `integration-issues/rendering-pipeline-removal` — pipeline removal doesn't affect CSS token strategy
