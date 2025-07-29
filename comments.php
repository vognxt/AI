<?php
/**
 * The template for displaying comments
 *
 * @package Modern_WooCommerce_Theme
 */

/*
 * If the current post is protected by a password and
 * the visitor has not entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php
    // You can start editing here -- including this comment!
    if (have_comments()) :
        ?>
        <h2 class="comments-title">
            <?php
            $modern_woocommerce_theme_comment_count = get_comments_number();
            if ('1' === $modern_woocommerce_theme_comment_count) {
                printf(
                    /* translators: 1: title. */
                    esc_html__('One thought on &ldquo;%1$s&rdquo;', 'modern-woocommerce-theme'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    /* translators: 1: comment count number, 2: title. */
                    esc_html(_nx('%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $modern_woocommerce_theme_comment_count, 'comments title', 'modern-woocommerce-theme')),
                    number_format_i18n($modern_woocommerce_theme_comment_count),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h2>

        <?php the_comments_navigation(); ?>

        <ol class="comment-list">
            <?php
            wp_list_comments(
                array(
                    'style'      => 'ol',
                    'short_ping' => true,
                )
            );
            ?>
        </ol>

        <?php
        the_comments_navigation();

        // If comments are closed and there are comments, let's leave a little note, shall we?
        if (!comments_open()) :
            ?>
            <p class="no-comments"><?php esc_html_e('Comments are closed.', 'modern-woocommerce-theme'); ?></p>
            <?php
        endif;

    endif; // Check for have_comments().
    ?>

    <?php
    comment_form(
        array(
            'title_reply' => __('Leave a Comment', 'modern-woocommerce-theme'),
            'title_reply_to' => __('Reply to %s', 'modern-woocommerce-theme'),
            'cancel_reply_link' => __('Cancel Reply', 'modern-woocommerce-theme'),
            'label_submit' => __('Post Comment', 'modern-woocommerce-theme'),
            'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x('Comment', 'noun', 'modern-woocommerce-theme') . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
        )
    );
    ?>

</div><!-- #comments -->