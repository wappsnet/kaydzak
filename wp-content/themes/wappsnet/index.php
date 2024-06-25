<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wappsnet
 */

use Wappsnet\Core\Render;

get_header();

Render::load_layout('Header');

Render::load_module('Header');
Render::load_module('Popular');
Render::load_module('Footer');

Render::load_layout('Footer');

get_footer();
