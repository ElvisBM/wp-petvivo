<div class="rehub_woo_review compact_w_deals">
    <div class="rehub_feat_block table_view_block">
        <div class="rehub_woo_review_tabs" style="display:table-row">
            <div class="offer_thumb">   
                <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                    <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb, 'width'=> 120, 'title' => $offer_title));?>                                   
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
                                <ins><span><?php echo $currency; ?></span> <?php echo $offer_price ?></ins>
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
                        <?php if($logo) :?>
                            <div class="egg-logo mt10"><img src="<?php echo $logo; ?>" alt="<?php echo esc_attr($offer_title); ?>" /></div>
                        <?php elseif ($merchant) :?>
                            <div class="aff_tag mt10"><?php echo $merchant; ?></div>
                        <?php endif ;?>	                        
                    </div>
                </div>
            </div>
        </div>                                             
    </div>
</div>
<div class="clearfix"></div>
