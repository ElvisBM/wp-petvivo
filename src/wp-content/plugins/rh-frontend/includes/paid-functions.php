<?php

/**
 * Register the custom product type after init
 */
function register_package_product_type() {
	
	require_once plugin_dir_path( __FILE__ ) . 'class-paid-wc-product.php';
	
}
add_action( 'plugins_loaded', 'register_package_product_type' );

/**
 * Add to product type drop down.
 */
function add_package_product( $types ){

	$types[ 'rh-submit-package' ] = __( 'Paid Submit Package' );
	return $types;

}
add_filter( 'product_type_selector', 'add_package_product' );

/**
 * Show pricing fields for post_package product.
 */
function post_package_custom_js() {

	if ( 'product' !== get_post_type() ) 
		return;
?>
	<script type='text/javascript'>
	// SPECIFIC OPTIONS for rh-submit-package
	jQuery( 'select#product-type' ).change( function () {
		var select_val = jQuery( this ).val();
		if ( 'rh-submit-package' === select_val ) {
			jQuery( '.type_box label[for="_virtual"]' ).addClass( 'show_if_rh-submit-package' ).show();
			jQuery( 'input#_virtual' ).prop( 'checked', true );
			jQuery( 'input#_virtual' ).prop({disabled: true});
			jQuery( '.options_group.pricing' ).addClass( 'show_if_rh-submit-package' ).show();
		} 
		jQuery( document.body ).trigger( 'woocommerce-product-type-change', select_val, jQuery( this ) );
	}).change();
	</script>
<?php
}
add_action( 'admin_footer', 'post_package_custom_js' ); 

/**
 * Add a custom product tab.
 */
function custom_product_tabs( $tabs) {

	$tabs['rh-submit-package'] = array(
		'label' => __( 'Package Options', 'woocommerce' ),
		'target'	=> 'package_options',
		'class' => array( 'show_if_rh-submit-package' ),
	);

	return $tabs;

}
add_filter( 'woocommerce_product_data_tabs', 'custom_product_tabs' );


/**
 * Contents of the Package options product tab.
 */
function package_options_product_tab_content() {

	global $woocommerce, $post;

	?><div id='package_options' class='panel woocommerce_options_panel'><?php
		?><div class='options_group'><?php

			woocommerce_wp_text_input( array(
				'id' => '_number_post_package',
				'label' => __( "Number of posts", "wpfepp-plugin" ),
				'desc_tip'	=> 'true',
				'description'	=> __( "Enter the number of posts that owns the package.", "wpfepp-plugin" ),
				'type' => 'number',
				'class' => 'short',
				'custom_attributes' => array(
					'step' => '1',
					'min' => '1'
				) ) );

			woocommerce_wp_text_input( array(
				'id' => '_expire_post_package',
				'label' => __( "Period of days", "wpfepp-plugin" ),
				'desc_tip' => 'true',
				'description'	=> __( "E.g. 30, 45...", "wpfepp-plugin" ),
				'type' => 'number',
				'class' => 'short',
				'custom_attributes' => array(
					'step' => '1',
					'min' => '0'
				) ) );
				
			woocommerce_wp_text_input( array(
				'id' => '_form_id_package',
				'label' => __( "Paid Form ID", "wpfepp-plugin" ),
				'desc_tip' => 'true',
				'description'	=> __( "Enter the form ID that owns the package.", "wpfepp-plugin" ),
				'type' => 'number',
				'class' => 'short',
				'custom_attributes' => array(
					'step' => '1',
					'min' => '1'
				) ) );

		?></div>
	</div><?php

}
add_action( 'woocommerce_product_data_panels', 'package_options_product_tab_content' );

/**
 * Save the Package option fields.
 */
