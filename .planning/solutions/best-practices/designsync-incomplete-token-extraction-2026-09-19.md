---
title: DesignSync token extraction incomplete — missing typography and elevation
date: 2026-09-19
category: best-practices/
module: frontend
problem_type: best_practice
severity: low
tags: [designsync, tokens, typography, elevation, design-system, ci4]
---

# DesignSync Token Extraction Incomplete

## Problem

The `DesignSync` command (`php spark design:sync`) only extracted CSS custom properties for colors (section 1.1), spaces (1.3), and radii (1.4) from `design.md`. It did not extract typography tokens (section 1.2) or elevation tokens (section 1.5), even though these are defined in `design.md` and referenced in `pages.css`. This created a gap where design tokens existed in `design.md` but weren't available as CSS custom properties.

## Symptoms

- `tokens.css` contained only colors, spaces, and radii — no `--font-*` or `--shadow-*` tokens
- `pages.css` had hardcoded typography values that should have been `var(--*)` references
- Design token system was incomplete — not a true single source of truth
- Elevation tokens existed in `design.md` section 1.5 but weren't extracted (even though the anti-shadow rule means they're currently unused)

## What Didn't Work

- Only extracting colors, spaces, radii — ignores typography and elevation
- Keeping `pages.css` hardcoded — defeats the purpose of design tokens
- Skipping elevation tokens — should be available even if currently unused

## Solution

Extend `DesignSync::extractRootBlock()` with dedicated methods:
1. `extractTypographyTokens()` — parses design.md section 1.2 markdown table, generates `--font-{role}-{property}` tokens (12 roles × 4 properties = 48 tokens)
2. `extractElevationTokens()` — parses section 1.5, generates `--shadow-none`, `--shadow-focus`, `--shadow-raised`
3. Merge new properties into the existing `$properties` array before building the `:root` block

Also migrate `pages.css` to use `var(--font-*)` references for all typography values.

## Why This Works

Extending `DesignSync` ensures `tokens.css` is a complete single source of truth for all design tokens defined in `design.md`. The typography extraction uses a dedicated method because the markdown table has a different structure (6 columns per row vs 2 columns for most other tokens). Elevation tokens are extracted proactively — they're available even if the anti-shadow rule means they're not currently used in CSS.

## Prevention

- When design.md is updated with new sections, extend `DesignSync` accordingly
- Always check `tokens.css` after running `design:sync` to verify all expected tokens are present
- Use `var(--*)` references in ALL CSS files — never hardcoded values
- Run `php spark design:sync` after updating `design.md`

## Related

- `ui-bugs/pagescss-hardcoded-typography-tokens` — pages.css migration to var(--*)
- `integration-issues/rendering-pipeline-removal` — pipeline removal doesn't affect token strategy
