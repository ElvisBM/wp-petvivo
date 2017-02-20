<?php
/**
 * The template for displaying the vendor store information including total sales, orders, products and commission
 *
 * Override this template by copying it to yourtheme/wc-vendors/dashboard/report
 *
 * @package    WCVendors_Pro
 * @version    1.2.3
 */
?>
<?php 
	
	$receiver_id = get_user_meta( get_current_user_id(), 'receiver_id', true );
	$response = request_receiver_pagarme( $receiver_id );

	$waitpayment	= (string) $response->waiting_funds->amount;
	$available 		= (string) $response->available->amount;
	$transferred 	= (string) $response->transferred->amount;

	//Format For Brazil
	$waitpayment	= substr($waitpayment, 0, -2).".".substr($waitpayment, -2, 2);
	$available 		= substr($available, 0, -2).".".substr($available, -2, 2);
	$transferred 	= substr($transferred, 0, -2).".".substr($transferred, -2, 2);

	if( is_numeric ( $waitpayment ) ){
  		$waitpayment = number_format($waitpayment,2,",",".");
  	}else{
  		$waitpayment = "00,00";
  	}

  	if( is_numeric ( $available ) ){
  		$available = number_format($available,2,",",".");
  	}else{
  		$available = "00,00";
  	}

  	if( is_numeric ( $transferred ) ){
  		$transferred = number_format($transferred,2,",",".");
  	}else{
  		$transferred = "00,00";
  	}
?>
<div id="minha-loja-dash">
	<div class="wcv_dashboard_datepicker wcv-cols-group"> 
		
		<div class="all-100">
		<h3>Filtro de informação por Data</h3>
		<hr />
		<form method="post" action="" class="wcv-form"> 
			<?php $store_report->date_range_form(); ?>
		</form>
		</div>
	</div>

	<div class="wcv_dashboard_overview wcv-cols-group wcv-horizontal-gutters"> 

		<h3>Extrado de Pagamento</h3>
		<hr>
		<div class="xlarge-50 large-50 medium-100 small-100 tiny-100 a-receber">
			<h4><?php _e( 'Já foi transferido', 'wcvendors-pro'); ?></h4>
			<table role="grid" class="wcvendors-table wcvendors-table-recent_order wcv-table">
		  	<tbody>
			    <tr>
			      <td><?php _e( 'Saldo: ', 'wcvendors-pro'); ?></td>
			      <td> R$ <?php echo $transferred; ?></td>
			    </tr>
		  	</tbody>

			</table>
		</div>

		<div class="xlarge-50 large-50 medium-100 small-100 tiny-100">
			<h4><?php _e( 'Será transferido', 'wcvendors-pro'); ?></h4>
			<table role="grid" class="wcvendors-table wcvendors-table-recent_order wcv-table">
		  	<tbody>
			    <tr>
			      <td><?php _e( 'Saldo: ', 'wcvendors-pro'); ?></td>
			      <td> R$ <?php echo $available; ?></td>
			    </tr>
		  	</tbody>
			</table>
		</div>

	</div>

	<?php if ( 'something' == 'somethingelse' ) : ?> 

		<div class="wcv_dashboard_overview wcv-cols-group"> 

			  <div class="xlarge-25 large-25 medium-50 small-50 tiny-100 stats">
		        	<span><?php _e( 'Orders', 'wcvendors-pro'); ?></span>
		        	<h3><?php echo $store_report->total_orders; ?></h3>
			        		<!-- <i class="fa fa-shopping-cart fa-3x orders"></i> -->
			  </div>
			  <div class="xlarge-25 large-25 medium-50 small-50 tiny-100 stats">
		            <span><?php _e( 'Total Products Sold', 'wcvendors-pro'); ?></span>
		            <h3><?php echo $store_report->total_products_sold; ?></h3>
			  </div>
			  <div class="xlarge-25 large-25 medium-50 small-50 tiny-100 stats">
			   	  <span><?php _e( 'Commission Owed', 'wcvendors-pro'); ?></span>
			      <h3><?php echo woocommerce_price( $store_report->commission_due ) ;?></h3>
			  </div>
			  <div class="xlarge-25 large-25 medium-50 small-50 tiny-100 stats">
			   	 	<span><?php _e( 'Commission Paid', 'wcvendors-pro'); ?></span>
			        <h3><?php echo woocommerce_price( $store_report->commission_paid ); ?></h3>
			  </div>

		</div>

	<?php endif; ?>

	
</div>