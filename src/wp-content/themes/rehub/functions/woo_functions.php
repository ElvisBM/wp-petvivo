<?php

//Include Widget for deal of day
include (locate_template( 'inc/widgets/dealwoo.php' ));
include (locate_template( 'inc/widgets/woocategory.php' ));

//CREATE BRAND TAXONOMY
function woo_product_store_init() {
	register_taxonomy(
		'store',
		'product',
		array(
			'labels' => array(
				'name'              => __( 'Store', 'rehub_framework' ),
				'singular_name'     => __( 'Store', 'rehub_framework' ),
				'search_items'      => __( 'Search store', 'rehub_framework' ),
				'all_items'         => __( 'All stores', 'rehub_framework' ),
				'parent_item'       => __( 'Parent store', 'rehub_framework' ),
				'parent_item_colon' => __( 'Parent store:', 'rehub_framework' ),
				'edit_item'         => __( 'Edit store', 'rehub_framework' ),
				'update_item'       => __( 'Update store', 'rehub_framework' ),
				'add_new_item'      => __( 'Add new store', 'rehub_framework' ),
				'new_item_name'     => __( 'New store name', 'rehub_framework' ),
				'menu_name'         => __( 'Store', 'rehub_framework' ),
			),		
			'show_ui' => true,
			'show_admin_column' => true,
			'update_count_callback' => '_update_post_term_count',
			'hierarchical' => true,
			'public' => true,
			'query_var' => true,
			'show_in_quick_edit' => true,
			'rewrite' => array( 'slug' => 'store' ),
		)
	);
}
add_action( 'init', 'woo_product_store_init' );


//////////////////////////////////////////////////////////////////
// WooCommerce css
//////////////////////////////////////////////////////////////////
if (class_exists('Woocommerce')) {
	if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
	   add_filter( 'woocommerce_enqueue_styles', '__return_false' );
	} else {
	   define( 'WOOCOMMERCE_USE_CSS', false );
	}
}

//////////////////////////////////////////////////////////////////
// Display number products per page.
//////////////////////////////////////////////////////////////////
if(rehub_option('woo_number') == '16') {
	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 16;' ), 20 );
}
else {
	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );	
}
add_filter( 'woocommerce_output_related_products_args', 'change_number_related_products' );
 
function change_number_related_products( $args ) {
if(rehub_option('woo_single_sidebar') =='1') {
	$args['posts_per_page'] = 3; // # of related products
	$args['columns'] = 3; // # of columns per row	
}
else{
	$args['posts_per_page'] = 5; // # of related products
	$args['columns'] = 5; // # of columns per row	
} 

 return $args;
}

add_action('woocommerce_before_shop_loop', 'rehub_woocommerce_wrapper_start3', 33);
function rehub_woocommerce_wrapper_start3() {
  echo '<div class="clear"></div>';
}

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 10 );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_sale_flash', 5 );
add_action( 'woocommerce_checkout_before_customer_details', 'rehub_woo_before_checkout' );
add_action( 'woocommerce_checkout_after_customer_details', 'rehub_woo_average_checkout' );
add_action( 'woocommerce_checkout_after_order_review', 'rehub_woo_after_checkout' );
add_action( 'woocommerce_after_add_to_cart_button', 'rehub_woo_countdown' );

if (rehub_option('woo_single_sidebar') == 1){
	add_action( 'woocommerce_single_product_summary', 'rehub_woo_info_wrap_start', 4 );
	add_action( 'woocommerce_single_product_summary', 'rehub_woo_title_start', 5 );	
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 6 );		
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 7 );
	add_action( 'woocommerce_single_product_summary', 'rehub_woo_thumbs_up', 8 );				
	add_action( 'woocommerce_single_product_summary', 'rehub_woo_title_end', 9 );			
	add_action( 'woocommerce_single_product_summary', 'rehub_woo_price_wrap_start', 21 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 29 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	add_action( 'woocommerce_single_product_summary', 'rehub_woo_price_wrap_end', 31 );
}
else {
	add_action( 'woocommerce_single_product_summary', 'rehub_woo_info_wrap_start', 4 );	
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );		
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );	
	add_action( 'woocommerce_single_product_summary', 'rehub_woo_thumbs_up', 11 );
	add_action( 'woocommerce_single_product_summary', 'rehub_woo_price_wrap_start', 51 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 60 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 70 );
	add_action( 'woocommerce_single_product_summary', 'rehub_woo_price_wrap_end', 71 );	
}
add_action( 'woocommerce_after_single_product_summary', 'woo_deals_shortcode', 9 ); //add affiliate shortcode to woocommerce
add_filter( 'woocommerce_breadcrumb_defaults', 'rh_change_breadcrumb_delimiter' );
function rh_change_breadcrumb_delimiter( $defaults ) {
	// Change the breadcrumb delimeter from '/' to '>'
	$defaults['delimiter'] = '<span class="delimiter"><i class="fa fa-angle-right"></i></span>';
	return $defaults;
}

