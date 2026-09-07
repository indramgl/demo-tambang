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
- **Deployment:** VPS traditional (Apache/nginx + PHP-FPM)
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

## Batasan

- Tidak ada admin panel
- Tidak ada CMS dinamis
- Design mengikuti design.md dari OpenDesign

## Open Questions

- 6 bahasa apa saja yang dimaksud?
- Detail arsitektur VPS (provider, web server)
- Bagaimana handling multilingual routing di CI4?
- Portfolio & Investor Relation: format konten (PDF, gambar, table)?
