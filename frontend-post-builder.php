<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.example.com
 * @since             1.0.0
 * @package           Frontend_Post_Builder
 *
 * @wordpress-plugin
 * Plugin Name:       Frontend Post Builder
 * Plugin URI:        https://example.com
 * Description:       It allows users to easily submit posts or custom content from the frontend of your WordPress site. Perfect for guest blogs, user-generated content, directories, and more — all with built-in security, moderation, and customization options.
 * Version:           1.0.0
 * Author:            Muhammad Saleh
 * Author URI:        https://www.example.com/
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