if (defined('wcv_plugin_dir')) {
	add_action( 'woocommerce_product_query', 'wcv_search_inside_vendor_shop' );	
	if ( class_exists( 'WCVendors_Pro' ) ) {
		remove_action( 'woocommerce_before_single_product', array($wcvendors_pro->wcvendors_pro_vendor_controller, 'store_single_header'));		
		remove_action( 'woocommerce_after_shop_loop_item', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9 );
		remove_action( 'woocommerce_product_meta_start', array( 'WCV_Vendor_Cart', 'sold_by_meta' ), 10, 2 );
		add_action( 'rehub_vendor_show_action', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9);
	}
	else{
		add_action('wcvendors_before_dashboard', 'rehub_woo_wcv_before_dash');
		add_action('wcvendors_after_dashboard', 'rehub_woo_wcv_after_dash');
		remove_action( 'woocommerce_before_single_product', array('WCV_Vendor_Shop', 'vendor_mini_header'));
		remove_action( 'woocommerce_after_shop_loop_item', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9 );
		remove_action( 'woocommerce_product_meta_start', array( 'WCV_Vendor_Cart', 'sold_by_meta' ), 10, 2 );
		add_action( 'rehub_vendor_show_action', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9);
	}
	add_action( 'woocommerce_single_product_summary', 'rh_show_vendor_info_single', 15);
}

//Change position of YITH Buttons
if ( defined( 'YITH_WCWL' )){
	add_filter('yith_wcwl_positions', 'rh_wishlist_change_position');
	function rh_wishlist_change_position($so_array=array()){
        $so_array   =   array(
            "shortcode" => array("hook"=>'shortcode', 'priority'=>0)
        );
	    return $so_array;
	}	
	if (rehub_option('woo_single_sidebar') == 1){
		add_action( 'woocommerce_single_product_summary', create_function( '', 'echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );' ), 8 );
	}
	else{
		add_action( 'woocommerce_single_product_summary', create_function( '', 'echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );' ), 12 );
	}
}
if ( class_exists('YITH_Woocompare_Frontend')){
	//$frontend = new YITH_Woocompare_Frontend();
	global $yith_woocompare;
	remove_action( 'woocommerce_single_product_summary', array( $yith_woocompare->obj , 'add_compare_link' ), 35 );
	if (rehub_option('woo_single_sidebar') == 1){
		add_action( 'woocommerce_single_product_summary', array($yith_woocompare->obj, 'add_compare_link'), 8 );
	}
	else{
		add_action( 'woocommerce_single_product_summary', array($yith_woocompare->obj, 'add_compare_link'), 12 );
	}
}

function rehub_woo_title_start() {
  echo '<div class="re_wooinner_title_compact">';
}
function rehub_woo_title_end() {
  echo '</div><div class="clear"></div>';
}
function rehub_woo_info_wrap_start() {
	if (rehub_option('woo_single_sidebar') == 1){
		echo '<div class="re_wooinner_info woo_inner_info_sidebar">';
	}
	else{
	    echo '<div class="re_wooinner_info">';	
	}
}
function rehub_woo_price_wrap_start() {
	if (rehub_option('woo_single_sidebar') == 1){
		echo '</div><div class="re_wooinner_cta_wrapper re_wooinner_cta_sidebar">';
	}
	else{
	    echo '</div><div class="re_wooinner_cta_wrapper">';	
	}	
  
}
function rehub_woo_price_wrap_end() {	
	$code_incart = get_post_meta(get_the_ID(), 'rh_code_incart', true );
	if ( !empty($code_incart)) {
		echo '<div class="rh_code_incart">';
		echo do_shortcode($code_incart);
		echo '</div>';
	}	
  echo '</div>';
}
function rehub_woo_before_checkout() {
	echo '<div class="re_woocheckout_details">';
}
function rehub_woo_average_checkout() {
	echo '</div><div class="re_woocheckout_order">';
}
function rehub_woo_after_checkout() {
	echo '</div>';
}
function rehub_woo_wcv_before_dash() {
	echo '<div class="rh_wcv_dashboard_page">';
}
function rehub_woo_wcv_after_dash() {
	echo '</div>';
}
if(!function_exists('rehub_woo_thumbs_up')){
	function rehub_woo_thumbs_up(){
		if (rehub_option('woo_thumb_enable') == '1') {echo getHotThumb(get_the_ID(), false, true);}
	}
}
if (!function_exists('woo_deals_shortcode')){
function woo_deals_shortcode(){
	$rehub_woodeals_short = get_post_meta(get_the_ID(), 'rehub_woodeals_short', true );
    if(!empty ($rehub_woodeals_short)) :
    	echo '<div class="deals_woo_short">';
    		echo do_shortcode($rehub_woodeals_short);
    	echo '</div>';
    endif;	
} 
}  

