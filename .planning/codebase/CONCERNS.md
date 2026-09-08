# Codebase Concerns

**Researched:** 2026-09-07
**Updated:** 2026-09-07 (post new-project ceremony + ideation)

---

## Code-Level Concerns

**None found.** No source code exists yet. All concerns are project-level.

---

## Project-Level Concerns

### 1. design.md Blocking Dependency (HIGH)
**File:** `.planning/PROJECT.md`, `.planning/REQUIREMENTS.md`
**Risk:** Phase 3 (Content Implementation) is blocked waiting for design.md from OpenDesign with no delivery date.
**Mitigation:** Scaffold HTML/CSS structure with placeholder content and neutral template now. When design.md arrives, swapping is a template replacement.
**Status:** Open — waiting on OpenDesign

### 2. No .gitignore (HIGH)
**File:** Repository root (missing)
**Risk:** Sensitive files (`.env`, credentials, IDE configs) can be accidentally committed.
**Action:** Create `.gitignore` for CI4/VPS (.env, vendor/, writable/, .opencode/, OS files).
**Status:** Open — should be created before any code is written.

### 3. No .gitignore for .planning/ (MEDIUM)
**File:** `.planning/`
**Risk:** Planning docs contain project structure and decisions — might need to be gitignored if `planning.commit_docs` is false.
**Note:** Currently `planning.commit_docs = true` in config.json, so planning docs ARE committed.
**Status:** OK — docs are tracked in git.

### 4. No .continue-here.md Commit (LOW)
**File:** `.planning/phases/phase-0-setup/.continue-here.md`
**Risk:** Handoff file exists but might not be tracked.
**Status:** Recently committed.

### 5. IDE/Editor Config Files Not Gitignored (LOW)
**Risk:** `.vscode/`, `.idea/` might be created by IDE and committed accidentally.
**Status:** Open — add to `.gitignore` before code starts.

### 6. OpenLitespeed Specific Concerns (MEDIUM)
**Risk:** OpenLitespeed is less common than Apache/nginx. CI4 routing might need custom configuration.
**Mitigation:** Research OpenLitespeed + CI4 compatibility. Verify mod_rewrite equivalent.
**Status:** Open — validate during Phase 1 provisioning.

### 7. PHP 8.5 Compatibility (MEDIUM)
**Risk:** CI4 4.x might not fully support PHP 8.5 at time of deployment.
**Mitigation:** Verify CI4 version compatibility with PHP 8.5 before finalizing stack.
**Status:** Open — check during Phase 1.

### 8. Postmark PHP SDK Dependency (MEDIUM)
**Risk:** `wildbit/postmark-php` package compatibility with PHP 8.5 and CI4.
**Mitigation:** Add to Composer, test during Phase 4.
**Status:** Open.

### 9. Multilingual Content Drift (MEDIUM)
**Risk:** 6 languages × 6 pages = 36 content files. Translation drift between languages is guaranteed without workflow.
**Mitigation:** Single-source markdown + JSON translation layer (decided in ideation). AI translation with direct publish.
**Status:** Addressed in planning — workflow decided but not implemented.

### 10. VPS Security (MEDIUM)
**Risk:** Password SSH auth, no firewall, no backup, no monitoring — all for demo purposes.
**Mitigation:** For production, add SSH key auth, UFW firewall, backup strategy, monitoring.
**Status:** Intentional for demo — must be addressed before production.

---

## Codebase Map Status

The `.planning/codebase/` documents were originally generated during the empty-repo mapping phase and have been updated to reflect the current project state after new-project ceremony and ideation session.

| Document | Status | Last Updated |
|----------|--------|--------------|
| STACK.md | Updated | 2026-09-07 |
| ARCHITECTURE.md | Updated | 2026-09-07 |
| STRUCTURE.md | Needs update | 2026-09-07 |
| CONVENTIONS.md | Needs update | 2026-09-07 |
| TESTING.md | Needs update | 2026-09-07 |
| INTEGRATIONS.md | Updated | 2026-09-07 |
| CONCERNS.md | Updated | 2026-09-07 |

---

## Recommended Actions

1. **Create `.gitignore`** before any code is written (CI4/VPS specific).
2. **Monitor design.md delivery** from OpenDesign — blocking Phase 3.
3. **Verify CI4 + PHP 8.5 + OpenLitespeed compatibility** during Phase 1.
4. **Test Postmark PHP SDK** during contact form implementation.
5. **Address VPS security** (SSH key, firewall, backup) before production deployment.
6. **Implement translation workflow** (markdown + JSON) before Phase 3 content implementation.
7. **Scaffold CI4 project** — Phase 1 deliverable.