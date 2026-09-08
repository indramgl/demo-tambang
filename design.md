# PT Indah Tambang Raya Semesta — Design Framework

> Desain kerangka untuk website company profile CodeIgniter 4.
> Acuan: Revolut Design System 2.0 (tokens, komponen, layout).
> Semua nilai warna menggunakan CSS custom property (`var(--*)`).

---

## 1. Design Tokens

### 1.1 Warna

```css
:root {
  /* Surface */
  --bg: #f7f8fb;
  --surface: #ffffff;
  --surface-warm: #eef4ff;

  /* Text */
  --fg: #111827;
  --fg-2: #334155;
  --muted: #64748b;

  /* Brand — Mining/Industrial accent */
  --accent: #0666eb;
  --accent-on: #ffffff;
  --accent-hover: color-mix(in oklab, var(--accent), black 8%);
  --accent-active: color-mix(in oklab, var(--accent), black 14%);

  /* Semantic */
  --success: #16a34a;
  --warn: #f59e0b;
  --danger: #ef4444;

  /* Borders */
  --border: #dbe3ef;
  --border-soft: #edf2f7;

  /* Meta */
  --meta: #0666eb;
}
```

### 1.2 Tipografi

| Peran | Font | Ukuran | Weight | Line Height | Letter Spacing |
|-------|------|--------|--------|-------------|----------------|
| Display Mega | Inter | 136px (8.50rem) | 500 | 1.00 | -2.72px |
| Display Hero | Inter | 80px (5.00rem) | 500 | 1.00 | -0.8px |
| Section Heading | Inter | 48px (3.00rem) | 500 | 1.21 | -0.48px |
| Sub-heading | Inter | 40px (2.50rem) | 500 | 1.20 | -0.4px |
| Card Title | Inter | 32px (2.00rem) | 500 | 1.19 | -0.32px |
| Feature Title | Inter | 24px (1.50rem) | 400 | 1.33 | normal |
| Nav / UI | Inter | 20px (1.25rem) | 500 | 1.40 | normal |
| Body Large | Inter | 18px (1.13rem) | 400 | 1.56 | -0.09px |
| Body | Inter | 16px (1.00rem) | 400 | 1.50 | 0.24px |
| Body Semibold | Inter | 16px (1.00rem) | 600 | 1.50 | 0.16px |
| Body Bold Link | Inter | 16px (1.00rem) | 700 | 1.50 | 0.24px |
| Caption / Meta | Inter | 12px (0.75rem) | 400 | 1.50 | 0.16px |

### 1.3 Spasi

| Token | Nilai |
|-------|-------|
| `--space-1` | 4px |
| `--space-2` | 8px |
| `--space-3` | 12px |
| `--space-4` | 16px |
| `--space-5` | 20px |
| `--space-6` | 24px |
| `--space-8` | 32px |
| `--space-12` | 48px |

### 1.4 Border Radius

| Token | Nilai | Penggunaan |
|-------|-------|------------|
| `--radius-sm` | 12px | Navigasi, tombol kecil |
| `--radius-md` | 20px | Kartu fitur |
| `--radius-lg` | 30px | Panel, container |
| `--radius-pill` | 9999px | Semua tombol |

### 1.5 Elevasi

| Level | Nilai | Penggunaan |
|-------|-------|------------|
| Flat | `none` | Semua elemen |
| Focus | `0 0 0 0.125rem` ring | Fokus accessibility |
| Raised | `0 24px 64px rgba(17, 24, 39, 0.12)` | Card hover (opsional) |

---

## 2. Layout Format

### 2.1 Container

```css
.container {
  max-width: var(--container-max, 1180px);
  margin: 0 auto;
  padding-left: var(--container-gutter-desktop, 36px);
  padding-right: var(--container-gutter-desktop, 36px);
}
```

### 2.2 Breakpoint

| Nama | Lebar | Perubahan |
|------|-------|-----------|
| Mobile Small | <400px | Kolom tunggal, kompak |
| Mobile | 400–720px | Standar mobile |
| Tablet | 720–1024px | 2 kolom |
| Desktop | 1024–1280px | Standar desktop |
| Large | 1280–1920px | Layout penuh |

### 2.3 Section Spacing

| Konteks | Desktop | Tablet | Phone |
|---------|---------|--------|-------|
| Section vertical | 104px | 72px | 52px |

---

## 3. Komponen

### 3.1 Tombol (Pill)

Semua tombol menggunakan radius 9999px dan padding 14px 32px.

