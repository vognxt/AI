<?php
/**
 * The template for displaying archive pages
 *
 * @package Modern_WooCommerce_Theme
 */

get_header(); ?>

<div class="container">
    <main id="primary" class="site-main">
        <?php if (have_posts()) : ?>
            <header class="page-header">
                <?php
                the_archive_title('<h1 class="page-title">', '</h1>');
                the_archive_description('<div class="archive-description">', '</div>');
                ?>
            </header>

            <div class="posts-grid">
                <?php
                /* Start the Loop */
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('modern-woocommerce-theme-thumbnail'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="post-content">
                            <header class="entry-header">
                                <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); ?>

                                <div class="entry-meta">
                                    <?php
                                    modern_woocommerce_theme_posted_on();
                                    modern_woocommerce_theme_posted_by();
                                    ?>
                                </div>
                            </header>

                            <div class="entry-summary">
                                <?php the_excerpt(); ?>
                            </div>

                            <footer class="entry-footer">
                                <a href="<?php the_permalink(); ?>" class="read-more">
                                    <?php esc_html_e('Read More', 'modern-woocommerce-theme'); ?>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12,5 19,12 12,19"></polyline>
                                    </svg>
                                </a>
                            </footer>
                        </div>
                    </article>
                    <?php
                endwhile;
                ?>
            </div>

            <?php
            the_posts_navigation(
                array(
                    'prev_text' => '<span class="nav-arrow">←</span> ' . __('Older posts', 'modern-woocommerce-theme'),
                    'next_text' => __('Newer posts', 'modern-woocommerce-theme') . ' <span class="nav-arrow">→</span>',
                )
            );

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