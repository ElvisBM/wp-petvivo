<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $post, $woocommerce, $product;
$attachment_ids = $product->get_gallery_attachment_ids();
?>

<div class="images">
	<figure>
	<div class="rh_table_image">
	<?php
		if ( has_post_thumbnail() ) {

            $showimg = new WPSM_image_resizer();
            $showimg->use_thumb = true;
            $height_figure_single = apply_filters( 'rh_woo_single_image_height', 350 );
            $showimg->height = $height_figure_single;
            $showimg->crop = false;  
            $showimg->lazy = false;         
            $image_url = $showimg->get_resized_url(); 	
            
			$props         = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );

			$attachment_count = count( $product->get_gallery_attachment_ids() );
			$gallery          = $attachment_count > 0 ? '[product-gallery]' : '';
			$imgtitle = get_the_title( get_post_thumbnail_id());

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '"><img src="%s" height="%s" width="%s" alt="%s" title="%s" /></a>', esc_url( $props['url'] ), esc_attr( $props['caption'] ), $image_url, $height_figure_single, $height_figure_single, $props['alt'], $props['title'] ), $post->ID );

		} else {

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );

		}
	?>
	</div>
	</figure>
	<?php do_action( 'woocommerce_product_thumbnails' ); ?>
</div>