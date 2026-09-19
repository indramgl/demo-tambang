---
title: Missing CSRF protection in contact form
date: 2026-09-19
category: security-issues/
module: frontend
problem_type: security_issue
severity: medium
tags: [csrf, security, form, contact, ci4]
---

# Missing CSRF Protection in Contact Form

## Problem

The contact form in `app/Views/pages/contact.php` was missing `<?= csrf_field() ?>` inside the `<form>` element. CI4 applications include CSRF protection by default, and any form that submits data should include the CSRF token to prevent cross-site request forgery attacks.

## Symptoms

- Contact form has no CSRF token field
- Form submission would fail CSRF validation if CSRF protection were enabled in `App.php` (`$CSPEnabled = false` currently, but could be enabled)
- No test verified the presence of the CSRF field in the form

## What Didn't Work

- Relying on the current disabled CSP setting is a time bomb — enabling CSP later would break form submissions
- Adding CSRF only after enabling CSP would be a reactive fix, not proactive

## Solution

Added `<?= csrf_field() ?>` as the first element inside the `<form>` tag in `app/Views/pages/contact.php`.

## Why This Works

CI4's `csrf_field()` helper generates a hidden input field with the CSRF token name and value. When the form is submitted, CI4 automatically validates the token against the session-stored token. This prevents cross-site request forgery attacks where an attacker could trick a user into submitting the contact form.

## Prevention

- Add a template lint check that verifies all `<form>` elements contain `csrf_field()`
- Enable CSRF protection globally in `App.php` ($CSPEnabled = true) and verify all forms pass
- Include CSRF verification in the `impeccable audit` design pass

## Related

- `app/Views/pages/contact.php` — affected view file
- CI4 CSRF documentation — built-in protection mechanism
