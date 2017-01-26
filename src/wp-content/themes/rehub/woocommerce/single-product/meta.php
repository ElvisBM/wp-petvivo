<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

?>
<div class="product_meta">
	
	<?php if($product->product_type =='external'):?>
		<?php $term_ids =  wp_get_post_terms(get_the_ID(), 'store', array("fields" => "ids")); ?>
		<?php if (!empty($term_ids) && ! is_wp_error($term_ids)) :?>
			<div class="woostorewrap">
				<div class="brand_logo_small">       
					<?php WPSM_Woohelper::re_show_brand_tax('logo'); //show brand logo?>
				</div>			
				<div class="store_tax">       
					<?php WPSM_Woohelper::re_show_brand_tax(); //show brand taxonomy?>
				</div>	
			</div>
		<?php endif;?>
	<?php endif;?>

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', 'woocommerce' ); ?></span></span>

	<?php endif; ?>

	<?php echo $product->get_categories( ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $cat_count, 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php echo $product->get_tags( ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $tag_count, 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php if (rehub_option('woo_enable_share') == 1){include(rh_locate_template('inc/parts/post_share.php'));}?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
