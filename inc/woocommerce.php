<?php
/**
 * WooCommerce Compatibility File
 *
 * @package Modern_WooCommerce_Theme
 */

/**
 * WooCommerce setup function.
 */
function modern_woocommerce_theme_woocommerce_setup() {
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 300,
        'single_image_width'    => 600,
        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 1,
            'default_columns' => 4,
            'min_columns'     => 1,
            'max_columns'     => 6,
        ),
    ));
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'modern_woocommerce_theme_woocommerce_setup');

/**
 * WooCommerce specific scripts & stylesheets.
 */
function modern_woocommerce_theme_woocommerce_scripts() {
    wp_enqueue_style('modern-woocommerce-theme-woocommerce-style', get_template_directory_uri() . '/woocommerce.css', array(), _S_VERSION);

    $font_path   = WC()->plugin_url() . '/assets/fonts/';
    $inline_font = '@font-face {
            font-family: "star";
            src: url("' . $font_path . 'star.eot");
            src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
                url("' . $font_path . 'star.woff") format("woff"),
                url("' . $font_path . 'star.ttf") format("truetype"),
                url("' . $font_path . 'star.svg#star") format("svg");
            font-weight: normal;
            font-style: normal;
        }';

    wp_add_inline_style('modern-woocommerce-theme-woocommerce-style', $inline_font);
}
add_action('wp_enqueue_scripts', 'modern_woocommerce_theme_woocommerce_scripts');

/**
 * Disable the default WooCommerce stylesheet.
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Add 'woocommerce-active' class to the body tag.
 */
function modern_woocommerce_theme_woocommerce_active_body_class($classes) {
    $classes[] = 'woocommerce-active';

    return $classes;
}
add_filter('body_class', 'modern_woocommerce_theme_woocommerce_active_body_class');

/**
 * Products per page.
 */
function modern_woocommerce_theme_woocommerce_products_per_page() {
    return 12;
}
add_filter('loop_shop_per_page', 'modern_woocommerce_theme_woocommerce_products_per_page');

/**
 * Product gallery thumnbail columns.
 */
function modern_woocommerce_theme_woocommerce_thumbnail_columns() {
    return 4;
}
add_filter('woocommerce_product_thumbnails_columns', 'modern_woocommerce_theme_woocommerce_thumbnail_columns');

/**
 * Default loop columns on product archives.
 */
function modern_woocommerce_theme_woocommerce_loop_columns() {
    return 4;
}
add_filter('loop_shop_columns', 'modern_woocommerce_theme_woocommerce_loop_columns');

/**
 * Related Products Args.
 */
function modern_woocommerce_theme_woocommerce_related_products_args($args) {
    $defaults = array(
        'posts_per_page' => 4,
        'columns'        => 4,
    );

    $args = wp_parse_args($defaults, $args);

    return $args;
}
add_filter('woocommerce_output_related_products_args', 'modern_woocommerce_theme_woocommerce_related_products_args');

/**
 * Remove default WooCommerce wrapper.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

if (!function_exists('modern_woocommerce_theme_woocommerce_wrapper_before')) {
    /**
     * Before Content.
     */
    function modern_woocommerce_theme_woocommerce_wrapper_before() {
        ?>
        <main id="primary" class="site-main">
        <?php
    }
}
add_action('woocommerce_before_main_content', 'modern_woocommerce_theme_woocommerce_wrapper_before');

if (!function_exists('modern_woocommerce_theme_woocommerce_wrapper_after')) {
    /**
     * After Content.
     */
    function modern_woocommerce_theme_woocommerce_wrapper_after() {
        ?>
        </main><!-- #main -->
        <?php
    }
}
add_action('woocommerce_after_main_content', 'modern_woocommerce_theme_woocommerce_wrapper_after');

/**
 * Sample implementation of the WooCommerce Mini Cart.
 */
