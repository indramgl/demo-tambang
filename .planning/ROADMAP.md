# ROADMAP.md — v2.0 Skeleton Pages & Design Integration

## Completed Milestones

### v1.0 — Setup & Scaffold
Completed: 2026-09-08. 1 phase, 6 of 7 requirements delivered (REQ-004 blocked on VPS provisioning). See `.planning/milestones/v1.0-ROADMAP.md` for full details.

---

## v2.0 — Skeleton Pages & Design Integration

### Phase 1: Multilingual Routing & Static Page Templates ✓ Complete (2026-09-09)

#### Phase 1 Deliverable
CI4 app serves skeleton pages with multilingual routing — all 7 pages accessible in all 6 languages via URL path (`/id/`, `/en/`, etc.).

#### Tasks

| REQ-ID | Task | Success Criteria | Status |
|--------|------|-----------------|--------|
| REQ-008 | Implement multilingual routing | Routes handle `/id/`, `/en/`, `/zh/`, `/fr/`, `/es/`, `/ja/` URL segments; locale filter validates against supported list | ✓ Complete |
| REQ-009 | Create static page templates | 7 skeleton pages render with consistent layout (header, content, footer); markdown content served as HTML | ✓ Complete |
| REQ-010 | Apply design.md tokens and components | CSS custom properties from design.md applied; Revolut Design System 2.0 components (buttons, cards, nav, forms) implemented | ✓ Complete |

#### Dependencies
1. REQ-008 (multilingual routing) → before REQ-009 (pages need locale-aware routing)
2. REQ-010 (design integration) → before REQ-009 (templates need design tokens to render correctly)
3. All three are interdependent — implement together

#### Timeline
- Phase 1: 2-3 days (solo, prototype quality)

#### Risks
- design.md may receive updates from OpenDesign before v3 — templates should be easy to update
- OpenLitespeed static page cache may serve wrong locale's cached page — validate during testing
- `{locale}` is a CI4 reserved placeholder — cannot use as custom regex

---

## Out of Scope (v2.0)

- Contact form / email (Phase 4)
- Database / SQLite (Phase 4)
- Admin panel
- Portfolio / IR content creation (placeholder only)
- VPS deployment (REQ-004 still blocked)
- Design iteration (design.md frozen after skeleton)
- Content writing (placeholder only)