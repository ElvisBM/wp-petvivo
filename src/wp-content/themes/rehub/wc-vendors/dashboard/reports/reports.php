<?php
/**
 * The template for displaying the vendor store graphs, recent products and recent orders
 *
 * Override this template by copying it to yourtheme/wc-vendors/dashboard/report
 *
 * @package    WCVendors_Pro
 * @version    1.2.5
 */
?>

<?php 
	//remove
	if(false){
?>

<div class="wcv_reports wcv-cols-group wcv-horizontal-gutters"> 

	<div class="all-50 small-100 tiny-100">
		<h3><?php _e( 'Orders Totals', 'wcvendors-pro'); ?> ( <?php echo $store_report->total_orders; ?> )</h3>
		<hr />
		<?php $order_chart_data = $store_report->get_order_chart_data(); ?>

		<?php if ( !$order_chart_data ) : ?>
			<p><?php _e( 'No orders for this period. Adjust your dates above and click Update, or list new products for customers to buy.', 'wcvendors-pro'); ?></p>
		<?php else : ?>
			<table role="grid" class="wcvendors-table wcv-table">
				<thead>
					<tr>
						<th>Data</th>
						<th>Quantidade Pedidos</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$remove = array('[',']','"');
						$labels = explode(",", str_replace($remove, "", $order_chart_data['labels']));
						$data =  explode(",", str_replace($remove, "", $order_chart_data['data']));
						$pedidos = "";
						for($i=0; $i < count($labels); $i++ ){
							$pedidos .= "<tr>"; 
							$pedidos .= "<td>"; 
							$pedidos .= date("d/m/Y", strtotime($labels[$i]));
							$pedidos .= "</td>"; 
							$pedidos .= "<td>"; 
							$pedidos .= $data[$i];
							$pedidos .= "</td>"; 
							$pedidos .= "</tr >";
						}
						echo $pedidos;
					?>
				</tbody>
			</table>
		<?php endif; ?>
	</div>

	<div class="all-50 small-100 tiny-100">
		<h3><?php _e( 'Product Totals', 'wcvendors-pro'); ?> ( <?php echo $store_report->total_products_sold; ?> )</h3>
		<hr />
		<?php $product_chart_data = $store_report->get_product_chart_data(); ?>

		<?php if ( !$product_chart_data ) : ?>
			<p><?php _e( 'No sales for this period. Adjust your dates above and click Update, or list new products for customers to buy.', 'wcvendors-pro'); ?></p>
		<?php else : ?>
			<table role="grid" class="wcvendors-table wcv-table">
				<thead>
					<tr>
						<th>Produto</th>
						<th>Quantidade Vendida</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					$data = json_decode($product_chart_data);
					$produtos = "";
					for($i=0; $i < count($data); $i++ ){
						$produtos .= "<tr>"; 
						$produtos .= "<td>"; 
						$produtos .= $data[$i]->label;
						$produtos .= "</td>";
						$produtos .= "<td>";
						$produtos .= $data[$i]->value;
						$produtos .= "</td>";
						$produtos .= "</tr>";
					}

					echo $produtos;
				?>
				</tbody>
			</table>
		<?php endif; ?>
	</div>

</div>
<?php 
	}//enf if remove
?>


<div class="wcv_recent wcv_recent_orders wcv-cols-group wcv-horizontal-gutters"> 	


	<div class="xlarge-100 large-100 medium-100 small-100 tiny-100">
		<h3><?php _e( 'Recent Orders', 'wcvendors-pro'); ?></h3>
		<hr />
		<?php $recent_orders = $store_report->recent_orders_table(); ?>
		<?php if ( ! $orders_disabled ) : ?>
			<?php if ( !empty( $recent_orders )  ) : ?>
				<a href="<?php echo WCVendors_Pro_Dashboard::get_dashboard_page_url('order'); ?>" class="wcv-button button"><?php _e( 'View All', 'wcvendors-pro'); ?></a>
			<?php endif; ?>
		<?php endif; ?>
	</div>


	<?php 
		//remove
		if(false){ 
	?>
	<div class="xlarge-50 large-50 medium-100 small-100 tiny-100">
		<h3><?php _e( 'Recent Products', 'wcvendors-pro'); ?></h3>
		<hr />
		<?php $recent_products = $store_report->recent_products_table(); ?>
		<?php if ( ! $products_disabled ) : ?>
			<?php if ( !empty( $recent_products ) ) : ?>
				<a href="<?php echo WCVendors_Pro_Dashboard::get_dashboard_page_url('product'); ?>" class="wcv-button button"><?php _e( 'View All', 'wcvendors-pro'); ?></a>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<?php 
		}//endif remove
	?>
</div>

