<?php global $product; global $post;?>
<?php if (empty( $product ) || ! $product->is_visible() ) {return;}?>
<?php $classes = array('product', 'col_item');?>
<?php if (rehub_option('woo_btn_disable') == '1'){$classes[] = 'non_btn';}?>

<?php $disable_thumbs = (isset($disable_thumbs)) ? $disable_thumbs : '';?>
<?php $woolinktype = (isset($woolinktype)) ? $woolinktype : '';?>
<?php $woolink = ($woolinktype == 'aff' && $product->product_type =='external') ? $product->add_to_cart_url() : get_post_permalink($post->ID) ;?>
<?php $wootarget = ($woolinktype == 'aff' && $product->product_type =='external') ? ' target="_blank" rel="nofollow"' : '' ;?>
<?php $offer_coupon = get_post_meta( $post->ID, 'rehub_woo_coupon_code', true ) ?>
<?php $offer_coupon_date = get_post_meta( $post->ID, 'rehub_woo_coupon_date', true ) ?>
<?php $offer_coupon_mask = '1' ?>
<?php $offer_url = esc_url( $product->add_to_cart_url() ); ?>
<?php $coupon_style = $expired = ''; if(!empty($offer_coupon_date)) : ?>
    <?php 
    $timestamp1 = strtotime($offer_coupon_date); 
    $seconds = $timestamp1 - time(); 
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
        $coupon_text = __('Coupon is Expired', 'rehub_framework');
        $coupon_style = ' expired_coupon';
        $expired = '1';
    }                 
    ?>
<?php endif ;?>
<?php do_action('woo_change_expired', $expired); //Here we update our expired?>
<?php $classes[] = $coupon_style;?>
<?php $coupon_mask_enabled = (!empty($offer_coupon) && ($offer_coupon_mask =='1' || $offer_coupon_mask =='on') && $expired!='1') ? '1' : ''; ?>
<?php if($coupon_mask_enabled =='1') {$classes[] = 'reveal_enabled';}?>
<?php if(rehub_option('woo_thumb_enable') == '1' && !$disable_thumbs) {$classes[] = 'thumb_enabled_col';}?>
<div <?php post_class( $classes ); ?>>
    <figure class="centered_image_woo">
        <a href="<?php echo $woolink ;?>"<?php echo $wootarget ;?>>
            <?php if ( $product->is_featured() ) : ?>
                    <?php echo apply_filters( 'woocommerce_featured_flash', '<span class="onfeatured">' . esc_html__( 'Featured!', 'woocommerce' ) . '</span>', $post, $product ); ?>
            <?php endif; ?>        
            <?php if ( $product->is_on_sale() ) : ?>
                <?php 
                $percentage=0;
                $featured = ($product->is_featured()) ? ' onsalefeatured' : '';
                if ($product->regular_price) {
                    $percentage = round( ( ( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 );
                }
                if ($percentage) {
                    $sales_html = '<span class="onsale'.$featured.'"><span>- ' . $percentage . '%</span></span>';
                } else {
                    $sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="onsale'.$featured.'">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product );
                }
                ?>
                <?php echo $sales_html; ?>
            <?php endif; ?>
            <?php 
            $showimg = new WPSM_image_resizer();
            $showimg->use_thumb = true; 
            $showimg->no_thumb = rehub_woocommerce_placeholder_img_src('');                                   
            ?>
            <?php if($columns == '3_col') : ?>
                <?php $showimg->width = '224';?>
            <?php elseif($columns == '4_col') : ?>
                <?php $showimg->width = '156';?>  
            <?php elseif($columns == '5_col') : ?>
                <?php $showimg->width = '186';?>   
            <?php elseif($columns == '6_col') : ?>
                <?php $showimg->width = '146';?>                      
            <?php else : ?>
                <?php $showimg->width = '224';?>                                       
            <?php endif ; ?>            
            <?php $showimg->show_resized_image(); ?>
        </a>
        <div class="yith_float_btns">
            <div class="button_action"> 
                <?php if (in_array( 'yith-woocommerce-compare/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )  { ?>
                    <?php 
                        $yith_compare = new YITH_Woocompare_Frontend();
                        add_shortcode( 'yith_compare_button', array( $yith_compare , 'compare_button_sc' ) );
                        echo do_shortcode('[yith_compare_button]'); 
                    ?>                
                <?php } ?>
                <?php if (in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )  { ?> 
                    <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?> 
                <?php } ?>                                          
            </div> 
        </div>          
        <div class="brand_store_tag">       
            <?php WPSM_Woohelper::re_show_brand_tax(); //show brand taxonomy?>
        </div>
        <?php do_action( 'rehub_after_woo_brand' ); ?>
    </figure>
    <div class="woo_loop_desc">      
        <a <?php if(rehub_option('woo_thumb_enable') =='1') :?>class="<?php echo getHotIconclass($post->ID); ?>"<?php endif ;?> href="<?php echo $woolink ;?>"<?php echo $wootarget ;?>>
            <?php echo rh_expired_or_not($post->ID, 'span');?>     
            <?php 
                /**
                 * woocommerce_shop_loop_item_title hook.
                 *
                 * @hooked woocommerce_template_loop_product_title - 10
                 */     
                do_action( 'woocommerce_shop_loop_item_title' ); 
            ?>
        </a>
        <?php do_action( 'rehub_vendor_show_action' ); ?>            
    </div>
    <div class="woo_loop_btn_actions">
        <div class="product_price_height">
            <?php
                /**
                 * woocommerce_after_shop_loop_item_title hook.
                 *
                 * @hooked woocommerce_template_loop_rating - 5
                 * @hooked woocommerce_template_loop_price - 10
                 */
                do_action( 'woocommerce_after_shop_loop_item_title' );
            ?>
        </div>
        <?php if (rehub_option('woo_btn_disable') != '1'):?>
            <?php if ( $product->add_to_cart_url() !='') : ?>
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
        <?php endif;?>            
    </div>
    <?php if (rehub_option('woo_thumb_enable') == '1' && !$disable_thumbs) :?>
        <div class="re_actions_for_grid two_col_btn_for_grid">
            <div class="btn_act_for_grid">
                <?php echo getHotThumb($post->ID, false);?>
            </div>
            <div class="btn_act_for_grid">
                <span class="comm_number_for_grid"><?php echo get_comments_number(); ?></span>
            </div>
        </div>  
    <?php endif;?>  

</div>