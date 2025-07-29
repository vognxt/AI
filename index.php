<?php
/**
 * The main template file
 *
 * @package Modern_WooCommerce_Theme
 */

get_header(); ?>

<div class="container">
    <main id="primary" class="site-main">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                    </header>

                    <div class="entry-content">
                        <?php
                        the_content();
                        
                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'modern-woocommerce-theme'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>
                </article>
                <?php
            endwhile;

            the_posts_navigation();

        else :
            ?>
            <div class="no-posts">
                <h2><?php esc_html_e('Nothing Found', 'modern-woocommerce-theme'); ?></h2>
                <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'modern-woocommerce-theme'); ?></p>
                <?php get_search_form(); ?>
            </div>
            <?php
        endif;
        ?>
    </main>
</div>

<?php
get_footer();