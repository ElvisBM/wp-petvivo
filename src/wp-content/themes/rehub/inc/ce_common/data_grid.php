<?php use ContentEgg\application\helpers\TemplateHelper;?>
<article class="small_post">
    <div>
        <figure>
            <?php if($percentageSaved) : ?>
                <span class="sale_a_proc">
                    <?php    
                        echo '-'; echo $percentageSaved; echo '%';
                    ;?>
                </span>
            <?php endif ;?>                 
            <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb, 'width'=> 336, 'title' => $offer_title, 'no_thumb_url' => get_template_directory_uri().'/images/default/noimage_336_220.png'));?>                                    
            </a>
        </figure>
        <div class="affegg_grid_title">
            <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                <?php echo esc_attr($offer_title); ?>
            </a>
        </div>
        <div class="buttons_col">
            <div class="priced_block clearfix">
                <?php if(!empty($offer_price)) : ?>
                    <p itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                        <span class="price_count">
                            <ins>                        
                                <?php echo TemplateHelper::formatPriceCurrency($offer_price, $currency_code, '<sup class="cur_sign">', '</sup>'); ?>
                            </ins>
                            <?php if(!empty($offer_price_old)) : ?>
                            <del>
                                <span class="amount">
                                    <?php echo TemplateHelper::formatPriceCurrency($offer_price_old, $currency_code, '<span class="value">', '</span>'); ?>
                                </span>
                            </del>
                            <?php endif ;?>                                      
                        </span> 
                        <meta itemprop="price" content="<?php echo $offer_price ?>">
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
                    <div class="aff_tag mt10 small_size">
                        <img src="<?php echo esc_attr(TemplateHelper::getMerhantIconUrl($item, true)); ?>" />
                        <?php if (!empty($merchant)):?>
                            <?php echo esc_html($merchant); ?>
                        <?php elseif(!empty($domain)):?>
                            <?php echo esc_html($domain); ?>    
                        <?php else:?>
                            <?php echo esc_html($item['domain']); ?>                                  
                        <?php endif;?>                            
                    </div>                            
                </div>
            </div>
        </div>            
    </div>
</article>