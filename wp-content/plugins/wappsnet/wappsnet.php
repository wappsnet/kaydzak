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

use Wappsnet\Core\Migration;
use Wappsnet\Core\Parser;

define("WAPPSNET_PATH", __DIR__);

require_once (WAPPSNET_PATH."/autoload.php");
require_once(WAPPSNET_PATH."/fields/acf.php");

//add admin actions
add_action( 'init', 'runApp' );

function runApp(): void
{
    $wpData = Parser::getConfig('wordpress');
    $wpFields = Parser::getConfig('fields');

    // ----------create post type---------------
    if(isset($wpData["post_types"])) {
        foreach ( $wpData["post_types"] as $post_type ) {
            register_post_type( $post_type["name"], $post_type["params"] );
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
        foreach ( $wpData["supports"] as $value ) {
            add_theme_support( $value );
        }

        add_theme_support( 'html5', array(
            // Any or all of these.
            'comment-list',
            'comment-form',
            'search-form',
            'gallery',
            'caption',
        ));
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
                Migration::up( $migration["name"], $migration["type"] );
            }
        }
    }

    //------------up widgets --------------------
    if(isset($wpData["widgets"])) {
        if ( is_array( $wpData["widgets"] ) ) {
            foreach ( $wpData["widgets"] as $widget) {
                register_sidebar($widget);
            }
        }
    }

    //------------up patterns --------------------
    if(isset($wpData["patterns"])) {
        if ( is_array( $wpData["patterns"] ) ) {
            foreach ( $wpData["patterns"] as $pattern) {
                $block_patter_category = wp_insert_term($pattern['category'], 'wp_pattern_category', array('slug' => $pattern['slug']));

                foreach ( $pattern["items"] as $item) {
                    $query =  new \WP_Query([
                        'name' => $item['post_name'],
                        'post_type' => $item['post_type'],
                    ]);

                    if (empty($query->post->post_content)) {
                        $block_pattern_id = wp_insert_post($item);

                        if (!is_wp_error($block_pattern_id)) {
                            add_post_meta($block_pattern_id, 'wp_pattern_sync_status', 'unsynced');

                            if (!is_wp_error($block_patter_category)) {
                                wp_set_object_terms($block_pattern_id, $pattern['slug'], 'wp_pattern_category');
                            }
                        }
                    }
                }
            }
        }
    }

    //------------up menus --------------------
    if(isset($wpData["menus"])) {
        if ( is_array( $wpData["menus"] ) ) {
            foreach ( $wpData["menus"] as $location => $description) {
                if ($location) {
                    wp_create_nav_menu($description);
                }
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
}