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

## Notes
- OpenLitespeed max connections calculation: adjust based on 2 vCPU/4GB resources
- Postmark integration: add `wildbit/postmark-php` via Composer
- Deploy script: git pull + Composer install + permissions
