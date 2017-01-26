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
class WC_Pagarme_Bank_Account {
	

	/**
	 * Constructor for the gateway.
	 */
	public function __construct() {

		// Set the API.
		$this->api = new WC_Pagarme_Receiver_API( $this );

	}


	public function create_bank_account() {

		$data = array(
			'bank_code'    		=> "teste",
			'agencia'    		=> "teste",
			'agencia_dv'    	=> "teste",
			'conta'    			=> "teste",
			'type'    			=> "teste",
			'document_number'   => "teste",
			'legal_name'    	=> "teste",
		);

		$response = $this->api->create_bank_account( $data );

		// echo "<pre>";
		// print_r( $response  );
		// echo "</pre>";

		// die;

	}

}