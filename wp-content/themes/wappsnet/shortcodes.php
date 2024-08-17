<?php

use Wappsnet\Core\Render;

add_shortcode( 'wp_latest_posts', function($attr) {
    $attr = array_merge($attr, ['size' => 5]);

    return Render::get_module('Latest', [
        'size' => $attr['size'],
    ]);
});

add_shortcode( 'wp_popular_posts', function($attr) {
    $attr = array_merge($attr, ['size' => 8]);

    return Render::get_module('Popular', [
        'size' => $attr['size'],
    ]);
});

add_shortcode( 'wp_board', function($attr) {
    $attr = array_merge(['slug' => ''], $attr);

    return Render::get_module('Board', [
        'slug' => $attr['slug'],
    ]);
});

add_shortcode( 'wp_explore', function($attr) {
    $attr = array_merge($attr, [
        'taxonomy' => 'category',
        'posts_per_page' => 3
    ]);

    return Render::get_module('Explore', $attr);
});

add_shortcode( 'wp_categories', function($attr) {
    $attr = array_merge($attr, ['taxonomy' => 'category']);

    return Render::get_module('Categories', $attr);
});

add_shortcode( 'wp_areas', function($attr) {
    $attr = array_merge($attr, ['taxonomy' => 'category']);

    return Render::get_module('Areas', $attr);
});

add_shortcode( 'wp_navigation', function($attr) {
    $attr = array_merge($attr, ['name' => 'footer']);

    return Render::get_module('Navigation', $attr);
});