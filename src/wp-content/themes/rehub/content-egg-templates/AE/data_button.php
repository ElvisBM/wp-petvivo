<?php
/*
  Name: Just button
 */
?>

<?php foreach ($items as $item): ?>
<?php $afflink = $item['url'] ;?> 
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
<?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>   	    
<?php include(locate_template('inc/ce_common/data_button.php')); ?>                                                                 
<?php endforeach; ?>         