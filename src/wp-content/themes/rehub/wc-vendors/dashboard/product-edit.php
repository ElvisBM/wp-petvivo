<?php
/**
 * The template for displaying the Product edit form  
 *
 * Override this template by copying it to yourtheme/wc-vendors/dashboard/
 *
 * @package    WCVendors_Pro
 * @version    1.3.2
 */
/**
 *   DO NOT EDIT ANY OF THE LINES BELOW UNLESS YOU KNOW WHAT YOU'RE DOING 
 *   
*/

$title = 	( is_numeric( $object_id ) ) ? __('Save Changes', 'wcvendors-pro') : __('Add Product', 'wcvendors-pro'); 
$product = 	( is_numeric( $object_id ) ) ? wc_get_product( $object_id ) : null;

// Get basic information for the product 
$product_title     			= ( isset($product) && null !== $product ) ? $product->post->post_title    : ''; 
$product_description        = ( isset($product) && null !== $product ) ? $product->post->post_content  : ''; 
$product_short_description  = ( isset($product) && null !== $product ) ? $product->post->post_excerpt  : ''; 
$post_status				= ( isset($product) && null !== $product ) ? $product->post->post_status   : ''; 

/**
 *  Ok, You can edit the template below but be careful!
*/
?>
<div id="add-product">

<h3><?php echo $title; ?></h3>
<a class="btn-voltar" href="..">Sair</a>

