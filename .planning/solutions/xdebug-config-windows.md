---
module: setup
problem_type: configuration
severity: low
tags: [xdebug, php, ide]
---

## Configure Xdebug for Debug Mode on Windows

**Problem:** Xdebug is installed but in `coverage` mode by default, not `debug` mode needed for step debugging.

**Solution:** Change `xdebug.mode` in `php.ini` from `coverage` to `debug`.

```powershell
# Find php.ini location
php --ini | Select-String "Loaded Configuration File"

# Edit php.ini
(Get-Content "C:\Coding\php-8.4.19-nts-Win32-vs17-x64\php.ini" -Raw) -replace 'xdebug\.mode=coverage', 'xdebug.mode=debug' | Set-Content "C:\Coding\php-8.4.19-nts-Win32-vs17-x64\php.ini"

# Verify
php -m | Select-String xdebug
```

**Why it works:** Xdebug v3.x uses `xdebug.mode` to control which features are active. `debug` mode enables step debugging, breakpoints, and stack traces in IDEs like VS Code and PhpStorm.

**Applicable when:** Setting up local PHP debugging with Xdebug on Windows.