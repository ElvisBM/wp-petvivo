<?php

use ContentEgg\application\helpers\TemplateHelper;
?>
<?php if (TemplateHelper::isPriceAlertAllowed($item['unique_id'], $module_id)): ?>

    <div class="cegg-price-alert-wrap">
        <strong><?php _e('Wait For A Price Drop', 'content-egg-tpl'); ?></strong>
        <form class="form-inline" style="margin-top: 10px; margin-bottom: 5px;">
            <input type="hidden" name="module_id" value="<?php echo esc_attr($module_id); ?>">
            <input type="hidden" name="unique_id" value="<?php echo esc_attr($item['unique_id']); ?>">
            <input type="hidden" name="post_id" value="<?php echo esc_attr(get_the_ID()); ?>">                                
            <div class="form-group">
                <label class="sr-only" for="cegg-email-<?php echo esc_attr($item['unique_id']); ?>"><?php _e('Your Email', 'content-egg-tpl'); ?></label>
                <input type="email" class="input-sm form-control" name="email" id="cegg-email-<?php echo esc_attr($item['unique_id']); ?>" placeholder="<?php _e('Your Email', 'content-egg-tpl'); ?>" required>
            </div>     
            <div class="form-group">
                <label class="sr-only" for="cegg-price-<?php echo esc_attr($item['unique_id']); ?>"><?php _e('Desired Price', 'content-egg-tpl'); ?></label>
                <div class="input-group">
                    <?php $cur_position = TemplateHelper::getCurrencyPos($item['currencyCode']); ?>
                    <?php if ($cur_position == 'left' || $cur_position == 'left_space'): ?>
                        <div class="input-group-addon"><?php echo TemplateHelper::getCurrencySymbol($item['currencyCode']); ?></div>
                    <?php endif; ?>
                    <input type="number" class="input-sm form-control" name="price" id="cegg-price-<?php echo esc_attr($item['unique_id']); ?>" placeholder="<?php _e('Desired Price', 'content-egg-tpl'); ?>" step="any" required>
                    <?php if ($cur_position == 'right' || $cur_position == 'right_space'): ?>
                        <div class="input-group-addon"><?php echo TemplateHelper::getCurrencySymbol($item['currencyCode']); ?></div>
                    <?php endif; ?>
                </div>                                          
            </div>     
            <button class="btn btn-warning btn-sm" type="submit"><?php _e('SET ALERT', 'content-egg-tpl'); ?></button>
        </form>
        <div class="cegg-price-loading-image" style="display: none;"><img src="<?php echo \ContentEgg\PLUGIN_RES . '/img/ajax-loader.gif' ?>" /></div>
        <div class="cegg-price-alert-result-succcess text-success" style="display: none;"></div>
        <div class="cegg-price-alert-result-error text-danger" style="display: none;"></div>
        <div class="text-muted small"><?php _e('You will receive a notification when the price drops.', 'content-egg-tpl'); ?></div>
    </div>
<?php endif; ?>