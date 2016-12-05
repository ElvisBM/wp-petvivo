<?php

use ContentEgg\application\helpers\TemplateHelper;
?>
<div class="after-price-row cegg-mb20 cegg-lineh-20">
    <span class="text-muted">
        <?php if (!empty($item['extra']['totalNew'])): ?>
            <?php echo $item['extra']['totalNew']; ?>
            <?php _e('new', 'content-egg-tpl'); ?> 
            <?php if ($item['extra']['lowestNewPrice']): ?>
                <?php _e('from', 'content-egg-tpl'); ?> <?php echo TemplateHelper::formatPriceCurrency($item['extra']['lowestNewPrice'], $item['currency']); ?>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (!empty($item['extra']['totalUsed'])): ?>
            <br><?php echo $item['extra']['totalUsed']; ?>
            <?php _e('used', 'content-egg-tpl'); ?> <?php _e('from', 'content-egg-tpl'); ?>
            <?php echo TemplateHelper::formatPriceCurrency($item['extra']['lowestUsedPrice'], $item['currency']); ?>
        <?php endif; ?>
        <?php if (!empty($item['extra']['IsEligibleForSuperSaverShipping'])): ?>
            <br><small class="text-muted text-success"><?php _e('Free shipping', 'content-egg-tpl'); ?></small>
        <?php endif; ?>                            
    </span>
</div>