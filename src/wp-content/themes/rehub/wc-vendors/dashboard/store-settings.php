<?php
/**
 * The template for displaying the store settings form
 *
 * Override this template by copying it to yourtheme/wc-vendors/dashboard/
 *
 * @package    WCVendors_Pro
 * @version    1.3.7
 */

$settings_social 		= (array) WC_Vendors::$pv_options->get_option( 'hide_settings_social' );
$social_total 		= count( $settings_social ); 
$social_count = 0; 
foreach ( $settings_social as $value) { if ( 1 == $value ) $social_count +=1;  }

?>

<h3><a href="..">Gerenciar Loja</a> > <?php _e( 'Settings', 'wcvendors-pro' ); ?></h3>


<form method="post" action="" class="wcv-form wcv-formvalidator"> 

<?php WCVendors_Pro_Store_Form::form_data(); ?>

<div class="wcv-tabs top" data-prevent-url-change="true">

	<?php WCVendors_Pro_Store_Form::store_form_tabs( ); ?>

	<!-- Store Settings Form -->
	
	<div class="tabs-content" id="store">
		<h3>Dados da Loja</h3>

		<div class="wcv-cols-group">
			<div class="all-70 tiny-100">
				<!-- Store Name -->
				<?php WCVendors_Pro_Store_Form::store_name( $store_name ); ?>
				<?php do_action( 'wcvendors_settings_after_shop_name' ); ?>

				<!-- Company URL -->
				<?php do_action( 'wcvendors_settings_before_company_url' ); ?>
				<?php WCVendors_Pro_Store_Form::company_url( ); ?>
				<?php do_action(  'wcvendors_settings_after_company_url' ); ?>	

				<!-- Store Phone -->
				<?php do_action( 'wcvendors_settings_before_store_phone' ); ?>
				<?php WCVendors_Pro_Store_Form::store_phone( ); ?>
				<?php do_action(  'wcvendors_settings_after_store_phone' ); ?>

				<!-- Store Description -->
				<?php WCVendors_Pro_Store_Form::store_description( $store_description ); ?>	
				<?php do_action( 'wcvendors_settings_after_shop_description' ); ?>
				<br />

				<!-- Store Vacation Mode -->
				<div class="modo_ferias">
				<?php do_action( 'wcvendors_settings_before_vacation_mode' ); ?>
				<?php WCVendors_Pro_Store_Form::vacation_mode( ); ?>
				<?php do_action(  'wcvendors_settings_after_vacation_mode' ); ?>
				</div>
				<!-- Seller Info -->
				<?php //WCVendors_Pro_Store_Form::seller_info( ); ?>
				<?php //do_action( 'wcvendors_settings_after_seller_info' ); ?>
			</div>
			<div class="all-30 tiny-100">
				<div class="logo">
					<!-- Store Icon -->
					<?php WCVendors_Pro_Store_Form::store_icon( ); ?>	
					<p>Clique na imagem para altera-la<br />
						Largura, Altura: 180x180<br />
						Formato: JPEG ou PNG<br />
						Tamanho:  Até 4mb
					</p>
				</div>
			</div>
		</div>
	</div>

	<div class="tabs-content" id="payment">
		<!-- Paypal address -->
		<?php do_action( 'wcvendors_settings_before_paypal' ); ?>

		<?php //WCVendors_Pro_Store_Form::paypal_address( ); ?>

		<?php do_action( 'wcvendors_settings_after_paypal' ); ?>
	</div>

	<div class="tabs-content" id="branding">
		<div class="wcv-cols-group">
			<div class="all-30 tiny-100">
				<h3>Banner da Loja</h3>
				<p>Use sua criatividade para criar um banner com a cara da sua loja</p><br ><br >
				<p>Especificações<br>
				Largura, Altura: 1200x260<br>
				Tamanho: até 4mb<br>
				Formato: JPEG ou PNG </p><br ><br >
			</div>
			<div class="all-70 tiny-100">
					<?php do_action( 'wcvendors_settings_before_branding' ); ?>
					<!-- Store Banner -->
					<?php WCVendors_Pro_Store_Form::store_banner( ); ?>	
					<?php do_action( 'wcvendors_settings_after_branding' ); ?>
			</div>
		</div>



	</div>

	<div class="tabs-content" id="shipping">
		<h3> Entrega</h3>
		<p>
			Defina a taxa de entrega para as localidades que atende. Se o "For Me/Comprador" estiver em uma localidade não definida por suas regras de entrega, ele terá a opção de retirar em sua loja.<br />
			Campos obrigátorios: Estado, Cidade e Taxa de Entrega. <br />
			Caso atenda apenas um bairro específico, verifique nós correio o nome exato dele e preencha o campo bairro.<br />
			<span>Exemplo de preenchimento da taxa: digite 12.50 para R$12,50 de taxa de entrega.</span>
		</p>	

		
		<div id="adress_base" class="wcv-cols-group">
			<!-- Store Address -->	
			<?php do_action( 'wcvendors_settings_before_address' ); ?>
			<div class="cep">
				<?php WCVendors_Pro_Store_Form::store_address_postcode(); ?>
			</div>
			<div class="endereco">
			<?php WCVendors_Pro_Store_Form::store_address1( ); ?>
			</div>
			<div class="cidade all-50 tiny-100">
				<?php WCVendors_Pro_Store_Form::store_address_city( ); ?>
			</div>
			<div class="estado all-50 tiny-100">
				<?php WCVendors_Pro_Store_Form::store_address_state( ); ?>
			</div>
			<?php do_action(  'wcvendors_settings_after_address' ); ?>
		</div>

	
		
		<h4>Locais de entrega:</h4>
		<?php //do_action( 'wcvendors_settings_before_shipping' ); ?>

		<!-- Shipping Rates -->
		<?php WCVendors_Pro_Store_Form::shipping_rates( ); ?>

		<?php //do_action( 'wcvendors_settings_after_shipping' ); ?>

		<!-- Shiping Information  -->

		<?php //WCVendors_Pro_Store_Form::product_handling_fee( $shipping_details ); ?>
		<?php //WCVendors_Pro_Store_Form::shipping_policy( $shipping_details ); ?>
		<?php //WCVendors_Pro_Store_Form::return_policy( $shipping_details ); ?>
		<?php //WCVendors_Pro_Store_Form::shipping_from( $shipping_details ); ?>
		<?php //WCVendors_Pro_Store_Form::shipping_address( $shipping_details ); ?>
		
	</div>

	<?php if ( $social_count != $social_total ) :  ?> 
		<div class="tabs-content" id="social">
			<h3>Redes Sociais da Loja</h3>
			<?php do_action( 'wcvendors_settings_before_social' ); ?>
			<!-- Twitter -->
			<?php WCVendors_Pro_Store_Form::twitter_username( ); ?>
			<!-- Instagram -->
			<?php WCVendors_Pro_Store_Form::instagram_username( ); ?>
			<!-- Facebook -->
			<?php WCVendors_Pro_Store_Form::facebook_url( ); ?>
			<!-- Linked in -->
			<?php WCVendors_Pro_Store_Form::linkedin_url( ); ?>
			<!-- Youtube URL -->
			<?php WCVendors_Pro_Store_Form::youtube_url( ); ?>
			<!-- Pinterest URL -->
			<?php WCVendors_Pro_Store_Form::pinterest_url( ); ?>
			<!-- Google+ URL -->
			<?php WCVendors_Pro_Store_Form::googleplus_url( ); ?>
			<!-- Snapchat -->
			<?php WCVendors_Pro_Store_Form::snapchat_username( ); ?>
			<?php do_action(  'wcvendors_settings_after_social' ); ?>
		</div>
	<?php endif; ?>

	<!-- </div> -->
		<!-- Submit Button -->
		<!-- DO NOT REMOVE THE FOLLOWING TWO LINES -->
		<?php WCVendors_Pro_Store_Form::save_button( __( 'Save Changes', 'wcvendors-pro') ); ?>
	</form>
	<div class="tabs-content" id="adress">
		<h3>Endereço</h3>
		<p>Clique em "Editar localização" para preencher o formulário ou preencher no mapa seu endereço.</p>

		<?php if ( class_exists( 'GMW_Members_Locator_Component' ) ) {echo do_shortcode('[rh_add_map_gmw]');echo '<div class="mb25"></div>';}?>

	</div>

</div>
	