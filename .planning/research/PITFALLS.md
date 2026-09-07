# PITFALLS.md

## Common Mistakes

### 1. CI4 di VPS — Standard Deployment
CI4 dirancang untuk traditional PHP hosting. VPS + Apache/nginx + PHP-FPM adalah cara standar. **Tidak ada masalah kompatibilitas.**

### 2. Multilingual Routing yang Salah
Jangan pakai cookie/subdomain untuk bahasa — pakai URL path (`/id/`, `/en/`) agar SEO benar dan bookmarkable.

### 3. Over-engineering Database
Konten statis → jangan pakai MySQL/PostgreSQL. SQLite hanya jika benar-benar diperlukan (contact form submissions).

### 4. Tidak Ada .gitignore
Pastikan `.opencode/`, `vendor/`, `.env` di-ignore sebelum commit pertama.

### 5. Desain Belum Fix Sebelum Coding
Design.md dari OpenDesign harus ready sebelum implementasi. Jangan coding dulu lalu ubah-ubah.

## Warning Signs
- Apache/nginx config salah → 403/404
- Hreflang tags salah → SEO penalty multilingual
- SQLite permission issues

## Prevention Strategies
- Setup Apache/nginx + PHP-FPM dengan benar
- Gunakan CI4 built-in multilingual routing
- Static page generation untuk halaman konten
- `.gitignore` lengkap sebelum commit

## Phase Mapping
| Pitfall | Phase |
|---------|-------|
| Apache/nginx config | Setup/Scaffold |
| Multilingual routing | Architecture |
| Over-engineering DB | Requirements |
| .gitignore missing | Setup |
| Design lock-in | Before coding |

## Confidence: HIGH
- Berdasarkan pola deployment CI4 standar
- VPS + Apache/nginx + PHP-FPM adalah cara resmi

## Sources
- firecrawl search: "company profile website tech stack 2026 best practices"
- firecrawl search: "CodeIgniter 4 deployment vercel cloudflare serverless"
- CodeIgniter 4 official docs: deployment