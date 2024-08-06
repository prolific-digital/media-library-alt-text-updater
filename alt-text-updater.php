<?php
/*
Plugin Name: Alt Text Updater
Description: A plugin to update image alt texts in blocks based on the media library.
Version: 1.0
Author: Prolific Digital
*/

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

// Include the settings page.
include_once plugin_dir_path(__FILE__) . 'settings-page.php';

// Enqueue admin scripts and styles.
function atu_enqueue_admin_scripts() {
  wp_enqueue_script('atu-admin-script', plugin_dir_url(__FILE__) . 'admin-script.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'atu_enqueue_admin_scripts');


function atu_scan_images() {
  // Ensure the user has the appropriate permissions.
  if (!current_user_can('manage_options')) {
    wp_send_json_error('You do not have permission to perform this action.');
  }

  // Get all pages
  $args = array(
    'post_type' => 'page',
    'post_status' => 'publish',
    'numberposts' => -1
  );

  $pages = get_posts($args);
  $results = array();
  $total_pages_with_missing_alt = 0;
  $total_images_with_missing_alt = 0;
  $images_with_alt_in_media_library = 0;

  error_log("Starting scan of all pages. Total pages: " . count($pages));

  foreach ($pages as $page) {
    $blocks = parse_blocks($page->post_content);
    error_log("Scanning page: " . $page->post_title . " with ID: " . $page->ID); // Debugging log
    $page_results = atu_scan_blocks_for_images($blocks, $page);

    error_log("Page Results for page " . $page->ID . ": " . json_encode($page_results)); // Debugging log for page results

    if (!empty($page_results)) {
      $total_pages_with_missing_alt++;
      $total_images_with_missing_alt += count($page_results);

      foreach ($page_results as $result) {
        $image_id = $result['image_id'];
        $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
        if (!empty($alt_text)) {
          $images_with_alt_in_media_library++;
        }
      }

      // Append each element of page_results to results
      foreach ($page_results as $page_result) {
        $results[] = $page_result;
      }

      // Log results after appending
      error_log("Results after appending for page " . $page->ID . ": " . json_encode($results));
    }
  }

  error_log("Final Results: " . json_encode($results)); // Debugging log for final results

  // Send the results back to the client.
  wp_send_json_success(array(
    'total_pages_with_missing_alt' => $total_pages_with_missing_alt,
    'total_images_with_missing_alt' => $total_images_with_missing_alt,
    'images_with_alt_in_media_library' => $images_with_alt_in_media_library,
    'details' => $results
  ));
}
add_action('wp_ajax_atu_scan_images', 'atu_scan_images');


function atu_scan_blocks_for_images($blocks, $page, &$results = array()) {
  // Loop through each block
  foreach ($blocks as $block) {
    // Check if the block is a core/image block
    if ($block['blockName'] === 'core/image') {
      // Get the image ID
      error_log("Block: " . json_encode($block)); // Debugging log
      if (isset($block['attrs']['id'])) {
        $image_id = $block['attrs']['id'];

        // Check if the image has alt text in the block HTML
        if (!has_alt_text($block['innerHTML'])) {
          error_log("Image ID: " . $image_id . " does not have alt text in block HTML"); // Debugging log
          // Check the alt text in the media library
          $alt_text_in_media_library = get_alt_text_from_media_library($image_id);
          if (!empty($alt_text_in_media_library)) {
            // Update the results array
            $results[] = array(
              'image_id' => $image_id,
              'page_permalink' => get_permalink($page->ID),
              'page_title' => $page->post_title
            );
          }
        }
      }
    }

    // If the block contains inner blocks, recursively loop through them
    if (!empty($block['innerBlocks'])) {
      atu_scan_blocks_for_images($block['innerBlocks'], $page, $results);
    }
  }

  error_log("Results for page " . $page->ID . ": " . json_encode($results)); // Debugging log for results

  return $results;
}

function get_alt_text_from_media_library($image_id) {
  // Get the alt text from the media library using the image ID
  return get_post_meta($image_id, '_wp_attachment_image_alt', true);
}

function atu_get_alt_text_from_html($html) {
  // Use regex to extract the alt attribute value from the img tag
  if (preg_match('/<img[^>]+alt=["\']([^"\']*)["\']/', $html, $matches)) {
    // Return the alt attribute value
    return $matches[1];
  }
  // Return an empty string if alt attribute is missing
  return '';
}

function has_alt_text($html) {
  // Use atu_get_alt_text_from_html to check for alt text
  $alt_text = atu_get_alt_text_from_html($html);
  return !empty($alt_text);
}







function atu_update_blocks_alt_text($blocks, $page, &$results = array()) {
  // Loop through each block
  foreach ($blocks as $block) {
    // Check if the block is a core/image block
    if ($block['blockName'] === 'core/image') {
      // Get the image ID
      // error_log("Block: " . json_encode($block)); // Debugging log
      if (isset($block['attrs']['id'])) {
        $image_id = $block['attrs']['id'];

        // Check if the image has alt text in the block HTML
        if (!$block['attrs']['alt']) {
          // error_log("Image ID: " . $image_id . " does not have alt text in block HTML"); // Debugging log
          // Check the alt text in the media library
          $alt_text_in_media_library = get_alt_text_from_media_library($image_id);
          if (!empty($alt_text_in_media_library)) {
            // Update the alt text in the block HTML
            $block['innerHTML'] = preg_replace(
              '/alt="[^"]*"/',
              'alt="' . esc_attr(get_alt_text_from_media_library($image_id)) . '"',
              $block['innerHTML']
            );

            // update block attribute alt text
            $block['attrs']['alt'] = get_alt_text_from_media_library($image_id);

            // error_log($page); // Debugging log

            // Update the results array
            $results[] = array(
              'image_id' => $image_id,
              'page_permalink' => get_permalink($page->ID),
              'page_title' => $page->post_title,
              'alt_text' => get_alt_text_from_media_library($image_id)
            );
          }
        }
      }
    }

    // If the block contains inner blocks, recursively loop through them
    if (!empty($block['innerBlocks'])) {
      atu_update_blocks_alt_text($block['innerBlocks'], $page, $results);
    }
  }

  error_log("Results for page " . $page->ID . ": " . json_encode($results)); // Debugging log for results

  return $blocks;
}


function atu_update_pages_with_image_alt_text() {
  // Ensure the user has the appropriate permissions.
  if (!current_user_can('manage_options')) {
    wp_send_json_error('You do not have permission to perform this action.');
  }

  // Get all pages
  $args = array(
    'post_type' => 'page',
    'post_status' => 'publish',
    'numberposts' => -1
  );

  $pages = get_posts($args);
  $updated_pages = array();

  foreach ($pages as $page) {
    $blocks = parse_blocks($page->post_content);
    $updated_blocks = atu_update_blocks_alt_text($blocks, $page);
    $new_content = serialize_blocks($updated_blocks);

    // Update the page content if it has changed
    if ($new_content !== $page->post_content) {
      $page_data = array(
        'ID' => $page->ID,
        'post_content' => $new_content
      );
      wp_update_post($page_data);
      $updated_pages[] = array(
        'page_id' => $page->ID,
        'page_title' => $page->post_title,
        'page_permalink' => get_permalink($page->ID)
      );
    }
  }

  // Send the results back to the client.
  wp_send_json_success(array(
    'updated_pages' => $updated_pages
  ));
}
add_action('wp_ajax_atu_update_pages_with_image_alt_text', 'atu_update_pages_with_image_alt_text');







function atu_update_alt_text() {
  // Ensure the user has the appropriate permissions.
  if (!current_user_can('manage_options')) {
    wp_send_json_error('You do not have permission to perform this action.');
  }

  // Get all pages
  $args = array(
    'post_type' => 'page',
    'post_status' => 'publish',
    'numberposts' => -1
  );

  $pages = get_posts($args);
  $updated_count = 0;

  foreach ($pages as $page) {
    $blocks = parse_blocks($page->post_content);
    $updated_blocks = atu_update_blocks_with_alt_text($blocks);
    $updated_content = serialize_blocks($updated_blocks);

    if ($updated_content !== $page->post_content) {
      wp_update_post(array(
        'ID' => $page->ID,
        'post_content' => $updated_content
      ));
      $updated_count++;
    }
  }

  // Send the results back to the client.
  wp_send_json_success(array('updated_count' => $updated_count));
}
add_action('wp_ajax_atu_update_alt_text', 'atu_update_alt_text');

function atu_update_blocks_with_alt_text($blocks) {
  foreach ($blocks as &$block) {
    if (isset($block['blockName']) && $block['blockName'] === 'core/image') {
      $image_id = isset($block['attrs']['id']) ? $block['attrs']['id'] : null;
      if ($image_id) {
        $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
        if (!empty($alt_text)) {
          $block['attrs']['alt'] = $alt_text;
        }
      }
    }

    // If the block contains inner blocks, update those too
    if (isset($block['innerBlocks']) && !empty($block['innerBlocks'])) {
      $block['innerBlocks'] = atu_update_blocks_with_alt_text($block['innerBlocks']);
    }
  }

  return $blocks;
}
