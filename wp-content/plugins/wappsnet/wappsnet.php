<?php
/**
 * @package Wappsnet
 */
/*
Plugin Name: Wappsnet
Plugin URI: https://wappsnet.com/
Description: Wappsnet Plugin created for shop web sites
Version: 4.0.8
Author: MIKE TEVAN
Author URI: https://wappsnet.com/
License: GPLv2 or later
Text Domain: Wappsnet
*/

use Wappsnet\Core\Parser;

define("WAPPSNET_PATH", __DIR__);
define("WAPPSNET_NAME", "WAPPSNET");

require_once (WAPPSNET_PATH."/autoload.php");
require_once(WAPPSNET_PATH."/fields/acf.php");

//add admin actions
add_action( 'init', 'run_app' );
add_filter('manage_posts_columns', 'add_img_column');
add_filter('manage_posts_custom_column', 'manage_img_column', 10, 2);

function add_img_column($columns) {
    $columns = array_slice($columns, 0, 1, true) + array("img" => "Featured Image") + array_slice($columns, 1, count($columns), true);
    return $columns;
}

function manage_img_column($column_name, $post_id) {
    if( $column_name == 'img' ) {
        echo get_the_post_thumbnail($post_id, 'thumbnail');
    }
    return $column_name;
}

function run_app() {
    $wpData = Parser::getConfig('wordpress');
    $wpFields = Parser::getConfig('fields');

    // ----------create post type---------------
    if(isset($wpData["post_types"])) {
        foreach ( $wpData["post_types"] as $post_type ) {
            register_post_type( $post_type["name"], $post_type["params"] );

            if(isset($post_type["rest_name"])) {
                add_filter("rest_prepare_{$post_type["rest_name"]}", "my_rest_prepare_post", 10, 3);
            }
        }
    }
    // ----------create post type---------------

    // ----------add post type supports---------------
    if(isset($wpData["post_type_supports"])) {
        foreach ( $wpData["post_type_supports"] as $support ) {
            print_r($support);
            add_post_type_support( $support["post_type"], $support["items"] );
        }
    }
    // ----------add post type supports---------------


    // ----------create taxonomies---------------
    if(isset($wpData["taxonomies"])) {
        foreach ( $wpData["taxonomies"] as $taxonomy ) {
            register_taxonomy( $taxonomy["name"], $taxonomy["settings"], $taxonomy["params"] );
        }
    }
    // ----------create taxonomies---------------

    // ----------create new meta boxes and filters---------------
    if(isset($wpData["filters"])) {
        foreach ( $wpData["filters"] as $key => $filter ) {
            add_filter( $key, $filter );
        }
    }

    // ----------create new meta boxes and filters---------------
    if(isset($wpData["supports"])) {
        foreach ( $wpData["supports"] as $support ) {
            add_theme_support( $support );
        }
    }

    // ----------create theme features---------------
    if(isset($wpData["features"])) {
        foreach ( $wpData["features"] as $support ) {
            current_theme_supports( $support );
        }
    }

    //------------up migrations --------------------
    if(isset($wpData["migrations"])) {
        if ( is_array( $wpData["migrations"] ) ) {
            foreach ( $wpData["migrations"] as $migration ) {
                \Wappsnet\Core\Migration::up( $migration["name"], $migration["type"] );
            }
        }
    }

    //------------up migrations --------------------
    if(isset($wpData["widgets"])) {
        if ( is_array( $wpData["widgets"] ) ) {
            foreach ( $wpData["widgets"] as $widget) {
                register_sidebar($widget);
            }
        }
    }

    //------------up menus --------------------
    if(isset($wpData["menus"])) {
        if ( is_array( $wpData["menus"] ) ) {
            foreach ( $wpData["menus"] as $location => $description) {
                wp_create_nav_menu($description);
            }
        }
    }

    // ----------create options page---------------
    if(isset($wpFields["options"])) {
        if( function_exists('acf_add_options_page') ) {

            acf_add_options_page();

            foreach ( $wpFields["options"] as $option ) {
                acf_add_options_sub_page( array(
                    'page_title' 	=> $option["title"],
                    'menu_title' 	=> $option["title"],
                    'menu_slug' 	=> $option["slug"]
                ));
            }
        }
    }
    // ----------create options page---------------

    //-------------custom fields configs--------------------------------
    if(isset($wpFields["groups"])) {
        if(function_exists("register_field_group")) {
            foreach ($wpFields["groups"] as $wpField) {
                acf_add_local_field_group($wpField);
            }
        }
    }

    //-------------custom plugins configs--------------------------------
    if(isset($wpFields["plugins_in"])) {
        foreach ($wpFields["plugins_in"] as $wpField) {
            \Wappsnet\Core\Field::setConnectedPlugins($wpField);
        }
    }
}

function my_rest_prepare_post($data, $post, $request) {
    $_data = $data->data;

    $fields = get_fields($post->ID);

    foreach ($fields as $key => $value){
        $_data[$key] = get_field($key, $post->ID);
    }

    $data->data = $_data;

    return $data;
}