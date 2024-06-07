<?php
/**
 * The template for displaying archive category.
 * @package wappsnet
 */

use Wappsnet\Core\Render;

get_header();

Render::load_layout('Header');

Render::load_module('Header');
Render::load_module('SubScribe');
Render::load_module('Footer');

Render::load_layout('Footer');

get_footer();
