# Structure — Research

**Researched:** 2026-09-07
**Phase goal:** N/A — no ROADMAP.md found in workspace

## Directory Map

```
C:\Coding\perusahaan-tambang\
├── .git/                          # Git repository internals (no commits yet)
├── .git/config                    # Git config (local settings)
├── .git/hooks/                    # Sample Git hooks (all *.sample, none active)
├── .git/objects/                  # Git object store (empty — no commits)
├── .git/refs/                     # Git refs (empty — no branches with commits)
├── .git/FETCH_HEAD                # Empty file
├── .git/HEAD                      # Points to refs/heads/master
├── .git/description               # Default repo description
├── .git/info/exclude              # Local exclude patterns
└── .planning/                     # Planning directory (created by planning workflow)
    └── codebase/                  # Codebase research output (currently empty)
```

## Naming Conventions

**None established.** No source files exist to infer conventions.

## Where to Find Things

| What | Where | Status |
|------|-------|--------|
| Source code | *(none)* | **Does not exist** |
| Configuration | *(none)* | **Does not exist** |
| Tests | *(none)* | **Does not exist** |
| Documentation | *(none)* | **Does not exist** |
| Dependencies | *(none)* | **Does not exist** |
| Build scripts | *(none)* | **Does not exist** |

## Conventions Observed

- **Planning folder:** `.planning/codebase/` is used for research artifacts (this is the only non-git directory).
- No `.gitignore` file exists in the repo root.
- No README, LICENSE, or CONTRIBUTING files exist.

## What Needs to Happen

The repository needs initial project scaffolding before structure conventions can be documented:
1. Initialize project with chosen tech stack
2. Create directory structure (e.g., `src/`, `tests/`, `docs/`, `config/`)
3. Establish naming conventions and file organization patterns
4. Then re-run this research to capture actual conventions
