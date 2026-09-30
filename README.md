# Media Library Alt Text Updater

A standalone plugin that updates image block alt text in posts and pages with the corresponding alt text from the media library. This plugin targets images that are missing alt text and ensures all images have descriptive alt text for better accessibility and SEO.

## Description

### The Problem

In WordPress, the alt text for images is an essential element for both accessibility and SEO. Alt text helps screen readers describe images to visually impaired users and provides context to search engines. However, the block editor (Gutenberg) introduced a challenge: it does not automatically pull in alt text from the media library for image blocks unless the alt text was already assigned before the image was added to the page. This differs from the classic editor, which did pull in the alt text from the media library by default.

As a result, many image blocks may end up missing alt text if the content creator forgets to manually add it, leading to poor accessibility and SEO performance. This gap can be especially problematic for websites with a large number of images, making it cumbersome to manually update each image block with the correct alt text.

### The Solution

The Media Library Alt Text Updater plugin addresses this issue by automatically updating the alt text for image blocks in posts and pages using the alt text defined in the media library. This ensures that all images have the correct alt text, improving both the accessibility and SEO of your website.

### Important Note

This plugin will display the alt text for images on the frontend, but you will not see the alt text populate within the WordPress editor. This allows you the opportunity to override the alt text on an image-by-image basis directly within the editor if needed.

## Features

- **Automatic Alt Text Update:** Automatically updates image block alt text in posts and pages.
- **Media Library Integration:** Uses alt text from the media library.
- **Multisite Support:** Supports multisite networks, including those using a single media library for site ID 1.
- **Missing Alt Text Targeting:** Targets images that are missing alt text.
- **Accessibility and SEO Improvement:** Improves website accessibility and SEO.
- **Editor Override:** Allows for manual override of alt text on an image-by-image basis within the WordPress editor.

| | |
|---|---|
| Requires | WordPress 6.5+, PHP 8.4+ |
| Text domain | `media-library-alt-text-updater` |
| License | GPL-2.0-or-later |

## Installation

1. **Upload the plugin files to the `/wp-content/plugins/media-library-alt-text-updater` directory**, or install the `media-library-alt-text-updater.zip` attached to a [GitHub release](https://github.com/prolific-digital/media-library-alt-text-updater/releases).
2. **Activate the plugin** through the 'Plugins' screen in WordPress.
3. The plugin will automatically start updating alt text for image blocks in posts and pages.

## Usage

Once the plugin is activated, it will automatically update the alt text for image blocks in your posts and pages with the alt text from the media library. No further configuration is necessary.

## Frequently Asked Questions

### Does this plugin update existing image blocks?

Yes, the plugin updates existing image blocks in your posts, pages, or custom post types to ensure they have alt text from the media library.

### What happens if an image in the media library does not have alt text?

If an image in the media library does not have alt text, the plugin will not update the alt text for the corresponding image block.

### Can I customize the alt text for individual image blocks?

The plugin updates the alt text based on the media library. If you need to customize the alt text for individual image blocks, you should do so directly in the media library or override it within the WordPress editor.

### Will the alt text be visible in the WordPress editor?

No, the alt text updated by this plugin will not populate within the WordPress editor. This allows you to manually override the alt text on an image-by-image basis if needed.

## Updates

Updates are served by the Prolific Digital license server. Add the site's license key to `wp-config.php`:

```php
define( 'PROLIFIC_LICENSE_KEY_MEDIA_LIBRARY_ALT_TEXT_UPDATER', 'your-key' );
```

You can also supply the key with the `prolific_license_key` filter, which receives `( $key, 'media-library-alt-text-updater' )`.

## Development

The dev site is the DDEV sandbox at `https://wp-sandbox.ddev.site`. Run commands in the container:

```sh
ddev exec -d /var/www/html/wp-content/plugins/media-library-alt-text-updater composer install
ddev exec -d /var/www/html/wp-content/plugins/media-library-alt-text-updater composer lint    # php -l on every file
ddev exec -d /var/www/html/wp-content/plugins/media-library-alt-text-updater composer phpcs   # WordPress-Extra + PHPCompatibilityWP
```

`vendor/` is not committed. A git checkout needs `composer install` before the updater loads. The plugin itself still runs without it.

## Releasing

1. Bump the version in the plugin header, `MEDIA_LIBRARY_ALT_TEXT_UPDATER_VERSION` and `readme.txt` `Stable tag`.
2. Add a `## [x.y.z] - YYYY-MM-DD` section to `CHANGELOG.md` and a `= x.y.z =` entry to `readme.txt`.
3. Merge to `main`, then push a `vx.y.z` tag. The release workflow builds `media-library-alt-text-updater.zip` (with `composer install --no-dev`, honoring `.distignore`) and attaches it to a GitHub Release.

CI and release logic live in the shared workflows in [`prolific-digital/.github`](https://github.com/prolific-digital/.github).
## Stored data

None. The plugin only filters rendered block output and reads `_wp_attachment_image_alt`.

## Support

For support, please contact [Prolific Digital](mailto:support@prolificdigital.com).
