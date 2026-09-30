
<?php
/**
 * Plugin Name: Media Library Alt Text Updater
 * Plugin URI: https://prolificdigital.com
 * Description: A standalone plugin that updates image block alt text in posts and pages with the corresponding alt text from the media library. This plugin targets images that are missing alt text and ensures all images have descriptive alt text for better accessibility and SEO.
 * Version: 1.0.1
 * Author: Prolific Digital
 * Author URI: https://prolificdigital.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: media-library-alt-text-updater
 * Domain Path: /languages
 * Requires at least: 5.7
 * Requires PHP: 7.3
 */

// Hook into the 'render_block' filter to modify the block content before rendering
add_filter('render_block', 'media_library_alt_text_updater', 10, 2);

/**
 * Updates the alt text of image blocks with the corresponding alt text from the media library.
 *
 * @param string $content The block content.
 * @param array $block The block details.
 * @return string The modified block content.
 */
function media_library_alt_text_updater($content, $block) {
  // Check if the block is an image block
  if ('core/image' !== $block['blockName']) {
    return $content;
  }

  // Retrieve the alt text from the media library if the image ID is set
  if (isset($block['attrs']['id'])) {
    $alt = get_image_alt_text($block['attrs']['id']);
  }

  // If the alt text is empty, return the original content
  if (empty($alt)) {
    return $content;
  }

  // If the alt attribute is empty in the content, replace it with the alt text from the media library
  if (false !== strpos($content, 'alt=""')) {
    $content = str_replace('alt=""', 'alt="' . $alt . '"', $content);

    // If the alt attribute is missing, add it before the src attribute
  } elseif (false === strpos($content, 'alt="')) {
    $content = str_replace('src="', 'alt="' . $alt . '" src="', $content);
  }

  // Return the modified content
  return $content;
}

/**
 * Retrieve the alt text for an image from the media library.
 *
 * @param int $image_id The image ID.
 * @return string The alt text.
 */
function get_image_alt_text($image_id) {
  // Get the alt text from the current site
  $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);

  // If the alt text is empty, switch to the main site (site ID 1) and check there
  if (empty($alt) && is_multisite() && get_current_blog_id() !== 1) {
    switch_to_blog(1);
    $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
    restore_current_blog();
  }

  return $alt;
}
