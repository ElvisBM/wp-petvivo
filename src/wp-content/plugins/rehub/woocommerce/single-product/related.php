<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4


if(rehub_option('woo_single_sidebar') !='1') {
	echo do_shortcode('[woo_mod ids="'.$related.'" show="6" data_source="ids" showrow="5" show_coupons_only="2"]');	
}
else{
	echo do_shortcode('[woo_mod ids="'.$related.'" show="6" data_source="ids" showrow="3" show_coupons_only="2"]');	
}


 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;


if (rehub_option('rehub_wcv_related') == '1'){
	$artist = get_the_author_meta('ID');
	$classes = array();
	$classes[] = 'rh-flex-eq-height column_woo';
	if(rehub_option('woo_single_sidebar') =='1') {
		$posts_per_page = 3;
		$classes[] = 'col_wrap_three';
	}
	else{
		$posts_per_page = 5;
		$classes[] = 'col_wrap_fifth';
	}
	$args = apply_filters('woocommerce_related_products_args', array(
        'post_type' => 'product',
        'ignore_sticky_posts'   => 1,
        'no_found_rows'   => 1,
        'posts_per_page'  => $posts_per_page,
        'author' => $artist,
        'post__not_in' => array($product->id)
	) );
	$products = new WP_Query( $args );
	if ( $products->have_posts() ) : 
		echo '<h3>'.__( 'Related Products', 'woocommerce' ).'</h3>';
		echo '<div class="products '.implode(' ',$classes).'">';
		while ( $products->have_posts() ) : $products->the_post();
			include(locate_template('inc/parts/woocolumnpart.php'));
		endwhile; 
		echo '<div>';
	endif;
}
else {
	$related = $product->get_related();
	if ( sizeof( $related ) == 0 ) return;
	$posts_per_page  = $columns = 6;
	$related = implode(',',$related);
	echo '<h3>'.__( 'Related Products', 'woocommerce' ).'</h3>';
	if(rehub_option('woo_single_sidebar') =='1') {
		echo do_shortcode('[wpsm_woocolumns ids="'.$related.'" columns="3_col" data_source="ids" show="3" show_coupons_only="2"]');	
	}
	else{
		echo do_shortcode('[wpsm_woocolumns ids="'.$related.'" columns="5_col" data_source="ids" show="5" show_coupons_only="2"]');	
	}
}