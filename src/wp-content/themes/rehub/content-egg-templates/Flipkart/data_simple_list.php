<?php
/*
  Name: Simple list
 */

?>

<?php
use ContentEgg\application\helpers\TemplateHelper;
$product_price_update = get_post_meta( get_the_ID(), '_cegg_last_update_Optimisedmedia', true );
$product_keyword_update = get_post_meta( get_the_ID(), '_cegg_last_bykeyword_update_Optimisedmedia', true );
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
            <?php $offer_price_old = (!empty($item['priceOld'])) ? TemplateHelper::price_format_i18n($item['priceOld']) : ''; ?>
            <?php $clean_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
            <?php $currency = (!empty($item['currency'])) ? $item['currency'] : ''; ?>
            <?php $currency_code = (!empty($item['currencyCode'])) ? $item['currencyCode'] : ''; ?>          
            <?php $availability = (!empty($item['availability'])) ? $item['availability'] : ''; ?>        
            <?php $afflink = (!empty($item['url'])) ? $item['url'] : '' ;?>
            <?php $aff_thumb = (!empty($item['img'])) ? $item['img'] : '' ;?>
            <?php $offer_title = (!empty($item['title'])) ? wp_trim_words( $item['title'], 10, '...' ) : ''; ?> 
            <?php $merchant = 'flipkart.com'; ?>
            <?php $logo = rh_ae_logo_get('http://flipkart.com'); ?>
            <?php $i++;?>  
            <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>  
            <?php include(locate_template('inc/ce_common/data_simple_list.php')); ?>
        <?php endforeach; ?>               
    </div>
    <?php if (!empty($product_update)) :?>
        <div class="last_update"><?php _e('Last update was on: ', 'rehub_framework'); ?><?php echo $product_update  ;?></div>
    <?php endif ;?>    
</div>
<div class="clearfix"></div>