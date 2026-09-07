# SUMMARY.md

## Executive Summary
Website company profile PT Indah Tambang Raya Semesta menggunakan PHP CodeIgniter 4, konten statis multilingual (6 bahasa), deployment VPS (Apache/nginx + PHP-FPM). Tidak ada CMS/database relasional — SQLite hanya jika diperlukan.

## Recommended Stack
- PHP 8.3+ + CodeIgniter 4 + Composer
- Static HTML/CSS/JS frontend
- SQLite (opsional)
- VPS traditional (Apache/nginx + PHP-FPM)
- Multilingual via URL path routing (`/id/`, `/en/`, `/zh/`, `/fr/`, `/es/`, `/ja/`)

## Table Stakes Features
- Hero, Sejarah, Visi-misi, Layanan & Produk, Kontak, Portofolio, Investor Relation
- Responsive, SEO multilingual (hreflang), contact form

## Key Architecture Decisions
- Static-first → generate HTML statis per bahasa
- Apache/nginx + PHP-FPM → standard CI4 deployment
- SQLite hanya jika ada fitur dinamis

## Top Pitfalls
1. **CI4 VPS deployment** — standard, well-documented
2. **Multilingual SEO** — hreflang tags harus benar
3. **Over-engineering DB** — jangan pakai MySQL untuk konten statis
4. **Design lock-in** — tunggu design.md sebelum coding

## Implications for Roadmap
- Phase 1: Scaffold CI4 + validasi deployment
- Phase 2: Implementasi halaman statis + multilingual routing
- Phase 3: Contact form + investor relation
- Phase 4: Deploy + testing

## Confidence Assessment
| Area | Confidence |
|------|-----------|
| CI4 + VPS deployment | HIGH |
| Multilingual approach | HIGH |
| Feature set | MEDIUM |

## Gaps
- Belum tahu 6 bahasa spesifik (user bilang "6 bahasa internasional paling banyak digunakan")
- Belum ada design.md dari OpenDesign
- VPS provider belum dipilih (DigitalOcean/Linode/Hetzner?)
- Format konten Portfolio & Investor Relation belum jelas
