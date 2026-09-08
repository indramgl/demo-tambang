# Conventions & Quality

**Researched:** 2026-09-07
**Updated:** 2026-09-07 (post new-project ceremony + ideation)

## Coding Style Enforced

**None established yet** — no source code exists. Conventions will be defined during Phase 1 scaffold.

### PHP Conventions (to be established)
- **PSR-12** — CodeIgniter 4 follows PSR-12 coding standard
- **Indentation:** 4 spaces (PHP convention)
- **Naming:** PascalCase for classes, camelCase for methods/properties
- **Views:** HTML/PHP mixed, minimal logic in views

### Frontend Conventions (to be established)
- **HTML5** semantic markup
- **CSS3** with no framework (static content)
- **No CSS framework** — vanilla CSS per design.md
- **Responsive:** mobile-first, breakpoints at 320px, 768px, 1024px, 1440px

### Markdown Conventions
- **One file per page per language** (`app/Views/pages/{halaman}/{bahasa}.md`)
- **Frontmatter optional** — metadata (title, description, date)
- **Translation JSON:** flat key-value, `app/Views/lang/{halaman}.{bahasa}.json`
- **Fallback:** missing key → Indonesian
- **AI translation:** `ling-3.0-flash-sante` → direct publish (no manual review)

## Naming Patterns

| Component | Convention | Example |
|-----------|-----------|---------|
| Controller | PascalCase | `Sejarah.php`, `Kontak.php` |
| View directory | kebab-case | `sejarah/`, `visi-misi/` |
| Markdown file | `{halaman}.{bahasa}.md` | `sejarah.id.md`, `kontak.en.md` |
| JSON translation | `{halaman}.{bahasa}.json` | `sejarah.id.json`, `kontak.en.json` |
| Language code | 2-letter ISO | `id`, `en`, `zh`, `fr`, `es`, `ja` |
| Route | URL path segment | `/id/`, `/en/`, `/zh/`, `/fr/`, `/es/`, `/ja/` |
| Model | PascalCase | `Message.php`, `Portfolio.php` |
| Config | PascalCase | `App.php`, `Database.php` |

## Common Idioms / Patterns

### CI4 Routing
- Language prefix in URL: `/id/sejarah`, `/en/about`
- Root `/` redirects to `/id/`
- Controller methods map to page views

### Content Loading
- Controller reads markdown file based on URL segment
- Markdown → HTML via Parsedown/CommonMark
- JSON translation drives dynamic content

### Error Handling
- **None established** — will be defined during Phase 1
- CI4 built-in error handling
- No custom error pages planned (static site)

### Database
- **SQLite only** — no ORM, raw PHP SQLite3 extension
- Minimal dynamic features (contact form submissions)
- No database migrations planned

## What NOT to Do (Based on Planning)

- Do **not** use a CMS — content is static
- Do **not** use MySQL/PostgreSQL — SQLite only
- Do **not** create 36 separate HTML files per page — use markdown + JSON
- Do **not** add user authentication — not required for this project
- Do **not** use serverless deployment — VPS is the chosen architecture
- Do **not** use Vercel/Cloudflare Pages — PHP not supported natively
- Do **not** build 6 languages simultaneously — start with ID+EN bilingual MVP
- Do **not** manually translate — use AI translation (ling-3.0-flash-sante)
- Do **not** add serverless complexity — keep it simple

## Existing Patterns in This Codebase

- **Planning artifacts:** `.planning/` directory with all project docs
- **Codebase map:** `.planning/codebase/` with 7 research docs
- **Session notes:** `.planning/notes/vps-provisioning.md` contains VPS + ideation specs
- **No `.gitignore`** yet — needs creation before any code
- **No linting/formatting config** — will be established during Phase 1
- **No CI/CD pipeline** — will be established during Phase 5

## Design Reference
- **design.md** from OpenDesign — will drive all frontend conventions
- Must be delivered before Phase 3 implementation
- Not yet available — blocking dependency

## Recommended Approach

1. **Create `.gitignore`** for CI4/VPS before any code
2. **Establish linting** (PHP_CodeSniffer, PHPCS) during Phase 1
3. **Create `composer.json`** with all dependencies (CI4, Postmark, Parsedown)
4. **Add `README.md`** with project description
5. **Set up PHP_CodeSniffer** with PSR-12 standard
6. **Wait for design.md** before establishing frontend conventions
7. **Document all conventions** in this file as they're established