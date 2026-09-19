# PROJECT.md

## Overview

Website company profile untuk **PT Indah Tambang Raya Semesta** menggunakan **PHP CodeIgniter 4**. Statis, tanpa CMS/database (SQLite hanya jika diperlukan). Deployment ke VPS traditional (OpenLitespeed + PHP-FPM).

## Halaman

1. Beranda (home)
2. Tentang (about)
3. Sejarah (history)
4. Visi-misi (vision-mission)
5. Layanan dan Product (services)
6. Kontak (contact)
7. Portofolio (portfolio)
8. Investor Relation (investor)

## Teknologi

- **Backend:** PHP CodeIgniter 4 v4.7.4
- **Dependency Manager:** Composer
- **Database:** SQLite (jika diperlukan)
- **Deployment:** VPS traditional (OpenLitespeed + PHP-FPM)
- **Design:** design.md dari OpenDesign ✓ Applied

## Multilingual

Website tersedia dalam **6 bahasa internasional**:
1. Indonesia (utama)
2. Inggris
3. Mandarin
4. Perancis
5. Spanyol
6. Jepang

## Keputusan Penting

- Konten statis → tidak butuh CMS
- Tanpa database relasional → SQLite hanya jika diperlukan
- Deployment ke VPS traditional (OpenLitespeed + PHP-FPM)
- Design dipisah → design.md handled oleh OpenDesign ✓ Applied
- v1.0 shipped → 6/7 requirements met, REQ-004 (VPS deploy) blocked on VPS provisioning
- v2.0 shipped → 3/3 requirements met (REQ-008 through REQ-010)

## Batasan

- Tidak ada admin panel
- Tidak ada CMS dinamis
- Design mengikuti design.md dari OpenDesign
- Tidak ada design iteration after skeleton
- Tidak ada content writing
- Tidak ada VPS deployment (blocked)

## Open Questions

- Portfolio & Investor Relation: format konten (PDF, gambar, table)?
- Design.md updates from OpenDesign before v3
- Contact form / email (Phase 4)

## Milestone History

### v1.0 — Setup & Scaffold ✓ Shipped (2026-09-08)
6/7 requirements delivered. REQ-004 blocked on VPS provisioning.

### v2.0 — Skeleton Pages & Design Integration ✓ Shipped (2026-09-19)
3/3 requirements delivered (REQ-008, REQ-009, REQ-010). 77/77 unit tests passing.

## Current Milestone: v3.0 (TBD)

**Goal:** TBD — next milestone planning required.

**Anti-goals:** To be defined.

Last updated: 2026-09-19
