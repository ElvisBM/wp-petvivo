<?php
/*
  Name: Carousel
 */
use ContentEgg\application\helpers\TemplateHelper;  
?>
<?php wp_enqueue_script('owlcarousel'); ?>



<div class="woo_carousel_block woo_sell_block loading carousel-style-2 carousel-style-deal woocommerce showrow-4">
    <div class="re_carousel" data-showrow="4" data-auto="1" data-fullrow="0" data-laizy="1" data-loopdisable="1">
        <?php $i=0; foreach ($items as $key => $item): ?>
            <?php $offer_post_url = $item['url'] ;?>
            <?php $afflink = apply_filters('rh_post_offer_url_filter', $offer_post_url );?>
            <?php $aff_thumb = $item['img'] ;?>
            <?php $offer_title = wp_trim_words( $item['title'], 8, '...' ); ?>
            <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>             
            <?php $i++;?>
            <div class="deal-item-wrap">
                <div class="deal-item"> 
                    <?php if(!empty($item['percentageSaved'])) : ?>
                        <span class="small_sale_a_proc">
                            <?php    
                                echo '-'; echo $item['percentageSaved']; echo '%';
                            ;?>
                        </span>
                    <?php endif ;?>                                         
                    <a rel="nofollow" class="re_track_btn" target="_blank" href="<?php echo esc_url($afflink) ?>">
                        <?php 
                            $showimg = new WPSM_image_resizer();
                            $showimg->use_thumb = false;
                            $showimg->width = '154';
                            $showimg->crop = true;
                            $showimg->lazy = false; 
                            $showimg->src = $aff_thumb;                                   
                        ?>
                        <img class="owl-lazy" data-src="<?php echo $showimg->get_resized_url();?>" alt="<?php the_title_attribute(); ?>">
                    </a>                    
                    <div class="info-overlay">                          
                    <?php if(!empty($item['price'])) : ?>
                        <span class="price">
                            <?php if(!empty($item['priceOld'])) : ?>
                                <del>
                                    <?php echo TemplateHelper::formatPriceCurrency($item['priceOld'], $item['currencyCode'], '<span class="value">', '</span>'); ?>
                                </del>
                            <?php endif ;?> 
                            <ins>
                                <?php echo TemplateHelper::formatPriceCurrency($item['price'], $item['currencyCode'], '<sup class="cur_sign">', '</sup>'); ?>
                            </ins>
                        </span>
                    <?php endif ;?>
                    </div>                                                                       
                </div>
                <div class="deal-detail">
                    <h3>
                        <a rel="nofollow" class="re_track_btn" target="_blank" href="<?php echo esc_url($afflink) ?>">
                            <?php echo esc_attr($offer_title); ?>
                        </a>
                    </h3>
                    <a class="re_track_btn woo_loop_btn btn_offer_block" href="<?php echo esc_url($afflink) ?>" target="_blank" rel="nofollow">
                        <?php echo $btn_txt ; ?>
                    </a>    
                </div>                  
            </div>            

        <?php endforeach; ?>
    </div>
</div>