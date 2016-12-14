<?php
/*
 * Name: List widget with store logos
 * Modules:
 * Module Types: PRODUCT
 * 
 */
?>
<?php
use ContentEgg\application\helpers\TemplateHelper;
// sort items by price
?> 
<?php 
    $all_items = array(); 
    foreach ($data as $module_id => $items) {
        foreach ($items as $item_ar) {
            $item_ar['module_id'] = $module_id;
            $all_items[] = $item_ar;

        }       
    }
    usort($all_items, function($a, $b) {
        if (!$a['price']) return 1;
        if (!$b['price']) return -1;
        return $a['price'] - $b['price'];
    }); 
               
?>

<div class="widget_logo_list">
    
    <?php  foreach ($all_items as $key => $item): ?>
        <?php $afflink = $item['url'] ;?>
        <?php $aff_thumb = $item['img'] ;?>
        <?php $offer_title = wp_trim_words( $item['title'], 10, '...' ); ?>
        <?php $merchant = (!empty($item['merchant'])) ? $item['merchant'] : ''; ?>
        <?php $manufacturer = (!empty($item['manufacturer'])) ? $item['manufacturer'] : ''; ?>
        <?php $offer_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
        <?php $offer_price_old = (!empty($item['priceOld'])) ? $item['priceOld'] : ''; ?> 
        <?php $currency_code = (!empty($item['currencyCode'])) ? $item['currencyCode'] : ''; ?>
        <?php if (!empty($item['domain'])):?>
            <?php $domain = $item['domain'];?>
        <?php elseif (!empty($item['extra']['domain'])):?>
            <?php $domain = $item['extra']['domain'];?>
        <?php else:?>
            <?php $domain = '';?>        
        <?php endif;?>    
        <?php $domain = rh_fix_domain($merchant, $domain);?> 
        <?php if(empty($merchant) && !empty($domain)) {
            $merchant = $domain;
        }
        ?>
        <?php if (!empty($item['logo'])) :?>
            <?php $logo = $item['logo']; ?>                       
        <?php elseif (!empty($item['extra']['logo'])) :?>
            <?php $logo = $item['extra']['logo']; ?>
        <?php elseif (!empty($item['extra']['MerchantLogoURL'])) :?>
            <?php $logo = $item['extra']['MerchantLogoURL']; ?>
        <?php elseif (!empty($item['extra']['programLogo'])) :?>
            <?php $logo = $item['extra']['programLogo']; ?>                         
        <?php elseif(isset($item['module_id']) && $item['module_id'] =='Amazon') :?>
            <?php $logo = get_template_directory_uri().'/images/logos/amazon.png' ;?>
        <?php elseif(isset($item['module_id']) && $item['module_id'] =='Aliexpress') :?>
            <?php $logo = get_template_directory_uri().'/images/logos/aliexpress.png' ;?> 
        <?php elseif(isset($item['module_id']) && $item['module_id'] =='Ebay') :?>
            <?php $logo = get_template_directory_uri().'/images/logos/ebay.png' ;?> 
        <?php elseif(isset($item['module_id']) && $item['module_id'] =='Flipkart') :?>
            <?php $logo = get_template_directory_uri().'/images/logos/flipkart.png' ;?>  
        <?php elseif(isset($item['module_id']) && $item['module_id'] =='PayTM') :?>
            <?php $logo = get_template_directory_uri().'/images/logos/paytm.jpg' ;?>                       
        <?php elseif(isset($item['module_id']) && !empty($domain)) :?>
            <?php $logo = rh_ae_logo_get('http://'.$domain); ?>                                             
        <?php else :?>
            <?php $logo = ''; ?>
        <?php endif;?>    
        <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('See it', 'rehub_framework') ;?><?php endif ;?>  
        <div class="table_div_list">               
            <div class="offer_thumb<?php if(!$logo) {echo ' nologo_thumb';}?>">   
                <a rel="nofollow" target="_blank" href="<?php echo esc_url($afflink) ?>" class="re_track_btn">
                    <?php if($logo) :?>
                        <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $logo, 'lazy'=>false, 'height'=> 30, 'title' => $offer_title, 'no_thumb_url' => get_template_directory_uri().'/images/default/noimage_100_70.png'));?>
                           
                    <?php endif ;?>                                                           
                </a>
            </div>                  
                <div class="price_simple_col">
                    <?php if(!empty($item['price'])) : ?>
                        <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                            <span class="val_sim_price">
                                <?php echo TemplateHelper::formatPriceCurrency($offer_price, $currency_code); ?>
                            </span>
                            <?php if(!empty($offer_price_old)) : ?>
                                <strike>
                                    <span class="amount">
                                        <?php echo TemplateHelper::price_format_i18n($offer_price_old); ?>
                                    </span>
                                </strike>
                            <?php endif;?>                              
                            <meta itemprop="price" content="<?php echo $offer_price ?>">
                            <meta itemprop="priceCurrency" content="<?php echo $currency_code; ?>">               
                        </div>
                    <?php endif ;?> 
                    <span class="vendor_sim_price"><?php echo $merchant;?> </span>                       
                </div>
                <div class="buttons_col">
                    <a class="wpsm-button rehub_main_btn re_track_btn" href="<?php echo esc_url($afflink) ?>" target="_blank" rel="nofollow">
                        <?php echo $btn_txt ; ?>
                    </a>                        			                        
                </div>
                                                                      
        </div>
    <?php endforeach; ?>                 
    <?php if (!empty($product_price_update)) :?>
        <div class="last_update"><?php _e('Last price update: ', 'rehub_framework'); ?><?php echo TemplateHelper::getLastUpdateFormatted('Amazon'); ?></div>
    <?php endif ;?>   
</div>
<div class="clearfix"></div>