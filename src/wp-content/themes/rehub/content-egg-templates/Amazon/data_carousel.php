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
            <?php $afflink = $item['url'] ;?>
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
                            <?php if(!empty($item['priceOld'])) : ?><del><span class="amount"><?php echo TemplateHelper::price_format_i18n($item['priceOld']); ?></span></del><?php endif ;?> 
                            <ins><span class="amount"><?php echo $item['currency']; ?></sup><?php echo TemplateHelper::price_format_i18n($item['price']); ?></span></ins>
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