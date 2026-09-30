=== Media Library Alt Text Updater ===
Contributors: prolificdigital
Tags: alt text, media, images, accessibility, seo
Requires at least: 6.5
Tested up to: 7.1
Requires PHP: 8.4
Stable tag: 1.1.0
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Updates image block alt text in posts and pages with the alt text from the Media Library.

== Description ==

The block editor does not pull an image's Media Library alt text into an image block unless the alt text existed when the image was inserted. Many image blocks therefore render without alt text.

This plugin fills in empty or missing `alt` attributes on `core/image` blocks at render time, using the attachment's alt text from the Media Library. Stored content is not changed, so you can still override the alt text per block in the editor.

On multisite, if a subsite's attachment has no alt text, the main site's (site ID 1) media library is checked.

== Installation ==

1. Upload the `media-library-alt-text-updater` folder to `/wp-content/plugins/`, or install the release zip from **Plugins > Add New > Upload Plugin**.
2. Activate the plugin. There are no settings.
3. To receive automatic updates, add your license key to `wp-config.php`:
   `define( 'PROLIFIC_LICENSE_KEY_MEDIA_LIBRARY_ALT_TEXT_UPDATER', 'your-key' );`

== Changelog ==

= 1.1.0 =
* Updates now come from the Prolific Digital license server. Define `PROLIFIC_LICENSE_KEY_MEDIA_LIBRARY_ALT_TEXT_UPDATER` to receive them.
* Main file renamed to `media-library-alt-text-updater.php`; reactivate the plugin once after updating.
* License is GPL-2.0-or-later.
* Fixed: a stray blank line was sent before the page output.
* Requires WordPress 6.5+ and PHP 8.4+.

= 1.0.1 =
* Multisite support.

= 1.0.0 =
* Initial release.
