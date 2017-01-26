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
class WC_Pagarme_Receiver_Account{
	
	/**
	 * Constructor for the gateway.
	 */
	public function __construct() {

		// Set the API.
		$this->api = new WC_Pagarme_API( $this );

		add_action( 'profile_update',  array( $this, 'receiver_account' ) , 10, 2 );
	}

	//Receiver Account
	public function receiver_account( ){	

		$user_id = get_current_user_id();

		if( $this->create_bank_account( $user_id ) ) 
			$this->create_receiver( $user_id );
	}

	//Create Bank Account
	public function create_bank_account( $user_id ) {

		$data = array(
			'bank_code'    		=> get_user_meta( $user_id, 'bank_code', true ),
			'agencia'    		=> get_user_meta( $user_id, 'agencia' , true),
			'agencia_dv'    	=> get_user_meta( $user_id, 'agencia_dv', true ),
			'conta'    			=> get_user_meta( $user_id, 'conta' , true),
			'conta_dv'    		=> get_user_meta( $user_id, 'conta_dv' , true),
			'type'    			=> get_user_meta( $user_id, 'type', true ),
			'document_number'   => get_user_meta( $user_id, 'document_number', true ),
			'legal_name'    	=> get_user_meta( $user_id, 'legal_name', true ),
		);

		$response = $this->api->create_bank_account( $data );

		//Update User Meta Id Account Bank
		update_usermeta( $user_id, 'bank_account_id', $response->id );

		return $response = true;
	}

	//Create Receiver
	public function create_receiver( $user_id ){	

		$data = array(
			'transfer_interval'    				=> get_user_meta( $user_id, 'transfer_interval', true ),
			'transfer_day'    					=> get_user_meta( $user_id, 'transfer_day' , true),
			'transfer_enabled'    				=> get_user_meta( $user_id, 'transfer_enabled', true ),
			'automatic_anticipation_enabled'    => get_user_meta( $user_id, 'automatic_anticipation_enabled' , true),
			'anticipatable_volume_percentage'   => get_user_meta( $user_id, 'anticipatable_volume_percentage' , true),
			'bank_account_id'   				=> get_user_meta( $user_id, 'bank_account_id' , true),
		);

		$response = $this->api->create_receiver( $data );

		//Update User Meta Id Receiver
		update_usermeta( $user_id, 'receiver_id', $response->id );
	}
	

	//Updating Receiver
	public function updating_receiver( $user_id ) {

		$data = array(
			'transfer_interval'    				=> get_user_meta( $user_id, 'transfer_interval', true ),
			'transfer_day'    					=> get_user_meta( $user_id, 'transfer_day' , true),
			'transfer_enabled'    				=> get_user_meta( $user_id, 'transfer_enabled', true ),
			'automatic_anticipation_enabled'    => get_user_meta( $user_id, 'automatic_anticipation_enabled' , true),
			'anticipatable_volume_percentage'   => get_user_meta( $user_id, 'anticipatable_volume_percentage' , true),
			'anticipatable_volume_percentage'   => get_user_meta( $user_id, 'anticipatable_volume_percentage', true ),
			'bank_account_id'   				=> get_user_meta( $user_id, 'bank_account_id', true ),
			'bank_account[bank_code]'    		=> get_user_meta( $user_id, 'bank_code', true ),
			'bank_account[agencia]'    			=> get_user_meta( $user_id, 'agencia' , true),
			'bank_account[agencia_dv]'    		=> get_user_meta( $user_id, 'agencia_dv', true ),
			'bank_account[conta]'    			=> get_user_meta( $user_id, 'conta' , true),
			'bank_account[conta_dv]'    		=> get_user_meta( $user_id, 'conta_dv' , true),
			'bank_account[type]'    			=> get_user_meta( $user_id, 'type', true ),
			'bank_account[document_number]'   	=> get_user_meta( $user_id, 'document_number', true ),
			'bank_account[legal_name]'    		=> get_user_meta( $user_id, 'legal_name', true ),
		);	

		$response = $this->api->updating_receiver( $user_id, $data );

		//Update User Meta Id receiver
		update_usermeta( $user_id, 'receiver_id', $response->id );
	}
}
new WC_Pagarme_Receiver_Account( );