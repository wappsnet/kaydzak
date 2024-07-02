<?php

use Wappsnet\Core\Blog;

define("THEME_PATH", __DIR__);

add_action('customize_register', function ($wp_customize) {
    $theme = json_decode(file_get_contents(THEME_PATH.'/theme.json'), true);

    foreach ($theme['settings']['color']['palette'] as $item) {
        // Border color
        $wp_customize->add_setting($item['slug'], array(
            'default' => $item['color'],
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_hex_color',
        ));

        $wp_control = new WP_Customize_Color_Control($wp_customize, $item['slug'], array(
            'section' => 'colors',
            'label' => esc_html__($item['name'], 'theme'),
        ));

        $wp_customize->add_control($wp_control);
    }
});

add_action( 'after_setup_theme', function() {
    add_theme_support( 'wp-block-styles' );
});


add_action('user_register', function ($id) {
    $user = get_userdata( $id );

    $roles = ['author', 'contributor', 'administrator', 'editor'];

    if (!empty(array_intersect($user->roles, $roles))) {
        $people = array(
            'post_title' => $user->display_name,
            'post_type' => 'people',
            'post_content' => $user->description,
            'post_status' => 'publish',
            'post_theme' => 'user-profile',
            'post_name' => $user->user_login,
        );


        return wp_insert_post($people);
    }

    return 0;
});

add_action('profile_update', function ($user_id) {
    $user = get_userdata( $user_id );

    $roles = ['author', 'contributor', 'administrator', 'editor'];

    if (!empty(array_intersect($user->roles, $roles))) {
        $people = array(
            'post_title' => $user->display_name,
            'post_type' => 'people',
            'post_content' => $user->description,
            'post_status' => 'publish',
            'post_theme' => 'user-profile',
            'post_name' => $user->user_login,
        );


        $exists = new WP_Query(array(
            'post_type' => 'people',
            'name' => $user->user_login
        ));

        if ($exists->have_posts()) {
            $posts = $exists->get_posts();
            return wp_update_post(
                array_merge($people, array(
                    'ID' => $posts[0]->ID
                ))
            );
        } else {
            return wp_insert_post($people);
        }
    }

    return 0;
});