<?php
//change password
add_action('wp_ajax_nopriv_user_change_password', 'user_change_password');
add_action('wp_ajax_user_change_password', 'user_change_password');

//register user
add_action( 'wp_ajax_nopriv_user_register', 'user_register');
add_action( 'wp_ajax_user_register', 'user_register');

//forgot user
add_action( 'wp_ajax_nopriv_user_forgot', 'user_forgot');
add_action( 'wp_ajax_user_forgot', 'user_forgot');

//login_user
add_action( 'wp_ajax_nopriv_user_login', 'user_login');
add_action( 'wp_ajax_user_login', 'user_login');

//update user
add_action( 'wp_ajax_nopriv_user_save', 'user_save');
add_action( 'wp_ajax_user_save', 'user_save');

//logout user
add_action( 'wp_ajax_nopriv_user_logout', 'user_logout');
add_action( 'wp_ajax_user_logout', 'user_logout');

//subscribe user
add_action( 'wp_ajax_nopriv_user_subscribe', 'user_subscribe');
add_action( 'wp_ajax_user_subscribe', 'user_subscribe');

//add comment
add_action( 'wp_ajax_nopriv_user_comment', 'user_comment');
add_action( 'wp_ajax_user_comment', 'user_comment');

function user_comment() {
    $results = \Wappsnet\Core\Visitor::addComment($_REQUEST);
    die(json_encode($results));
}

function user_subscribe() {
    $results = \Wappsnet\Core\Visitor::subscribe($_REQUEST);
    die(json_encode($results));
}

function user_login() {
    $results = \Wappsnet\Core\Visitor::login($_REQUEST);
    die(json_encode($results));
}

function user_register() {
    $results = \Wappsnet\Core\Visitor::register($_REQUEST);
    die(json_encode($results));
}

function user_forgot() {
    $results = \Wappsnet\Core\Visitor::forgot($_REQUEST);
    die(json_encode($results));
}

function user_logout() {
    $results = \Wappsnet\Core\Visitor::logoutUser();
    die(json_encode($results));
}

function user_save() {
    $results = \Wappsnet\Core\Visitor::saveUser($_REQUEST);
    die(json_encode($results));
}

function user_change_password() {
    $results = \Wappsnet\Core\Visitor::change_password($_REQUEST);
    die(json_encode($results));
}