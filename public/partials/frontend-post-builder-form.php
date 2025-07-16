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
        <style>
            .fps_main_wrapper {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            padding: 32px 24px;
            font-family: 'Segoe UI', Arial, sans-serif;
            }
            .fps_frontend_form h2 {
            margin-bottom: 24px;
            font-size: 2rem;
            color: #333;
            text-align: center;
            }
            .fps_field {
            margin-bottom: 20px;
            }
            .fps_field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #222;
            }
            .fps_field input[type="text"],
            .fps_field textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            background: #fafafa;
            transition: border-color 0.2s;
            }
            .fps_field input[type="text"]:focus,
            .fps_field textarea:focus {
            border-color: #007cba;
            outline: none;
            }
            .fps_field textarea {
            resize: vertical;
            min-height: 100px;
            }
            .fps_field .button {
            background: #007cba;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.2s;
            }
            .fps_field .button:hover {
            background: #005a9e;
            }
            .fps_field input[type="submit"].button-primary {
            width: 100%;
            font-weight: bold;
            margin-top: 10px;
            }
            #fps_file_preview {
            margin-top: 10px;
            }
            .submission_message {
            margin-top: 24px;
            font-size: 1.1rem;
            color: #007cba;
            text-align: center;
            }
        </style>
        <form method="post" action="">
            <?php wp_nonce_field('fps_post_builder', 'fps_post_builder_nonce'); ?>
            <div class="fps_field">
                <label for="fps_post_title"><?php esc_html_e('Post Title:', 'frontend-post-builder'); ?></label>
                <input type="text" name="fps_post_title" id="fps_post_title" required>
            </div>
            <div class="fps_field">
                <label><?php esc_html_e('Upload File:', 'frontend-post-builder'); ?></label>
                <button type="button" class="button" id="fps_upload_media"><?php esc_html_e('Select from Media Library', 'frontend-post-builder'); ?></button>
                <input type="hidden" name="fps_file_url" id="fps_file_url">
                <div id="fps_file_preview"></div>
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

    <script>
        jQuery(document).ready(function() {
            // Handle media upload
            var fps_media_frame;
	jQuery(document).on('click', '#fps_upload_media', function (e) {
		console.log('Media upload button clicked');
		e.preventDefault();
		// If the media frame already exists, reopen it.
		if (fps_media_frame) {
			fps_media_frame.open();
			return;
		}
		// Create the media frame.
		fps_media_frame = wp.media({
			title: 'Select or Upload Media',
			button: {
				text: 'Select Thumbnail'
			},
			multiple: false
		});
		// When a file is selected, run a callback.
		fps_media_frame.on('select', function () {
			var attachment = fps_media_frame.state().get('selection').first().toJSON();
			jQuery('#fps_file_url').val(attachment.url);
			jQuery('#fps_file_preview').html('<a href="' + attachment.url + '" target="_blank">' + attachment.filename + '</a>');
		});
		// Finally, open the modal
		fps_media_frame.open();
	});
        });
    </script>