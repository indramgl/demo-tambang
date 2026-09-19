# ROADMAP.md — PT Indah Tambang Raya Semesta

## Completed Milestones

### v1.0 — Setup & Scaffold
Completed: 2026-09-08. 1 phase, 6 of 7 requirements delivered (REQ-004 blocked on VPS provisioning). See `.planning/milestones/v1.0-ROADMAP.md` for full details.

---

### v2.0 — Skeleton Pages & Design Integration ✓ Complete (2026-09-19)

Completed: 2026-09-19. 1 phase (02-skeleton-pages), 3 requirements delivered (REQ-008, REQ-009, REQ-010). See `.planning/milestones/v2.0-ROADMAP.md` for full details.

#### Phase 02 — Skeleton Pages & Design Integration ✓ Complete

All 3 requirements satisfied: multilingual routing (REQ-008), 8 skeleton pages with CI4 view rendering (REQ-009), design tokens including typography and elevation (REQ-010). 77/77 unit tests passing. DesignSync extended with typography and elevation tokens. Pre-render pipeline removed in favor of CI4 native `view()` rendering.

---

## Out of Scope (v2.0)

- Contact form / email (Phase 4)
- Database / SQLite (Phase 4)
- Admin panel
- Portfolio / IR content creation (placeholder only)
- VPS deployment (REQ-004 still blocked)
- Design iteration (design.md frozen after skeleton)
- Content writing (placeholder only)

## Upcoming Milestones

### v3.0 (TBD)
- Contact form with Postmark email
- Database/SQLite for contact form storage
- Portfolio & Investor Relation content pages
- Design iteration based on v2.0 feedback

---

## Requirements Index

| REQ-ID | Description | Status | Milestone |
|--------|-------------|--------|-----------|
| REQ-001 | CI4 project scaffolded via Composer | ✓ Delivered | v1.0 |
| REQ-002 | .gitignore created | ✓ Delivered | v1.0 |
| REQ-003 | Local dev server working | ✓ Delivered | v1.0 |
| REQ-004 | VPS deploy pipeline | Blocked | v1.0 |
| REQ-005 | Multilingual directory structure | ✓ Delivered | v1.0 |
| REQ-006 | CI4 + PHP + OpenLitespeed compatibility | ✓ Delivered | v1.0 |
| REQ-007 | Git remote configured | ✓ Delivered | v1.0 |
| REQ-008 | Multilingual routing | ✓ Delivered | v2.0 |
| REQ-009 | Static page templates | ✓ Delivered | v2.0 |
| REQ-010 | Design integration | ✓ Delivered | v2.0 |
