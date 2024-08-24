<?php
//add search

use Wappsnet\Core\Render;
use Wappsnet\Core\Visitor;

add_action( 'wp_ajax_nopriv_wp_search', 'wpSearch');
add_action( 'wp_ajax_wp_search', 'wpSearch');

add_action( 'wp_ajax_nopriv_wp_subscribe', 'wpSubscribe');
add_action( 'wp_ajax_wp_subscribe', 'wpSubscribe');

function wpSearch() {
    echo json_encode(Visitor::search($_REQUEST));
    die();
}

function wpSubscribe() {
    echo json_encode(Visitor::subscribe($_REQUEST));
    die();
}