# FEATURES.md — v1.0 Research

**Researched:** 2026-09-08
**Scope:** v1.0 Setup & Scaffold capabilities

## Feature: CI4 Project Scaffold

### Composer `create-project`
- Command: `composer create-project codeigniter4/appstarter project-name`
- Creates full CI4 directory structure with `app/`, `public/`, `writable/`, `vendor/`
- **Confidence:** HIGH — standard CI4 installation method

### `php spark serve` (Local Dev)
- Built-in PHP development server
- Default: `localhost:8080`
- No web server configuration needed
- Serves CI4 app locally for development and testing
- **Confidence:** HIGH — standard CI4 CLI command

### Multilingual Directory Structure
- `app/Views/pages/{halaman}/{bahasa}.md` — markdown content files
- `app/Views/lang/{halaman}.{bahasa}.json` — translation JSON
- CI4 routing handles language segments (`/id/`, `/en/`, etc.)
- **Confidence:** MEDIUM — routing structure planned but not yet implemented

### VPS Deployment (Git Pull)
- Git remote on IDCloudhost VPS
- `git pull origin master` to deploy
- OpenLitespeed serves from `public/` directory
- **Confidence:** HIGH — standard deployment pattern

### `.gitignore` for CI4/VPS
- Excludes: `.env`, `vendor/`, `writable/`, `.opencode/`, IDE configs
- Must be created BEFORE any code is written
- **Confidence:** HIGH — standard CI4 `.gitignore` pattern