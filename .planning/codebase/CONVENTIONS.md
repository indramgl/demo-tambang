# Conventions & Quality

**Researched:** 2026-09-07
**Phase goal:** N/A — no ROADMAP.md found in workspace

## Current State

The repository at `C:\Coding\perusahaan-tambang` has **no source code**. The only directories are `.git/` and `.planning/`. No linting config, no style guide, no code files of any kind exist to analyze.

- `package.json` — **None found**
- `tsconfig.json` — **None found**
- `.eslintrc*` — **None found**
- `.prettierrc*` — **None found**
- Any source files (`.ts`, `.js`, `.py`, `.rs`, `.go`, `.java`, `.cs`, etc.) — **None found**
- `.gitignore` — **None found**

## Coding Style Enforced

**None established.** No linting, formatting, or style configuration exists. Nothing is enforced because nothing exists to enforce.

## Naming Patterns

**None established.** No source files exist to infer naming conventions (camelCase vs snake_case, PascalCase for classes, etc.).

## Common Idioms / Patterns

**None established.** No error handling patterns, logging approaches, validation strategies, or utility functions exist in the codebase.

## What NOT to Do (Based on Absence)

- Do **not** introduce code without first deciding on a tech stack and creating the project scaffold.
- Do **not** add linting/formatting config without first choosing tools (e.g., ESLint + Prettier for JS/TS, ruff/black for Python, etc.).
- Do **not** establish naming conventions retroactively from a single file — define them upfront as part of the initial scaffold.
- Do **not** create a `.gitignore` after files are committed — the repo currently has no `.gitignore` at all.

## Existing Patterns in This Codebase

- **Planning folder:** `.planning/codebase/` is used for research artifacts (ARCHITECTURE.md, INTEGRATIONS.md, STACK.md, STRUCTURE.md were created by earlier research).
- No `.gitignore` file exists in the repo root.
- No README, LICENSE, or CONTRIBUTING files exist.

## Recommended Approach

Before conventions can be documented, the project must be scaffolded:
1. Decide the tech stack (language, framework, runtime).
2. Create the project with standard tooling (linter, formatter, type-checker).
3. Establish directory structure (`src/`, `tests/`, `docs/`, `config/`).
4. Then re-run this research to capture actual conventions from the new code.