if (!function_exists('rehub_woo_countdown')){
function rehub_woo_countdown(){
	global $post;
	$endshedule = get_post_meta($post->ID, '_sale_price_dates_to', true );	
	if($endshedule){
		$endshedule = date_i18n( 'Y-m-d', $endshedule );
		$countdown = explode('-', $endshedule);
		$year = $countdown[0];
		$month = $countdown[1];
		$day  = $countdown[2];
		$startshedule = get_post_meta($post->ID, '_sale_price_dates_from', true );
		if ($startshedule){			
			$startshedule = strtotime(date_i18n( 'Y-m-d', $startshedule )); 
			$current = time();
			if($startshedule > $current){
				return;
			}
		}
		echo do_shortcode('[wpsm_countdown year="'.$year.'" month="'.$month.'" day="'.$day.'"]');
	}
	else {
		$rehub_woo_expiration = get_post_meta( $post->ID, 'rehub_woo_coupon_date', true );
		if ($rehub_woo_expiration){
			$countdown = explode('-', $rehub_woo_expiration);
			$year = $countdown[0];
			$month = $countdown[1];
			$day  = $countdown[2];	
			echo do_shortcode('[wpsm_countdown year="'.$year.'" month="'.$month.'" day="'.$day.'"]');		
		}
	}	
} 
}  


//////////////////////////////////////////////////////////////////
// change default sizes
//////////////////////////////////////////////////////////////////
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' )
	add_action( 'init', 'rehub_woocommerce_image_dimensions', 1 );

if( !function_exists('rehub_woocommerce_image_dimensions') ) {
function rehub_woocommerce_image_dimensions() {
  	$catalog = array(
		'width' 	=> '270',	// px
		'height'	=> '270',	// px
		'crop'		=> 1 		// true
	);
 
	$single = array(
		'width' 	=> '324',	// px
		'height'	=> '324',	// px
		'crop'		=> 0 		// true
	);
 
	$thumbnail = array(
		'width' 	=> '200',	// px
		'height'	=> '200',	// px
		'crop'		=> 1 		// false
	);
 
	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}
}


//////////////////////////////////////////////////////////////////
// Woo default thumbnail
//////////////////////////////////////////////////////////////////
add_filter('woocommerce_placeholder_img_src', 'rehub_woocommerce_placeholder_img_src');
function rehub_woocommerce_placeholder_img_src( $src ) {
	global $post;
	if (is_object($post)) {
		if (get_post_meta($post->ID, 'rehub_woo_coupon_code', true) !=''){
			$src = get_template_directory_uri() . '/images/default/woocouponph.png';
		}
		elseif (get_post_meta($post->ID, '_sale_price', true) !=''){
			$src = get_template_directory_uri() . '/images/default/woodealph.png';
		}
		else {
			$src = get_template_directory_uri() . '/images/default/wooproductph.png';
		} 
	}
	else {
		$src = get_template_directory_uri() . '/images/default/wooproductph.png';
	}	
	return $src;
}

//////////////////////////////////////////////////////////////////
// Woo update cart in header
//////////////////////////////////////////////////////////////////
if (rehub_option('woo_cart_place') =='1' || rehub_option('woo_cart_place') =='2'){
	add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
	if( !function_exists('woocommerce_header_add_to_cart_fragment') ) { 
	function woocommerce_header_add_to_cart_fragment( $fragments ) {
		global $woocommerce;
		ob_start();
		?>
		<?php if (rehub_option('woo_cart_place') =='1'):?>
			<a class="cart-contents cart_count_<?php echo $woocommerce->cart->cart_contents_count; ?>" href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><i class="fa fa-shopping-cart"></i> <?php _e( 'Cart', 'rehub_framework' ); ?> (<?php echo $woocommerce->cart->cart_contents_count; ?>) - <?php echo $woocommerce->cart->get_cart_total(); ?></a>		
		<?php elseif (rehub_option('woo_cart_place') =='2'):?>
			<a class="rh_woocartmenu-link icon-in-main-menu menu-item-one-line cart-contents cart_count_<?php echo $woocommerce->cart->cart_contents_count; ?>" href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><span class="rh_woocartmenu-icon"><strong><?php echo $woocommerce->cart->cart_contents_count;?></strong><span class="rh_woocartmenu-icon-handle"></span></span><span class="rh_woocartmenu-amount"><?php echo $woocommerce->cart->get_cart_total();?></span></a>		
		<?php endif;?>
		<?php
		$fragments['a.cart-contents'] = ob_get_clean();
		return $fragments;
	}
	}	
}


