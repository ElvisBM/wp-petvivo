<?php
/*
  Name: Compact product cart
 */
use ContentEgg\application\helpers\TemplateHelper;  
?>

<?php foreach ($items as $item): ?>
    <?php $offer_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
    <?php $offer_price_old = (!empty($item['priceOld'])) ? $item['priceOld'] : ''; ?>
    <?php $currency_code = (!empty($item['currencyCode'])) ? $item['currencyCode'] : ''; ?>
    <?php $description = (!empty($item['description'])) ? $item['description'] : ''?>
    <?php $availability = (!empty($item['availability'])) ? $item['availability'] : ''; ?>  
    <?php $afflink = (!empty($item['url'])) ? $item['url'] : '' ;?>
    <?php $aff_thumb = (!empty($item['img'])) ? $item['img'] : '' ;?>
    <?php $offer_title = (!empty($item['title'])) ? wp_trim_words( $item['title'], 12, '...' ) : ''; ?>  
    <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>
    <?php $merchant = (!empty($item['merchant'])) ? $item['merchant'] : ''; ?> 
    <?php if (!empty($item['domain'])):?>
        <?php $domain = $item['domain'];?>
    <?php elseif (!empty($item['extra']['domain'])):?>
        <?php $domain = $item['extra']['domain'];?>
    <?php endif;?>    
    <?php include(rh_locate_template('inc/ce_common/data_compact.php')); ?>
<?php endforeach; ?>