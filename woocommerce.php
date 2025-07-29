<?php
/**
 * The template for displaying WooCommerce pages
 *
 * @package Modern_WooCommerce_Theme
 */

get_header(); ?>

<div class="container">
    <main id="primary" class="site-main">
        <?php woocommerce_content(); ?>
    </main>
</div>

<?php
get_footer();