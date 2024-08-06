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

## Installation

1. **Upload the plugin files to the `/wp-content/plugins/media-library-alt-text-updater` directory**, or install the plugin through the WordPress plugins screen directly.
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

## Support

For support, please contact [Prolific Digital](mailto:support@prolificdigital.com).
