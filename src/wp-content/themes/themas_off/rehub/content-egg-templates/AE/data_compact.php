<?php
/*
  Name: Compact product cart
 */
use ContentEgg\application\helpers\TemplateHelper;  
?>

<?php foreach ($items as $item): ?>
    <?php $modulename = $this->getModuleId();?>
    <?php $offer_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
    <?php $offer_price_old = (!empty($item['priceOld'])) ? TemplateHelper::price_format_i18n($item['priceOld']) : ''; ?>
    <?php $clean_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
    <?php $currency = (!empty($item['currency'])) ? $item['currency'] : ''; ?>
    <?php $currency_code = (!empty($item['currencyCode'])) ? $item['currencyCode'] : ''; ?>
    <?php $description = (!empty($item['description'])) ? $item['description'] : ''?>
    <?php $availability = (!empty($item['availability'])) ? $item['availability'] : ''; ?>  
    <?php $afflink = (!empty($item['url'])) ? $item['url'] : '' ;?>
    <?php $aff_thumb = (!empty($item['img'])) ? $item['img'] : '' ;?>
    <?php $offer_title = (!empty($item['title'])) ? wp_trim_words( $item['title'], 12, '...' ) : ''; ?>  
    <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>
    <?php $merchant = (!empty($item['merchant'])) ? $item['merchant'] : ''; ?>
    <?php if(empty($merchant)):?>
        <?php if (!empty($item['domain'])):?>
            <?php $merchant = $item['domain'];?>
        <?php elseif (!empty($item['extra']['domain'])):?>
            <?php $merchant = $item['extra']['domain'];?>
        <?php else:?>
            <?php $merchant = '';?>        
        <?php endif;?>
    <?php endif;?>    
    <?php $logo = (!empty($item['extra']['MerchantLogoURL'])) ? $item['extra']['MerchantLogoURL'] : ''; ?>  
    <?php if(empty($logo) && !empty($item['extra']['domain'])) :?>
        <?php $logo = rh_ae_logo_get('http://'.$item['extra']['domain'])?>             
    <?php endif;?> 
    <?php include(locate_template('inc/ce_common/data_compact.php')); ?>
<?php endforeach; ?>