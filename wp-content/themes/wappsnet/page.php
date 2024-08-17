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

use Wappsnet\Core\Render;

get_header();

Render::load_layout('Header');
Render::load_layout('Search');
Render::load_layout('Page');
Render::load_layout('Footer');

get_footer();
