<?php
/**
 * The template for displaying archive category.
 * @package wappsnet
 */

//Template Name: Archive Template

use Wappsnet\Core\Render;

get_header();

Render::load_layout('Header');
Render::load_layout('Search');
Render::load_layout('Archive');
Render::load_layout('Footer');

get_footer();
