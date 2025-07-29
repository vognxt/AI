    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><?php bloginfo('name'); ?></h3>
                    <p><?php bloginfo('description'); ?></p>
                </div>
                
                <div class="footer-section">
                    <h3><?php esc_html_e('Quick Links', 'modern-woocommerce-theme'); ?></h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'footer-menu',
                        'container'      => false,
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>
                
                <div class="footer-section">
                    <h3><?php esc_html_e('Contact', 'modern-woocommerce-theme'); ?></h3>
                    <ul>
                        <li><?php esc_html_e('Email: info@example.com', 'modern-woocommerce-theme'); ?></li>
                        <li><?php esc_html_e('Phone: +1 234 567 890', 'modern-woocommerce-theme'); ?></li>
                        <li><?php esc_html_e('Address: 123 Main St, City, State', 'modern-woocommerce-theme'); ?></li>
                    </ul>
                </div>
                
                <?php if (class_exists('WooCommerce')) : ?>
                <div class="footer-section">
                    <h3><?php esc_html_e('Shop', 'modern-woocommerce-theme'); ?></h3>
                    <ul>
                        <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"><?php esc_html_e('Shop', 'modern-woocommerce-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>"><?php esc_html_e('My Account', 'modern-woocommerce-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(wc_get_page_permalink('cart')); ?>"><?php esc_html_e('Cart', 'modern-woocommerce-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(wc_get_page_permalink('checkout')); ?>"><?php esc_html_e('Checkout', 'modern-woocommerce-theme'); ?></a></li>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All rights reserved.', 'modern-woocommerce-theme'); ?></p>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

<script>
// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const siteNavigation = document.querySelector('.site-navigation');
    
    if (menuToggle && siteNavigation) {
        menuToggle.addEventListener('click', function() {
            siteNavigation.classList.toggle('toggled');
            const isExpanded = siteNavigation.classList.contains('toggled');
            menuToggle.setAttribute('aria-expanded', isExpanded);
        });
    }
});
</script>

</body>
</html>