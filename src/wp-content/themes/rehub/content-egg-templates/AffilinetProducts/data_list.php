<?php
/*
  Name: Sorted list
 */
use ContentEgg\application\helpers\TemplateHelper;  
?>

<?php
// sort items by price
usort($items, function($a, $b) {
    if (!$a['price']) return 1;
    if (!$b['price']) return -1;
    return $a['price'] - $b['price'];
});
$product_price_update = get_post_meta( get_the_ID(), '_cegg_last_update_Otimisemedia'.$module_id, true );
$product_keyword_update = get_post_meta( get_the_ID(), '_cegg_last_bykeyword_update_Otimisemedia'.$module_id, true );
if ($product_price_update) {
    $product_update = date("F j, Y, g:i a", $product_price_update);
}
elseif ($product_keyword_update) {
   $product_update = date("F j, Y, g:i a", $product_keyword_update);  
}
?>

<div class="rehub_feat_block egg_sort_list notitle_sort_list"><a name="aff-link-list"></a>
    <div class="aff_offer_links">
        <?php $i=0; foreach ($items as $key => $item): ?> 

            <?php $offer_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
            <?php $offer_price_old = (!empty($item['priceOld'])) ? $item['priceOld'] : ''; ?>
            <?php $currency_code = (!empty($item['currencyCode'])) ? $item['currencyCode'] : ''; ?>          
            <?php $availability = (!empty($item['availability'])) ? $item['availability'] : ''; ?>        
            <?php $afflink = (!empty($item['url'])) ? $item['url'] : '' ;?>
            <?php $aff_thumb = (!empty($item['img'])) ? $item['img'] : '' ;?>
            <?php $offer_title = (!empty($item['title'])) ? wp_trim_words( $item['title'], 12, '...' ) : ''; ?> 
            <?php $merchant = (!empty($item['merchant'])) ? $item['merchant'] : ''; ?> 
            <?php if (!empty($item['domain'])):?>
                <?php $domain = $item['domain'];?>
            <?php elseif (!empty($item['extra']['domain'])):?>
                <?php $domain = $item['extra']['domain'];?>
            <?php endif;?> 

            <?php $description = (!empty($item['description'])) ? $item['description'] : '' ;?>
            <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>
            <?php $i++;?>  
 
            <?php include(rh_locate_template('inc/ce_common/data_list.php')); ?>
        <?php endforeach; ?>
        <?php if (!empty($product_update)) :?>
            <div class="last_update"><?php _e('Last update was on: ', 'rehub_framework'); ?><?php echo $product_update  ;?></div>
        <?php endif ;?>       
    </div>
</div>
<div class="clearfix"></div>