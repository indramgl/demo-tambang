# Structure — Research

**Researched:** 2026-09-07
**Updated:** 2026-09-07 (post new-project ceremony + ideation)

## Directory Map

```
perusahaan-tambang/
├── app/                          # CI4 application (controllers, models, views)
│   ├── Config/                   # App configuration (App.php, Database.php, .env)
│   ├── Controllers/              # Page controllers (Sejarah, VisiMisi, etc.)
│   ├── Models/                   # Database models (SQLite)
│   ├── Views/                    # View templates (PHP)
│   │   ├── pages/                # Page views (sejarah, visi-misi, etc.)
│   │   │   └── {halaman}/        # Per halaman
│   │   │       └── {bahasa}.md   # Markdown content per bahasa
│   │   └── lang/                 # Translation JSON files
│   │       └── {halaman}.{bahasa}.json
│   └── Views/                    # View templates (standard CI4 views)
├── public/                       # Document root (index.php, assets)
│   ├── index.php                 # CI4 front controller
│   ├── .htaccess                 # OpenLitespeed rewrite rules
│   └── assets/                   # CSS, JS, images
├── writable/                     # Writable directory (logs, cache, sessions)
├── vendor/                       # Composer dependencies
├── content/                      # Static content (optional, markdown source)
│   ├── pages/                    # Markdown per halaman per bahasa
│   ├── portfolio/                # Portfolio images
│   └── ir/                       # Investor Relations PDFs
├── .opencode/                    # OpenCode platform config (gitignored)
├── .planning/                    # Planning artifacts
│   ├── PROJECT.md
│   ├── REQUIREMENTS.md
│   ├── ROADMAP.md
│   ├── config.json
│   ├── DECISIONS.md
│   ├── notes/                    # Session notes (vps-provisioning.md, etc.)
│   ├── research/                 # Research files (STACK, FEATURES, etc.)
│   ├── codebase/                 # Codebase map (7 docs)
│   └── phases/                   # Phase plans, handoff files
├── .git/                         # Git repository
├── .gitignore                    # Git ignore (to be created)
├── AGENTS.md                     # AI agent configuration
├── README.md                     # Project description (to be created)
├── design.md                     # Design reference from OpenDesign (pending)
└── composer.json                 # Composer dependencies
```

## Naming Conventions

- **Controllers:** PascalCase (`Sejarah.php`, `Kontak.php`)
- **Views:** kebab-case directory, snake_case files (`sejarah/id.md`, `visi-misi/en.json`)
- **Models:** PascalCase (`Message.php`, `Portfolio.php`)
- **Configuration:** PascalCase (`App.php`, `Database.php`)
- **Markdown:** `{halaman}.{bahasa}.md` (e.g., `sejarah.id.md`)
- **JSON:** `{halaman}.{bahasa}.json` (e.g., `sejarah.id.json`)
- **Routes:** URL path segments (`/id/`, `/en/`)

## Where to Find Things

| What | Where | Status |
|------|-------|--------|
| Source code | `app/` | **Not yet created** |
| Configuration | `app/Config/` | **Not yet created** |
| Views/templates | `app/Views/` | **Not yet created** |
| Translation files | `app/Views/lang/` | **Not yet created** |
| Tests | `tests/` | **Not yet created** |
| Documentation | `.planning/` | **Created** |
| Dependencies | `vendor/` | **Not yet created** |
| Design reference | `design.md` | **Pending (OpenDesign)** |

## Conventions Observed

- **Planning folder:** `.planning/` is used for all planning artifacts
- **Codebase map:** `.planning/codebase/` contains 7 research docs
- **Session notes:** `.planning/notes/` contains ideation deep-dive results
- **No .gitignore** yet — needs creation before code starts
- **No README** yet — needs creation before code starts
- **design.md** pending from OpenDesign — blocks Phase 3

## What Needs to Happen

1. **Scaffold CI4 project** — create `app/`, `public/`, `vendor/` structure
2. **Create `.gitignore`** for CI4/VPS
3. **Add `README.md`** with project description
4. **Setup OpenLitespeed + PHP-FPM** on VPS
5. **Create directory structure** per map above
6. **Add `design.md`** from OpenDesign when delivered