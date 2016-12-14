<?php
/*
Plugin Name: RH Frontend Publishing Pro
Plugin URI: https://bitbucket.org/bizdirect/rehub-frontend-pro
Description: Allow your users to create, edit and delete posts directly from the WordPress frontend area.
Version: 3.3.0.4
Author: Wpsoul.com
Author URI: http://wpsoul.com
Text Domain: wpfepp-plugin
Domain Path: /languages/
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}
if( ! defined( 'WPFEPP_SLUG' ) ){
	define( 'WPFEPP_SLUG', 'rh-frontend' );
}
if( ! defined( 'WPFEPP_FILE' ) ){
	define( 'WPFEPP_FILE', __FILE__ );
}
if( ! defined( 'WPFEPP_REPO' ) ){
	define( 'WPFEPP_REPO', 'http://rehub.wpsoul.com/plugins/' );
}

require_once 'includes/class-frontend-publishing-pro.php';
include('includes/global-functions.php');

$data_settings = get_option('wpfepp_payment_settings');
if( $data_settings && $data_settings['turn_on_payment'] ){
	include('includes/paid-functions.php');
}

function wpfepp_run_plugin() {
	$wpfepp = new Frontend_Publishing_Pro( "3.3.0.4" );
	$wpfepp->run();
}

wpfepp_run_plugin();
wpfepp_check_update();

/**
 * Loads the plugin's text domain for localization.
 */
function wpfepp_load_plugin_textdomain() {
	load_plugin_textdomain( 'wpfepp-plugin', FALSE, basename( dirname( WPFEPP_FILE ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'wpfepp_load_plugin_textdomain' );

/**
 * Uses do_action to run plugin activation and initialization functions.
 */
function wpfepp_activation(){
	do_action('wpfepp_activation');
}
register_activation_hook( WPFEPP_FILE, 'wpfepp_activation' );

/**
 * Uses do_action to run hooked functions when plugin is uninstalled.
 */
function wpfepp_uninstall(){
	do_action('wpfepp_uninstall');
}
register_uninstall_hook( WPFEPP_FILE, 'wpfepp_uninstall' );

?>