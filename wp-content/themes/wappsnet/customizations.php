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

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('dashicons');
});