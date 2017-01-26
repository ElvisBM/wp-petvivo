<?php
/*
  Name: Just button
 */
?>

<?php foreach ($items as $item): ?>
<?php $afflink = $item['url'] ;?> 
<?php $merchant = 'flipkart.com'; ?>
<?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>   	    
<?php include(locate_template('inc/ce_common/data_button.php')); ?>                                                                 
<?php endforeach; ?>         