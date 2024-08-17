<?php

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

// Step 2: Add Typography section and controls in the Customizer
add_action( 'customize_register', function( $wp_customize ) {
    // Add Typography Section
    $wp_customize->add_section( 'typography' , array(
        'title'      => __( 'Typography', 'theme' ),
        'priority'   => 30,
    ) );

    // Add Font Family Setting and Control
    $wp_customize->add_setting( 'body_font_family' , array(
        'default'     => 'Roboto',
        'transport'   => 'refresh',
    ));

    $wp_customize->add_control( 'body_font_family', array(
        'label' => __( 'Body Font Family', 'theme' ),
        'section' => 'typography',
        'settings' => 'body_font_family',
        'type' => 'select',
        'choices'    => array(
            'Arial' => 'Arial',
            'Gotham' => 'Gotham',
            'Roboto' => 'Roboto',
        ),
    ) );

    // Add Font Family Setting and Control
    $wp_customize->add_setting( 'body_font_size' , array(
        'default'     => 14,
        'transport'   => 'refresh',
    ));

    $wp_customize->add_control( 'body_font_size', array(
        'label' => __( 'Body Font Size', 'theme' ),
        'section' => 'typography',
        'settings' => 'body_font_size',
        'type' => 'number',
    ) );
});

// Step 1: Enqueue Google Fonts in your theme
add_action( 'wp_enqueue_scripts', function () {
    $font_uri = get_template_directory_uri() . '/assets/fonts/index.css';

    // Enqueue the stylesheet
    wp_enqueue_style( 'theme-fonts', $font_uri );
});

// Step 3: Output the custom CSS in your theme’s header
add_action( 'wp_head', function () {
    $theme = json_decode(file_get_contents(THEME_PATH.'/theme.json'), true);

    $colors = [];

    foreach ($theme['settings']['color']['palette'] as $item) {
        $color = get_theme_mod($item['slug'], $item['color']);
        $colors[] = "--{$item['slug']}: {$color} !important";
    }

    $styles = join(';', $colors);

    echo '<style>
        :root {
            '.$styles.'
        }
        body { 
            font-family: ' . get_theme_mod('body_font_family', 'Roboto') . '!important;
            font-size: ' . get_theme_mod('body_font_size', 14) . 'px !important;
        }
    </style>';
});

function getColorPalette(): array {
    $theme = json_decode(file_get_contents(THEME_PATH.'/theme.json'), true);
    $colors = [];

    foreach ($theme['settings']['color']['palette'] as $item) {
        $colors[] = [
            'name'  => $item['name'],
            'slug'  => $item['slug'],
            'color' => get_theme_mod($item['slug'], $item['color']),
        ];
    }

    return $colors;
}

add_filter( 'wappsnet_editor_color_palette', function ( array $palette ): array {
    return array_merge(
        $palette,
        getColorPalette()
    );
});

add_theme_support('editor-color-palette', apply_filters('wappsnet_editor_color_palette', getColorPalette()));