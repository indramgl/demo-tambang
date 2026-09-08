# Testing

**Researched:** 2026-09-07
**Updated:** 2026-09-07 (post new-project ceremony + ideation)

## Current State

The repository at `C:\Coding\perusahaan-tambang` has **no source code and no tests**. No test framework, no test files, no CI configuration exist.

- Test framework config — **None found**
- Test files — **None found**
- CI/test workflow — **None found**
- Coverage config — **None found**
- Mocking libraries — **None found**

## Test Framework

**None established.** Will be defined during Phase 1 scaffold.

### Recommended: CI4 Built-in Testing
- CodeIgniter 4 has built-in PHPUnit integration (`php spark test`)
- PHPUnit is the default test framework for CI4
- No additional test framework selection needed

## Test Structure

**None established.** Expected structure after scaffold:

```
tests/
├── Feature/                    # Feature/integration tests
│   ├── SejarahTest.php
│   ├── KontakTest.php
│   └── MultilingualTest.php
├── Unit/                       # Unit tests
│   ├── Controllers/
│   ├── Models/
│   └── Libraries/
└── Support/                    # Test helpers, fixtures
```

## Mocking Approach

**None established.** CI4 has built-in mocking support via PHPUnit.
- Use PHPUnit's built-in mock methods
- No external mocking library needed

## Coverage State

**None.** No coverage tooling configured.

### Recommended: PHPUnit Coverage
- `--coverage-text` for basic coverage
- `--coverage-html` for HTML report
- Will be configured during Phase 1

## How to Run Tests

**N/A.** No tests exist yet.

After Phase 1 scaffold:
```bash
php spark test                    # Run all tests
php spark test --coverage         # Run with coverage
php spark test Feature/           # Run specific test directory
```

## Multilingual Testing (from ideation)

### Hreflang/SEO Auto-Check
- **CLI script** to verify hreflang tags, canonical URLs, broken links
- Run as pre-deploy gate in Phase 5
- Checks all 36 page variants (6 pages × 6 languages)
- Verifies: every page has hreflang links for all 6 languages

### Content Drift Detection
- Verify translation JSON files have all required keys
- Check for missing translations (fallback to Indonesian)
- Run as pre-deploy check

## Testing Priorities

| Priority | Test Type | Phase |
|----------|-----------|-------|
| High | Hreflang/SEO verification | Phase 2 |
| High | Multilingual routing | Phase 2 |
| Medium | Contact form (Postmark) | Phase 4 |
| Medium | PHPUnit feature tests | Phase 1 |
| Low | Performance testing | Phase 5 |

## Recommended Approach

1. **Use CI4 built-in PHPUnit** — no additional framework needed
2. **Add PHP_CodeSniffer** during Phase 1 for code quality
3. **Create test directory structure** during Phase 1
4. **Implement hreflang/SEO check script** during Phase 2
5. **Configure PHPUnit coverage** during Phase 1
6. **Add pre-deploy checks** (hreflang, links) during Phase 5
7. **Test multilingual routing** with URL path verification
8. **Test Postmark integration** during Phase 4