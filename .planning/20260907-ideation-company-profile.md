# Ideation — Company Profile Website

**Date:** 2026-09-07
**Focus:** open-ended (PT Indah Tambang Raya Semesta)
**Mode:** scan (parallel, 3 lenses)

## Top Ideas

### 1. VPS Provisioning Script
**Impact:** high | **Evidence:** ROADMAP Phase 1, open question (VPS provider?)
**Summary:** Pick VPS provider (DigitalOcean/Linode/Hetzner), create provisioning script covering PHP 8.3, Composer, Apache/nginx, PHP-FPM, SQLite extension, git clone, SSL (Let's Encrypt). Makes Phase 1 reproducible.
**Scope:** medium

### 2. Static Content Workflow
**Impact:** high | **Evidence:** REQUIREMENTS FR-3, FR-1
**Summary:** Single-source markdown per page → 6 language copies. Without this, operator edits 36 files for one typo fix. Use CI4 view loader to serve language-specific markdown.
**Scope:** medium

### 3. Bilingual MVP (ID + EN first)
**Impact:** high | **Evidence:** open question (6 languages?), scope reduction
**Summary:** Start with Indonesia + English only. Add ZH/FR/ES/JA later as content is ready. No architecture change needed — just copy templates + translate.
**Scope:** small

### 4. Translation JSON+Template
**Impact:** medium | **Evidence:** 6×6 = 36 page variants
**Summary:** One CI4 view template + 6 JSON files per page instead of 6 full HTML files. Adding a language = config change, not 6 new files.
**Scope:** medium

### 5. Email Dependency Resolution
**Impact:** medium | **Evidence:** REQUIREMENTS dependency #3
**Summary:** Decide email provider (SMTP/SES/sendmail), store credentials in .env, write test script, document in DECISIONS.md before Phase 4.
**Scope:** small

### 6. SQLite Schema Decision
**Impact:** medium | **Evidence:** "optional" ambiguity in REQUIREMENTS
**Summary:** Define messages table schema now: id, name, email, subject, body, created_at, read_status. Makes "SQLite if needed" concrete.
**Scope:** small

### 7. Hreflang/SEO Auto-Check
**Impact:** medium | **Evidence:** PITFALLS #2 (wrong hreflang = SEO penalty)
**Summary:** CLI script that verifies hreflang tags, canonical URLs, broken links across all 36 page variants. Run as pre-deploy gate in Phase 5.
**Scope:** medium

### 8. Pre-commit Safety Net
**Impact:** medium | **Evidence:** CONCERNS #1 (HIGH severity — no .gitignore)
**Summary:** Create .gitignore (CI4/VPS: .env, vendor/, writable/, .opencode/) + README.md skeleton before any code is written.
**Scope:** small

### 9. Content Format Lock
**Impact:** medium | **Evidence:** open questions (Portfolio format? IR format?)
**Summary:** Define: Portfolio = images only or images+video? IR = PDF only? Max file sizes? Image dimensions? Document in content-specs.md.
**Scope:** small

### 10. IR Index Page
**Impact:** low | **Evidence:** open question (IR format?)
**Summary:** IR landing page with summaries, dates, categories + PDF links. Not bare file dump. Professional first impression for analysts/shareholders.
**Scope:** small

## Eliminated Ideas

| Idea | Reason |
|------|--------|
| Kill CI4 | contradicts decided stack |
| Remove VPS entirely | contradicts user decision |
| Cut SQLite | SQLite already accepted as optional |
| Static site generator replacement | too radical for scope |
| Design.md dependency blocker | already known constraint |

## Scan Context

- Codebase: empty (no source files)
- Git: 6 commits (all planning docs)
- Concerns: no .gitignore (HIGH), no README (MEDIUM)
- Open questions: VPS provider, 6 languages spec, contact form email, CI4 version, portfolio/IR format