function save_package_option_field( $post_id ) {

	if ( isset( $_POST['_number_post_package'] ) ) {
		update_post_meta( $post_id, '_number_post_package', sanitize_text_field( $_POST['_number_post_package'] ) );
	}
		
	if ( isset( $_POST['_expire_post_package'] ) ) {
		update_post_meta( $post_id, '_expire_post_package', sanitize_text_field( $_POST['_expire_post_package'] ) );
	}
	
	if ( isset( $_POST['_form_id_package'] ) ) {
		update_post_meta( $post_id, '_form_id_package', sanitize_text_field( $_POST['_form_id_package'] ) );
	}

}
add_action( 'woocommerce_process_product_meta_rh-submit-package', 'save_package_option_field' );


/**
 * Hide Attributes data panel.
 */
function hide_attributes_data_panel( $tabs) {

	$tabs['attribute']['class'][] = 'hide_if_rh-submit-package';
	$tabs['shipping']['class'][] = 'hide_if_rh-submit-package';

	return $tabs;

}
add_filter( 'woocommerce_product_data_tabs', 'hide_attributes_data_panel', 10, 1 );

/**
 *
 */
function add_user_order_package( $order_id, $status ) {
	
	if ( $status && $status == 'completed' ) {
		
		$order = new WC_Order( $order_id );
		$items = $order->get_items();
		$user_id = $order->user_id;
		$completed_timestamp = strtotime( $order->completed_date );
		$number_post_package = $expire_post_package = 0;
		$number_post_package_array = $expire_post_package_array = array();
		
		if ( $items ) {
			
			foreach( $items as $item ) {
				$product_id = $item['product_id'];
				$qty = (int) $item['qty'];
				
				$paid_form_id = get_post_meta( $product_id, '_form_id_package', true );
				if ( !$paid_form_id or $paid_form_id <= 0 )
					continue;
				
				$get_number_post_package = get_post_meta( $product_id, '_number_post_package', true );
				
				if ( !empty( $get_number_post_package ) && $qty >= 1 ) {
					$get_number_post_package = $get_number_post_package * $qty;
					$number_post_package_array[$paid_form_id] += $get_number_post_package;
				}

				$get_expire_post_package = get_post_meta( $product_id, '_expire_post_package', true );
				
				if ( !empty( $get_expire_post_package ) && $qty >= 1 ) {
					$expire_post_package_secs = $get_expire_post_package * $qty * 86400;
					$expire_post_package_array[$paid_form_id] += $expire_post_package_secs;
				}
					
			}
			
			foreach ( $number_post_package_array as $paid_form_id => $number_post_package ) {
				$user_numb_post_meta = '_numb_post_package_'. $paid_form_id;
				$current_number_post_package = get_user_meta( $user_id, $user_numb_post_meta, true );
				
				if ( !empty( $current_number_post_package ) ) {
					$number_post_package += $current_number_post_package;
				}
				update_user_meta( $user_id, $user_numb_post_meta, $number_post_package );
			}
			
			foreach ( $expire_post_package_array as $paid_form_id => $expire_post_package ) {
				$user_post_package_meta = '_exp_post_package_'. $paid_form_id;
				$current_expire_post_package = get_user_meta( $user_id, $user_post_package_meta, true );
				
				if ( !empty( $current_expire_post_package ) ) {
					$expire_post_package += $current_expire_post_package;
				} else {
					$expire_post_package += $completed_timestamp;
				}
				update_user_meta( $user_id, $user_post_package_meta, $expire_post_package );
			}
		}
	}
}
add_action( 'woocommerce_order_edit_status', 'add_user_order_package', 10, 2 );

/**
 *
 */
function eject_ordered_number_post( $ID, $post ) {
	
	$paid_form_id = get_post_meta( $ID, '_wpfepp_paid_post', true );
	if ( !$paid_form_id or $paid_form_id <= 0 )
		return;
	
	$user_numb_post_meta = '_numb_post_package_'. $paid_form_id;
	$author_number_post_package = get_user_meta( $post->post_author, $user_numb_post_meta, true );
	
	if ( !$author_number_post_package or $author_number_post_package <= 0 ) {
		return;
		
	} else {
		$author_number_post_package = $author_number_post_package - 1;
		update_user_meta( $post->post_author, $user_numb_post_meta, $author_number_post_package );	
	}
}
add_action( 'publish_post', 'eject_ordered_number_post', 10, 2 );