<?php use ContentEgg\application\helpers\TemplateHelper;?>
<div class="col_wrap_two">
    <div class="product_egg single_product_egg">

        <div class="image col_item">
            <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb, 'width'=> 500, 'title' => $offer_title));?>
                <?php if($percentageSaved) : ?>
                    <span class="sale_a_proc">
                        <?php    
                            echo '-'; echo $percentageSaved; echo '%';
                        ;?>
                    </span>
                <?php endif ;?>                                   
            </a>                
        </div>

        <div class="product-summary col_item">
        
            <?php if($showtitle == 1):?> <h2 class="product_title entry-title"><?php echo esc_attr($offer_title); ?> </h2> <?php endif;?> 
            <small class="small_size">
                <?php if ($availability): ?>
                    <?php _e('Available: ', 'rehub_framework') ;?><span class="yes_available"><?php _e('In stock', 'rehub_framework') ;?></span>
                    <br />
                <?php endif; ?>                        
            </small>                             

            <?php if($offer_price) : ?>
                <div class="deal-box-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                    <?php echo TemplateHelper::formatPriceCurrency($offer_price, $currency_code, '<sup class="cur_sign">', '</sup>'); ?>
                    <?php if($offer_price_old) : ?>
                    <span class="retail-old">
                      <strike><?php echo TemplateHelper::formatPriceCurrency($offer_price_old, $currency_code, '<span class="value">', '</span>'); ?></strike>
                    </span>
                    <?php endif ;?>                
                    <meta itemprop="price" content="<?php echo $clean_price ?>">
                    <meta itemprop="priceCurrency" content="<?php echo $currency_code; ?>">
                    <?php if ($availability): ?>
                        <link itemprop="availability" href="http://schema.org/InStock">
                    <?php endif ;?>                        
                </div>                
            <?php endif ;?>
            <div class="buttons_col">
                <div class="priced_block clearfix">
                    <div>
                        <a class="re_track_btn btn_offer_block" href="<?php echo esc_url($afflink) ?>" target="_blank" rel="nofollow">
                            <?php echo $btn_txt ; ?>
                            <span class="aff_tag mtinside">
                                <img src="<?php echo esc_attr(TemplateHelper::getMerhantIconUrl($item, true)); ?>" />
                                <?php if (!empty($merchant)):?>
                                    <?php echo esc_html($merchant); ?>
                                <?php elseif(!empty($domain)):?>
                                    <?php echo esc_html($domain); ?>    
                                <?php else:?>
                                    <?php echo esc_html($item['domain']); ?>                                  
                                <?php endif;?>
                            </span>
                        </a>                                                
                    </div>
                </div>
            </div>  
            <?php if(!empty($item['extra']['keyspecs'])):?>
                <ul class="featured_list">
                    <?php foreach ($item['extra']['keyspecs'] as $keyspec) :?>
                        <li><?php echo $keyspec; ?></li>
                    <?php endforeach; ?>   
                </ul>
            <?php elseif ($description): ?>
                <p><?php echo $description; ?></p>                                                   
            <?php endif; ?>              
        </div>           
    </div> 
</div>  
<div class="clearfix"></div>   