<?php
/**
 * The template for displaying all single posts.
 *
 * @package wappsnet
 */
get_header();
\Wappsnet\Core\Render::load_layout('Header');
\Wappsnet\Core\Render::load_module('Header');
\Wappsnet\Core\Render::load_module('Service');
\Wappsnet\Core\Render::load_module('Footer');
\Wappsnet\Core\Render::load_layout('Footer');
get_footer();
