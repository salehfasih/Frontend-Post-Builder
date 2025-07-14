<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/salehfasih/Frontend-Post-Builder
 * @since      1.0.0
 *
 * @package    Frontend_Post_Builder
 * @subpackage Frontend_Post_Builder/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php
// Fetch post types and options
$post_types     = get_post_types(['public' => true], 'objects');
$selected_post  = get_option('_fps_post_type');
$status         = get_option('_fps_post_status');

// Output admin form
?>
<div class="fps_main_wrapper">
<div class="fps_admin_form">
    <h2><?php esc_html_e('Select Post Type', 'frontend-post-builder'); ?></h2>
    <form method="post">
        <?php wp_nonce_field('save_post_type', 'post_type_nonce'); ?>

        <div class="fps_field">
            <label for="fps_post_type"><?php esc_html_e('Post Type:', 'frontend-post-builder'); ?></label>
            <select name="fps_post_type" id="fps_post_type">
                <?php foreach ($post_types as $slug => $post_type) : ?>
                    <option value="<?php echo esc_attr($slug); ?>" <?php selected($selected_post, $slug); ?>>
                        <?php echo esc_html($post_type->labels->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="fps_field">
            <label for="fps_post_status"><?php esc_html_e('Status:', 'frontend-post-builder'); ?></label>
            <select name="fps_post_status" id="fps_post_status">
                <option value="draft" <?php selected($status, 'draft'); ?>><?php esc_html_e('Draft', 'frontend-post-builder'); ?></option>
                <option value="publish" <?php selected($status, 'publish'); ?>><?php esc_html_e('Publish', 'frontend-post-builder'); ?></option>
                <option value="private" <?php selected($status, 'private'); ?>><?php esc_html_e('Private', 'frontend-post-builder'); ?></option>
                <option value="pending" <?php selected($status, 'pending'); ?>><?php esc_html_e('Pending', 'frontend-post-builder'); ?></option>
                <option value="trash" <?php selected($status, 'trash'); ?>><?php esc_html_e('Trash', 'frontend-post-builder'); ?></option>
            </select>
        </div>
        <div class="fps_field">
            <input type="submit" class="button button-primary" value="<?php esc_attr_e('Save Selection', 'frontend-post-builder'); ?>">
        </div>
    </form>
</div>
<div class="fps_shortcode_wrapper">
    <h2><?php esc_html_e('Shortcode', 'frontend-post-builder'); ?></h2>
    <p><?php esc_html_e('Use the following shortcode to display the frontend post builder form:', 'frontend-post-builder'); ?></p>
    <code>[frontend_post_builder]</code>
    <p><?php esc_html_e('You can also specify the post type and status using attributes:', 'frontend-post-builder'); ?></p>
    <code>[frontend_post_builder post_type="<?php echo esc_attr($selected_post); ?>" post_status="<?php echo esc_attr($status); ?>"]</code>
</div>
                </div>
<div class="fps_support">
    <div class="fps_support_wrapper">
    <h2><?php esc_html_e('Usage', 'frontend-post-builder'); ?></h2>
    <p><?php esc_html_e('To use the frontend post builder, simply add the shortcode to any page or post where you want the form to appear.', 'frontend-post-builder'); ?></p>
    <p><?php esc_html_e('Make sure to configure the post type and status settings above before using the shortcode.', 'frontend-post-builder'); ?></p>
    <p><?php esc_html_e('This will allow users to submit posts or custom content from the frontend of your WordPress site.', 'frontend-post-builder'); ?></p>
</div>
<div class="fps_support_wrapper">
    <h2><?php esc_html_e('Support', 'frontend-post-builder'); ?></h2>
    <p><?php esc_html_e('If you have any questions or need assistance, please visit our support page.', 'frontend-post-builder'); ?></p>
    <p><?php esc_html_e('Thank you for using Frontend Post Builder!', 'frontend-post-builder'); ?></p>
</div>
<div class="fps_support_wrapper">
    <h2><?php esc_html_e('Contribute', 'frontend-post-builder'); ?></h2>
    <p><?php esc_html_e('If you would like to contribute to the development of this plugin, please visit our GitHub repository.', 'frontend-post-builder'); ?></p>
    <p><?php esc_html_e('Your contributions are welcome!', 'frontend-post-builder'); ?></p>
</div>
<div class="fps_support_wrapper">
    <h2><?php esc_html_e('Feedback', 'frontend-post-builder'); ?></h2>
    <p><?php esc_html_e('We value your feedback! If you have suggestions or improvements, please let us know.', 'frontend-post-builder'); ?></p>
    <p><?php esc_html_e('Your input helps us make the plugin better for everyone.', 'frontend-post-builder'); ?></p>
</div>
<div class="fps_support_wrapper">
    <h2><?php esc_html_e('Documentation', 'frontend-post-builder'); ?></h2>
    <p><?php esc_html_e('For detailed documentation on how to use the Frontend Post Builder, please refer to our documentation page.', 'frontend-post-builder'); ?></p>
    <p><?php esc_html_e('This will help you get the most out of the plugin.', 'frontend-post-builder'); ?></p>
</div>
<div class="fps_support_wrapper">
    <h2><?php esc_html_e('Updates', 'frontend-post-builder'); ?></h2>
    <p><?php esc_html_e('Keep an eye on our updates for new features and improvements.', 'frontend-post-builder'); ?></p>
    <p><?php esc_html_e('We are constantly working to enhance the plugin based on user feedback.', 'frontend-post-builder'); ?></p>
</div>
<div class="fps_support_wrapper">
    <h2><?php esc_html_e('Changelog', 'frontend-post-builder'); ?></h2>
    <p><?php esc_html_e('Check the changelog for a list of changes and updates made to the plugin.', 'frontend-post-builder'); ?></p>
    <p><?php esc_html_e('This will help you stay informed about the latest improvements.', 'frontend-post-builder'); ?></p>
</div>
<div class="fps_support_wrapper">
    <h2><?php esc_html_e('License', 'frontend-post-builder'); ?></h2>
    <p><?php esc_html_e('This plugin is licensed under the GPL-2.0+ license.', 'frontend-post-builder'); ?></p>
    <p><?php esc_html_e('You can find the full license text in the plugin directory.', 'frontend-post-builder'); ?></p>             
</div>
</div>