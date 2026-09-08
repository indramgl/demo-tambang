---
module: setup
problem_type: build-error
severity: medium
tags: [ci4, composer, windows, scaffold]
---

## CI4 Scaffold on Windows with Non-Empty Directory

**Problem:** `composer create-project codeigniter4/appstarter .` fails when the target directory is not empty (contains `.gitignore`, `AGENTS.md`, etc.).

**Solution:** Scaffold to a temp directory, then copy CI4 files into the project directory, preserving existing project files.

```powershell
# Scaffold to temp dir
composer create-project codeigniter4/appstarter C:\Coding\temp-ci4 --no-interaction

# Copy CI4 files to project (preserve existing files)
Copy-Item C:\Coding\temp-ci4\app C:\Coding\project\app -Recurse -Force
Copy-Item C:\Coding\temp-ci4\public C:\Coding\project\public -Recurse -Force
Copy-Item C:\Coding\temp-ci4\writable C:\Coding\project\writable -Recurse -Force
Copy-Item C:\Coding\temp-ci4\vendor C:\Coding\project\vendor -Recurse -Force
Copy-Item C:\Coding\temp-ci4\composer.json C:\Coding\project\composer.json -Force
Copy-Item C:\Coding\temp-ci4\composer.lock C:\Coding\project\composer.lock -Force
Copy-Item C:\Coding\temp-ci4\env C:\Coding\project\.env.example -Force
Copy-Item C:\Coding\temp-ci4\phpunit.dist.xml C:\Coding\project\phpunit.xml.dist -Force
Copy-Item C:\Coding\temp-ci4\spark C:\Coding\project\spark -Force
Copy-Item C:\Coding\temp-ci4\preload.php C:\Coding\project\preload.php -Force
Copy-Item C:\Coding\temp-ci4\LICENSE C:\Coding\project\LICENSE -Force
Copy-Item C:\Coding\temp-ci4\builds C:\Coding\project\builds -Recurse -Force
Copy-Item C:\Coding\temp-ci4\tests C:\Coding\project\tests -Recurse -Force

# Clean up temp dir
Remove-Item C:\Coding\temp-ci4 -Recurse -Force
```

**Why it works:** CI4's `create-project` refuses to overwrite existing files. Scaffolding to a temp dir bypasses this. The project's own files (`.gitignore`, `AGENTS.md`, etc.) are preserved because we selectively copy only CI4-generated files.

**Applicable when:** Scaffolding CI4 into an existing project directory that already has project files.