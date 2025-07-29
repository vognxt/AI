<?php
/**
 * Modern WooCommerce Theme functions and definitions
 *
 * @package Modern_WooCommerce_Theme
 */

if (!defined('_S_VERSION')) {
    define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function modern_woocommerce_theme_setup() {
    // Make theme available for translation
    load_theme_textdomain('modern-woocommerce-theme', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menu() in two locations
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'modern-woocommerce-theme'),
        'footer'  => esc_html__('Footer Menu', 'modern-woocommerce-theme'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for core custom logo
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Add support for WooCommerce
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'modern_woocommerce_theme_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function modern_woocommerce_theme_content_width() {
    $GLOBALS['content_width'] = apply_filters('modern_woocommerce_theme_content_width', 1200);
}
add_action('after_setup_theme', 'modern_woocommerce_theme_content_width', 0);

/**
 * Register widget area.
 */
function modern_woocommerce_theme_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'modern-woocommerce-theme'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'modern-woocommerce-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area', 'modern-woocommerce-theme'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here.', 'modern-woocommerce-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'modern_woocommerce_theme_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function modern_woocommerce_theme_scripts() {
    wp_enqueue_style('modern-woocommerce-theme-style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_style_add_data('modern-woocommerce-theme-style', 'rtl', 'replace');

    wp_enqueue_script('modern-woocommerce-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'modern_woocommerce_theme_scripts');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * WooCommerce specific functions
 */
if (class_exists('WooCommerce')) {
    require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Fallback menu function
 */
function modern_woocommerce_theme_fallback_menu() {
    echo '<ul id="primary-menu" class="menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'modern-woocommerce-theme') . '</a></li>';
    if (class_exists('WooCommerce')) {
        echo '<li><a href="' . esc_url(wc_get_page_permalink('shop')) . '">' . esc_html__('Shop', 'modern-woocommerce-theme') . '</a></li>';
    }
    echo '</ul>';
}

/**
 * Add custom classes to body
 */
function modern_woocommerce_theme_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'modern_woocommerce_theme_body_classes');

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