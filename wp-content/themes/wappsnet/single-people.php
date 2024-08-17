<?php
/**
 * The template for displaying author posts.
 * @package wappsnet
 */

//Template Name: Author

use Wappsnet\Core\Render;

get_header();

Render::load_layout('Header');
Render::load_layout('Author');
Render::load_layout('Footer');

get_footer();
