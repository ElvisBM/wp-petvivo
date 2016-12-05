<?php global $product; global $post;?>
<?php if (empty( $product ) || ! $product->is_visible() ) {return;}?>
<?php $woolink = ($product->product_type =='external' && $product->add_to_cart_url() !='') ? $product->add_to_cart_url() : get_post_permalink(get_the_ID()) ;?>
<?php $offer_coupon = get_post_meta( get_the_ID(), 'rehub_woo_coupon_code', true ) ?>
<?php $offer_coupon_date = get_post_meta( get_the_ID(), 'rehub_woo_coupon_date', true ) ?>
<?php $offer_coupon_mask = get_post_meta( get_the_ID(), 'rehub_woo_coupon_mask', true ) ?>
<?php $offer_coupon_url = esc_url( $product->add_to_cart_url() ); ?>
<?php $coupon_style = $expired =''; if(!empty($offer_coupon_date)) : ?>
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
<?php do_action('woo_change_expired', $coupon_style); //Here we update our expired?>
<?php $coupon_mask_enabled = (!empty($offer_coupon) && ($offer_coupon_mask =='1' || $offer_coupon_mask =='on') && $expired!='1') ? '1' : ''; ?>
<?php $reveal_enabled = ($coupon_mask_enabled =='1') ? ' reveal_enabled' : '';?>
<?php $outsidelinkpart = ($coupon_mask_enabled=='1') ? 'data-codeid="'.$product->id.'" data-dest="'.$offer_coupon_url.'" data-clipboard-text="'.$offer_coupon.'" class="masked_coupon"' : '';?>
<?php 
if (!empty($offer_coupon)) {
    $deal_type = ' coupontype';
    $deal_type_string = __('Coupon', 'rehub_framework');
}
elseif ($product->is_on_sale()){
    $deal_type = ' saledealtype';
    $deal_type_string = __('Deal', 'rehub_framework');
}
else {
    $deal_type = ' defdealtype';
    $deal_type_string = __('Deal', 'rehub_framework');
}
?>
<div class="rehub_feat_block table_view_block <?php echo $reveal_enabled; echo $coupon_style; echo $deal_type; ?>">
    <div class="yith_re_block">
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
    <div class="block_with_coupon <?php echo $deal_type;?>">
        <div class="offer_thumb"> 
            <div class="deal_img_wrap">       
            <a href="<?php echo $woolink; ?>"<?php if ($product->product_type =='external'){echo ' target="_blank" rel="nofollow" '; echo $outsidelinkpart; } ?>>
            <?php if (!has_post_thumbnail() && $product->is_on_sale() && $product->get_regular_price() && $product->get_price() > 0) :?>
                <span class="sale_tag_inwoolist">
                    <h5>
                    <?php   
                        $offer_price_calc = (float) $product->get_price();
                        $offer_price_old_calc = (float) $product->get_regular_price();
                        $sale_proc = 0 -(100 - ($offer_price_calc / $offer_price_old_calc) * 100); 
                        $sale_proc = round($sale_proc); 
                        echo $sale_proc; echo '%';
                    ;?>
                    </h5>
                </span>
            <?php else :?>
                <?php if ($product->is_on_sale() && $product->get_regular_price() && $product->get_price() > 0) : ?>
                <span class="sale_a_proc">
                    <?php   
                        $offer_price_calc = (float) $product->get_price();
                        $offer_price_old_calc = (float) $product->get_regular_price();
                        $sale_proc = 0 -(100 - ($offer_price_calc / $offer_price_old_calc) * 100); 
                        $sale_proc = round($sale_proc); 
                        echo $sale_proc; echo '%';
                    ;?>
                </span> 
                <?php endif ?>              
                <?php WPSM_image_resizer::show_static_resized_image(array('lazy'=> false, 'thumb'=> true, 'crop'=> false, 'height'=> 92, 'no_thumb_url' => rehub_woocommerce_placeholder_img_src('')));?>
            <?php endif;?>
            </a>
            <div class="<?php echo $deal_type;?>_deal_string text-center deal_string"><?php echo $deal_type_string;?></div>
            </div>
        </div>
        <div class="desc_col">             
            <h3><a href="<?php echo $woolink; ?>"<?php if ($product->product_type =='external'){echo ' target="_blank" rel="nofollow"'; echo $outsidelinkpart; } ?>><?php echo rh_expired_or_not($post->ID, 'span');?><?php the_title(); ?></a></h3>
            <p>
                <?php kama_excerpt('maxchar=150'); ?>
                <?php $rehub_woo_review_related = get_post_meta( get_the_ID(), "review_woo_id", true ); if ( !empty($rehub_woo_review_related)) : ?>
                    <a href="<?php echo get_permalink($rehub_woo_review_related) ;?>" target="_blank" class="color_link"><?php _e("Read review", "rehub_framework") ;?></a>
                    <div class="clearfix"></div>
                <?php endif; ?>
            </p>
            <div class="woolist_meta">
                <span class="comm_count_meta"><?php comments_popup_link( __('no comments','rehub_framework'), __('1 comment','rehub_framework'), __('% comments','rehub_framework'), 'comm_meta', ''); ?></span>                
                <span class="date_ago"><i class="fa fa-clock-o"></i> <?php printf( __( '%s ago', 'rehub_framework' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?></span>
                <?php if (class_exists('WCV_Vendor_Shop')) :?>
                    <?php if(method_exists('WCV_Vendor_Shop', 'template_loop_sold_by')) :?>
                        <span class="woolist_vendor"><?php WCV_Vendor_Shop::template_loop_sold_by(get_the_ID()); ?></span>
                    <?php endif;?>
                <?php endif;?>                                  
            </div>
            <?php if (rehub_option('woo_thumb_enable') == '1') :?><?php echo getHotThumb(get_the_ID(), false);?><?php endif;?>
        </div>
        <div class="price_col">
            <?php if ($product->get_price() !='') : ?>
            <p><span class="price_count"><?php echo $product->get_price_html(); ?></span></p>
            <?php
                $price_clean = $product->get_price();
                $price_clean = rehub_price_clean($price_clean); 
                $result_min[] = $price_clean;
            ?>
            <?php endif ;?> 
            <div class="brand_logo_small">       
                <?php WPSM_Woohelper::re_show_brand_tax('list'); //show brand taxonomy?>
            </div>                                          
        </div>            
        <div class="buttons_col">
            <div class="priced_block">
                <?php if ( $product->is_in_stock() &&  $product->add_to_cart_url() !='') : ?>
                    <?php  echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                        sprintf( '<a href="%s" data-product_id="%s" data-product_sku="%s" class="re_track_btn woo_loop_btn btn_offer_block %s %s product_type_%s"%s%s>%s</a>',
                        esc_url( $product->add_to_cart_url() ),
                        esc_attr( $product->id ),
                        esc_attr( $product->get_sku() ),
                        $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                        $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
                        esc_attr( $product->product_type ),
                        $product->product_type =='external' ? ' target="_blank"' : '',
                        $product->product_type =='external' ? ' rel="nofollow"' : '',
                        esc_html( $product->add_to_cart_text() )
                        ),
                    $product );?>
                <?php endif; ?>                    
                <?php if ($coupon_mask_enabled =='1') :?>
                    <?php wp_enqueue_script('zeroclipboard'); ?>                
                    <a class="woo_loop_btn coupon_btn re_track_btn btn_offer_block rehub_offer_coupon masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" href="<?php echo $woolink; ?>"<?php if ($product->product_type =='external'){echo ' target="_blank" rel="nofollow"'; echo $outsidelinkpart; } ?>>
                        <?php if(rehub_option('rehub_mask_text') !='') :?><?php echo rehub_option('rehub_mask_text') ; ?><?php else :?><?php _e('Reveal coupon', 'rehub_framework') ?><?php endif ;?>
                    </a>
                <?php else :?> 
                    <?php if(!empty($offer_coupon)) : ?>
                        <?php wp_enqueue_script('zeroclipboard'); ?>
                        <div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>">
                            <i class="fa fa-scissors fa-rotate-180"></i>
                            <span class="coupon_text"><?php echo $offer_coupon ?></span>
                        </div>
                    <?php endif ;?>                                               
                <?php endif;?>
                <?php if(!empty($offer_coupon_date)) {echo '<div class="time_offer">'.$coupon_text.'</div>';} ?>                        
            </div>
        </div>
    </div>
</div>