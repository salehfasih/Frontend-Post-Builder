<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/salehfasih/Frontend-Post-Builder
 * @since             1.0.0
 * @package           Frontend_Post_Builder
 *
 * @wordpress-plugin
 * Plugin Name:       Frontend Post Builder
 * Plugin URI:       https://github.com/salehfasih/Frontend-Post-Builder
 * Description:       It allows users to easily submit posts or custom content from the frontend of your WordPress site. Perfect for guest blogs, user-generated content, directories, and more — all with built-in security, moderation, and customization options.
 * Version:          1.0.0
 * Author:            Muhammad Saleh
 * Author URI:       https://github.com/salehfasih/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       frontend-post-builder
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'FRONTEND_POST_BUILDER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-frontend-post-builder-activator.php
 */
function activate_frontend_post_builder() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-frontend-post-builder-activator.php';
	Frontend_Post_Builder_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-frontend-post-builder-deactivator.php
 */
function deactivate_frontend_post_builder() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-frontend-post-builder-deactivator.php';
	Frontend_Post_Builder_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_frontend_post_builder' );
register_deactivation_hook( __FILE__, 'deactivate_frontend_post_builder' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-frontend-post-builder.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_frontend_post_builder() {

	$plugin = new Frontend_Post_Builder();
	$plugin->run();

}
run_frontend_post_builder();



// Save Form
add_action( 'admin_post_fpb_save_form', function(){
    if ( ! current_user_can('manage_options') ) wp_die('Nope');
    check_admin_referer( 'fpb_save_form','fpb_nonce' );
    $in = $_POST['fields'] ?? [];
    $out = array_map(function($f){
		// if(empty($f['type'])){
		// 	return null; // Skip empty fields
		// }
        $type = sanitize_text_field($f['type']);
        $label = sanitize_text_field($f['label']);

        return ['type'=> $type,'label'=>$label];
    }, $in);
    update_option('fpb_reg_form_fields', $out);
    wp_redirect( admin_url('admin.php?page=frontend-post-builder-register') );
    exit;
});

// Shortcode & Registration Handler
// add_shortcode('fpb_register_form', function(){

// 	$user_id= get_current_user_id();
// 	var_dump(get_user_meta($user_id));
//     if(is_user_logged_in()) return '<p>You are already registered.</p>';

//     $fields = get_option('fpb_reg_form_fields', []);
//     $out = '<form method="post">'.wp_nonce_field('fpb_front_register','fpb_front_nonce',true,false);
//     foreach($fields as $fld){
//         $name = sanitize_title($fld['label']);
//         $out .= '<p><label>'.esc_html($fld['label']).'<br>';
//         if($fld['type']==='password'){
//             $out .= '<input type="password" name="'.esc_attr($name).'" required>';
//         } else {
//             $out .= '<input type="'.esc_attr($fld['type']).'" name="'.esc_attr($name).'" required>';
//         }
//         $out .= '</label></p>';
//     }
//     $out .= '<input type="hidden" name="fpb_register_form_submit" value="1">';
//     $out .= '<p><button type="submit">Register</button></p>';
//     $out .= '</form>';

//     if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['fpb_register_form_submit'])){
//         if(!wp_verify_nonce($_POST['fpb_front_nonce'],'fpb_front_register')){
//             return '<p>Security check failed.</p>'.$out;
//         }
//         $data = [];
//         foreach($fields as $fld){
//             $key = sanitize_title($fld['label']);
//             $data[$key] = sanitize_text_field($_POST[$key] ?? '');
//         }
//         $errors = [];
//         if(empty($data['username']) || !validate_username($data['username']))
//             $errors[] = 'Invalid or missing username.';
//         if(username_exists($data['username']))
//             $errors[] = 'Username already taken.';
//         if(empty($data['email']) || !is_email($data['email']))
//             $errors[] = 'Invalid or missing email.';
//         if(email_exists($data['email']))
//             $errors[] = 'Email already registered.';
//         if(empty($data['password']))
//             $errors[] = 'Password is required.';

//         if(empty($errors)){
//             $user_id = wp_create_user($data['username'],$data['password'],$data['email']);
// 			if($user_id && !is_wp_error($user_id)){

// 				foreach($fields as $fld){
// 				$key = sanitize_title($fld['label']);
// 				update_user_meta($user_id, $key, sanitize_text_field($data[$key] ?? ''));
				
// 			}
// 			}
//             if(is_wp_error($user_id)){
//                 $errors[] = $user_id->get_error_message();
//             } else {
//                 return '<p>Registration successful! <a href="'.wp_login_url().'">Log in here</a>.</p>';
//             }
//         }
//         $out = '<div class="fpb-errors"><ul><li>'.implode('</li><li>',$errors).'</li></ul></div>'.$out;
//     }

//     return $out;
// });


