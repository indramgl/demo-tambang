# PROJECT.md

## Overview

Website company profile untuk **PT Indah Tambang Raya Semesta** menggunakan **PHP CodeIgniter 4**. Statis, tanpa CMS/database (SQLite hanya jika diperlukan). Deployment ke cloud platform (Vercel/Cloudflare Pages) dengan serverless architecture.

## Halaman

1. Sejarah
2. Visi-misi
3. Layanan dan Product
4. Kontak
5. Portofolio
6. Investor Relation

## Teknologi

- **Backend:** PHP CodeIgniter 4
- **Dependency Manager:** Composer
- **Database:** SQLite (jika dibutuhkan)
- **Deployment:** VPS traditional (OpenLitespeed + PHP-FPM)
- **Design:** design.md (akan disediakan oleh OpenDesign)

## Multilingual

Website akan tersedia dalam **6 bahasa internasional**:
1. Indonesia (utama)
2. Inggris
3. Mandarin
4. Perancis
5. Spanyol
6. Jepang

## Keputusan Penting

- Konten statis → tidak butuh CMS
- Tanpa database relasional → SQLite hanya jika diperlukan
- Serverless deployment → tidak applicable, pakai VPS
- Design dipisah → design.md handled oleh OpenDesign
- v1.0 shipped → 6/7 requirements met, REQ-004 (VPS deploy) blocked on VPS provisioning

## Batasan

- Tidak ada admin panel
- Tidak ada CMS dinamis
- Design mengikuti design.md dari OpenDesign

## Open Questions

- Portfolio & Investor Relation: format konten (PDF, gambar, table)?

## Current Milestone: v1.0 — Setup & Scaffold ✓ Shipped

**Goal:** CI4 project scaffolded via Composer with working routing and deployable to staging VPS.

**Delivered (v1.0):**
- REQ-001: CI4 project scaffolded via Composer ✓
- REQ-002: `.gitignore` created ✓
- REQ-003: Local dev server (`php spark serve`) working ✓
- REQ-005: Multilingual directory structure created ✓
- REQ-006: CI4 + PHP 8.4 + OpenLitespeed compatibility verified ✓
- REQ-007: Git remote configured, push to master works ✓

**Blocked:**
- REQ-004: VPS deploy pipeline — blocked on VPS provisioning

**Anti-goals:** No design integration, no contact form, no CMS, no admin panel, no database logic, no portfolio/IR content.

---

## Current Milestone: v2.0 — Skeleton Pages & Design Integration

**Goal:** Create skeleton pages for all agreed pages following design.md, with multilingual routing, static page templates, and design integration (REQ-008 through REQ-010).

**Target features:**
- Multilingual routing (`/id/`, `/en/`, `/zh/`, `/fr/`, `/es/`, `/ja/`) — REQ-008
- Static page templates rendering markdown as HTML with consistent layout — REQ-009
- Design integration: apply design.md tokens, components, and layout to CI4 views — REQ-010
- 7 skeleton pages (home, history, vision-mission, services, contact, portfolio, investor relation)

**Anti-goals:** No CMS, no database, no design iteration after skeleton, no content writing, no VPS deployment.

Last updated: 2026-09-08

