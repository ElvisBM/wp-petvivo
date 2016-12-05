<?php

use ContentEgg\application\helpers\TemplateHelper;

\wp_enqueue_style('egg-bootstrap');
\wp_enqueue_style('content-egg-products');
?>

<div class="egg-container egg-list">
    <?php if ($title): ?>
        <h3><?php echo esc_html($title); ?></h3>
    <?php endif; ?>

    <div class="egg-listcontainer">
        <?php foreach ($items as $item): ?>
            <div class="row-products">
                <div class="col-md-2 col-sm-2 col-xs-12 cegg-image-cell">
                    <?php if ($item['img']): ?>
                        <a rel="nofollow" target="_blank" href="<?php echo $item['url']; ?>">
                            <img src="<?php echo $item['img']; ?>" alt="<?php echo esc_attr($item['title']); ?>" />
                        </a>
                    <?php endif; ?>
                </div>
                <div class="col-md-7 col-sm-7 col-xs-12 cegg-desc-cell">
                    <h4 class="cegg-no-top-margin">
                        <a rel="nofollow" target="_blank" href="<?php echo $item['url']; ?>">
                            <?php echo $item['title']; ?>
                        </a>
                    </h4>
                    <?php if (!empty($item['extra']['totalNew'])): ?>
                        <span class="text-muted">
                            <?php echo $item['extra']['totalNew']; ?>
                            <?php _e('new', 'content-egg-tpl'); ?> 
                            <?php if ($item['extra']['lowestNewPrice']): ?>
                                <?php _e('from', 'content-egg-tpl'); ?> <?php echo TemplateHelper::formatPriceCurrency($item['extra']['lowestNewPrice'], $item['currency']); ?>
                            <?php endif; ?>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($item['extra']['totalUsed'])): ?>
                        <span class="text-muted">
                            <br><?php echo $item['extra']['totalUsed']; ?>
                            <?php _e('used', 'content-egg-tpl'); ?> <?php _e('from', 'content-egg-tpl'); ?>
                            <?php echo TemplateHelper::formatPriceCurrency($item['extra']['lowestUsedPrice'], $item['currency']); ?>
                        </span>
                    <?php endif; ?>     
                    <?php if (!empty($item['domain'])): ?>
                        <div class="cegg-mb5">
                            <img src="<?php echo esc_attr(TemplateHelper::getMerhantIconUrl($item, true)); ?>" /> <small class="text-muted"><?php echo $item['domain']; ?></small>
                        </div>
                    <?php endif; ?>

                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 cegg-price-cell">
                    <div class="cegg-price-row">
                        <?php if ($item['priceOld']): ?>
                            <span class="text-muted"><strike><?php echo TemplateHelper::formatPriceCurrency($item['priceOld'], $item['currencyCode'], '<small>', '</small>'); ?></strike></span><br>
                        <?php endif; ?>
                        <?php if ($item['price']): ?>
                            <span class="cegg-price"><?php echo TemplateHelper::formatPriceCurrency($item['price'], $item['currencyCode'], '<span class="cegg-currency">', '</span>'); ?></span>
                        <?php elseif (!empty($item['extra']['toLowToDisplay'])): ?>
                            <span class="text-muted"><?php _e('Too low to display', 'content-egg-tpl'); ?></span>
                        <?php endif; ?> 
                    </div>         
                    <div class="cegg-btn-row cegg-mb10">
                        <a rel="nofollow" target="_blank" href="<?php echo $item['url']; ?>" class="btn btn-success"><?php _e('Buy This Item', 'content-egg-tpl'); ?></a> 
                    </div>  
                    <?php if (!empty($item['extra']['IsEligibleForSuperSaverShipping'])): ?>
                        <small class="text-muted text-success"><?php _e('Free shipping', 'content-egg-tpl'); ?></small>
                    <?php endif; ?>                                                         
                </div>
            </div>        
        <?php endforeach; ?>

    </div>   
    <?php if ($module_id == 'Amazon'): ?>
        <div class="row">
            <div class="col-md-12 text-right text-muted">
                <small><?php _e('Last updated on', 'content-egg-tpl'); ?> <?php echo TemplateHelper::getLastUpdateFormatted($module_id, true, $post_id); ?></small>
            </div>
        </div>        
    <?php endif; ?>

</div>