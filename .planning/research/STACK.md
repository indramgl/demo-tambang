# STACK.md

## Recommended Stack

### Backend
- **PHP 8.3+** — CodeIgniter 4 (CI4) framework
- **Composer** — dependency management
- **SQLite** — lightweight DB for contact form / dynamic data jika dibutuhkan

### Frontend
- **HTML5 + CSS3 + vanilla JS** — company profile bersifat statis, tidak butuh SPA
- **Hreflang tags** — multilingual SEO (6 bahasa)

### Deployment
- **VPS traditional** (DigitalOcean, Linode, Hetzner)
- Apache/nginx + PHP-FPM

## Versions
- PHP 8.3+ (CI4 4.5+ recommended)
- Composer latest

## What NOT to Use
- Database MySQL/PostgreSQL — overkill untuk konten statis
- CMS seperti WordPress — konten statis, tidak perlu CMS
- Client-side rendering heavy — buruk untuk SEO multilingual
- Vercel/Cloudflare Pages — tidak support PHP native

## Confidence: HIGH
- CI4 + VPS adalah deployment standar, well-documented
- Apache/nginx + PHP-FPM sudah mature

## Sources
- firecrawl search: "company profile website tech stack 2026"
- firecrawl search: "CodeIgniter 4 deployment vercel cloudflare serverless"
- firecrawl search: "PHP static company website CI4 2026"
- CodeIgniter 4 official docs: deployment