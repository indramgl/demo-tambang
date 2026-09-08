# PT Indah Tambang Raya Semesta

Company profile website for PT Indah Tambang Raya Semesta, built with PHP CodeIgniter 4.

## Tech Stack

- **Language:** PHP 8.4+
- **Framework:** CodeIgniter 4 v4.7.4
- **Web Server:** OpenLitespeed + PHP-FPM
- **Hosting:** VPS traditional (IDCloudhost)
- **Multilingual:** 6 languages via URL path routing (`/id/`, `/en/`, `/zh/`, `/fr/`, `/es/`, `/ja/`)
- **Content:** Static markdown pages rendered as HTML

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
├── design.md             # Design reference from OpenDesign (pending)
└── AGENTS.md             # AI agent configuration
```

## Status

- **Milestone:** v1.0 — Setup & Scaffold
- **Phase:** 1 — Setup & Scaffold
- **Status:** Shipped

## License

Private.