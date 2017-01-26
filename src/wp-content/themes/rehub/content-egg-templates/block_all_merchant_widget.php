<?php
/*
 * Name: List widget with merchants
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
<?php if(!empty($all_items)):?>

    <?php $postid = (isset($post_id)) ? $post_id : get_the_ID();?>
    <?php $unique_id = get_post_meta($postid, '_rehub_product_unique_id', true);?>
    <?php $module_id = get_post_meta($postid, '_rehub_module_ce_id', true);?>
    <?php $syncitem = $data[$module_id][$unique_id];?>

    <?php $rand = uniqid();?>
    <?php $countitems = count($all_items);?>
    <?php if ($unique_id && $module_id && !empty($syncitem)) :?>
        <?php include(rh_locate_template( 'inc/parts/pricealertpopup.php' ) ); ?>                                
    <?php endif;?>
    <div class="widget_merchant_list<?php if ($countitems > 7):?> expandme<?php endif;?>">
        <div class="tabledisplay">
            <?php  foreach ($all_items as $key => $item): ?>
                <?php $offer_post_url = $item['url'] ;?>
                <?php $afflink = apply_filters('rh_post_offer_url_filter', $offer_post_url );?>
                <?php $merchant = (!empty($item['merchant'])) ? $item['merchant'] : ''; ?>
                <?php $offer_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
                <?php $currency_code = (!empty($item['currencyCode'])) ? $item['currencyCode'] : ''; ?>
                <?php if (!empty($item['domain'])):?>
                    <?php $domain = $item['domain'];?>
                <?php elseif (!empty($item['extra']['domain'])):?>
                    <?php $domain = $item['extra']['domain'];?>
                <?php else:?>
                    <?php $domain = '';?>        
                <?php endif;?>           
                <?php $domain = rh_fix_domain($merchant, $domain);?>
                <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('See it', 'rehub_framework') ;?><?php endif ;?>  
                <div class="table_merchant_list">               
                    <div class="merchant_thumb">   
                        <a rel="nofollow" target="_blank" href="<?php echo esc_url($afflink) ?>" class="re_track_btn">
                            <?php if ($merchant) :?>
                                <?php echo rehub_get_site_favicon_icon('http://'.$domain); ?>
                                <?php echo $merchant; ?>
                            <?php else :?> 
                                <?php echo rehub_get_site_favicon('http://'.$domain); ?>                        
                            <?php endif ;?>                                                           
                        </a>
                    </div>                  
                    <div class="price_simple_col">
                        <?php if(!empty($item['price'])) : ?>
                            <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                <a rel="nofollow" target="_blank" href="<?php echo esc_url($afflink) ?>" class="re_track_btn">
                                    <span class="val_sim_price">
                                        <?php echo TemplateHelper::formatPriceCurrency($offer_price, $currency_code); ?>
                                    </span>                         
                                <meta itemprop="price" content="<?php echo $offer_price ?>">
                                <meta itemprop="priceCurrency" content="<?php echo $currency_code; ?>">
                                </a>                       
                            </div>
                        <?php endif ;?>                       
                    </div>
                    <div class="buttons_col">
                        <a class="re_track_btn" href="<?php echo esc_url($afflink) ?>" target="_blank" rel="nofollow">
                            <?php echo $btn_txt ; ?>
                        </a>                        			                        
                    </div>
                                                                              
                </div>
            <?php endforeach; ?> 
        </div>     
        <div class="additional_line_merchant flowhidden">
            <?php if ($countitems > 7):?>
            <span class="expand_all_offers"><?php _e('Show all', 'rehub_framework');?> <span class="expandme">+</span></span>
            <?php endif;?>
            <?php if ($unique_id && $module_id && !empty($syncitem)) {
                include(rh_locate_template( 'inc/parts/pricehistorypopup.php' ) );
            } ?>    
        </div>         
    </div>
    <div class="clearfix"></div>
<?php endif;?>