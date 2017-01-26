<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.elvisbmartins.com.br
 * @since             1.0.0
 * @package           Woocommerce_pagarme_registration_receiver
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Pagar.me Registration Receiver
 * Plugin URI:        https://github.com/ElvisBM/woocommerce-pagarme-registration-receiver
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Elvis B. Martins
 * Author URI:        www.elvisbmartins.com.br
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce_pagarme_registration_receiver
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce_pagarme_registration_receiver-activator.php
 */
function activate_woocommerce_pagarme_registration_receiver() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce_pagarme_registration_receiver-activator.php';
	Woocommerce_pagarme_registration_receiver_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce_pagarme_registration_receiver-deactivator.php
 */
function deactivate_woocommerce_pagarme_registration_receiver() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce_pagarme_registration_receiver-deactivator.php';
	Woocommerce_pagarme_registration_receiver_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woocommerce_pagarme_registration_receiver' );
register_deactivation_hook( __FILE__, 'deactivate_woocommerce_pagarme_registration_receiver' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce_pagarme_registration_receiver.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woocommerce_pagarme_registration_receiver() {

	$plugin = new Woocommerce_pagarme_registration_receiver();
	$plugin->run();

}
run_woocommerce_pagarme_registration_receiver();
