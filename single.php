<?php
/**
 * The template for displaying all single posts
 *
 * @package Modern_WooCommerce_Theme
 */

get_header(); ?>

<div class="container">
    <main id="primary" class="site-main">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                    
                    <div class="entry-meta">
                        <?php
                        modern_woocommerce_theme_posted_on();
                        modern_woocommerce_theme_posted_by();
                        ?>
                    </div>
                </header>

                <?php modern_woocommerce_theme_post_thumbnail(); ?>

                <div class="entry-content">
                    <?php
                    the_content(
                        sprintf(
                            wp_kses(
                                /* translators: %s: Name of current post. Only visible to screen readers */
                                __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'modern-woocommerce-theme'),
                                array(
                                    'span' => array(
                                        'class' => array(),
                                    ),
                                )
                            ),
                            wp_kses_post(get_the_title())
                        )
                    );

                    wp_link_pages(
                        array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'modern-woocommerce-theme'),
                            'after'  => '</div>',
                        )
                    );
                    ?>
                </div>

                <footer class="entry-footer">
                    <?php modern_woocommerce_theme_entry_footer(); ?>
                </footer>
            </article>

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;

            // Post navigation
            the_post_navigation(
                array(
                    'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'modern-woocommerce-theme') . '</span> <span class="nav-title">%title</span>',
                    'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'modern-woocommerce-theme') . '</span> <span class="nav-title">%title</span>',
                )
            );

        endwhile; // End of the loop.
        ?>
    </main>
</div>

<?php
get_footer();