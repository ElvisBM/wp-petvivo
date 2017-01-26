<?php global $product; global $post; ?>
<?php if (empty( $product ) || ! $product->is_visible() ) {return;}?>
<?php $classes = array();?>
<?php $offer_coupon = get_post_meta( get_the_ID(), 'rehub_woo_coupon_code', true ) ?>
<?php $offer_coupon_date = get_post_meta( get_the_ID(), 'rehub_woo_coupon_date', true ) ?>
<?php $offer_coupon_mask = '1' ?>
<?php $offer_url = esc_url( $product->add_to_cart_url() ); ?>
<?php $coupon_style = $expired = ''; if(!empty($offer_coupon_date)) : ?>
    <?php 
    $timestamp1 = strtotime($offer_coupon_date); 
    $seconds = $timestamp1 - (int)current_time('timestamp',0); 
    $days = floor($seconds / 86400);
    $seconds %= 86400;
    if ($days > 0) {
      $coupon_text = $days.' '.__('days left', 'rehub_framework');
      $coupon_style = '';
    }
    elseif ($days == 0){
      $coupon_text = __('Last day', 'rehub_framework');
      $coupon_style = '';
    }
    else {
        $coupon_text = __('Expired', 'rehub_framework');
        $coupon_style = ' expired_coupon';
        $expired = '1';
    }                 
    ?>
<?php endif ;?>
<?php $coupon_mask_enabled = (!empty($offer_coupon) && ($offer_coupon_mask =='1' || $offer_coupon_mask =='on') && $expired!='1') ? '1' : ''; ?>
<?php if($coupon_mask_enabled =='1') {$classes[] = 'reveal_enabled';}?>
<?php do_action('woo_change_expired', $expired); //Here we update our expired?>
<div class="woomainlist clearfix <?php echo implode(' ', $classes); ?>">
	<div class="woomainlist_wrap_table">		
    <div class="featured_woomainlist_left">
    	<div>
        <figure>
        <a href="<?php the_permalink();?>">
            <?php if ( $product->is_on_sale()) : ?>
                <?php 
                $percentage=0;
                if ($product->regular_price) {
                    $percentage = round( ( ( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 );
                }
                if ($percentage && $percentage>0 && !$product->is_type( 'variable' )) {
                    $sales_html = '<span class="onsale"><span>- ' . $percentage . '%</span></span>';
                } else {
                    $sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product );
                }
                ?>
                <?php echo $sales_html; ?>
            <?php endif; ?>
            <?php if ( $product->is_featured() ) : ?>
                <?php if ($product->is_on_sale()) :?>
                    <?php echo apply_filters( 'woocommerce_featured_flash', '<span class="onfeatured onsalefeatured">' . esc_html__( 'Featured!', 'rehub_framework' ) . '</span>', $post, $product ); ?>
                <?php else :?>
                    <?php echo apply_filters( 'woocommerce_featured_flash', '<span class="onfeatured">' . __( 'Featured!', 'rehub_framework' ) . '</span>', $post, $product ); ?>
                <?php endif ;?>
            <?php endif; ?>        
        <?php 
            $showimg = new WPSM_image_resizer();
            $showimg->use_thumb = true;
            $showimg->no_thumb = rehub_woocommerce_placeholder_img_src('');
            $height_figure_single = apply_filters( 're_woolistmain_height', 138 );
            $showimg->height = $height_figure_single;
            $showimg->width = $height_figure_single;
            $showimg->crop = false;           
            $showimg->show_resized_image();                                    
        ?>
        </a>
        </figure> 
        </div>  
		<?php do_action( 'rehub_after_wooleft_list_thumb_figure' ); ?>
		<div class="woomainlist_btn_block">
            <div class="single_wooprice_count"><?php wc_get_template( 'loop/price.php' ); ?></div>
            <div class="woobtn_block_part">
                <?php if ( $product->is_in_stock() &&  $product->add_to_cart_url() !='') : ?>
                 <?php  echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                        sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="re_track_btn woo_loop_btn btn_offer_block %s %s product_type_%s"%s>%s</a>',
                        esc_url( $product->add_to_cart_url() ),
                        esc_attr( $product->id ),
                        esc_attr( $product->get_sku() ),
                        $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                        $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
                        esc_attr( $product->product_type ),
                        $product->product_type =='external' ? ' target="_blank"' : '',
                        esc_html( $product->add_to_cart_text() )
                        ),
                $product );?>
                <?php endif; ?>
                <?php if ($coupon_mask_enabled =='1') :?>
                    <?php wp_enqueue_script('zeroclipboard'); ?>
                    <a class="woo_loop_btn coupon_btn re_track_btn btn_offer_block rehub_offer_coupon masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>" data-codeid="<?php echo $product->id ?>" data-dest="<?php echo $offer_url ?>"><?php if(rehub_option('rehub_mask_text') !='') :?><?php echo rehub_option('rehub_mask_text') ; ?><?php else :?><?php _e('Reveal coupon', 'rehub_framework') ?><?php endif ;?>
                    </a>
                <?php else :?>
                    <?php if(!empty($offer_coupon)) : ?>
                        <?php wp_enqueue_script('zeroclipboard'); ?>
                        <div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $offer_coupon ?></span>
                        </div>
                    <?php endif;?>
                <?php endif;?> 
            </div>            
        </div>                                 
    </div>
    <div class="woomainlist_detail">
    	<div class="woomainlist_head">
	    	<?php if(rehub_option('woo_thumb_enable') == '1') :?><?php echo getHotLike(get_the_ID(), false, true); ?><?php endif ;?>
		    <?php echo rh_expired_or_not($post->ID, 'span');?><h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
		    <?php do_action( 'rehub_after_wooleft_list_thumb_title' ); ?>
		  
            <?php wc_get_template( 'loop/rating.php' );?>    
        </div>
	    <div class="woolistmain_desc"><?php kama_excerpt('maxchar=180'); ?></div>
        <?php if(rehub_option('woo_rhcompare') == 1) {echo wpsm_comparison_button(array('class'=>'rhwoolistcompare'));}?>        
        <?php do_action( 'rehub_vendor_show_action' ); ?>
	    <?php do_action( 'rehub_after_wooleft_list_thumb' ); ?>  
    </div>
    </div>   
</div>