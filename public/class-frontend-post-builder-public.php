<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.example.com
 * @since      1.0.0
 *
 * @package    Frontend_Post_Builder
 * @subpackage Frontend_Post_Builder/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Frontend_Post_Builder
 * @subpackage Frontend_Post_Builder/public
 * @author     Muhammad Saleh <sfclickysoft@gmail.com>
 */
class Frontend_Post_Builder_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_shortcode('frontend_post_builder', [$this, 'frontend_post_builder_callback']);
		add_action('wp_ajax_fps_create_post', [$this, 'fps_create_post_callback']);
		// add_action('wp_ajax_nopriv_fps_create_post', [$this, 'fps_create_post']);
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Frontend_Post_Builder_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Frontend_Post_Builder_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/frontend-post-builder-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Frontend_Post_Builder_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Frontend_Post_Builder_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/frontend-post-builder-public.js', array('jquery'), $this->version, false);
		wp_localize_script($this->plugin_name, 'fps_ajax_object', array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce'    => wp_create_nonce('fps_create_post_nonce')
		));
	}

	/**
	 * Callback function for the shortcode [frontend_post_builder].
	 *
	 * This function will render the frontend post builder form.
	 *
	 * @since    1.0.0
	 * @return   string    The HTML output of the form.			
	 * 
	 */
	public function frontend_post_builder_callback($atts)
	{
		// Extract shortcode attributes
		$atts = shortcode_atts(array(

			'post_type' => 'post',
			'post_status' => 'draft',
			'post_title' => ''

		), $atts, 'frontend_post_builder');

		// Include the form template
		ob_start();
		include plugin_dir_path(__FILE__) . 'partials/frontend-post-builder-form.php';
		return ob_get_clean();
	}


	/**
	 * Handles the AJAX request to create a post.
	 *
	 * This function processes the form submission and creates a new post.
	 *
	 * @since    1.0.0
	 */
	public function fps_create_post_callback()
	{
		// check_ajax_referer('fps_create_post_nonce', 'nonce');

		if (isset($_POST) && isset($_POST['fps_post_builder_nonce'])  && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['fps_post_builder_nonce'])), 'fps_post_builder')) {
			
			$post_title = isset($_POST['fps_post_title']) && !empty($_POST['fps_post_title']) ? sanitize_text_field(wp_unslash($_POST['fps_post_title'])) : 'Demo Post';
			$post_content =  isset($_POST['fps_post_content']) && !empty($_POST['fps_post_content']) ?  sanitize_textarea_field(wp_unslash($_POST['fps_post_content'])) : '';
			$post_type =  isset($_POST['fps_post_type']) && !empty($_POST['fps_post_type']) ?   sanitize_text_field(wp_unslash($_POST['fps_post_type'])) : '';
			$post_status =  isset($_POST['fps_post_status']) && !empty($_POST['fps_post_status']) ?   sanitize_text_field(wp_unslash($_POST['fps_post_status'])) : '';

			if (empty($post_title) || empty($post_content)) {
				wp_send_json_error(array('message' => __('Title and content are required.', 'frontend-post-builder')));
				wp_die();
			}

			$post_data = array(
				'post_title' => $post_title,
				'post_content' => $post_content,
				'post_type' => $post_type,
				'post_status' => $post_status,
				'post_author' => get_current_user_id(),
			);

			$post_id = wp_insert_post($post_data);

			if (is_wp_error($post_id)) {
				wp_send_json_error(array('message' => __('Failed to create post.', 'frontend-post-builder')));
			} else {
				wp_send_json_success(array('message' => __('Post created successfully.', 'frontend-post-builder'), 'post_id' => $post_id));
			}
		}
		wp_die();
	}
}
