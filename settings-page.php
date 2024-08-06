<?php

function atu_settings_page() {
  add_menu_page('Alt Text Updater', 'Alt Text Updater', 'manage_options', 'alt-text-updater', 'atu_render_settings_page');
}
add_action('admin_menu', 'atu_settings_page');

function atu_render_settings_page() {
?>
  <div class="wrap">
    <h1>Alt Text Updater</h1>
    <button id="atu-scan-button" class="button button-primary">Scan for Missing Alt Text</button>
    <div id="atu-scan-results"></div>
    <button id="atu-update-button" class="button button-secondary">Update Alt Text</button>
    <div id="atu-update-results"></div>
  </div>
<?php
}
