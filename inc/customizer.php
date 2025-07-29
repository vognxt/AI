<?php
/**
 * Modern WooCommerce Theme Customizer
 *
 * @package Modern_WooCommerce_Theme
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function modern_woocommerce_theme_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport         = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.site-title a',
                'render_callback' => 'modern_woocommerce_theme_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => 'modern_woocommerce_theme_customize_partial_blogdescription',
            )
        );
    }

    // Theme Options Section
    $wp_customize->add_section('modern_woocommerce_theme_options', array(
        'title'    => __('Theme Options', 'modern-woocommerce-theme'),
        'priority' => 130,
    ));

    // Primary Color Setting
    $wp_customize->add_setting('primary_color', array(
        'default'           => '#007cba',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label'   => __('Primary Color', 'modern-woocommerce-theme'),
        'section' => 'modern_woocommerce_theme_options',
    )));

    // Secondary Color Setting
    $wp_customize->add_setting('secondary_color', array(
        'default'           => '#005a87',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label'   => __('Secondary Color', 'modern-woocommerce-theme'),
        'section' => 'modern_woocommerce_theme_options',
    )));

    // Footer Text Setting
    $wp_customize->add_setting('footer_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('footer_text', array(
        'label'   => __('Footer Text', 'modern-woocommerce-theme'),
        'section' => 'modern_woocommerce_theme_options',
        'type'    => 'textarea',
    ));

    // Show/Hide Elements
    $wp_customize->add_setting('show_search_in_header', array(
        'default'           => true,
        'sanitize_callback' => 'modern_woocommerce_theme_sanitize_checkbox',
    ));

    $wp_customize->add_control('show_search_in_header', array(
        'label'   => __('Show Search in Header', 'modern-woocommerce-theme'),
        'section' => 'modern_woocommerce_theme_options',
        'type'    => 'checkbox',
    ));

    $wp_customize->add_setting('show_cart_in_header', array(
        'default'           => true,
        'sanitize_callback' => 'modern_woocommerce_theme_sanitize_checkbox',
    ));

    $wp_customize->add_control('show_cart_in_header', array(
        'label'   => __('Show Cart in Header', 'modern-woocommerce-theme'),
        'section' => 'modern_woocommerce_theme_options',
        'type'    => 'checkbox',
    ));

    // Typography Settings
    $wp_customize->add_section('modern_woocommerce_theme_typography', array(
        'title'    => __('Typography', 'modern-woocommerce-theme'),
        'priority' => 140,
    ));

    $wp_customize->add_setting('body_font_family', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('body_font_family', array(
        'label'   => __('Body Font Family', 'modern-woocommerce-theme'),
        'section' => 'modern_woocommerce_theme_typography',
        'type'    => 'select',
        'choices' => array(
            'Inter'     => 'Inter',
            'Roboto'    => 'Roboto',
            'Open Sans' => 'Open Sans',
            'Lato'      => 'Lato',
            'Poppins'   => 'Poppins',
        ),
    ));

    $wp_customize->add_setting('heading_font_family', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('heading_font_family', array(
        'label'   => __('Heading Font Family', 'modern-woocommerce-theme'),
        'section' => 'modern_woocommerce_theme_typography',
        'type'    => 'select',
        'choices' => array(
            'Inter'     => 'Inter',
            'Roboto'    => 'Roboto',
            'Open Sans' => 'Open Sans',
            'Lato'      => 'Lato',
            'Poppins'   => 'Poppins',
        ),
    ));

    // WooCommerce Settings
    if (class_exists('WooCommerce')) {
        $wp_customize->add_section('modern_woocommerce_theme_woocommerce', array(
            'title'    => __('WooCommerce', 'modern-woocommerce-theme'),
            'priority' => 150,
        ));

        $wp_customize->add_setting('products_per_page', array(
            'default'           => 12,
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control('products_per_page', array(
            'label'   => __('Products per Page', 'modern-woocommerce-theme'),
            'section' => 'modern_woocommerce_theme_woocommerce',
            'type'    => 'number',
        ));

        $wp_customize->add_setting('show_related_products', array(
            'default'           => true,
            'sanitize_callback' => 'modern_woocommerce_theme_sanitize_checkbox',
        ));

        $wp_customize->add_control('show_related_products', array(
            'label'   => __('Show Related Products', 'modern-woocommerce-theme'),
            'section' => 'modern_woocommerce_theme_woocommerce',
            'type'    => 'checkbox',
        ));
    }
}
add_action('customize_register', 'modern_woocommerce_theme_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function modern_woocommerce_theme_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function modern_woocommerce_theme_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function modern_woocommerce_theme_customize_preview_js() {
    wp_enqueue_script('modern-woocommerce-theme-customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), _S_VERSION, true);
}
add_action('customize_preview_init', 'modern_woocommerce_theme_customize_preview_js');

/**
 * Sanitize checkbox
 */
function modern_woocommerce_theme_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Sanitize select
 */
function modern_woocommerce_theme_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}