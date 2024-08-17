<?php
/**
 * The template for displaying archive category.
 * @package wappsnet
 */

//Template Name: Explore All Template

use Wappsnet\Core\Render;

get_header();
Render::load_layout('Header');
Render::load_layout('Search');
Render::load_layout('Explore');
Render::load_layout('Footer');
get_footer();
