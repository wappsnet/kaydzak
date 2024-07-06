<?php

use Wappsnet\Core\Render;

add_shortcode( 'wp_latest_posts', function($attr) {
    $attr = array_merge($attr, ['size' => 9]);

    return Render::get_module('Latest', [
        'size' => $attr['size'],
    ]);
});

add_shortcode( 'wp_popular_posts', function($attr) {
    $attr = array_merge($attr, ['size' => 6]);

    return Render::get_module('Popular', [
        'size' => $attr['size'],
    ]);
});

add_shortcode( 'wp_contributors', function() {
    return Render::get_module('Contributors');
});

add_shortcode( 'wp_categories_list', function($attr) {
    $attr = array_merge($attr, ['taxonomy' => 'category']);

    return Render::get_module('Categories', $attr);
});

add_shortcode( 'wp_about_author', function($attr) {
    global $post;

    $attr = array_merge($attr, ['id' => $post->post_author]);

    return Render::get_module('Author', $attr);
});

add_shortcode( 'wp_navigation', function($attr) {
    $attr = array_merge($attr, ['name' => 'footer']);

    return Render::get_module('Navigation', $attr);
});