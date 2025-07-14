<?php


/** * The public-facing HTML form for the Frontend Post Builder plugin.
 *
 * This file is responsible for rendering the form that allows users to create posts from the frontend.
 *
 * 
 * @package    Frontend_Post_Builder
 * @subpackage Frontend_Post_Builder/public/partials
 */
?>
<div class="fps_main_wrapper">
    <div class="fps_frontend_form">
        <?php if (isset($atts['post_title']) && !empty($atts['post_title'])): ?>
            <h2><?php esc_html_e('Create a New Post', 'frontend-post-builder'); ?></h2>
        <?php endif; ?>
        <form method="post" action="">
            <?php wp_nonce_field('fps_post_builder', 'fps_post_builder_nonce'); ?>
            <div class="fps_field">
                <label for="fps_post_title"><?php esc_html_e('Post Title:', 'frontend-post-builder'); ?></label>
                <input type="text" name="fps_post_title" id="fps_post_title" required>
            </div>
            <div class="fps_field">
                <label for="fps_post_content"><?php esc_html_e('Post Content:', 'frontend-post-builder'); ?></label>
                <textarea name="fps_post_content" id="fps_post_content" rows="5" required></textarea>
            </div>
            <div class="fps_field">
                <input type="hidden" name="fps_user_id" value="<?php echo esc_attr(get_current_user_id()); ?>" id="fps_user_id" />
            </div>
            <div class="fps_field">
                <input type="hidden" name="fps_post_type" value="<?php echo esc_attr(get_option('_fps_post_type', true)); ?>">
            </div>
            <div class="fps_field">
                <input type="hidden" name="fps_post_status" value="<?php echo esc_attr(get_option('_fps_post_status', true)); ?>">
            </div>
            <div class="fps_field">
                <input type="submit" class="button button-primary" value="<?php esc_attr_e('Submit Post', 'frontend-post-builder'); ?>">
            </div>
        </form>
        <div class="submission_message">

        </div>
    </div>