//////////////////////////////////////////////////////////////////
// Redirect Vendors to Vendor Dashboard on Login
//////////////////////////////////////////////////////////////////
add_filter('woocommerce_login_redirect', 'login_redirect', 10, 2);
function login_redirect( $redirect_to, $user ) {
    
    if (class_exists('WCV_Vendors') && class_exists('WCVendors_Pro') && WCV_Vendors::is_vendor( $user->id ) ) {
        $redirect_to = get_permalink(WCVendors_Pro::get_option( 'dashboard_page_id' ));
    }
    elseif (class_exists('WCV_Vendors') && WCV_Vendors::is_vendor( $user->id ) ) {
    	$redirect_to = get_permalink(WC_Vendors::$pv_options->get_option( 'vendor_dashboard_page' ));
    }
    return $redirect_to;
}

//////////////////////////////////////////////////////////////////
// Deals links Deprecated in 6.0.5
//////////////////////////////////////////////////////////////////
if( !function_exists('woo_dealslinks_rehub') ) {
function woo_dealslinks_rehub($shortcode_include='yes') {
?>
	<?php $rehub_woo_post_ids = vp_metabox('rehub_framework_woo.review_woo_list_links'); 
	if (!empty($rehub_woo_post_ids) && !is_array($rehub_woo_post_ids)) { $rehub_woo_post_ids = explode(',', $rehub_woo_post_ids); }
	$rehub_aff_post_ids = vp_metabox('rehub_framework_woo.review_woo_links');
	$rehub_woodeals_short = get_post_meta(get_the_ID(), 'rehub_woodeals_short', true );
	?>
    <?php if (!empty ($rehub_woodeals_short) && $shortcode_include=='yes') :?>
    	<div class="deals_woo_short">
    		<?php echo do_shortcode($rehub_woodeals_short);?>
    	</div>
    <?php endif;?>	
	<?php if(!empty($rehub_woo_post_ids) || (function_exists('thirstyInit') && !empty($rehub_aff_post_ids))) :?>
		<div class="deals_woo_rehub">
			<?php if(!empty($rehub_woo_post_ids)) :?>
				<div class="wooaff_offer_links">
				<?php  $args = array(
		            'post__in' => $rehub_woo_post_ids,
		            'numberposts' => '-1',
		            'orderby' => 'post__in', 
		            'post_type' => 'product',
		            'ignore_sticky_posts'   => 1,
		            'no_found_rows' => 1,           
		        ); 
		        global $post; global $woocommerce; $backup=$post;
		        ?>
		        <?php $i=1; $wp_query = new WP_Query( $args ); if ( $wp_query->have_posts() ) : ?>                      
				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();  global $product;  ?>
				<?php $woolink = ($product->product_type =='external') ? $product->add_to_cart_url() : get_post_permalink(get_the_ID()) ;?>  
					<div class="woorow_aff">
						<div class="product-pic-wrapper">
							<a href="<?php echo $woolink; ?>" target="_blank"<?php if ($product->product_type =='external'){echo ' rel="nofollow"';} ?>>
								<?php WPSM_image_resizer::show_static_resized_image(array('thumb'=>true, 'width'=> 100, 'no_thumb_url' => rehub_woocommerce_placeholder_img_src('')));?>
			            	</a>				
						</div>
						<div class="product-details">
							<div class="product-name">
								<div class="aff_name"><a href="<?php echo $woolink; ?>" target="_blank"<?php if ($product->product_type =='external'){echo ' rel="nofollow"';} ?>><?php the_title(); ?></a></div>
								<p><?php kama_excerpt('maxchar=150'); ?></p>
							</div>
							<div class="left_data_aff">
								<div class="wooprice_count">
								<?php if ($product->get_price() !='') : ?>
									<?php echo $product->get_price_html(); ?>
								<?php endif; ?>	
								</div>					
								<div class="wooaff_tag">
 									<?php WPSM_Woohelper::re_show_brand_tax(); //show brand taxonomy?>
								</div>
							</div>					
							<div class="woobuy_butt">
		                    <?php if ( $product->is_in_stock() &&  $product->add_to_cart_url() !='') : ?>
		                        <?php  echo apply_filters( 'woocommerce_loop_add_to_cart_link',
		                            sprintf( '<a href="%s" data-product_id="%s" data-product_sku="%s" class="re_track_btn woobtn_offer_block %s product_type_%s"%s%s>%s</a>',
		                            esc_url( $product->add_to_cart_url() ),
		                            esc_attr( $product->id ),
		                            esc_attr( $product->get_sku() ),
		                            $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
		                            esc_attr( $product->product_type ),
		                            $product->product_type =='external' ? ' target="_blank"' : '',
		                            $product->product_type =='external' ? ' rel="nofollow"' : '',                            
		                            $product->add_to_cart_text() ? esc_html( $product->add_to_cart_text()) : __('See it', 'rehub_framework')
		                            ),
		                        $product );?>
		                    <?php endif; ?>
							</div>
						</div>
					</div>
				<?php endwhile; endif; wp_reset_postdata(); $post=$backup; ?> 
				</div>
			<?php endif ;?>
			<?php if(function_exists('thirstyInit') && !empty($rehub_aff_post_ids)) :?>		
				<div class="wooaff_offer_links">
				<?php 
				$rehub_aff_posts = get_posts(array(
					'post_type'        => 'thirstylink',
					'post__in' => $rehub_aff_post_ids,
					'meta_key' => 'rehub_aff_sticky',
					'orderby' => 'meta_value',
					'order' => 'DESC',
					'numberposts' => '-1'			
				));
				foreach($rehub_aff_posts as $aff_post) { ?>	
					<?php 	$attachments = get_posts( array(
			            'post_type' => 'attachment',
						'post_mime_type' => 'image',
			            'posts_per_page' => -1,
			            'post_parent' => $aff_post->ID,
		        	) );
					if (!empty($attachments)) {$aff_thumb_list = wp_get_attachment_url( $attachments[0]->ID );} else {$aff_thumb_list ='';}
					$term_list = wp_get_post_terms($aff_post->ID, 'thirstylink-category', array("fields" => "names")); 
					$term_ids =  wp_get_post_terms($aff_post->ID, 'thirstylink-category', array("fields" => "ids")); if (!empty($term_ids)) {$term_brand = $term_ids[0]; $term_brand_image = get_option("taxonomy_term_$term_ids[0]");} else {$term_brand_image ='';}
					?>
					<div class="woorow_aff">
						<div class="product-pic-wrapper">
							<a href="<?php echo get_post_permalink($aff_post) ?>">
								<?php if (!empty($aff_thumb_list) ) :?>									
			            			<?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb_list, 'width'=> 100, 'height' => 100, 'title' => $aff_post->post_title));?>	
			            		<?php elseif (!empty($term_brand_image['brand_image'])) :?>
			            			<?php WPSM_image_resizer::show_static_resized_image(array('src'=> $term_brand_image['brand_image'], 'width'=> 100, 'height' => 100, 'title' => $aff_post->post_title));?>				            		
			            		<?php else :?>
			            			<?php WPSM_image_resizer::show_static_resized_image(array('width'=> 100, 'no_thumb_url' => get_template_directory_uri().'/images/default/noimage_100_70.png'));?>
			            		<?php endif?>
			            	</a>				
						</div>
						<div class="product-details">
							<div class="product-name">
								<div class="aff_name"><a href="<?php echo get_post_permalink($aff_post) ?>"><?php echo $aff_post->post_title; ?></a></div>
								<p><?php echo get_post_meta( $aff_post->ID, 'rehub_aff_desc', true );?></p>
							</div>
							<div class="left_data_aff">
								<div class="wooprice_count">
									<?php $product_price = get_post_meta( $aff_post->ID, 'rehub_aff_price', true );?>
									<?php echo $product_price ;?>
								</div>					
								<div class="wooaff_tag">
						            <?php if (!empty($term_brand_image['brand_image'])) :?>
						            	<?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb_list, 'height' => 35));?>							            	
						            <?php elseif (!empty($term_list[0])) :?> 
						            	<?php echo $term_list[0]; ?>
						            <?php endif; ?> 							
								</div>
							</div>	
							<?php $offer_btn_text = get_post_meta( $aff_post->ID, 'rehub_aff_btn_text', true ) ?>				
							<div class="woobuy_butt">
								<a class="re_track_btn woobtn_offer_block" href="<?php echo get_post_permalink($aff_post) ?>" target="_blank" rel="nofollow"><?php if($offer_btn_text !='') :?><?php echo $offer_btn_text ; ?><?php elseif(rehub_option('rehub_btn_text') !='') :?><?php echo rehub_option('rehub_btn_text') ; ?><?php else :?><?php _e('See it', 'rehub_framework') ?><?php endif ;?></a>
							</div>
						</div>
					</div>	
				<?php 
				}
				?>
				</div>
			<?php endif;?>
		</div>
    <?php endif;?>	
