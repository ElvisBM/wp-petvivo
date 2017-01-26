<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       www.elvisbmartins.com.br
 * @since      1.0.0
 *
 * @package    Woocommerce_pagarme_registration_receiver
 * @subpackage Woocommerce_pagarme_registration_receiver/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<h3><?php echo esc_html( $this->method_title ); ?></h3>

<?php
if ( 'yes' === $this->get_option( 'enabled' ) ) {
	// if ( ! $this->api->using_supported_currency() && ! class_exists( 'woocommerce_wpml' ) ) {
	// 	include dirname( __FILE__ ) . '/html-notice-currency-not-supported.php';
	// }
}
?>

<?php echo wp_kses_post( wpautop( $this->method_description ) ); ?>

<table class="form-table">
	<?php $this->generate_settings_html(); ?>
</table>
