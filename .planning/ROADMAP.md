# ROADMAP.md — v1.0 Setup & Scaffold

## Phase 1: Setup & Scaffold

### Phase 1 Deliverable
CI4 project scaffolded and deployable to staging VPS.

### Tasks

| REQ-ID | Task | Success Criteria |
|--------|------|-----------------|
| REQ-002 | Create `.gitignore` | `.gitignore` covers `.env`, `vendor/`, `writable/`, `.opencode/`, IDE configs |
| REQ-001 | Scaffold CI4 via Composer | `composer create-project codeigniter4/appstarter` completes without errors |
| REQ-007 | Configure Git remote | `git push origin master` succeeds |
| REQ-003 | Verify `php spark serve` | App accessible at `localhost:8080` |
| REQ-005 | Create multilingual directory structure | `app/Views/pages/{halaman}/{bahasa}.md` dirs exist for all 6 languages |
| REQ-006 | Verify CI4 + PHP 8.4 + OpenLitespeed compatibility | No compatibility errors, routing works |
| REQ-004 | Test VPS deploy pipeline | `git pull origin master` works on VPS, app serves correctly |

### Dependencies
1. `.gitignore` (REQ-002) → before any code is written
2. CI4 scaffold (REQ-001) → before all other tasks
3. Git remote (REQ-007) → before VPS deploy (REQ-004)
4. `php spark serve` (REQ-003) → before VPS deploy (REQ-004)

### Timeline
- Phase 1: 2-3 days (solo, prototype quality)

### Risks
- OpenLitespeed rewrite rules — CI4 `.htaccess` should work, needs validation on VPS
- PHP 8.4 + CI4 compatibility — CI4 v4.7.4 requires PHP ^8.2, PHP 8.4 satisfies this
- VPS provisioning not yet started — blocks REQ-004

---

## v2 Candidates (Next Milestone)

| REQ-ID | Feature | Phase |
|--------|---------|-------|
| REQ-008 | Multilingual routing | Phase 2 |
| REQ-009 | Static page templates | Phase 2 |
| REQ-010 | Design integration | Phase 3 (blocked by design.md) |

---

## Out of Scope (v1)

- Design integration (design.md pending)
- Contact form / email
- CMS / admin panel
- Portfolio / IR content
- Database logic
- User authentication
- Blog / news
