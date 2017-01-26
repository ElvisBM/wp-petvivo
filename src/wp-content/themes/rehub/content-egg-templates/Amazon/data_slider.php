<?php
/*
  Name: Slider
 */
use ContentEgg\application\helpers\TemplateHelper;  
?>

<?php  wp_enqueue_script('flexslider'); ?>

<div class="post_slider media_slider blog_slider egg_cart_slider loading">
    <ul class="slides">        
        <?php foreach ($items as $item): ?>
        <?php $offer_post_url = $item['url'] ;?>
        <?php $afflink = apply_filters('rh_post_offer_url_filter', $offer_post_url );?>
        <?php $aff_thumb = $item['img'] ;?>
        <?php $offer_title = wp_trim_words( $item['title'], 20, '...' ); ?>  
        <?php $offer_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
        <?php $offer_price_old = (!empty($item['priceOld'])) ? $item['priceOld'] : ''; ?>
        <?php $currency_code = (!empty($item['currencyCode'])) ? $item['currencyCode'] : ''; ?>        
        <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>   
        <li>
            <div class="col_wrap_two">
                <div class="product_egg">

                    <div class="image col_item">
                        <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                            <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb, 'width'=> 500, 'title' => $offer_title, 'no_thumb_url' => get_template_directory_uri().'/images/default/noim_gray.png'));?> 
                            <?php if(!empty($item['percentageSaved'])) : ?>
                                <span class="sale_a_proc">
                                    <?php    
                                        echo '-'; echo $item['percentageSaved']; echo '%';
                                    ;?>
                                </span>
                            <?php endif ;?>                                   
                        </a>
                        <?php if (!empty($item['extra']['itemLinks'][3])): ?>
                            <span class="add_wishlist_ce">
                                <a href="<?php echo $item['extra']['itemLinks'][3]['URL'];?>" rel="nofollow" target="_blank" ><i class="fa fa-heart-o"></i> <?php echo $item['extra']['itemLinks'][3]['Description'];?></a>
                            </span>
                        <?php endif; ?>                
                    </div>

                    <div class="product-summary col_item">
                    
                        <h2 class="product_title entry-title"><?php echo esc_attr($offer_title); ?> </h2>  
                        <small class="small_size">
                            <?php if ($item['availability']): ?>
                                <?php _e('Available: ', 'rehub_framework') ;?><span class="yes_available"><?php _e('In stock', 'rehub_framework') ;?></span>
                                <br />
                            <?php endif; ?>
                            <?php if ((bool) $item['extra']['IsEligibleForSuperSaverShipping']): ?>
                                <?php _e('& Free shipping', 'rehub_framework'); ?>
                            <?php endif; ?>                        
                        </small>                             

                        <?php if(!empty($offer_price)) : ?>
                            <div class="deal-box-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                <?php echo TemplateHelper::formatPriceCurrency($offer_price, $currency_code, '<sup class="cur_sign">', '</sup>'); ?>
                                <?php if(!empty($offer_price_old)) : ?>
                                <span class="retail-old">
                                    <strike>
                                        <?php echo TemplateHelper::formatPriceCurrency($offer_price_old, $currency_code, '<span class="value">', '</span>'); ?>
                                    </strike>
                                </span>
                                <?php endif ;?>                
                                <meta itemprop="price" content="<?php echo $offer_price ?>">
                                <meta itemprop="priceCurrency" content="<?php echo $currency_code; ?>">            
                            </div>                
                        <?php endif ;?>
                        <div class="buttons_col">
                            <div class="priced_block clearfix">
                                <div>
                                    <a class="re_track_btn btn_offer_block" href="<?php echo esc_url($afflink) ?>" target="_blank" rel="nofollow">
                                        <?php echo $btn_txt ; ?>
                                        <span class="aff_tag mtinside">
                                            <img src="<?php echo esc_attr(TemplateHelper::getMerhantIconUrl($item, true)); ?>" />
                                            <?php if (!empty($item['domain'])):?>
                                                <?php echo esc_html($item['domain']); ?>
                                            <?php elseif($item['extra']['domain']):?>
                                                <?php echo esc_html($item['extra']['domain']); ?>            
                                            <?php endif;?>                                             
                                        </span>
                                    </a>                                                
                                </div>
                            </div>
                        </div>                
                        <div class="last_update_amazon mb15"><?php _e('Last update was in: ', 'rehub_framework'); ?><?php echo TemplateHelper::getLastUpdateFormatted('Amazon'); ?></div>                    
                        <?php if ($item['extra']['itemAttributes']['Feature']): ?>  
                            <p>
                                <ul class="featured_list">
                                    <?php $length = $maxlength = '';?>
                                    <?php foreach ($item['extra']['itemAttributes']['Feature'] as $k => $feature): ?>
                                        <?php $length = strlen($feature); $maxlength += $length; ?> 
                                        <li><?php echo $feature; ?></li>
                                        <?php if($k >= 4 || $maxlength > 300) break; ?>                                    
                                <?php endforeach; ?>
                                </ul>
                            </p>                     
                        <?php endif; ?>              
                    </div>           
                </div>
            </div>  
        </li>
        <?php endforeach; ?>                   
    </ul>
</div>