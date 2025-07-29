<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Modern_WooCommerce_Theme
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function modern_woocommerce_theme_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'modern_woocommerce_theme_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function modern_woocommerce_theme_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'modern_woocommerce_theme_pingback_header');

/**
 * Change the excerpt length
 */
function modern_woocommerce_theme_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'modern_woocommerce_theme_excerpt_length');

/**
 * Change the excerpt more string
 */
function modern_woocommerce_theme_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'modern_woocommerce_theme_excerpt_more');

/**
 * Add custom image sizes
 */
function modern_woocommerce_theme_image_sizes() {
    add_image_size('modern-woocommerce-theme-featured', 800, 400, true);
    add_image_size('modern-woocommerce-theme-thumbnail', 300, 200, true);
}
add_action('after_setup_theme', 'modern_woocommerce_theme_image_sizes');

/**
 * Customize the search form
 */
function modern_woocommerce_theme_search_form($form) {
    $form = '<form role="search" method="get" class="search-form" action="' . home_url('/') . '">
        <label>
            <span class="screen-reader-text">' . _x('Search for:', 'label', 'modern-woocommerce-theme') . '</span>
            <input type="search" class="search-field" placeholder="' . esc_attr_x('Search …', 'placeholder', 'modern-woocommerce-theme') . '" value="' . get_search_query() . '" name="s" />
        </label>
        <button type="submit" class="search-submit">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <span class="screen-reader-text">' . _x('Search', 'submit button', 'modern-woocommerce-theme') . '</span>
        </button>
    </form>';

    return $form;
}
add_filter('get_search_form', 'modern_woocommerce_theme_search_form');

/**
 * Add custom logo support
 */
function modern_woocommerce_theme_custom_logo_setup() {
    $defaults = array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    );
    add_theme_support('custom-logo', $defaults);
}
add_action('after_setup_theme', 'modern_woocommerce_theme_custom_logo_setup');

/**
 * Add preconnect for Google Fonts
 */
function modern_woocommerce_theme_resource_hints($urls, $relation_type) {
    if (wp_style_is('modern-woocommerce-theme-style', 'queue') && 'preconnect' === $relation_type) {
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        );
    }

    return $urls;
}
add_filter('wp_resource_hints', 'modern_woocommerce_theme_resource_hints', 10, 2);

/**
 * Add customizer support
 */
function modern_woocommerce_theme_customize_register($wp_customize) {
    // Add section for theme options
    $wp_customize->add_section('modern_woocommerce_theme_options', array(
        'title'    => __('Theme Options', 'modern-woocommerce-theme'),
        'priority' => 130,
    ));

    // Add setting for primary color
    $wp_customize->add_setting('primary_color', array(
        'default'           => '#007cba',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label'   => __('Primary Color', 'modern-woocommerce-theme'),
        'section' => 'modern_woocommerce_theme_options',
    )));
}
add_action('customize_register', 'modern_woocommerce_theme_customize_register');

/**
 * Output custom CSS for customizer options
 */
function modern_woocommerce_theme_customizer_css() {
    $primary_color = get_theme_mod('primary_color', '#007cba');
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_attr($primary_color); ?>;
        }
        
        a {
            color: var(--primary-color);
        }
        
        .woocommerce ul.products li.product .button,
        .single-product .product .summary .single_add_to_cart_button {
            background: var(--primary-color);
        }
        
        .woocommerce ul.products li.product .button:hover,
        .single-product .product .summary .single_add_to_cart_button:hover {
            background: <?php echo esc_attr(adjust_brightness($primary_color, -20)); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'modern_woocommerce_theme_customizer_css');

/**
 * Helper function to adjust color brightness
 */
function adjust_brightness($hex, $steps) {
    $hex = str_replace('#', '', $hex);
    
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    $r = max(0, min(255, $r + $steps));
    $g = max(0, min(255, $g + $steps));
    $b = max(0, min(255, $b + $steps));
    
    return sprintf('#%02x%02x%02x', $r, $g, $b);
}