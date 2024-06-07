<?php
// 1. customize ACF path
function my_acf_settings_path( $path ) {
    $path = WAPPSNET_PATH . '/fields/classes/acf/';
    return $path;
}

add_filter('acf/settings/path', 'my_acf_settings_path');

// 2. customize ACF dir
function my_acf_settings_dir( $link ) {
    $name = plugin_basename(WAPPSNET_NAME );
    $link = plugins_url($name) . '/fields/classes/acf/';
    return $link;
}

add_filter('acf/settings/dir', 'my_acf_settings_dir');

