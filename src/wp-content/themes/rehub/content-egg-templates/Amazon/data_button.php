<?php
/*
  Name: Just button
 */
?>

<?php foreach ($items as $item): ?>
<?php $offer_post_url = $item['url'] ;?>
<?php $afflink = apply_filters('rh_post_offer_url_filter', $offer_post_url );?> 
<?php $merchant = (!empty($item['merchant'])) ? $item['merchant'] : ''; ?>
<?php if (!empty($item['domain'])):?>
    <?php $domain = $item['domain'];?>
<?php elseif (!empty($item['extra']['domain'])):?>
    <?php $domain = $item['extra']['domain'];?>
<?php endif;?>  
<?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>   	    
<?php include(rh_locate_template('inc/ce_common/data_button.php')); ?>                                                                 
<?php endforeach; ?>         