<?php
/*
  Name: Simple list
 */

?>

<?php
use ContentEgg\application\helpers\TemplateHelper;
$product_price_update = get_post_meta( get_the_ID(), '_cegg_last_update_Ebay', true );
$product_keyword_update = get_post_meta( get_the_ID(), '_cegg_last_bykeyword_update_Ebay', true );
if ($product_price_update) {
    $product_update = date("F j, Y, g:i a", $product_price_update);
}
elseif ($product_keyword_update) {
   $product_update = date("F j, Y, g:i a", $product_keyword_update);  
}
?>

<div class="egg_sort_list re_sort_list simple_sort_list mb20"><a name="aff-link-list"></a>
    <div class="aff_offer_links">
        <?php $i=0; foreach ($items as $key => $item): ?>
            <?php $offer_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
            <?php $offer_price_old = (!empty($item['priceOld'])) ? $item['priceOld'] : ''; ?>
            <?php $currency_code = (!empty($item['currencyCode'])) ? $item['currencyCode'] : ''; ?>        
            <?php $offer_post_url = $item['url'] ;?>
            <?php $afflink = apply_filters('rh_post_offer_url_filter', $offer_post_url );?>
            <?php $aff_thumb = $item['img'] ;?>
            <?php $offer_title = wp_trim_words( $item['title'], 10, '...' ); ?>
            <?php $i++;?>  
            <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>  
            <div class="rehub_feat_block table_view_block<?php if ($i == 1){echo' best_price_item';}?>">
                
                    <div class="offer_thumb">   
                        <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                            <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb, 'height'=> 100, 'title' => $offer_title, 'no_thumb_url' => get_template_directory_uri().'/images/default/noimage_100_70.png'));?>                                    
                        </a>
                    </div>
                    <div class="desc_col desc_simple_col">
                        <div class="simple_title">
                            <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                                <?php echo esc_attr($offer_title); ?>
                            </a>                            
                        </div>                                
                    </div>                    
                    <div class="desc_col price_simple_col">
                        <?php if(!empty($offer_price)) : ?>
                            <p itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                <span class="price_count">
                                    <span>
                                        <?php echo TemplateHelper::formatPriceCurrency($offer_price, $currency_code, '<sup class="cur_sign">', '</sup>'); ?>
                                    </span>
                                    <?php if(!empty($offer_price_old)) : ?>
                                    <strike>
                                        <?php echo TemplateHelper::formatPriceCurrency($offer_price_old, $currency_code, '<span class="amount">', '</span>'); ?>
                                    </strike>
                                    <?php endif ;?>                                     
                                </span>
                                <?php if ($item['extra']['listingInfo']['bestOfferEnabled'] == true): ?>
                                    <span class="best_offer_badge"><?php _e('Best offer', 'rehub_framework') ?></span> 
                                <?php endif; ?>                                 
                                <meta itemprop="price" content="<?php echo $offer_price ?>">
                                <meta itemprop="priceCurrency" content="<?php echo $currency_code; ?>">                        
                            </p>
                        <?php endif ;?>                        
                    </div>
                    <div class="desc_col shop_simple_col">
                        <div class="aff_tag mt10">
                            <img src="<?php echo esc_attr(TemplateHelper::getMerhantIconUrl($item, true)); ?>" />
                            <?php if (!empty($item['domain'])):?>
                                <?php echo esc_html($item['domain']); ?>
                            <?php elseif($item['extra']['domain']):?>
                                <?php echo esc_html($item['extra']['domain']); ?>            
                            <?php endif;?>                             
                        </div>                         
                    </div>
                    <div class="buttons_col">
                        <div class="priced_block clearfix">
                            <div>
                                <a class="re_track_btn btn_offer_block" href="<?php echo esc_url($afflink) ?>" target="_blank" rel="nofollow">
                                    <?php echo $btn_txt ; ?>
                                </a>                                                        
                            </div>
                        </div>
                    </div>
                                                                          
            </div>
        <?php endforeach; ?>               
    </div>
    <?php if (!empty($product_update)) :?>
        <div class="last_update"><?php _e('Last update was on: ', 'rehub_framework'); ?><?php echo $product_update  ;?></div>
    <?php endif ;?>    
</div>
<div class="clearfix"></div>