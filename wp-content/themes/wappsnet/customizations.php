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

add_action( 'customize_register', function( $wp_customize ) {
    $wp_customize->add_section( 'typography' , array(
        'title'      => __( 'Typography', 'theme' ),
        'priority'   => 30,
    ) );

    $font_families = array(
        'Arial' => 'Arial',
        'Gotham' => 'Gotham',
        'Roboto' => 'Roboto',
    );

    $font_weights = array(
        '300' => '300',
        '500' => '500',
        '700' => '700',
        '900' => '900',
        'normal' => 'normal',
        'bold' => 'bold',
        'bolder' => 'bolder',
    );

    $typography_types = array(
        'nav' => [
            'label' => 'Nav Bar',
            'font-family' => $font_families['Gotham'],
            'font-size' => 14,
            'font-weight' => $font_weights['bold']
        ],
        'body' => [
            'label' => 'Body',
            'font-family' => $font_families['Gotham'],
            'font-size' => 14,
            'font-weight' => $font_weights['normal']
        ],
        'heading' => [
            'label' => 'Heading',
            'font-family' => $font_families['Gotham'],
            'font-size' => 28,
            'font-weight' => $font_weights['bold']
        ],
        'title' => [
            'label' => 'Article Title',
            'font-family' => $font_families['Gotham'],
            'font-size' => 42,
            'font-weight' => $font_weights['bold']
        ]
    );

    foreach ($typography_types as $key => $value) {
        // Add Font Family Setting and Control
        $wp_customize->add_setting( $key.'_font_family' , array(
            'default'     => $value['font-family'],
            'transport'   => 'refresh',
        ));

        $wp_customize->add_control( $key.'_font_family', array(
            'label' => __( $value['label'].' Font Family', 'theme' ),
            'section' => 'typography',
            'settings' => $key.'_font_family',
            'type' => 'select',
            'choices'    => $font_families,
        ) );

        // Add Font Family Setting and Control
        $wp_customize->add_setting( $key.'_font_weight' , array(
            'default'     => $value['font-weight'],
            'transport'   => 'refresh',
        ));

        $wp_customize->add_control( $key.'_font_weight', array(
            'label' => __( $value['label'].' Font Weight', 'theme' ),
            'section' => 'typography',
            'settings' => $key.'_font_weight',
            'type' => 'select',
            'choices'    => $font_weights,
        ) );

        // Add Font Family Setting and Control
        $wp_customize->add_setting( $key.'_font_size' , array(
            'default'     => $value['font-size'],
            'transport'   => 'refresh',
        ));

        $wp_customize->add_control( $key.'_font_size', array(
            'label' => __( $value['label'].' Font Size', 'theme' ),
            'section' => 'typography',
            'settings' => $key.'_font_size',
            'type' => 'number',
        ) );
    }

    $layout_sizes = array(
        '1200px' => 'Large',
        '920px' => 'Medium',
        '720px' => 'Small',
    );

    $layout_types = [
        "header" => [
            'key' => 'header_layout_size',
            'label' => 'Header Layout Size',
            'default' => array_keys($layout_sizes)[0]
        ],
        "footer" => [
            'key' => 'footer_layout_size',
            'label' => 'Footer Layout Size',
            'default' => array_keys($layout_sizes)[0]
        ],
        "page" => [
            'key' => 'page_layout_size',
            'label' => 'Page Layout Size',
            'default' => array_keys($layout_sizes)[1]
        ],
        "post" => [
            'key' => 'post_layout_size',
            'label' => 'Post Layout Size',
            'default' => array_keys($layout_sizes)[1]
        ]
    ];

    $wp_customize->add_section( 'layouts' , array(
        'title'      => __( 'Layouts', 'theme' ),
        'priority'   => 30,
    ) );

    foreach ($layout_types as $key => $value) {
        $wp_customize->add_setting( $value['key'] , array(
            'default'     => $value['default'],
            'transport'   => 'refresh',
        ));

        $wp_customize->add_control( $value['key'], array(
            'label' => __( $value['label'], 'theme' ),
            'section' => 'layouts',
            'settings' => $value['key'],
            'type' => 'select',
            'choices'    => $layout_sizes,
        ) );
    }
});

// Step 1: Enqueue Google Fonts in your theme
add_action( 'wp_enqueue_scripts', function () {
    $font_uri = get_template_directory_uri() . '/assets/fonts/index.css';

    // Enqueue the stylesheet
    wp_enqueue_style( 'theme-fonts', $font_uri, [], null );
});

// Step 3: Output the custom CSS in your theme’s header
add_action( 'wp_head', function () {
    $cache = wp_cache_get('wp-custom-styles');

    if (!$cache) {
        $theme = json_decode(file_get_contents(THEME_PATH . '/theme.json'), true);

        $colors = [];

        foreach ($theme['settings']['color']['palette'] as $item) {
            $color = get_theme_mod($item['slug'], $item['color']);
            $colors[] = "--{$item['slug']}: {$color} !important";
        }

        $root = join(';', $colors);

        $styles = '<style>
             :root {' . $root . '}
              body { 
                font-family: ' . get_theme_mod('body_font_family', 'Gotham') . '!important;
                font-size: ' . get_theme_mod('body_font_size', 14) . 'px !important;
                font-weight: ' . get_theme_mod('body_font_weight') . '!important;
                }
            .app-page-title { 
                font-family: ' . get_theme_mod('title_font_family', 'Gotham') . '!important;
                font-size: ' . get_theme_mod('title_font_size', 14) . 'px !important;
                font-weight: ' . get_theme_mod('title_font_weight') . '!important;
                }
        
            .app-page-heading { 
                font-family: ' . get_theme_mod('heading_font_family', 'Gotham') . '!important;
                font-size: ' . get_theme_mod('heading_font_size', 14) . 'px !important;
                font-weight: ' . get_theme_mod('heading_font_weight') . '!important;
                }
        
            .app-nav-item { 
                font-family: ' . get_theme_mod('nav_font_family', 'Gotham') . '!important;
                font-size: ' . get_theme_mod('nav_font_size', 14) . 'px !important;
                font-weight: ' . get_theme_mod('nav_font_weight') . '!important;
            }
        </style>';

        wp_cache_set('wp-custom-styles', $styles);
        $cache = wp_cache_get('wp-custom-styles');
    }

    echo $cache;
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