<?php
}
}

//////////////////////////////////////////////////////////////////
// Add the Meta Box to woocommerce for using coupons
//////////////////////////////////////////////////////////////////
add_action( 'woocommerce_product_options_pricing', 'show_rehub_woo_meta_box_inner' );

// Field Array
$wooprefixrehub = 'rehub_woo_coupon_';
$woo_custom_meta_fields = array(
    array(
        'label'=>  __('Set coupon code', 'rehub_framework'),
        'desc'  => __('Set coupon code or leave blank', 'rehub_framework'),
        'id'    => $wooprefixrehub.'code',
        'type'  => 'text'
    ),
	array(
	    'label' => __('Offer End Date', 'rehub_framework'),
	    'desc'  => __('Choose expiration date of product or leave blank', 'rehub_framework'),
	    'id'    => $wooprefixrehub.'date',
	    'type'  => 'date'
	),    
    array(
        'label'=> __('Mask coupon code?', 'rehub_framework'),
        'desc'  => __('If this option is enabled, coupon code will be hidden.', 'rehub_framework'),
        'id'    => $wooprefixrehub.'mask',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> __('Brand logo url', 'rehub_framework'),
        'desc'  => __('Insert url to logo of brand or leave blank', 'rehub_framework'),
        'id'    => $wooprefixrehub.'logo_url',
        'type'  => 'text'
    )    
);
if(rehub_option('rehub_woo_print') =='1') {
	$woo_custom_meta_fields[] = array(
        'label'=> __('Additional coupon image url', 'rehub_framework'),
        'desc'  => __('Used for printable coupon function. To enable it, you must have any coupon code above', 'rehub_framework'),
        'id'    => $wooprefixrehub.'coupon_img_url',
        'type'  => 'text'
    );
}

