<?php
/*
 * Name: All offers list with logos
 * Modules:
 * Module Types: PRODUCT
 * 
 */

__('All offers list with logos', 'content-egg-tpl');

use ContentEgg\application\helpers\TemplateHelper;
use ContentEgg\application\helpers\TextHelper;
?>

<?php
\wp_enqueue_style('egg-bootstrap');
\wp_enqueue_style('content-egg-products');
?>
<div class="egg-container">
    <?php if ($title): ?>
        <h3><?php echo esc_html($title); ?></h3>
    <?php endif; ?>
    
    <div class="egg-listcontainer cegg-list-withlogos">
        <?php foreach ($data as $module_id => $items): ?>
            <?php foreach ($items as $item): ?>
                <div class="row-products">
                    <div class="col-md-2 col-sm-2 col-xs-12 cegg-image-cell">
                        <?php if ($item['img']): ?>
                            <a rel="nofollow" target="_blank" href="<?php echo $item['url']; ?>">
                                <img src="<?php echo esc_attr(TemplateHelper::getMerhantLogoUrl($item, true)); ?>" alt="<?php echo esc_attr($item['title']); ?>" />                                
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 cegg-desc-cell">
                        <div class="cegg-no-top-margin cegg-list-logo-title">
                            <a rel="nofollow" target="_blank" href="<?php echo $item['url']; ?>">
                                <?php echo esc_html(TextHelper::truncate($item['title'], 100)); ?>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12 cegg-price-cell text-center">
                        <div class="cegg-price-row">
                            
                            <?php if ($item['priceOld']): ?>
                                <span class="text-muted"><strike><?php echo TemplateHelper::formatPriceCurrency($item['priceOld'], $item['currencyCode'], '<small>', '</small>'); ?></strike></span><br>
                            <?php endif; ?>
                            <?php if ($item['price']): ?>
                                <span class="cegg-price"><?php echo TemplateHelper::formatPriceCurrency($item['price'], $item['currencyCode']); ?></span>
                            <?php elseif (!empty($item['extra']['toLowToDisplay'])): ?>
                                <span class="text-muted"><?php _e('Too low to display', 'content-egg-tpl'); ?></span>
                            <?php endif; ?> 
                        </div> 
                    </div>                    
                    <div class="col-md-3 col-sm-3 col-xs-12 cegg-btn-cell">        
                        <div class="cegg-btn-row cegg-mb5">
                            <a rel="nofollow" target="_blank" href="<?php echo $item['url']; ?>" class="btn btn-success"><?php _e('Buy This Item', 'content-egg-tpl'); ?></a> 
                        </div>  
                        <?php if (!empty($item['extra']['IsEligibleForSuperSaverShipping'])): ?>
                            <strong class="text-success small cegg-mb10"><?php _e('Free shipping', 'content-egg-tpl'); ?></strong>
                        <?php endif; ?>    
                        <?php if (!empty($item['domain'])): ?>
                            <small class="text-muted"><?php echo esc_html($item['domain']); ?></small>
                        <?php endif; ?>                                                                             
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</div>