<!-- Product Edit Form -->
<form method="post" action="" id="wcv-product-edit" class="wcv-form wcv-formvalidator"> 

	<!-- Basic Product Details -->
	<div class="wcv-product-basic wcv-product"> 
		
		<div id="name-product">
			<!-- Product Title -->
			<?php WCVendors_Pro_Product_Form::title( $object_id, $product_title ); ?>
		</div>
		<div id="description-product">
			<!-- Product Description -->
			<?php WCVendors_Pro_Product_Form::description( $object_id, $product_description );  ?>
		</div>
		<!-- Product Short Description -->
		<?php WCVendors_Pro_Product_Form::short_description( $object_id, $product_short_description );  ?>
		<div id="category-product">
		<!-- Product Categories -->
	    <?php WCVendors_Pro_Product_Form::categories( $object_id, true ); ?>
	    </div>
	    <div id="tags-product">
	    <!-- Product Tags -->
	    <?php WCVendors_Pro_Product_Form::tags( $object_id, true ); ?>
	    </div>

		<div class="show_if_simple show_if_external prices">
			<!-- Price and Sale Price -->
			<?php WCVendors_Pro_Product_Form::prices( $object_id ); ?>
		</div>
		<div class="tempo-producao">
			<?php 
				WCVendors_Pro_Form_Helper::input( array(  
				     'type'      => 'text',
				     'post_id'   => $object_id, 
				     'id'     => 'wcv_custom_product_producao', 
				     'label'    => __( 'Tempo de produção', 'wcvendors-pro' ), 
				     'placeholder'   => __( 'Tempo de produção', 'wcvendors-pro' ), 
				     'desc_tip'    => 'true', 
				     'description'   => __( 'Tempo de produção', 'wcvendors-pro' ), 
				) );
			?>
		</div>
	</div>

	<div class="all-100"> 
    	<!-- Media uploader -->
		<div class="wcv-product-media">
			<?php WCVendors_Pro_Form_helper::product_media_uploader( $object_id ); ?>
		</div>
	</div>

	<hr />
	
	<div class="all-100">
		<!-- Product Type -->
		<div class="wcv-product-type"> 
			<?php WCVendors_Pro_Product_Form::product_type( $object_id ); ?>
		</div>
	</div>

	<div class="all-100">
		<div class="wcv-tabs top" data-prevent-url-change="true">

			<?php WCVendors_Pro_Product_Form::product_meta_tabs( ); ?>

			<?php do_action( 'wcv_before_general_tab', $object_id ); ?>
	
			<!-- General Product Options -->
			<div class="wcv-product-general tabs-content" id="general">
			
				<div class="hide_if_grouped">
					<!-- SKU  -->
					<?php WCVendors_Pro_Product_Form::sku( $object_id ); ?>
					<!-- Private listing  -->
					<?php WCVendors_Pro_Product_Form::private_listing( $object_id ); ?>
				</div>

		
				<div class="options_group show_if_external external_url">
					<?php WCVendors_Pro_Product_Form::external_url( $object_id ); ?>
					<?php WCVendors_Pro_Product_Form::button_text( $object_id ); ?>
				</div>

				<div class="show_if_simple show_if_external show_if_variable"> 
					<!-- Tax -->
					<?php WCVendors_Pro_Product_Form::tax( $object_id ); ?>
				</div>

				<div class="show_if_downloadable" id="files_download">
					<!-- Downloadable files -->
					<?php WCVendors_Pro_Product_Form::download_files( $object_id ); ?>
					<!-- Download Limit -->
					<?php WCVendors_Pro_Product_Form::download_limit( $object_id ); ?>
					<!-- Download Expiry -->
					<?php WCVendors_Pro_Product_Form::download_expiry( $object_id ); ?>
					<!-- Download Type -->
					<?php WCVendors_Pro_Product_Form::download_type( $object_id ); ?>
				</div>
			</div>

			<?php do_action( 'wcv_after_general_tab', $object_id ); ?>

			<?php do_action( 'wcv_before_inventory_tab', $object_id ); ?>

			<!-- Inventory -->
			<div class="wcv-product-inventory inventory_product_data tabs-content" id="inventory">
				<h3>Estoque</h3>
				
				<?php WCVendors_Pro_Product_Form::manage_stock( $object_id ); ?>
				
				<?php do_action( 'wcv_product_options_stock' ); ?>
				
				<div class="stock_fields show_if_simple show_if_variable">
					<?php WCVendors_Pro_Product_Form::stock_qty( $object_id ); ?>
					<?php WCVendors_Pro_Product_Form::backorders( $object_id ); ?>
				</div>

				<?php WCVendors_Pro_Product_Form::stock_status( $object_id ); ?>
				<div class="options_group show_if_simple show_if_variable">
					<?php WCVendors_Pro_Product_Form::sold_individually( $object_id ); ?>
				</div>

				<?php do_action( 'wcv_product_options_sold_individually' ); ?>

				<?php do_action( 'wcv_product_options_inventory_product_data' ); ?>

			</div>

			<?php do_action( 'wcv_after_inventory_tab', $object_id ); ?>

			<?php do_action( 'wcv_before_shipping_tab', $object_id ); ?>

			<!-- Shipping  -->
			<div class="wcv-product-shipping shipping_product_data tabs-content" id="shipping">

				<div class="hide_if_grouped hide_if_external">
					<h3>Entrega</h3>
					<p>Caso esse produto tenha regiões de entrega diferente da loja, defina as regiões específica para este produto.</p>

					<!-- Shipping rates  -->
					<?php WCVendors_Pro_Product_Form::shipping_rates( $object_id ); ?>	
					<!-- weight  -->
					<?php //WCVendors_Pro_Product_Form::weight( $object_id ); ?>
					<!-- Dimensions -->
					<?php //WCVendors_Pro_Product_Form::dimensions( $object_id ); ?>
					<?php do_action( 'wcv_product_options_dimensions' ); ?>
					<!-- shipping class -->
					<?php //WCVendors_Pro_Product_Form::shipping_class( $object_id ); ?>
					<?php do_action( 'wcv_product_options_shipping' ); ?>
				</div>
			
			</div>

			<?php do_action( 'wcv_after_shipping_tab', $object_id ); ?>

			<?php do_action( 'wcv_before_linked_tab', $object_id ); ?>

			<!-- Upsells and grouping -->
			<div class="wcv-product-upsells tabs-content" id="linked_product"> 

				<?php WCVendors_Pro_Product_Form::up_sells( $object_id ); ?>
				
				<?php WCVendors_Pro_Product_Form::crosssells( $object_id ); ?>

				<div class="hide_if_grouped hide_if_external">

					<?php WCVendors_Pro_Product_Form::grouped_products( $object_id, $product ); ?>

				</div>
			</div>

			<?php do_action( 'wcv_after_linked_tab', $object_id ); ?>

			<!-- Attributes -->

			<?php do_action( 'wcv_before_attributes_tab', $object_id ); ?>

			<div class="wcv_product_attributes tabs-content" id="attributes"> 
				<p> Adicione atributos em seu produto para personalizar ainda mais e criar variações do mesmo produto, ex: Quantidade: 50 | 100 | 150</p>

				<?php WCVendors_Pro_Product_Form::product_attributes( $object_id ); ?>

			</div>
			
			<?php do_action( 'wcv_after_attributes_tab', $object_id ); ?>

			<!-- Variations -->

			<?php do_action( 'wcv_before_variations_tab', $object_id ); ?>

			<div class="wcv_product_variations tabs-content" id="variations">
				<p> Adicione as variações do produto, definindo o valor, imagem, quantidade em estoque, peso e dimensões para variação do produto disponivel.</p> 

				<?php WCVendors_Pro_Product_Form::product_variations( $object_id ); ?>

			</div>

			<?php do_action( 'wcv_after_variations_tab', $object_id ); ?>

			<?php WCVendors_Pro_Product_Form::form_data( $object_id, $post_status ); ?>
			<?php WCVendors_Pro_Product_Form::save_button( $title ); ?>
			<?php WCVendors_Pro_Product_Form::draft_button( __('Save Draft','wcvendors-pro') ); ?>

			</div>
		</div>
</form>
</div>