**Primary Dark**
- Background: `#191c1f`
- Text: `#ffffff`
- Hover: opacity 0.85
- Focus: `0 0 0 0.125rem` ring

**Secondary Light**
- Background: `#f4f4f4`
- Text: `#000000`
- Hover: opacity 0.85

**Outlined**
- Background: transparent
- Text: `#191c1f`
- Border: `2px solid #191c1f`

**Ghost on Dark**
- Background: `rgba(244, 244, 244, 0.1)`
- Text: `#f4f4f4`
- Border: `2px solid #f4f4f4`

### 3.2 Kartu (Card)

- Radius: 20px
- Background: `var(--surface)`
- Border: `1px solid var(--border)`
- Tidak ada shadow — flat surface

### 3.3 Navigasi

- Font: Inter 20px weight 500
- Header: clean, hamburger toggle di 12px radius
- CTA pill di kanan atas

### 3.4 Form Field

- Border: `1px solid var(--border)`
- Radius: 12px
- Padding: 12px 16px
- Focus: `var(--accent)` border + ring

---

## 4. Format Layout Halaman CodeIgniter

### 4.1 Struktur View CI4

Setiap halaman menggunakan struktur tiga bagian:

```
app/Views/
├── layouts/
│   ├── header.php          ← <head>, <nav>, opening <body>
│   ├── footer.php          ← <footer>, <scripts>
│   └── navbar.php          ← Navigasi utama (reusable)
├── partials/
│   ├── hero.php
│   ├── features.php
│   ├── stats.php
│   ├── cta.php
│   └── breadcrumb.php
├── pages/
│   ├── home.php
│   ├── history.php
│   ├── vision-mission.php
│   ├── services.php
│   ├── contact.php
│   ├── portfolio.php
│   └── investor.php
└── errors/
    └── html/
        └── error_404.php
```

### 4.2 Template Layout (`layouts/main.php`)

Setiap halaman membungkus konten dengan layout utama:

```
<!doctype html>
<html lang="[bahasa]">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>[Halaman] — PT Indah Tambang Raya Semesta</title>
  <link rel="stylesheet" href="/assets/css/main.css">
  [Hreflang tags untuk multilingual]
</head>
<body>
  <?= $this->include('layouts/navbar') ?>
  <main id="content">
    [Konten halaman di sini]
  </main>
  <?= $this->include('layouts/footer') ?>
</body>
</html>
```

### 4.3 Bagian-Bagian Layout per Halaman

#### Halaman Utama (Home)
1. **Hero** — Judul besar, subtitle, CTA primary
2. **Tentang** — Intro perusahaan, statistik kunci
3. **Layanan** — Grid kartu layanan (3–4 kolom di desktop)
4. **Portofolio Preview** — Galeri proyek terpilih
5. **CTA** — Ajakan kontak/investasi

#### Halaman Sejarah
1. **Breadcrumb**
2. **Hero section** — Judul "Sejarah"
3. **Timeline** — Vertikal timeline perjalanan perusahaan
4. **Statistik** — Angka kunci (tahun berdiri, karyawan, proyek)

#### Halaman Visi-Misi
1. **Breadcrumb**
2. **Hero section** — Judul "Visi & Misi"
3. **Visi** — Kartu besar dengan ikon
4. **Misi** — Daftar poin dengan nomor
5. **Nilai Inti** — Grid kartu nilai

#### Halaman Layanan & Produk
1. **Breadcrumb**
2. **Hero section** — Judul "Layanan & Produk"
3. **Grid layanan** — Kartu dengan ikon, judul, deskripsi
4. **CTA** — Hubungi kami

#### Halaman Kontak
1. **Breadcrumb**
2. **Hero section** — Judul "Kontak"
3. **Dua kolom**: Form kontak (kiri) + Info alamat/telepon/email + Map (kanan)
4. **CTA sekunder** — Atau langsung ke form

#### Halaman Portofolio
1. **Breadcrumb**
2. **Hero section** — Judul "Portofolio"
3. **Filter** — Tab/kategori proyek (opsional)
4. **Grid galeri** — Gambar + judul proyek + deskripsi singkat
5. **CTA** — Lihat proyek lain / Hubungi untuk proyek baru

#### Halaman Investor Relation
1. **Breadcrumb**
2. **Hero section** — Judul "Investor Relation"
3. **Daftar dokumen** — Tabel atau kartu: laporan keuangan, pengumuman, dokumen
4. **CTA** — Download PDF / Hubungi investor relations

