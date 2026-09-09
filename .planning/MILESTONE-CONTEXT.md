---
version: v2.0
created: 2026-09-08
status: ready
---

# Milestone Context: v2.0 — Skeleton Pages & Design Integration

## Goals

- Buat skeleton pages untuk semua halaman yang sudah disepakati (home, sejarah, visi-misi, layanan, kontak, portofolio, investor relation)
- Halaman harus mematuhi design.md (Revolut Design System 2.0 tokens, komponen, layout)
- Implementasi REQ-008: Multilingual routing (`/id/`, `/en/`, `/zh/`, `/fr/`, `/es/`, `/ja/`)
- Implementasi REQ-009: Static page templates (render markdown sebagai HTML dengan layout konsisten)
- Implementasi REQ-010: Design integration (terapkan design.md ke CI4 views/templates)

## Must-Have Features

- CI4 routes handle locale-prefixed URLs (`/id/`, `/en/`, etc.) with locale filter
- 7 skeleton pages render with consistent layout (header, content, footer)
- Design tokens from design.md applied as CSS custom properties in `public/assets/css/main.css`
- Layout template (`layouts/main.php`) with navbar, breadcrumb, and footer partials
- Each page uses CI4 view structure per design.md section 4 (hero, content sections, CTA)
- Hreflang tags generated in `<head>` for all 6 language variants
- Language switcher in navbar (top-right, dropdown or inline)
- Responsive breakpoints from design.md (mobile-first, 4 breakpoints)

## Anti-Goals

- **No CMS or database** — static content only, no SQLite, no dynamic content management
- **No design iteration** — design.md is frozen after skeleton is complete; no further design changes until v3
- **No content writing** — placeholder/lorem content only; real multilingual content comes in v3
- **No VPS deployment** — local dev only; VPS provisioning stays out of scope

## Constraints

- **Scope:** Solo developer, 2-3 days
- **Quality bar:** Prototype/skeleton — pages render with placeholder content, not production-ready
- **Off-limits areas:** No contact form logic, no database setup, no admin panel, no portfolio/IR content creation
- **Architecture constraints:** CI4 + OpenLitespeed stack locked; git pull deployment; multilingual via URL path routing; static content model

## Open Questions

- Portfolio & IR: format konten (PDF, gambar, table)? — placeholder only for now
- design.md from OpenDesign — already exists in repo, but may receive updates before v3
- Exact VPS installation path (TBD during installation)

---

*Captured 2026-09-08*