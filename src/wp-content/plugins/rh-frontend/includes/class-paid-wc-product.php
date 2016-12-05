<?php

if (class_exists('WC_Product')) {
	
	class WC_Product_Post_Package extends WC_Product {

		 public function __construct( $product ) {
			  $this->product_type = 'rh-submit-package';
			  //$this->supports[]   = 'ajax_add_to_cart';
			  parent::__construct( $product );
		 }
		 
		 public function is_virtual() {
			return true;
		 }
	}
}