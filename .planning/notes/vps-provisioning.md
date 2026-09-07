# VPS Provisioning — PT Indah Tambang Raya Semesta

## Provider & Specs
- **Provider:** IDCloudhost
- **OS:** Ubuntu 26.04
- **vCPU:** 2
- **RAM:** 4GB
- **Storage:** 40GB

## Web Server
- **Server:** OpenLitespeed
- **Cache Level:** Max
- **Max Connections:** Based on resources (2 vCPU/4GB)
- **Static Page Cache:** Enabled

## PHP
- **Version:** 8.5
- **FPM:** max_children = 5
- **FPM Mode:** PHP-FPM

## SSL & Domain
- **Domain:** tambang.indramgl.web.id
- **SSL:** Let's Encrypt (no auto-renew — demo only)

## Deployment
- **Method:** Git pull from GitHub
- **Branch:** master
- **Deploy Path:** TBD during installation

## Database
- **Type:** SQLite only
- **Rationale:** Static content, minimal dynamic features

## Email
- **Provider:** Postmark
- **CI4 Dependency:** Postmark PHP SDK

## Security
- **SSH:** Password auth open (demo only)
- **Firewall:** Not configured (demo only)
- **Backup:** None (demo only)
- **Monitoring:** None (demo only)

## Bilingual MVP (Ide #3)
- **Languages first:** ID + EN only
- **URL routing:** `/id/`, `/en/` — root `/` redirects to `/id/`
- **URL display:** always show `/id/` or `/en/`
- **Language switch:** flag icon
- **Other languages:** added in final version when content ready
- **Structure:** `app/Views/pages/{halaman}/{bahasa}.md`
- **Source:** Markdown per halaman (Indonesian as primary)
- **Translation:** AI (ling-3.0-flash-sante) → langsung publish, no review
- **Rendering:** CI4 view sebagai template standar, controller baca markdown → HTML via Parsedown/CommonMark
- **Files:** 6 halaman × 1 markdown + 1 view template per bahasa
