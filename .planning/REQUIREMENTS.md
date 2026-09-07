# REQUIREMENTS.md

## Project: PT Indah Tambang Raya Semesta — Company Profile Website

## Functional Requirements

### FR-1: Multilingual
- Website tersedia dalam 6 bahasa: Indonesia, Inggris, Mandarin, Perancis, Spanyol, Jepang
- Routing berbasis URL path: `/id/`, `/en/`, `/zh/`, `/fr/`, `/es/`, `/ja/`
- Bahasa utama: Indonesia

### FR-2: Halaman
- Halaman 1: Sejarah
- Halaman 2: Visi-misi
- Halaman 3: Layanan dan Product
- Halaman 4: Kontak
- Halaman 5: Portofolio
- Halaman 6: Investor Relation

### FR-3: Konten Statis
- Semua konten bersifat statis (HTML/TEMPLATE)
- Tidak ada CMS, tidak ada database relasional
- SQLite hanya jika ada fitur dinamis (misal: contact form submissions)

### FR-4: Kontak
- Form kontak (nama, email, pesan)
- Alamat, telepon, email
- Embedded map

### FR-5: Portofolio
- Galeri proyek/kegiatan perusahaan
- Format: gambar + deskripsi

### FR-6: Investor Relation
- Laporan keuangan, pengumuman, dokumen
- Format: PDF download

### FR-7: Contact Form
- Formulir kontak dengan validasi dasar
- Kirim ke email perusahaan

## Non-Functional Requirements

### NFR-1: Performance
- Static assets di CDN edge
- Target: LCP < 2.5s

### NFR-2: SEO
- Hreflang tags untuk multilingual
- Structured data (Organization schema)
- Clean URL structure

### NFR-3: Responsive
- Mobile-first design
- Breakpoints: 320px, 768px, 1024px, 1440px

### NFR-4: Security
- HTTPS mandatory
- No exposed .env atau file sensitif
- Form validation server-side

### NFR-5: Deployment
- VPS traditional (DigitalOcean/Linode/Hetzner)
- Apache/nginx + PHP-FPM
- Auto-deploy dari git push

## Design Requirements

### DR-1: Design Reference
- Design.md disediakan oleh OpenDesign
- Implementasi mengikuti desain yang sudah ada
- Tidak mengubah tata letak tanpa persetujuan

### DR-2: Brand
- Sesuai identitas PT Indah Tambang Raya Semesta
- Warna, typography, logo dari design.md

## Teknologi

| Komponen | Pilihan |
|----------|---------|
| Backend | PHP CodeIgniter 4 |
| Dependency | Composer |
| Database | SQLite (opsional) |
| Deployment | VPS traditional |
| Bahasa | 6 bahasa internasional |

## Batasan

- Tidak ada admin panel
- Tidak ada CMS dinamis
- Tidak ada user authentication
- Tidak ada blog/news (kecuali ditambah nanti)
- Konten statis saja

## Dependencies

1. Design.md dari OpenDesign → sebelum implementasi frontend
2. CI4 + Vercel/Cloudflare compatibility → sebelum scaffold
3. Email service untuk contact form → sebelum FR-7

## Open Items

1. 6 bahasa spesifik — user bilang "6 bahasa internasional paling banyak digunakan" → perlu konfirmasi: apakah Jepang termasuk? Atau Bahasa Arab?
2. Format konten Portofolio → gambar saja atau ada video?
3. Format Investor Relation → PDF only atau ada online viewer?
4. Contact form → email tujuan ke mana?
5. CI4 version → 4.4 atau 4.5?
6. Hosting spesifik → Vercel atau Cloudflare Pages?
