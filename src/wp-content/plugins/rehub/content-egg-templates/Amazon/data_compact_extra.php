<?php
/*
  Name: Compact product cart with extra
 */
use ContentEgg\application\helpers\TemplateHelper;  
?>

<?php $random_key = rand(0, 50);?>
<?php foreach ($items as $item): ?>
    <?php $offer_price = (!empty($item['price'])) ? TemplateHelper::price_format_i18n($item['price']) : ''; ?>
    <?php $offer_price_old = (!empty($item['priceOld'])) ? TemplateHelper::price_format_i18n($item['priceOld']) : ''; ?>
    <?php $clean_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
    <?php $currency = (!empty($item['currency'])) ? $item['currency'] : ''; ?>
    <?php $currency_code = (!empty($item['currencyCode'])) ? $item['currencyCode'] : ''; ?>
    <?php $availability = (!empty($item['extra']['availability'])) ? $item['extra']['availability'] : ''; ?>
    <?php $instock = (!empty($item['in_stock'])) ? $item['in_stock'] : ''; ?>
    <?php $afflink = (!empty($item['url'])) ? $item['url'] : '' ;?>
    <?php $aff_thumb = (!empty($item['img'])) ? $item['img'] : '' ;?>
    <?php $offer_title = (!empty($item['title'])) ? wp_trim_words( $item['title'], 12, '...' ) : ''; ?>  
    <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>
    <?php $features = (!empty($item['extra']['itemAttributes']['Feature'])) ? $item['extra']['itemAttributes']['Feature'] : ''?>
    <?php $gallery_images = (!empty ($item['extra']['imageSet'])) ? $item['extra']['imageSet'] : ''?>

    <div class="rehub_woo_review compact_w_deals">
        <?php if (!empty ($features) || !empty ($gallery_images)) :?>
            <ul class="rehub_woo_tabs_menu">
                <li><?php _e('Product', 'rehub_framework') ?></li>
                <?php if (!empty ($features)) :?><li class="contaffdesc"><?php _e('Features', 'rehub_framework') ?></li><?php endif ;?>
                <?php if (!empty ($gallery_images)) :?><li class="pretty_woo"><?php _e('Photos', 'rehub_framework') ?></li><?php endif ;?>
            </ul>
        <?php endif ;?>
        <div class="rehub_feat_block table_view_block">
            <div class="rehub_woo_review_tabs" style="display:table-row">
                <div class="offer_thumb">   
                    <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                        <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb, 'width'=> 120, 'title' => $offer_title));?>                                   
                    </a>
                    <?php if (!empty($item['extra']['itemLinks'][3])): ?>
                        <span class="add_wishlist_ce">
                            <a href="<?php echo $item['extra']['itemLinks'][3]['URL'];?>" rel="nofollow" target="_blank" ><i class="fa fa-heart-o"></i></a>
                        </span>
                    <?php endif; ?>                    
                </div>
                <div class="desc_col">
                    <h4 class="offer_title">
                        <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                            <?php echo esc_attr($offer_title); ?>
                        </a>
                    </h4>
                    <?php if ($item['description']): ?>
                        <p><?php echo $item['description']; ?></p>
                        
                    <?php elseif ($features): ?>  
                        <p>
                            <ul class="featured_list">
                                <?php $length = $maxlength = '';?>
                                <?php foreach ($features as $k => $feature): ?>
                                    <?php $length = strlen($feature); $maxlength += $length; ?> 
                                    <li><?php echo $feature; ?></li>
                                    <?php if($k >= 4 || $maxlength > 200) break; ?>                                    
                            <?php endforeach; ?>
                            </ul>
                        </p>                     
                    <?php endif; ?>
                    <small class="small_size">
                        <?php if ($availability): ?>
                            <span class="yes_available"><?php echo $availability; ?></span>
                        <?php endif; ?>
                        <?php if ((bool) $item['extra']['IsEligibleForSuperSaverShipping']): ?>
                            <?php _e('& Free shipping', 'rehub_framework'); ?>
                        <?php endif; ?>                         
                    </small> 
                    <div class="last_update_amazon"><?php _e('Last update was in: ', 'rehub_framework'); ?><?php echo TemplateHelper::getLastUpdateFormatted('Amazon'); ?></div>                               
                </div>
                <div class="buttons_col">
                    <div class="priced_block clearfix">
                        <?php if(!empty($offer_price)) : ?>
                            <p itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                <span class="price_count">
                                    <ins><span><?php echo $currency; ?></span> <?php echo $offer_price ?></ins>
                                    <?php if(!empty($offer_price_old)) : ?>
                                    <del>
                                        <span class="amount"><?php echo $offer_price_old ?></span>
                                    </del>
                                    <?php endif ;?>                                      
                                </span> 
                                <meta itemprop="price" content="<?php echo $clean_price ?>">
                                <meta itemprop="priceCurrency" content="<?php echo $currency_code; ?>">
                                <?php if ($instock): ?>
                                    <link itemprop="availability" href="http://schema.org/InStock">
                                <?php endif ;?>                         
                            </p>
                        <?php endif ;?>
                        <div>
                            <a class="re_track_btn btn_offer_block" href="<?php echo esc_url($afflink) ?>" target="_blank" rel="nofollow">
                                <?php echo $btn_txt ; ?>
                            </a>
                            <?php $offer_coupon_mask = 1 ?>
                            <?php if(!empty($item['extra']['coupon']['code_date'])) : ?>
                                <?php 
                                $timestamp1 = strtotime($item['extra']['coupon']['code_date']); 
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
                                  $coupon_style = 'expired_coupon';
                                }                 
                                ?>
                            <?php endif ;?>
                            <?php  if(!empty($item['extra']['coupon']['code'])) : ?>
                                <?php wp_enqueue_script('zeroclipboard'); ?>
                                <?php if ($offer_coupon_mask !='1' && $offer_coupon_mask !='on') :?>
                                    <div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($item['extra']['coupon']['code_date'])) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $item['extra']['coupon']['code'] ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $item['extra']['coupon']['code'] ?></span></div>   
                                <?php else :?>
                                    <?php wp_enqueue_script('affegg_coupons'); ?>
                                    <div class="rehub_offer_coupon masked_coupon <?php if(!empty($item['extra']['coupon']['code_date'])) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $item['extra']['coupon']['code'] ?>" data-codetext="<?php echo $item['extra']['coupon']['code'] ?>" data-dest="<?php echo esc_url($item['url']) ?>"><?php if(rehub_option('rehub_mask_text') !='') :?><?php echo rehub_option('rehub_mask_text') ; ?><?php else :?><?php _e('Reveal coupon', 'rehub_framework') ?><?php endif ;?><i class="fa fa-external-link-square"></i></div>   
                                <?php endif;?>
                                <?php if(!empty($item['extra']['coupon']['code_date'])) {echo '<div class="time_offer">'.$coupon_text.'</div>';} ?>    
                            <?php endif ;?> 
                            <div class="aff_tag mt10"><?php echo rehub_get_site_favicon($item['url']); ?></div>                         
                        </div>
                    </div>
                </div>
            </div>
            <?php if (!empty ($features)) :?>
                <div class="rehub_woo_review_tabs contaffdesc">
                    <div class="wpsm_pros">
                        <ul class="featured_list">
                            <?php foreach ($features as $k => $feature): ?> 
                                <li><?php echo $feature; ?></li>                                   
                        <?php endforeach; ?>
                        </ul>
                    </div>                                 
                </div>
            <?php endif ;?> 
            <?php if (!empty ($gallery_images)) :?>
                <script>
                jQuery(document).ready(function($) {
                    'use strict'; 
                    $('.rehub_woo_review .pretty_woo a').attr('rel', 'prettyPhoto[rehub_product_gallery_<?php echo $random_key;?>]');
                    $(".rehub_woo_review .pretty_woo a[rel^='prettyPhoto']").prettyPhoto({social_tools:false});
                });
                </script>
                <div class="rehub_woo_review_tabs pretty_woo">
                    <?php wp_enqueue_script('prettyphoto');
                        foreach ($gallery_images as $gallery_img) {
                            ?> 
                            <a href="<?php echo esc_attr($gallery_img['LargeImage']) ;?>"> 
                            <img src="<?php echo esc_attr($gallery_img['ThumbnailImage']) ;?>" alt="<?php echo esc_attr($offer_title); ?>" />  
                            </a>
                            <?php
                        }
                    ?>
                </div>
            <?php endif ;?>                                                         
        </div>
    </div>
    <div class="clearfix"></div>
<?php endforeach; ?>