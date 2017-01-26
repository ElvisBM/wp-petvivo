<?php
/**
 * Pagar.me Credit Card gateway
 *
 * @package WooCommerce_Pagarme/Gateway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WC_Pagarme_Split class.
 *
 * @extends WC_Payment_Gateway
 */
class WC_Pagarme_Split extends WC_Payment_Gateway {

	/**
	 * Constructor for the gateway.
	 */
	public function __construct() {
		$this->id                   = 'pagarme-split';
		//$this->icon                 = apply_filters( 'wc_pagarme_credit_card_icon', false );
		$this->has_fields           = true;
		$this->method_title         = __( 'Pagar.me - Split', 'woocommerce-pagarme_registration_receiver' );
		$this->method_description   = __( 'Accept credit card payments using Pagar.me.', 'woocommerce-pagarme_registration_receiver' );
		$this->view_transaction_url = 'https://dashboard.pagar.me/#/transactions/%s';

		// Load the form fields.
		$this->init_form_fields();

		// Load the settings.
		$this->init_settings();

		// Define user set variables.
		$this->title                = $this->get_option( 'title' );
		$this->description          = $this->get_option( 'description' );
		$this->api_key              = $this->get_option( 'api_key' );
		$this->encryption_key       = $this->get_option( 'encryption_key' );
		$this->debug                = $this->get_option( 'debug' );

		// Active logs.
		if ( 'yes' === $this->debug ) {
			$this->log = new WC_Logger();
		}

		// Set the API.
		$this->api = new WC_Pagarme_Receiver_API( $this );
	
		// Actions.
		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'checkout_scripts' ) );
		add_action( 'woocommerce_thankyou_' . $this->id, array( $this, 'thankyou_page' ) );
		add_action( 'woocommerce_email_after_order_table', array( $this, 'email_instructions' ), 10, 3 );
		add_action( 'woocommerce_api_wc_pagarme_split', array( $this, 'ipn_handler' ) );
	}

	/**
	 * Admin page.
	 */
	public function admin_options() {
		include dirname( __FILE__ ) . '/../admin/views/html-admin-page.php';
	}

	/**
	 * Check if the gateway is available to take payments.
	 *
	 * @return bool
	 */
	public function is_available() {
		//return parent::is_available() && ! empty( $this->api_key ) && ! empty( $this->encryption_key ) && $this->api->using_supported_currency();
	}

	/**
	 * Settings fields.
	 */
	public function init_form_fields() {
		$this->form_fields = array(
			'enabled' => array(
				'title'   => __( 'Enable/Disable', 'woocommerce-pagarme_registration_receiver' ),
				'type'    => 'checkbox',
				'label'   => __( 'Enable Pagar.me Credit Card', 'woocommerce-pagarme_registration_receiver' ),
				'default' => 'no',
			),
			'title' => array(
				'title'       => __( 'Title', 'woocommerce-pagarme_registration_receiver' ),
				'type'        => 'text',
				'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce-pagarme_registration_receiver' ),
				'desc_tip'    => true,
				'default'     => __( 'Credit Card', 'woocommerce-pagarme_registration_receiver' ),
			),
			'description' => array(
				'title'       => __( 'Description', 'woocommerce-pagarme_registration_receiver' ),
				'type'        => 'textarea',
				'description' => __( 'This controls the description which the user sees during checkout.', 'woocommerce-pagarme_registration_receiver' ),
				'desc_tip'    => true,
				'default'     => __( 'Pay with Credit Card', 'woocommerce-pagarme_registration_receiver' ),
			),
			'api_key' => array(
				'title'             => __( 'Pagar.me API Key', 'woocommerce-pagarme_registration_receiver' ),
				'type'              => 'text',
				'description'       => sprintf( __( 'Please enter your Pagar.me API Key. This is needed to process the payment and notifications. Is possible get your API Key in %s.', 'woocommerce-pagarme_registration_receiver' ), '<a href="https://dashboard.pagar.me/">' . __( 'Pagar.me Dashboard > My Account page', 'woocommerce-pagarme_registration_receiver' ) . '</a>' ),
				'default'           => '',
				'custom_attributes' => array(
					'required' => 'required',
				),
			),
			'encryption_key' => array(
				'title'             => __( 'Pagar.me Encryption Key', 'woocommerce-pagarme_registration_receiver' ),
				'type'              => 'text',
				'description'       => sprintf( __( 'Please enter your Pagar.me Encryption key. This is needed to process the payment. Is possible get your Encryption Key in %s.', 'woocommerce-pagarme_registration_receiver' ), '<a href="https://dashboard.pagar.me/">' . __( 'Pagar.me Dashboard > My Account page', 'woocommerce-pagarme_registration_receiver' ) . '</a>' ),
				'default'           => '',
				'custom_attributes' => array(
					'required' => 'required',
				),
			)
		);
	}

	/**
	 * Checkout scripts.
	 */
	public function checkout_scripts() {
		if ( is_checkout() ) {
			
		}
	}

	/**
	 * Payment fields.
	 */
	public function payment_fields() {
	}

	/**
	 * Process the payment.
	 *
	 * @param int $order_id Order ID.
	 *
	 * @return array Redirect data.
	 */
	public function process_payment( $order_id ) {
		//return $this->api->process_regular_payment( $order_id );
	}

	/**
	 * Thank You page message.
	 *
	 * @param int $order_id Order ID.
	 */
	public function thankyou_page( $order_id ) {
		// $order = wc_get_order( $order_id );
		// $data  = get_post_meta( $order_id, '_wc_pagarme_transaction_data', true );

		// if ( isset( $data['installments'] ) && in_array( $order->get_status(), array( 'processing', 'on-hold' ), true ) ) {
		// 	wc_get_template(
		// 		'credit-card/payment-instructions.php',
		// 		array(
		// 			'card_brand'   => $data['card_brand'],
		// 			'installments' => $data['installments'],
		// 		),
		// 		'woocommerce/pagarme/',
		// 		WC_Pagarme::get_templates_path()
		// 	);
		//}
	}

	/**
	 * Add content to the WC emails.
	 *
	 * @param  object $order         Order object.
	 * @param  bool   $sent_to_admin Send to admin.
	 * @param  bool   $plain_text    Plain text or HTML.
	 *
	 * @return string                Payment instructions.
	 */
	public function email_instructions( $order, $sent_to_admin, $plain_text = false ) {
		// if ( $sent_to_admin || ! in_array( $order->get_status(), array( 'processing', 'on-hold' ), true ) || $this->id !== $order->payment_method ) {
		// 	return;
		// }

		// $data = get_post_meta( $order->id, '_wc_pagarme_transaction_data', true );

		// if ( isset( $data['installments'] ) ) {
		// 	$email_type = $plain_text ? 'plain' : 'html';

		// 	wc_get_template(
		// 		'credit-card/emails/' . $email_type . '-instructions.php',
		// 		array(
		// 			'card_brand'   => $data['card_brand'],
		// 			'installments' => $data['installments'],
		// 		),
		// 		'woocommerce/pagarme/',
		// 		WC_Pagarme::get_templates_path()
		// 	);
		// }
	}

	/**
	 * IPN handler.
	 */
	public function ipn_handler() {
		$this->api->ipn_handler();
	}
}