---

## 5. Multilingual Layout

### 5.1 Routing CI4

```
/id/        → Bahasa Indonesia (default)
/en/        → English
/zh/        → Mandarin
/fr/        → Perancis
/es/        → Spanyol
/ja/        → Jepang
```

### 5.2 Switcher Bahasa

- Posisi: pojok kanan atas navigasi
- Format: dropdown atau inline list
- Setiap item menyesuaikan URL path tanpa mengubah halaman saat ini
- Hreflang tag di setiap halaman `<head>`

### 5.3 Konten Per Bahasa

Setiap halaman memiliki file view terpisah per bahasa, atau menggunakan file bahasa CI4 (`app/Language/`):

```
app/Language/
├── id/
│   └── messages.php
├── en/
│   └── messages.php
├── zh/
│   └── messages.php
├── fr/
│   └── messages.php
├── es/
│   └── messages.php
└── ja/
    └── messages.php
```

---

## 6. Responsive Behavior

### 6.1 Mobile-First Approach

1. Layout default: single column, stacked
2. Tablet (720px+): 2 kolom untuk grid, side-by-side layout
3. Desktop (1024px+): full layout, navigasi horizontal
4. Large (1280px+): max-width container, centered

### 6.2 Breakpoint CSS

```css
@media (max-width: 720px) {
  .container {
    padding-left: var(--container-gutter-tablet, 28px);
    padding-right: var(--container-gutter-tablet, 28px);
  }
  /* Stack columns, reduce font sizes */
}

@media (max-width: 400px) {
  .container {
    padding-left: var(--container-gutter-phone, 18px);
    padding-right: var(--container-gutter-phone, 18px);
  }
  /* Compact layout */
}
```

### 6.3 Touch Targets

- Minimum 44px untuk semua elemen interaktif
- Tombol pill: padding 14px 32px (memenuhi syarat)

---

## 7. Anti-Pattern & Larangan

- **Jangan gunakan shadow** — Revolut flat design, depth dari kontras warna
- **Jangan gunakan bold (700) untuk heading Aeonik Pro** — weight 500 adalah standar
- **Jangan gunakan tombol kecil** — padding generous (14px 32px) adalah intentional
- **Jangan terapkan warna semantic ke marketing surface** — warna semantic untuk produk, bukan landing page
- **Jangan invent warna baru** — gunakan hanya token dari `:root`
- **Jangan gunakan hex mentah di luar `:root`** — semua warna via `var(--*)`
- **Jangan gunakan scrollIntoView** — bisa break embedded preview
- **Jangan hotlink gambar** — semua gambar harus local atau inline data URI

---

## 8. File CSS Utama

```
public/assets/
├── css/
│   ├── main.css          ← Token + reset + layout
│   ├── components.css    ← Komponen (tombol, kartu, form)
│   ├── pages.css         ← Halaman spesifik
│   └── responsive.css    ← Media queries
├── js/
│   └── main.js           ← Navigasi mobile, smooth scroll
└── img/                  ← Semua gambar lokal
```

---

## 9. Catatan Implementasi CI4

### 9.1 Asset Loading

```php
// Di controller atau view
$this->request->getBaseURL('assets/css/main.css');
// Atau gunakan helper URL
echo base_url('assets/css/main.css');
```

### 9.2 Multilingual Route

```php
// app/Config/Routes.php
$routes->group('{locale}', ['filter' => 'locale'], function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('sejarah', 'Home::history');
    $routes->get('visi-misi', 'Home::visionMission');
    $routes->get('layanan', 'Home::services');
    $routes->get('kontak', 'Home::contact');
    $routes->get('portofolio', 'Home::portfolio');
    $routes->get('investor', 'Home::investor');
});
```

### 9.3 View Rendering

```php
// Di controller
return view('pages/home', [
    'title' => 'Beranda',
    'locale' => $locale,
]);
```

```php
// Di view (layouts/main.php)
<!doctype html>
<html lang="<?= esc($locale) ?>">
```

---

## 10. Referensi Desain

- **Design System:** Revolut Design System 2.0
- **Framework:** CodeIgniter 4 (PHP 8.3+)
- **Deployment:** VPS (Apache/nginx + PHP-FPM)
- **Multilingual:** 6 bahasa via URL path routing
- **Responsive:** Mobile-first, 4 breakpoint
- **Static:** Tanpa CMS, tanpa database relasional