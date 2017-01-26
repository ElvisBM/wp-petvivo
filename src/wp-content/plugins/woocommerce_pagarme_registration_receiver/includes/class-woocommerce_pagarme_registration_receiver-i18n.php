<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.elvisbmartins.com.br
 * @since      1.0.0
 *
 * @package    Woocommerce_pagarme_registration_receiver
 * @subpackage Woocommerce_pagarme_registration_receiver/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woocommerce_pagarme_registration_receiver
 * @subpackage Woocommerce_pagarme_registration_receiver/includes
 * @author     Elvis B. Martins <elvisbmartins@gmail.com>
 */
class Woocommerce_pagarme_registration_receiver_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woocommerce_pagarme_registration_receiver',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
