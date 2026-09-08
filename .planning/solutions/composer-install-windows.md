---
module: setup
problem_type: build-error
severity: low
tags: [composer, windows, php]
---

## Install Composer on Windows

**Problem:** Composer is not pre-installed on Windows PHP environments.

**Solution:** Download and install Composer globally using the official installer.

```powershell
$installer = "$env:TEMP\composer-setup.exe"
Invoke-WebRequest -Uri https://getcomposer.org/installer -OutFile $installer -UseBasicParsing
php $installer --install-dir="C:\Coding\php-8.4.19-nts-Win32-vs17-x64" --filename=composer
Remove-Item $installer
```

**Verify:** `composer --version` returns the installed version.

**Why it works:** The official Composer installer downloads the latest stable version and places it in the specified directory. Adding the PHP directory to PATH makes `composer` available globally.

**Applicable when:** Setting up a PHP development environment on Windows where Composer is not yet installed.