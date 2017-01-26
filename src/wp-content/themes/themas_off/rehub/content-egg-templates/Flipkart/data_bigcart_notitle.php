<?php
/*
  Name: Big product cart without title
 */

use ContentEgg\application\helpers\TemplateHelper;

?>

<?php foreach ($items as $item): ?>
    <?php $afflink = $item['url'] ;?>
    <?php $aff_thumb = $item['img'] ;?>
    <?php $merchant = 'flipkart.com'; ?>
    <?php $offer_title = wp_trim_words( $item['title'], 20, '...' ); ?>  
    <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>
    <?php $percentageSaved = (!empty($item['percentageSaved'])) ? $item['percentageSaved'] : '';?>
    <?php $availability = (!empty($item['availability'])) ? $item['availability'] : '';?> 
    <?php $offer_price = (!empty($item['price'])) ? TemplateHelper::price_format_i18n($item['price']) : ''; ?>
    <?php $offer_price_old = (!empty($item['priceOld'])) ? TemplateHelper::price_format_i18n($item['priceOld']) : ''; ?>
    <?php $clean_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
    <?php $currency = (!empty($item['currency'])) ? $item['currency'] : ''; ?>
    <?php $currency_code = (!empty($item['currencyCode'])) ? $item['currencyCode'] : ''; ?>
    <?php $description = (!empty($item['description'])) ? $item['description'] : '';?>
    <?php $keyspecs = (!empty($item['extra']['keySpecs'])) ? $item['extra']['keySpecs'] : '';?>    
    <?php $showtitle = 0; ?>
    <?php include(locate_template('inc/ce_common/data_bigcart.php')); ?>
<?php endforeach; ?>     