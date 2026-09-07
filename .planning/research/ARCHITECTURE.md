# ARCHITECTURE.md

## Component Boundaries

```
┌─────────────────────────────┐
│  VPS (DigitalOcean/Linode) │
├─────────────────────────────┤
│  Apache/nginx + PHP-FPM     │
├─────────────────────────────┤
│  CI4 Application            │
├─────────────────────────────┤
│  SQLite (optional)          │
├─────────────────────────────┤
│  Contact Form (mail())      │
└─────────────────────────────┘
```

## Data Flow
1. User → CDN edge → static page (cached)
2. Contact form → serverless function → email/SQLite
3. Language switch → URL-based routing (`/id/`, `/en/`, `/zh/`, dll.)

## Build Order
1. Scaffold CI4 project di VPS
2. Setup Apache/nginx + PHP-FPM
3. Buat halaman statis per bahasa
4. Integrasi multilingual routing

## Integration Points
- OpenDesign → design.md → frontend implementation
- CDN edge caching → static assets
- Email service → contact form (opsional)

## Confidence: HIGH
- CI4 + Apache/nginx + PHP-FPM adalah standar deployment
- Multilingual routing CI4 sudah supported — mungkin butuh static export

## Key Decisions
- Static-first → generate HTML statis per bahasa
- Serverless functions hanya untuk contact form
- SQLite hanya jika ada fitur dinamis

## Sources
- firecrawl search: "CodeIgniter 4 deployment vercel cloudflare serverless"
- firecrawl search: "PHP static company website CI4 2026"
- CodeIgniter 4 official docs: deployment, running