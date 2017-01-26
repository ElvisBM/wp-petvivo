<?php use ContentEgg\application\helpers\TemplateHelper;?>
<div class="rehub_feat_block table_view_block<?php if ($i == 1){echo' best_price_item';}?>">               
        <div class="offer_thumb">   
            <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb, 'height'=> 100, 'title' => $offer_title, 'no_thumb_url' => get_template_directory_uri().'/images/default/noimage_100_70.png'));?>                                    
            </a>
        </div>
        <div class="desc_col desc_simple_col">
            <div class="simple_title">
                <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                    <?php echo esc_attr($offer_title); ?>
                </a>
            </div>                                
        </div>                    
        <div class="desc_col price_simple_col">
            <?php if($offer_price) : ?>
                <p itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                    <span class="price_count">
                        <?php echo TemplateHelper::formatPriceCurrency($offer_price, $currency_code, '<sup class="cur_sign">', '</sup>'); ?>
                        <?php if(!empty($offer_price_old)) : ?>
                        <strike>
                            <span class="amount"><?php echo TemplateHelper::formatPriceCurrency($offer_price_old, $currency_code, '<span class="value">', '</span>'); ?></span>
                        </strike>
                        <?php endif ;?>                                      
                    </span> 
                    <meta itemprop="price" content="<?php echo $offer_price ?>">
                    <meta itemprop="priceCurrency" content="<?php echo $currency_code; ?>">                        
                </p>
            <?php endif ;?>                        
        </div>
        <div class="desc_col shop_simple_col">
            <?php if(!empty($logo)) :?>
                <div class="egg-logo"><img src="<?php echo $logo; ?>" alt="<?php echo esc_attr($offer_title); ?>" /></div>
            <?php else :?>
                <div class="aff_tag">
                    <img src="<?php echo esc_attr(TemplateHelper::getMerhantIconUrl($item, true)); ?>" />
                    <?php if (!empty($merchant)):?>
                        <?php echo esc_html($merchant); ?>
                    <?php elseif(!empty($domain)):?>
                        <?php echo esc_html($domain); ?>    
                    <?php else:?>
                        <?php echo esc_html($item['domain']); ?>                                  
                    <?php endif;?>
                </div>
            <?php endif ;?>                         
        </div>
        <div class="buttons_col">
            <div class="priced_block clearfix">
                <div>
                    <a class="re_track_btn btn_offer_block" href="<?php echo esc_url($afflink) ?>" target="_blank" rel="nofollow">
                        <?php echo $btn_txt ; ?>
                    </a>                                                        
                </div>
            </div>
        </div>
                                                              
</div>