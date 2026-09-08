# DECISIONS.md

---

### DEC-001: v1.0 Challenge Verdict — Setup & Scaffold

**Date:** 2026-09-08
**Type:** scope
**Context:** Challenged via `/challenge` — product + engineering lens
**Decision:** Reduced scope with modification
**Rationale:** Engineering lens flagged OpenLitespeed + CI4 compatibility and PHP 8.5 compatibility as MEDIUM risks. ROADMAP contradicted itself (Apache/nginx vs OpenLitespeed). Product lens confirmed the scaffold is sound. User resolved: keep OpenLitespeed on VPS (production) but use `php spark serve` for local testing/scaffold development — decoupling local dev from production web server. This removes the OpenLitespeed routing concern from Phase 1 scope while keeping the production architecture intact.

---
