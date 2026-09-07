# ROADMAP.md

## Phase 1: Setup & Scaffold
- Inisiasi project CI4 via Composer
- Setup VPS (Apache/nginx + PHP-FPM)
- Struktur directory, .gitignore, config awal
- **Deliverable:** Project scaffold, bisa deploy ke staging

## Phase 2: Architecture & Multilingual
- CI4 multilingual routing (`/id/`, `/en/`, `/zh/`, `/fr/`, `/es/`, `/ja/`)
- Static page structure per bahasa
- Hreflang tags, structured data
- **Deliverable:** Routing multilingual berjalan

## Phase 3: Content Implementation
- Implementasi 6 halaman per bahasa (Sejarah, Visi-misi, Layanan & Product, Kontak, Portofolio, Investor Relation)
- Integrasi design.md dari OpenDesign
- Responsive mobile-first
- **Deliverable:** Semua halaman live dalam 6 bahasa

## Phase 4: Contact Form & Investor Relation
- Contact form dengan validasi + email delivery
- Investor Relation — PDF upload/download
- Portfolio gallery
- **Deliverable:** Form & IR functional

## Phase 5: Deploy & Test
- Deploy production ke VPS
- Apache/nginx config
- Multilingual SEO testing (hreflang, canonical)
- Performance testing
- **Deliverable:** Live di production

## Dependencies
1. Design.md (OpenDesign) → sebelum Phase 3
2. VPS provider + Apache/nginx setup → sebelum Phase 1
3. Email service → sebelum Phase 4

## Timeline Estimasi
- Phase 1: 2-3 hari
- Phase 2: 2-3 hari
- Phase 3: 3-5 hari
- Phase 4: 2-3 hari
- Phase 5: 1-2 hari
- Total: ~10-15 hari

## Risks
- VPS provider belum dipilih
- Desain dari OpenDesign belum ready
- 6 bahasa — perlu konfirmasi bahasa spesifik
