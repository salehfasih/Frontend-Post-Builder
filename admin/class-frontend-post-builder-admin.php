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
		add_shortcode('fpb_register_form', [$this, 'fps_register_form_shortcode']);
		// add_filter( 'ajax_query_attachments_args', [$this, 'fpb_limit_media_library_to_user'], 10, 1 );

	}

	/**
	 * Fires before the administration menu loads in the admin.
	 *
	 * @param string $context Empty context.
	 */
	public function fps_action_admin_menu()
	{

		add_menu_page('Frontend Post', 'Frontend Post', 'manage_options', 'frontend-post-builder', [$this, 'fps_menu_callback'], 'dashicons-admin-post', 5);
		add_submenu_page('frontend-post-builder', 'Register', 'Register', 'manage_options', 'frontend-post-builder-register', [$this, 'fps_register_callback']);

	}


	public function fps_register_callback(){

		include plugin_dir_path(__FILE__). '/register/register-model.php';
	}


	/**
	 * Fires on frontend admin screen
	 * 
	 */

	public function fps_menu_callback()
	{

		include plugin_dir_path(__FILE__) . '/partials/frontend-post-builder-setting.php';
	}


	public function fpb_limit_media_library_to_user( $args ) {
    if ( current_user_can('administrator') ) {
        return $args;
    }

    $admin_users = get_users( [ 'role' => 'Administrator', 'fields' => 'ID' ] );

    if ( ! empty( $admin_users ) ) {
        $args['author__not_in'] = $admin_users;
    }

    return $args;
}


	/**
	 * Register form shortcode
	 */

	public function fps_register_form_shortcode()
	{

    if(is_user_logged_in()) return '<p>You are already registered.</p>';

    $fields = get_option('fpb_reg_form_fields', []);
    $out = '<form method="post">'.wp_nonce_field('fpb_front_register','fpb_front_nonce',true,false);
    foreach($fields as $fld){
        $name = sanitize_title($fld['label']);
        $out .= '<p><label>'.esc_html($fld['label']).'<br>';
        if($fld['type']==='password'){
            $out .= '<input type="password" name="'.esc_attr($name).'" required>';
        } else {
            $out .= '<input type="'.esc_attr($fld['type']).'" name="'.esc_attr($name).'" required>';
        }
        $out .= '</label></p>';
    }
    $out .= '<input type="hidden" name="fpb_register_form_submit" value="1">';
    $out .= '<p><button type="submit">Register</button></p>';
    $out .= '</form>';

    if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['fpb_register_form_submit'])){
        if(!wp_verify_nonce($_POST['fpb_front_nonce'],'fpb_front_register')){
            return '<p>Security check failed.</p>'.$out;
        }
        $data = [];
        foreach($fields as $fld){
            $key = sanitize_title($fld['label']);
            $data[$key] = sanitize_text_field($_POST[$key] ?? '');
        }
        $errors = [];
        if(empty($data['username']) || !validate_username($data['username']))
            $errors[] = 'Invalid or missing username.';
        if(username_exists($data['username']))
            $errors[] = 'Username already taken.';
        if(empty($data['email']) || !is_email($data['email']))
            $errors[] = 'Invalid or missing email.';
        if(email_exists($data['email']))
            $errors[] = 'Email already registered.';
        if(empty($data['password']))
            $errors[] = 'Password is required.';

        if(empty($errors)){
            $user_id = wp_create_user($data['username'],$data['password'],$data['email']);
			if($user_id && !is_wp_error($user_id)){

				foreach($fields as $fld){
				$key = sanitize_title($fld['label']);
				update_user_meta($user_id, $key, sanitize_text_field($data[$key] ?? ''));
				
			}
			}
            if(is_wp_error($user_id)){
                $errors[] = $user_id->get_error_message();
            } else {
                return '<p>Registration successful! <a href="'.wp_login_url().'">Log in here</a>.</p>';
            }
        }
        $out = '<div class="fpb-errors"><ul><li>'.implode('</li><li>',$errors).'</li></ul></div>'.$out;
    }

    return $out;
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
