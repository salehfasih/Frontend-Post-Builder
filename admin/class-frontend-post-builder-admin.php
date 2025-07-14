<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/salehfasih/Frontend-Post-Builder
 * @since      1.0.0
 *
 * @package    Frontend_Post_Builder
 * @subpackage Frontend_Post_Builder/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Frontend_Post_Builder
 * @subpackage Frontend_Post_Builder/admin
 * @author     Muhammad Saleh <sfclickysoft@gmail.com>
 */
class Frontend_Post_Builder_Admin
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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action("admin_menu", [$this, 'fps_action_admin_menu']);
		add_action("init", [$this, 'fps_submmission_request']);
	}

	/**
	 * Fires before the administration menu loads in the admin.
	 *
	 * @param string $context Empty context.
	 */
	public function fps_action_admin_menu()
	{

		add_menu_page('Frontend Post', 'Frontend Post', 'manage_options', 'frontend-post-builder', [$this, 'fps_menu_callback'], 'dashicons-admin-post', 5);
		// add_submenu_page('frontend-post-builder', 'Settings', 'Settings', 'manage_options', 'frontend-post-builder-setting', [$this, 'fps_setting_callback']);

	}


	/**
	 * Fires on frontend admin screen
	 * 
	 */

	public function fps_menu_callback()
	{

		include plugin_dir_path(__FILE__) . '/partials/frontend-post-builder-setting.php';
	}

	/**
	 * Fires on frontend admin screen
	 * 
	 */

	public function fps_submmission_request()
	{

		$option_key = '_fps_post_type';

		// Handle form submission
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_type_nonce']) && !empty($_POST['post_type_nonce'])) {
			if (wp_verify_nonce(wp_unslash($_POST['post_type_nonce']), 'save_post_type')) {
				$selected_post_type =  isset($_POST['fps_post_type']) && !empty($_POST['fps_post_type']) ?   sanitize_text_field(wp_unslash($_POST['fps_post_type'])) : '';
				$fps_post_status =  isset($_POST['fps_post_status']) && !empty($_POST['fps_post_status']) ?  sanitize_text_field(wp_unslash($_POST['fps_post_status'])) : '';
				update_option($option_key, $selected_post_type);
				update_option('_fps_post_status', $fps_post_status);

				add_action('admin_notices', function () {
					echo '<div class="notice notice-success is-dismissible"><p>Settings saved successfully.</p></div>';
				});
			} else {

				add_action('admin_notices', function () {
					echo '<div class="notice notice-failure is-dismissible"><p>Settings not saved successfully.</p></div>';
				});
			}
		}
	}


	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/frontend-post-builder-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/frontend-post-builder-admin.js', array('jquery'), $this->version, false);
	}
}