if (!function_exists('modern_woocommerce_theme_cart_link_fragment')) {
    /**
     * Cart Fragments.
     *
     * Ensure cart contents update when products are added to the cart via AJAX.
     */
    function modern_woocommerce_theme_cart_link_fragment($fragments) {
        ob_start();
        modern_woocommerce_theme_cart_link();
        $fragments['a.cart-contents'] = ob_get_clean();

        return $fragments;
    }
}
add_filter('woocommerce_add_to_cart_fragments', 'modern_woocommerce_theme_cart_link_fragment');

if (!function_exists('modern_woocommerce_theme_cart_link')) {
    /**
     * Cart Link.
     */
    function modern_woocommerce_theme_cart_link() {
        ?>
        <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'modern-woocommerce-theme'); ?>">
            <?php
            $item_count_text = sprintf(
                /* translators: number of items in the mini cart. */
                _n('%d item', '%d items', WC()->cart->get_cart_contents_count(), 'modern-woocommerce-theme'),
                WC()->cart->get_cart_contents_count()
            );
            ?>
            <span class="amount"><?php echo wp_kses_data(WC()->cart->get_cart_subtotal()); ?></span> <span class="count"><?php echo esc_html($item_count_text); ?></span>
        </a>
        <?php
    }
}

if (!function_exists('modern_woocommerce_theme_cart_totals')) {
    /**
     * Display Header Cart.
     */
    function modern_woocommerce_theme_cart_totals() {
        if (is_cart()) {
            $class = 'current-menu-item';
        } else {
            $class = '';
        }
        ?>
        <ul id="site-header-cart" class="site-header-cart">
            <li class="<?php echo esc_attr($class); ?>">
                <?php modern_woocommerce_theme_cart_link(); ?>
            </li>
            <li>
                <?php
                $instance = array(
                    'title' => '',
                );

                the_widget('WC_Widget_Cart', $instance);
                ?>
            </li>
        </ul>
        <?php
    }
}

/**
 * Customize WooCommerce breadcrumbs
 */
function modern_woocommerce_theme_woocommerce_breadcrumb_defaults($args) {
    $args['delimiter']   = ' <span class="breadcrumb-separator">/</span> ';
    $args['wrap_before'] = '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">';
    $args['wrap_after']  = '</nav>';
    $args['before']      = '';
    $args['after']       = '';
    $args['home']        = _x('Home', 'breadcrumb', 'modern-woocommerce-theme');
    return $args;
}
add_filter('woocommerce_breadcrumb_defaults', 'modern_woocommerce_theme_woocommerce_breadcrumb_defaults');

/**
 * Remove WooCommerce default sidebar
 */
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

/**
 * Customize WooCommerce pagination
 */
function modern_woocommerce_theme_woocommerce_pagination_args($args) {
    $args['prev_text'] = '&larr; ' . __('Previous', 'modern-woocommerce-theme');
    $args['next_text'] = __('Next', 'modern-woocommerce-theme') . ' &rarr;';
    return $args;
}
add_filter('woocommerce_pagination_args', 'modern_woocommerce_theme_woocommerce_pagination_args');

/**
 * Add custom classes to WooCommerce buttons
 */
function modern_woocommerce_theme_woocommerce_button_class($class, $button, $product) {
    $class .= ' modern-woocommerce-button';
    return $class;
}
add_filter('woocommerce_loop_add_to_cart_args', function($args) {
    $args['class'] .= ' modern-woocommerce-button';
    return $args;
});

/**
 * Customize WooCommerce notices
 */
function modern_woocommerce_theme_woocommerce_notice_types($types) {
    $types['success'] = 'modern-woocommerce-notice modern-woocommerce-notice--success';
    $types['error'] = 'modern-woocommerce-notice modern-woocommerce-notice--error';
    $types['notice'] = 'modern-woocommerce-notice modern-woocommerce-notice--info';
    return $types;
}
add_filter('woocommerce_notice_types', 'modern_woocommerce_theme_woocommerce_notice_types');