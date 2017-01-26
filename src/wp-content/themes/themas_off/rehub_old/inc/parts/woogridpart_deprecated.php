<?php global $product; global $post;?>
<?php if ( ! $product->is_visible() )
    return;?>
<?php $offer_price = $product->get_price_html() ?>
<?php $offer_desc = get_the_excerpt() ?>
<?php $offer_title = $product->get_title() ?>
<?php $woolink = ($woolinktype == 'aff' && $product->product_type =='external') ? $product->add_to_cart_url() : get_post_permalink(get_the_ID()) ;?>
<?php $wootarget = ($woolinktype == 'aff' && $product->product_type =='external') ? ' target="_blank" rel="nofollow"' : '' ;?>
<?php $offer_coupon = get_post_meta( get_the_ID(), 'rehub_woo_coupon_code', true ) ?>
<?php $offer_coupon_date = get_post_meta( get_the_ID(), 'rehub_woo_coupon_date', true ) ?>
<?php $offer_coupon_mask = get_post_meta( get_the_ID(), 'rehub_woo_coupon_mask', true ) ?>
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
<?php $coupon_mask_enabled = (!empty($offer_coupon) && ($offer_coupon_mask =='1' || $offer_coupon_mask =='on') && $expired!='1') ? '1' : ''; ?> <?php $reveal_enabled = ($coupon_mask_enabled =='1') ? ' reveal_enabled' : '';?>        
<?php $thumb_enable = (rehub_option('woo_thumb_enable') == '1') ? ' thumb_enabled_col' : '' ?>  
<div class="offer_grid eq_height_post col_item woocommerce yith_float_btns<?php echo $reveal_enabled; echo $coupon_style; echo $thumb_enable;?>">          
    <div class="image_container offer_thumb"> 
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
        <a href="<?php echo $woolink ;?>"<?php echo $wootarget ;?> class="prodimglink">
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
            <?php 
            $showimg = new WPSM_image_resizer();
            $showimg->use_thumb = true; 
            $showimg->no_thumb = rehub_woocommerce_placeholder_img_src('');                                   
            ?>
            <?php if($columns == '3_col') : ?>
                <?php $showimg->width = '210';?>
            <?php elseif($columns == '4_col') : ?>
                <?php $showimg->width = '150';?>  
            <?php elseif($columns == '5_col') : ?>
                <?php $showimg->width = '180';?>   
            <?php elseif($columns == '6_col') : ?>
                <?php $showimg->width = '140';?>                      
            <?php else : ?>
                <?php $showimg->width = '210';?>                                       
            <?php endif ; ?>
            <?php $showimg->show_resized_image(); ?>
        </a>
            <div class="clearfix"></div>                        
    </div>
    <?php do_action( 'rehub_after_woo_grid_figure' ); ?>
    <div class="brand_logo_small">       
        <?php WPSM_Woohelper::re_show_brand_tax(); //show brand taxonomy?>
    </div> 
    <?php do_action( 'rehub_after_woogrid_brand' ); ?>          
    <div class="desc_col">                      
        <h3><a href="<?php echo $woolink ;?>"<?php echo $wootarget ;?>><?php echo $offer_title ;?></a></h3>
        <?php do_action( 'rehub_after_woo_grid_title' ); ?>                              
    </div>  
    <div class="buttons_col">        
        <div class="price_count"><?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?></div>
        <?php if (class_exists('WCV_Vendor_Shop')) :?>
            <?php if(method_exists('WCV_Vendor_Shop', 'template_loop_sold_by')) :?>
                <?php WCV_Vendor_Shop::template_loop_sold_by(get_the_ID()); ?>
            <?php endif;?>
        <?php endif;?>
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
    <?php do_action( 'rehub_after_woo_grid_button' ); ?>
    <?php if (rehub_option('woo_thumb_enable') == '1') :?>
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