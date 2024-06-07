<?php
/**
 * The template for displaying all single posts.
 *
 * @package wappsnet
 */

//if user not redirected print profile
get_header();
\Wappsnet\Core\Render::load_layout('Header');
\Wappsnet\Core\Render::load_module('Header');
\Wappsnet\Core\Render::load_module('Post');
\Wappsnet\Core\Render::load_module('Footer');
\Wappsnet\Core\Render::load_layout('Footer');
get_footer();
