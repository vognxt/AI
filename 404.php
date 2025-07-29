<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Modern_WooCommerce_Theme
 */

get_header(); ?>

<div class="container">
    <main id="primary" class="site-main">
        <section class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'modern-woocommerce-theme'); ?></h1>
            </header>

            <div class="page-content">
                <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'modern-woocommerce-theme'); ?></p>

                <?php get_search_form(); ?>

                <div class="widget-area">
                    <div class="error-widgets">
                        <div class="widget">
                            <h2><?php esc_html_e('Most Used Categories', 'modern-woocommerce-theme'); ?></h2>
                            <ul>
                                <?php
                                wp_list_categories(
                                    array(
                                        'orderby'    => 'count',
                                        'order'      => 'DESC',
                                        'show_count' => 1,
                                        'title_li'   => '',
                                        'number'     => 10,
                                    )
                                );
                                ?>
                            </ul>
                        </div>

                        <div class="widget">
                            <h2><?php esc_html_e('Recent Posts', 'modern-woocommerce-theme'); ?></h2>
                            <ul>
                                <?php
                                wp_get_archives(
                                    array(
                                        'type'  => 'postbypost',
                                        'limit' => 10,
                                    )
                                );
                                ?>
                            </ul>
                        </div>

                        <?php if (class_exists('WooCommerce')) : ?>
                        <div class="widget">
                            <h2><?php esc_html_e('Shop Categories', 'modern-woocommerce-theme'); ?></h2>
                            <ul>
                                <?php
                                $product_categories = get_terms(array(
                                    'taxonomy' => 'product_cat',
                                    'hide_empty' => true,
                                    'number' => 10,
                                ));

                                if (!empty($product_categories) && !is_wp_error($product_categories)) {
                                    foreach ($product_categories as $category) {
                                        echo '<li><a href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a></li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<?php
get_footer();