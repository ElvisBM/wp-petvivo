<?php
/*
 * Name: Price history table with graph
 * Modules:
 * Module Types: PRODUCT
 * 
 */
?>
<?php
use ContentEgg\application\helpers\TemplateHelper;
// sort items by price
?>
<?php if (2.8 <= ContentEgg\application\Plugin::version()) :?>
    <?php $postid = (isset($post_id)) ? $post_id : get_the_ID();?>
    <?php $unique_id = get_post_meta($postid, '_rehub_product_unique_id', true);?>
    <?php $module_id = get_post_meta($postid, '_rehub_module_ce_id', true);?>

    <?php if ($unique_id && $module_id) :?>
        <?php $syncitem = $data[$module_id][$unique_id];?>
        <?php $pricesarray = TemplateHelper::priceHistoryPrices($unique_id, $module_id, $limit = 3);
            $pricescheck = '';
            if (!empty($pricesarray) && is_array($pricesarray)){
                $pricescheck = (count($pricesarray) > 1) ? true : '';
            }
        ?>
        <?php if (!empty($pricescheck) && !empty($syncitem)) :?>
            <table class="rh-tabletext-block">
                <tr>
                <th class="rh-tabletext-block-heading" colspan="2"><?php _e('Price history for ', 'rehub_framework');?><?php echo $syncitem['title']; ?></th>
                </tr>
                <tr>
                <td class="rh-tabletext-block-left">

                    <div class="rh-tabletext-block-latest"> 
                    <div class="mb10"><strong><?php _e('Latest updates:', 'rehub_framework');?></strong></div>                             
                    <?php $prices = TemplateHelper::priceHistoryPrices($unique_id, $module_id, $limit = 8); ?>
                    <?php if ($prices): ?>
                        <ul>
                            <?php foreach ($prices as $price): ?>
                                <li>
                                    <?php echo TemplateHelper::formatPriceCurrency($price['price'], $syncitem['currencyCode']); ?>                    
                                    - <?php echo date(get_option('date_format'), $price['date']); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <?php $since = TemplateHelper::priceHistorySinceDate($unique_id, $module_id); ?>
                    <?php if ($since): ?>
                        <?php _e('Since:', 'rehub_framework');?> <?php echo date(get_option('date_format'), $since); ?>
                    <?php endif; ?>                    
                    </div>
                </td>
                <td class="rh-tabletext-block-right">
                    <?php TemplateHelper::priceHistoryMorrisChart($unique_id, $module_id, 180, array('lineWidth' => 2, 'postUnits' => ' ' . $syncitem['currencyCode'], 'goals' => array((int) $syncitem['price']), 'fillOpacity' => 0.5), array('style' => 'height: 230px;')); ?>
                    <ul class="rh-lowest-highest">
                        <?php $price = TemplateHelper::priceHistoryMax($unique_id, $module_id); ?>
                        <?php if ($price): ?>
                            <li>
                                <b style="color: red;">Highest Price:</b> 
                                <?php echo TemplateHelper::formatPriceCurrency($price['price'], $syncitem['currencyCode']); ?> 
                                - <?php echo date(get_option('date_format'), $price['date']); ?>
                            </li>
                        <?php endif; ?>

                        <?php $price = TemplateHelper::priceHistoryMin($unique_id, $module_id); ?>
                        <?php if ($price): ?>
                            <li>
                                <b style="color: green;">Lowest Price:</b> 
                                <?php echo TemplateHelper::formatPriceCurrency($price['price'], $syncitem['currencyCode']); ?>   
                                - <?php echo date(get_option('date_format'), $price['date']); ?>
                            </li>
                        <?php endif; ?>
                    </ul>            
                </td>
                </tr>                
            </table>
        <?php endif;?>
    <?php endif;?>
<?php endif;?>