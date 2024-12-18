<?php

use Wappsnet\Core\Render;

add_shortcode( 'wp_latest_posts', function($attr) {
    $attr = array_merge(['size' => 9], $attr);

    return Render::get_module('Latest', [
        'size' => $attr['size'],
    ]);
});

add_shortcode( 'wp_popular_posts', function($attr) {
    $attr = array_merge(['size' => 8], $attr);

    return Render::get_module('Popular', [
        'size' => $attr['size'],
    ]);
});

add_shortcode( 'wp_featured_posts', function($attr) {
    $attr = array_merge(['size' => 8], $attr);

    return Render::get_module('Featured', [
        'size' => $attr['size'],
        'slug' => $attr['slug'],
    ]);
});

add_shortcode( 'wp_board', function($attr) {
    $attr = array_merge(['slug' => ''], $attr);

    return Render::get_module('Board', [
        'slug' => $attr['slug'],
    ]);
});

add_shortcode( 'wp_explore', function($attr) {
    $attr = array_merge([
        'taxonomy' => 'category',
        'posts_per_page' => 3
    ], $attr);

    return Render::get_module('Explore', $attr);
});

add_shortcode( 'wp_categories', function($attr) {
    $attr = array_merge(['taxonomy' => 'category'], $attr);

    return Render::get_module('Categories', $attr);
});

add_shortcode( 'wp_areas', function($attr) {
    $attr = array_merge(['taxonomy' => 'category'], $attr);

    return Render::get_module('Areas', $attr);
});

add_shortcode( 'wp_navigation', function($attr) {
    $attr = array_merge(['name' => 'footer'], $attr);

    return Render::get_module('Navigation', $attr);
});

add_shortcode( 'wp_search', function($attr) {
    return Render::get_module('Search', $attr);
});

add_shortcode( 'wp_subscribe', function($attr) {
    return Render::get_module('Subscribe', $attr);
});