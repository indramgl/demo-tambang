---
title: Missing content pipeline — markdown source files and pre-rendered HTML absent
date: 2026-09-19
category: integration-issues/
module: frontend
problem_type: integration_issue
severity: high
tags: [content, render-pages, markdown, pre-render, pipeline]
---

# Missing Content Pipeline — Markdown Source and Pre-Rendered HTML Absent

## Problem

The `RenderPages` command expected markdown files at `app/Views/pages/{page}/{locale}/page.md`, but these directories existed empty. The `Home::getRenderedContent()` method read from `public/content/{page}/{locale}.html`, but the `public/content/` directory didn't exist because `RenderPages` had never been run. This meant **all 7 pages rendered with empty content sections** — the layout shell displayed correctly but no actual content appeared.

## Symptoms

- All page routes (`/id/`, `/en/sejarah`, etc.) showed layout (header, navbar, footer) but empty content area
- `RenderPages` command found no markdown files to process
- `Home::getRenderedContent()` returned empty strings because target HTML files didn't exist
- The pre-render deploy pipeline was completely broken

## What Didn't Work

- Simply creating the `public/content/` directory without source markdown files wouldn't help — `RenderPages` needs the `.md` files to generate HTML
- Modifying `getRenderedContent()` to return default text would mask the root cause
- Skipping the pre-render step would mean content is generated at runtime, violating the plan's architecture

## Solution

1. Created markdown source files at `app/Views/pages/{page}/{locale}/page.md` for all 7 pages × 6 locales (42 files)
2. Installed `erusev/parsedown` via Composer to satisfy the `RenderPages` dependency
3. Ran `php spark render:pages` to generate all 42 HTML files in `public/content/`
4. Verified `Home::getRenderedContent()` correctly reads from `public/content/{page}/{locale}.html`

## Why This Works

The plan's architecture specifies markdown source → pre-render → static HTML serving. By creating the markdown source files and running the pre-render command, the full pipeline from content to served HTML is now functional.

## Prevention

- Add a CI check that verifies `public/content/` has HTML files for all page×locale combinations
- Add a pre-deploy verification step that fails if `RenderPages` produces fewer than 42 pages
- Document the content pipeline in `CONVENTIONS.md`

## Related

- `app/Commands/RenderPages.php` — pre-render command
- `app/Controllers/Home.php::getRenderedContent()` — content reader
- `public/content/` — pre-rendered HTML output directory
