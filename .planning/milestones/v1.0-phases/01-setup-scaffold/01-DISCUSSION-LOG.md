# Phase 01 — Setup & Scaffold - Discussion Log

**Gathered:** 2026-09-08
**Mode:** deep

## Gray Areas Discussed

### 1. Local Dev Environment Setup

#### Hot Reload
- **Option A:** `php spark serve` with auto-reload ← **SELECTED**
  - CI4 built-in server handles file watching, no extra config
- **Option B:** External file watcher (nodemon)
  - More control but adds tooling complexity
- **Option C:** Manual restart only
  - Simplest but slows development

**Rationale:** CI4's built-in auto-reload is the standard approach. No extra tooling needed.

#### .env Management
- **Option A:** Standard CI4 .env pattern ← **SELECTED**
  - `.env.example` committed, `.env` gitignored, VPS has its own `.env`
- **Option B:** Environment variables only, no .env file
  - More secure but less convenient for local dev
- **Option C:** Separate .env files per environment
  - More complex, CI4's built-in pattern is sufficient

**Rationale:** Standard CI4 pattern is well-documented and works for both local and VPS.

#### Debugging
- **Option A:** Xdebug + CI4 error pages ← **SELECTED**
  - Full step debugging capability, CI4 error pages for quick diagnostics
- **Option B:** Simple dump debugging only
  - No setup but limited debugging capability
- **Option C:** No debugging in v1.0
  - Simplest but slows development if issues arise

**Rationale:** Xdebug is the standard PHP debugging tool. CI4 error pages provide quick diagnostics without setup.

## Areas Skipped (All Clear)

- VPS provisioning approach — not discussed, standard manual setup
- OpenLitespeed CI4 routing config — CI4 .htaccess works on OpenLitespeed (verified in research)
- .gitignore scope and strategy — standard CI4 pattern, already created

## Prior Decisions Applied

- DEC-001: OpenLitespeed on VPS, `php spark serve` locally — confirmed
- Challenge verdict: Reduced scope, no design integration, no contact form

## Deferred Ideas

- Docker for local dev — could simplify environment setup, deferred to v2
- CI4 caching config for OpenLitespeed — defer to Phase 5
- SSH key auth for VPS — defer to Phase 5 (production hardening)

---
*Phase: 01-setup-scaffold*
*Discussion log: 2026-09-08*