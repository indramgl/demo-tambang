# PT Indah Tambang Raya Semesta

Company profile website for PT Indah Tambang Raya Semesta, built with PHP CodeIgniter 4.

## Tech Stack

- **Language:** PHP 8.4+
- **Framework:** CodeIgniter 4 v4.7.4
- **Web Server:** OpenLitespeed + PHP-FPM
- **Hosting:** VPS traditional (IDCloudhost)
- **Multilingual:** 6 languages via URL path routing (`/id/`, `/en/`, `/zh/`, `/fr/`, `/es/`, `/ja/`)
- **Content:** Flat PHP views rendered via CodeIgniter 4

## Quick Start

### Local Development

```bash
php spark serve
```

App runs at `localhost:8080`.

### VPS Deployment

```bash
git pull origin master
```

## Project Structure

```
perusahaan-tambang/
├── app/                  # CI4 application
├── public/               # Document root
├── writable/             # Writable directory
├── vendor/               # Composer dependencies
├── .planning/            # Planning artifacts
├── design.md             # Design reference from OpenDesign ✓ Applied
└── AGENTS.md             # AI agent configuration
```

## Status

- **Milestone:** v2.0 — Skeleton Pages & Design Integration ✓ Complete
- **Phase:** 02 — Skeleton Pages & Design Integration ✓ complete → Phase 03 (TBD)
- **Branch:** `feat/02-skeleton-pages-complete`

## License

Private.