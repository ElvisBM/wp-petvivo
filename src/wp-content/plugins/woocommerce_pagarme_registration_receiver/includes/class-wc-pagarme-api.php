<?php
/**
 * Pagar.me API
 *
 * @package WooCommerce_Pagarme/API
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WC_Pagarme_API class.
 */
class WC_Pagarme_Receiver_API{


	
	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://api.pagar.me/1/';


	/**
	 * Get API URL.
	 *	
	 * @return string
	 */
	public function get_api_url() {
		return $this->api_url;
	}


	public function create_bank_account( $data  ) {

		//$data['api_key'] = $this->gateway->api_key;

		$response = $this->do_request( 'bank_accounts', 'POST', $data );

		return $post;

	}

	// public function create_user_receiver( $data  ) {

	// 	$data = array(
	// 		'api_key'      		         		=> $this->gateway->api_key,
	// 		'transfer_interval'    		 		=> $order->get_total() * 100,
	// 		'transfer_day'    		 	 		=> $order->get_total() * 100,
	// 		'transfer_enabled'    				=> $order->get_total() * 100,
	// 		'automatic_anticipation_enabled'    => $order->get_total() * 100,
	// 		'anticipatable_volume_percentage'   => $order->get_total() * 100,
	// 		'bank_account_id'   				=> $order->get_total() * 100,
	// 	);

	// 	$response = $this->do_request( 'recipients', 'POST', $data );

	// 	//Create Field User user_receiver_id

	// }

	protected function do_request( $endpoint, $method = 'POST', $data = array(), $headers = array() ) {
		$params = array(
			'method'  => $method,
			'timeout' => 60,
		);

		if ( ! empty( $data ) ) {
			$params['body'] = $data;
		}

		if ( ! empty( $headers ) ) {
			$params['headers'] = $headers;
		}

		return wp_safe_remote_post( $this->get_api_url() . $endpoint, $params );
	}

}