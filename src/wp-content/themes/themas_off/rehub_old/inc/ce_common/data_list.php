<?php use ContentEgg\application\helpers\TemplateHelper;?>
<div class="rehub_feat_block compact_w_deals table_view_block<?php if ($i == 1){echo' best_price_item';}?>">
    <div class="rehub_woo_review_tabs" style="display:table-row">
        <div class="offer_thumb">   
            <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb, 'width'=> 120, 'title' => $offer_title, 'no_thumb_url' => get_template_directory_uri().'/images/default/noimage_123_90.png'));?>                                    
            </a>                       
        </div>
        <div class="desc_col">
            <h4 class="offer_title">
                <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                    <?php echo esc_attr($offer_title); ?>
                </a>
            </h4>
            <?php if ($description): ?>
                <p><?php echo $description; ?></p> 
            <?php elseif(!empty($keyspecs)):?>
                <p class="featured_list">
                    <?php $total_spec = count($keyspecs); $count = 0;?>
                    <?php foreach ($keyspecs as $keyspec) :?>
                        <?php echo $keyspec; $count ++; ?><?php if ($count != $total_spec) :?>, <?php endif;?>
                    <?php endforeach; ?>   
                </p>                                   
            <?php endif; ?>                        
            <small class="small_size">
            <?php if ($availability): ?>
                <?php _e('Available: ', 'rehub_framework') ;?><span class="yes_available"><?php _e('In stock', 'rehub_framework') ;?></span>
            <?php endif; ?>                         
            </small>                                
        </div>
        <div class="buttons_col">
            <div class="priced_block clearfix">
                <?php if(!empty($offer_price)) : ?>
                    <p itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                        <span class="price_count">
                            <ins><?php echo TemplateHelper::formatPriceCurrency($offer_price, $currency_code); ?></ins>
                            <?php if(!empty($offer_price_old)) : ?>
                            <del>
                                <span class="amount"><?php echo $offer_price_old ?></span>
                            </del>
                            <?php endif ;?>                                      
                        </span> 
                        <meta itemprop="price" content="<?php echo $clean_price ?>">
                        <meta itemprop="priceCurrency" content="<?php echo $currency_code; ?>">
                        <?php if ($availability): ?>
                            <link itemprop="availability" href="http://schema.org/InStock">
                        <?php endif ;?>                         
                    </p>
                <?php endif ;?>
                <div>
                    <a class="re_track_btn btn_offer_block" href="<?php echo esc_url($afflink) ?>" target="_blank" rel="nofollow">
                        <?php echo $btn_txt ; ?>
                    </a>
                    <div class="egg-logo mt10">
                    <?php if(!empty($logo)) :?>
                        <img src="<?php echo $logo; ?>" alt="<?php echo esc_attr($offer_title); ?>" />
                    <?php else:?>
                        <img src="<?php echo esc_attr(TemplateHelper::getMerhantLogoUrl($item, true)); ?>" alt="<?php echo esc_attr($offer_title); ?>" />
                    <?php endif;?>
                    </div>
                    <?php if ($merchant) :?>
                        <div class="aff_tag mt10"><?php echo $merchant; ?></div>
                    <?php endif ;?>                        
                </div>
            </div>
        </div>
    </div>                                                          
</div>