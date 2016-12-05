<?php
/*
 * Name: All offers list
 * Modules:
 * Module Types: PRODUCT
 * 
 */

__('All offers list', 'content-egg-tpl');

use ContentEgg\application\helpers\TemplateHelper;
use ContentEgg\application\helpers\TextHelper;
?>
<?php
$all_items = array();
foreach ($data as $module_id => $items)
{
    foreach ($items as $item_ar)
    {
        $item_ar['module_id'] = $module_id;
        $all_items[] = $item_ar;
    }
}
usort($all_items, function($a, $b) {
    if (!$a['price'])
        return 1;
    if (!$b['price'])
        return -1;
    return $a['price'] - $b['price'];
});
?>
<?php
\wp_enqueue_style('egg-bootstrap');
\wp_enqueue_style('content-egg-products');
?>
<div class="egg-container">
    <?php if ($title): ?>
        <h3><?php echo esc_html($title); ?></h3>
    <?php endif; ?>

    <div class="egg-listcontainer">
        <?php foreach ($all_items as $key => $item): ?>           
            <div class="row-products">
                <div class="col-md-2 col-sm-2 col-xs-12 cegg-image-cell">
                    <?php if ($item['img']): ?>
                        <a rel="nofollow" target="_blank" href="<?php echo $item['url']; ?>">
                            <img src="<?php echo $item['img']; ?>" alt="<?php echo esc_attr($item['title']); ?>" />
                        </a>
                    <?php endif; ?>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12 cegg-desc-cell">
                    <h4 class="cegg-no-top-margin">
                        <a rel="nofollow" target="_blank" href="<?php echo $item['url']; ?>">
                            <?php echo esc_html(TextHelper::truncate($item['title'], 100)); ?>
                        </a>
                    </h4>
                    <?php if (!empty($item['domain'])): ?>
                        <div class="cegg-mb5">
                            <img src="<?php echo esc_attr(TemplateHelper::getMerhantIconUrl($item, true)); ?>" /> <small class="text-muted"><?php echo esc_html($item['domain']); ?></small>
                        </div>
                    <?php endif; ?>                    
                </div>

                <div class="col-md-2 col-sm-2 col-xs-12 offer_price cegg-price-cell">
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
</div>