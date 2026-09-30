# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.1.0] - 2026-09-29

### Changed
- Adopted the Prolific plugin standard. Updates now come from the Prolific Digital license server (`api.prolificdigital.io`). Set `PROLIFIC_LICENSE_KEY_MEDIA_LIBRARY_ALT_TEXT_UPDATER` in `wp-config.php` (or use the `prolific_license_key` filter) to receive updates.
- The main file is renamed from `alt-text.php` to `media-library-alt-text-updater.php`. Reactivate the plugin once after updating.
- License is GPL-2.0-or-later (the bundled LICENSE file was GPL-3.0 text).
- Requires WordPress 6.5+ and PHP 8.4+.

### Fixed
- A blank line before `<?php` in the main file was sent as output on every request (WP-CLI reported "The plugin generated unexpected output" on activation).

### Added
- `MEDIA_LIBRARY_ALT_TEXT_UPDATER_VERSION` constant, ABSPATH guard, and translation loading from `languages/`.
- `CHANGELOG.md`, coding-standards config and CI/release workflows.

## [1.0.1] - 2024-08-06

### Added
- Multisite support: when a subsite's attachment has no alt text, the main site's (site ID 1) media library is checked.

## [1.0.0] - 2024-08-05

### Added
- Initial release: fills empty or missing alt attributes on `core/image` blocks from the Media Library at render time.

[Unreleased]: https://github.com/prolific-digital/media-library-alt-text-updater/compare/v1.1.0...HEAD
[1.1.0]: https://github.com/prolific-digital/media-library-alt-text-updater/compare/v1.0.1...v1.1.0
[1.0.1]: https://github.com/prolific-digital/media-library-alt-text-updater/compare/v1.0.0...v1.0.1
[1.0.0]: https://github.com/prolific-digital/media-library-alt-text-updater/releases/tag/v1.0.0
