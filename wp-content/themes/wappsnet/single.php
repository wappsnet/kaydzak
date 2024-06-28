<?php
/**
 * The template for displaying all single posts.
 *
 * @package wappsnet
 */

use Wappsnet\Core\Render;

get_header();
Render::load_layout('Header');
Render::load_layout('Single');
Render::load_layout('Footer');
get_footer();
