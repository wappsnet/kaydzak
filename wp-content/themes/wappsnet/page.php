<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package wappsnet
 */
get_header();
\Wappsnet\Core\Render::load_layout('Header');
\Wappsnet\Core\Render::load_module('Header');
\Wappsnet\Core\Render::load_module('Page');
\Wappsnet\Core\Render::load_module('Footer');
\Wappsnet\Core\Render::load_layout('Footer');
get_footer();
