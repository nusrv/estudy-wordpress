# eStudy WordPress site

This repository contains the deployable WordPress code for the eStudy site. It excludes environment-specific credentials, user-uploaded media, caches, backups, and other generated files.

## Before deploying

1. Create `wp-config.php` from `wp-config-sample.php` and provide the target database credentials and unique WordPress keys.
2. Restore the site's database separately.
3. Restore the contents of `wp-content/uploads/` from the original backup or media storage.
4. Confirm that required server settings, plugins, and PHP version are available in the target environment.

## Repository policy

Do not commit `wp-config.php`, `.env` files, uploads, backups, caches, or logs. They may contain credentials, personal data, or files that are regenerated at runtime.
