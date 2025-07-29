<?php
/**
 * The template for displaying search results pages
 *
 * @package Modern_WooCommerce_Theme
 */

get_header(); ?>

<div class="container">
    <main id="primary" class="site-main">
        <?php if (have_posts()) : ?>
            <header class="page-header">
                <h1 class="page-title">
                    <?php
                    printf(
                        /* translators: %s: search query. */
                        esc_html__('Search Results for: %s', 'modern-woocommerce-theme'),
                        '<span>' . get_search_query() . '</span>'
                    );
                    ?>
                </h1>
            </header>

            <div class="search-results">
                <?php
                /* Start the Loop */
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('search-result'); ?>>
                        <header class="entry-header">
                            <?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>

                            <?php if ('post' === get_post_type()) : ?>
                                <div class="entry-meta">
                                    <?php
                                    modern_woocommerce_theme_posted_on();
                                    modern_woocommerce_theme_posted_by();
                                    ?>
                                </div>
                            <?php endif; ?>
                        </header>

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('modern-woocommerce-theme-thumbnail'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

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
                    </article>
                    <?php
                endwhile;
                ?>
            </div>

            <?php
            the_posts_navigation(
                array(
                    'prev_text' => '<span class="nav-arrow">←</span> ' . __('Previous', 'modern-woocommerce-theme'),
                    'next_text' => __('Next', 'modern-woocommerce-theme') . ' <span class="nav-arrow">→</span>',
                )
            );

        else :
            ?>
            <div class="no-results">
                <h2><?php esc_html_e('Nothing Found', 'modern-woocommerce-theme'); ?></h2>
                <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'modern-woocommerce-theme'); ?></p>
                <?php get_search_form(); ?>
            </div>
            <?php
        endif;
        ?>
    </main>
</div>

<?php
get_footer();