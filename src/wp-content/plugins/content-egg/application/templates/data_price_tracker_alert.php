<?php
/*
  Name: Price tracker & alert
 */
__('Price tracker & alert', 'content-egg-tpl');

use ContentEgg\application\helpers\TemplateHelper;

?>

<div class="egg-container cegg-price-tracker-item">

    <?php if ($title): ?>
        <h3><?php echo esc_html($title); ?></h3>
    <?php endif; ?>

    <div class="products">

        <?php foreach ($items as $item): ?>
            <div class="row">
                <div class="col-md-8">
                    <h3 class="media-heading" id="<?php echo esc_attr($item['unique_id']); ?>"><?php echo $item['title']; ?><?php if ($item['manufacturer']): ?>, <?php echo esc_html($item['manufacturer']); ?><?php endif; ?></h3>
                    <?php if (!empty($item['extra']['data']['rating'])): ?>
                        <span class="rating"><?php
                            echo str_repeat("<span>&#x2605</span>", $item['extra']['data']['rating']);
                            echo str_repeat("<span>☆</span>", 5 - $item['extra']['data']['rating']);
                            ?></span>
                    <?php endif; ?>                

                    <div class="panel panel-default cegg-price-tracker-panel">
                        <div class="panel-body">
                            <div class="row" style="margin-bottom: 0px;">
                                <div class="col-md-7 col-sm-7 col-xs-12 cegg-mb15">

                                    <?php if ($item['price']): ?>
                                        <span class="cegg-price">
                                            <small><?php _e('Price', 'content-egg-tpl'); ?>:</small> <?php echo TemplateHelper::formatPriceCurrency($item['price'], $item['currencyCode'], '<span class="cegg-currency">', '</span>'); ?>
                                        </span>
                                        <br><small class="text-muted"><?php _e('as of', 'content-egg-tpl'); ?> <?php echo TemplateHelper::getLastUpdateFormatted($module_id, false, $post_id, true); ?></small>
                                    <?php endif; ?>
                                    &nbsp;
                                </div>
                                <div class="col-md-5 col-sm-5 col-xs-12 text-muted">
                                    <a rel="nofollow" target="_blank" href="<?php echo $item['url']; ?>" class="btn btn-success"><?php _e('BUY THIS ITEM', 'content-egg-tpl'); ?></a>
                                    <?php if (!empty($item['domain'])): ?>
                                        <div class="cegg-mb5">
                                            <img src="<?php echo esc_attr(TemplateHelper::getMerhantIconUrl($item, false)); ?>" /> <small class="text-muted"><?php echo $item['domain']; ?></small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>

                    <?php $this->renderBlock('price_alert_inline', array('item' => $item)); ?>

                </div>                
                <div class="col-md-4">
                    <?php if ($item['img']): ?>
                        <div class="cegg-thumb">
                            <a rel="nofollow" target="_blank" href="<?php echo $item['url']; ?>">                    
                                <img src="<?php echo $item['img']; ?>" alt="<?php echo esc_attr($item['title']); ?>" />
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">

                    <?php $this->renderBlock('price_history', array('item' => $item)); ?>


                    <?php if ($item['description']): ?>
                        <p><?php echo $item['description']; ?></p>
                    <?php endif; ?>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