add_action('admin_head','rehub_add_woo_custom_scripts',11);
if ( !function_exists( 'rehub_add_woo_custom_scripts' ) ) {
function rehub_add_woo_custom_scripts() {
    global $woo_custom_meta_fields, $post, $pagenow;
    if ( $pagenow=='post-new.php' || $pagenow=='post.php' ) {
	    if ( 'product' === $post->post_type ) { 
		    $output = '<script type="text/javascript">
		                jQuery(function() {';	                 
		    foreach ($woo_custom_meta_fields as $field) { // loop through the fields looking for certain types
		        if($field['type'] == 'date')
		            $output .= 'jQuery(".rehubdatepicker").each(function(){jQuery(this).datepicker({dateFormat: "yy-mm-dd"});});';
		    };	     
		    $output .= '});
		        </script>';	         
		    echo $output;
		}
	}
}
}

// The Callback for external products
function show_rehub_woo_meta_box_inner() {
global $woo_custom_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="custom_woo_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
     
    // Begin the field table and loop
    echo '<div class="options_group show_if_external">';
    foreach ($woo_custom_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<p class="form-field rh_woo_meta_'.$field['id'].'">
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
                switch($field['type']) {
                    // text
					case 'text':
					    echo '<input class="short" type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="70" />
					        <span class="description">'.$field['desc'].'</span>';
					break;
					// checkbox
					case 'checkbox':
					    echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
					        <span class="description">'.$field['desc'].'</span>';
					break;
					// date
					case 'date':
						echo '<input class="short rehubdatepicker" type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="70" />
								<span class="description">'.$field['desc'].'</span>';
					break;															
                } //end switch
        echo '</p>';
    } // end foreach
    echo '</div>'; // end table
    woocommerce_wp_text_input( array( 'id' => 'rh_code_incart', 'class' => 'short', 'label' => __( 'Custom shortcode', 'rehub_framework' ), 'description' => __( 'Will be rendered in button block', 'rehub_framework' )  ));
    woocommerce_wp_text_input( array( 'id' => 'rehub_woodeals_short', 'class' => 'short', 'label' => __( 'Custom shortcode', 'rehub_framework' ), 'description' => __( 'Will be rendered before tabs', 'rehub_framework' )  ));    
}



// Save the Data
function save_rehub_woo_custom_meta($post_id) {
    global $woo_custom_meta_fields;
     
    // verify nonce
	if ( ! isset( $_POST['custom_woo_meta_box_nonce'] ) ) {
		return $post_id;
	}
    if (!wp_verify_nonce($_POST['custom_woo_meta_box_nonce'], basename(__FILE__))) 
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }

    if (isset ($_POST['rh_code_incart'])) {
		$woo_custom_meta_fields[] = array(
	        'id'    => 'rh_code_incart',
	    ); 
    }  

    if (isset ($_POST['rehub_woodeals_short'])) {
		$woo_custom_meta_fields[] = array(
	        'id'    => 'rehub_woodeals_short',
	    ); 
    }     
     
    // loop through fields and save the data
    foreach ($woo_custom_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        if (isset ($_POST[$field['id']])) {
            $new = sanitize_text_field($_POST[$field['id']]);
        }
        else {
           $new =''; 
        }
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach

}
add_action('save_post', 'save_rehub_woo_custom_meta');


//////////////////////////////////////////////////////////////////
//EXPIRE FUNCTION
//////////////////////////////////////////////////////////////////

add_action('woo_change_expired', 'woo_change_expired_function', 10, 1);
if (!function_exists('woo_change_expired_function')) {
function woo_change_expired_function($expired=''){
	global $post;
	$expired_exist = get_post_meta($post->ID, 're_post_expired', true);
	if($expired ==1 && $expired_exist !=1){
		update_post_meta($post->ID, 're_post_expired', 1);
	}
	elseif($expired =='' && $expired_exist == 1){
		update_post_meta($post->ID, 're_post_expired', 0);
	}	
	elseif($expired_exist==''){
		update_post_meta($post->ID, 're_post_expired', 0);
	}
}
}

if (rehub_option('woo_exclude_expired') == '1') {
	//exclude from main archives
	if (!function_exists('woo_exclude_expired')) {
		function woo_exclude_expired($query) {
			if( ! is_admin() && $query->is_main_query() ) {
			    if (is_post_type_archive('product') || is_product_category()) {
				    $query->set( 'meta_query', array(
				    	'relation' => 'OR',
				    	array(
				       		'key' => 're_post_expired',
				       		'value' => '1',
				       		'compare' => '!=',
				    	),
				    	array(
				       		'key' => 're_post_expired',
				       		'compare' => 'NOT EXISTS',
				    	),				    	 				    	   	
				    ));
				}
			}
		}
	add_action('pre_get_posts','woo_exclude_expired');		
	}
}

add_filter( 'post_class', 're_expired_post_classes' );
function re_expired_post_classes( $classes ){
	if(is_singular('product')){
		$expired = get_post_meta(get_the_ID(), 're_post_expired', true);
		if ($expired == '1'){
			$classes[] = 're_post_expired';
		}
	}
 
    return $classes;
}

if (!function_exists('rh_show_vendor_info_single')) {
function rh_show_vendor_info_single() {
	//global $post; 
	//$author_id=$post->post_author; 
	$vendor_id = get_the_author_meta( 'ID' );
	$sold_by_label = WC_Vendors::$pv_options->get_option( 'sold_by_label' );
	echo '<div class="vendor_store_details">';
	echo '<div class="vendor_store_details_image"><a href="'.WCV_Vendors::get_vendor_shop_page( $vendor_id ).'"><img src="'.rh_show_vendor_avatar($vendor_id, 50, 50).'" class="vendor_store_image_single" width=50 height=50 /></a></div>';
	echo '<div class="vendor_store_details_single">';
	echo '<div class="vendor_store_details_nameshop">';
	echo'<span class="rh-favorite-shop floatright">'.getShopLikeButton($vendor_id).'</span>';
	echo '<span class="vendor_store_details_label">'.WC_Vendors::$pv_options->get_option( 'sold_by_label' ).'</span>';
	$sold_by = WCV_Vendors::is_vendor( $vendor_id )
			? sprintf( '<h5><a href="%s" class="wcvendors_cart_sold_by_meta">%s</a></h5>', WCV_Vendors::get_vendor_shop_page( $vendor_id ), WCV_Vendors::get_vendor_sold_by( $vendor_id ) )
			: '<h5>'.get_bloginfo( 'name' ).'</h5>';
	echo '<span class="vendor_store_details_title">'.$sold_by.'</span>';
	echo '</div>';
	if ( class_exists( 'BuddyPress' ) ) {
		echo '<span class="vendor_store_details_contact"><span class="vendor_store_owner_label">@ </span>';
		echo '<a href="'.bp_core_get_user_domain( $vendor_id ).'" class="vendor_store_owner_name"><span>'. get_the_author_meta('display_name') .'</span></a> ';
		if ( bp_is_active( 'messages' )){
			$link = (is_user_logged_in()) ? wp_nonce_url( bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . bp_core_get_username( $vendor_id)) : '#';
			$class = (!is_user_logged_in() && rehub_option('userlogin_enable') == '1') ? ' act-rehub-login-popup' : '';
				echo ' <a href="'.$link.'" class="vendor_store_owner_contactlink'.$class.'"><i class="fa fa-envelope-o" aria-hidden="true"></i> <span>'. __('Ask owner', 'rehub_framework') .'</span></a>';			
		}
		echo '</span>';		
	}
	echo '</div></div>';

}}


if (!function_exists('rh_show_vendor_ministore')) {
function rh_show_vendor_ministore($vendor_id, $label='') { 
	$totaldeals = count_user_posts( $vendor_id, $post_type = 'product' );

	if(WCV_Vendors::is_vendor( $vendor_id ) && $totaldeals>0){
		echo '<div class="vendor_store_in_bp">';
		echo '<div class="vendor-list-like">'.getShopLikeButton( $vendor_id ).'</div>';
		echo '<div class="vendor_store_in_bp_image"><a href="'.WCV_Vendors::get_vendor_shop_page( $vendor_id ).'"><img src="'.rh_show_vendor_avatar($vendor_id, 80, 80).'" class="vendor_store_image_single" width=80 height=80 /></a></div>';
		echo '<div class="vendor_store_in_bp_single">';
		echo '<span class="vendor_store_in_bp_label"><span class="vendor_store_owner_label">'.$label.'</span></span>';
		$sold_by = WCV_Vendors::is_vendor( $vendor_id )
				? sprintf( '<h5><a href="%s" class="wcvendors_cart_sold_by_meta">%s</a></h5>', WCV_Vendors::get_vendor_shop_page( $vendor_id ), WCV_Vendors::get_vendor_sold_by( $vendor_id ) )
				: get_bloginfo( 'name' );
		echo '<span class="vendor_store_in_bp_title">'.$sold_by.'</span>';
		echo '</div>';
		echo '<div class="vendor_store_in_bp_last_products">';
			$totaldeals = $totaldeals - 4;
			$args = array(
				'post_type' => 'product',
				'posts_per_page' => 4,
				'author' => $vendor_id,
				'ignore_sticky_posts'=> true,
				'no_found_rows'=> true
			);
			$looplatest = new WP_Query($args);
			if ( $looplatest->have_posts() ){
				while ( $looplatest->have_posts() ) : $looplatest->the_post();
					echo '<a href="'.get_permalink($looplatest->ID).'">';
			            $showimg = new WPSM_image_resizer();
			            $showimg->use_thumb = true;
			            $showimg->height = 70;
			            $showimg->width = 70;
			            $showimg->crop = true;
						$showimg->no_thumb = rehub_woocommerce_placeholder_img_src('');
			            $img = $showimg->get_resized_url();
			            echo '<img src="'.$img.'" width=70 height=70 alt="'.get_the_title($looplatest->ID).'"/>';
					echo '</a>';
				endwhile;
				if($totaldeals>0){
					echo '<a class="vendor_store_in_bp_count_pr" href="'.WCV_Vendors::get_vendor_shop_page( $vendor_id ).'"><span>+'.$totaldeals.'</span></a>';					
				}

			}
			wp_reset_query();

		echo '</div>';
		echo '</div>';		
	}
}}

if (!function_exists('rh_show_vendor_avatar')) {
function rh_show_vendor_avatar($vendor_id, $width=150, $height=150) {
	if(!$vendor_id) return;
	if ( class_exists( 'WCVendors_Pro' ) ) {
		$store_icon_src 	= wp_get_attachment_image_src( get_user_meta( $vendor_id, '_wcv_store_icon_id', true ), array( 150, 150 ) );
		if ( is_array( $store_icon_src ) ) { 
			$store_icon_url= $store_icon_src[0]; 
		}
		else{
			$store_icon_url = get_template_directory_uri() . '/images/default/wcvendoravatar.png';
		}
	}
	elseif(rehub_option('wcv_vendor_avatar') !=''){
		$store_icon_url = esc_url(rehub_option('wcv_vendor_avatar'));
	}
	else{
		$store_icon_url = get_template_directory_uri() . '/images/default/wcvendoravatar.png';
	}
    $showimg = new WPSM_image_resizer();
    $showimg->src = $store_icon_url;
    $showimg->use_thumb = false;
    $showimg->height = $height;
    $showimg->width = $width;
    $showimg->crop = true;           
    $img = $showimg->get_resized_url();
	return $img;	
}}

if (!function_exists('rh_show_vendor_bg')) {
function rh_show_vendor_bg($vendor_id) {
	if(!$vendor_id) return;
	if ( class_exists( 'WCVendors_Pro' ) ) {
		$store_icon_src 	= wp_get_attachment_image_src( get_user_meta( $vendor_id, '_wcv_store_banner_id', true ), 'full'); 
		if ( is_array( $store_icon_src ) ) { 
			$store_bg= $store_icon_src[0]; 
		}
		else { 
			//  Getting default banner 
			$default_banner_src = WCVendors_Pro::get_option( 'default_store_banner_src' ); 
			$store_bg= $default_banner_src; 
		}	
		$store_bg_styles = 'background-image: url('.$store_bg.'); background-repeat: no-repeat;background-size: cover;';	
	}
	elseif(rehub_option('wcv_vendor_bg') !=''){
		$store_bg = esc_url(rehub_option('wcv_vendor_bg'));
		$store_bg_styles = 'background-image: url('.$store_bg.'); background-repeat: no-repeat;background-size: cover;';
	}
	else{
		$store_bg_styles = 'background-image: url('.get_template_directory_uri() . '/images/default/brickwall.png); background-repeat:repeat;';
	}
	return $store_bg_styles;	
}}

function wcv_search_inside_vendor_shop($q){
	$string = (isset($_GET['rh_wcv_search'])) ? esc_html($_GET['rh_wcv_search']) : '';
	$cat_string = (isset($_GET['rh_wcv_vendor_cat'])) ? esc_html($_GET['rh_wcv_vendor_cat']) : '';
	if($string){
		$q->set( 's', $string);
	}	
	if($cat_string){
		$catarray = array(
			array(
    				'taxonomy' => 'product_cat', 
    				'terms' => array($cat_string), 
    				'field' => 'term_id'				
				)
			);
		$q->set( 'tax_query', $catarray);
	}	
}

?>