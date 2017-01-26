<?php
/*
  Name: Big product cart without title
 */

use ContentEgg\application\helpers\TemplateHelper;

?>

<?php foreach ($items as $item): ?>
    <?php $afflink = $item['url'] ;?>
    <?php $aff_thumb = $item['img'] ;?>
    <?php $merchant = (!empty($item['merchant'])) ? $item['merchant'] : ''; ?>
    <?php $offer_title = wp_trim_words( $item['title'], 20, '...' ); ?>  
    <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>   
    <div class="col_wrap_two">
        <div class="product_egg single_product_egg">

            <div class="image col_item">
                <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                    <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb, 'width'=> 500, 'title' => $offer_title));?>
                    <?php if(!empty($item['percentageSaved'])) : ?>
                        <span class="sale_a_proc">
                            <?php    
                                echo '-'; echo $item['percentageSaved']; echo '%';
                            ;?>
                        </span>
                    <?php endif ;?>                                   
                </a>                
            </div>

            <div class="product-summary col_item"> 
                <small class="small_size">
                    <?php if ($item['availability']): ?>
                        <?php _e('Available: ', 'rehub_framework') ;?><span class="yes_available"><?php _e('In stock', 'rehub_framework') ;?></span>
                        <br />
                    <?php endif; ?>                        
                </small>                             

                <?php if(!empty($item['price'])) : ?>
                    <div class="deal-box-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                        <sup class="cur_sign"><?php echo $item['currency']; ?></sup><?php echo TemplateHelper::price_format_i18n($item['price']); ?>
                        <?php if(!empty($item['priceOld'])) : ?>
                        <span class="retail-old">
                          <strike><span class="value"><?php echo TemplateHelper::price_format_i18n($item['priceOld']); ?></span></strike>
                        </span>
                        <?php endif ;?>                
                        <meta itemprop="price" content="<?php echo $item['price'] ?>">
                        <meta itemprop="priceCurrency" content="<?php echo $item['currencyCode']; ?>">
                        <?php if ($item['availability']): ?>
                            <link itemprop="availability" href="http://schema.org/InStock">
                        <?php endif ;?>                        
                    </div>                
                <?php endif ;?>
                <div class="buttons_col">
                    <div class="priced_block clearfix">
                        <div>
                            <a class="re_track_btn btn_offer_block" href="<?php echo esc_url($afflink) ?>" target="_blank" rel="nofollow">
                                <?php echo $btn_txt ; ?>
                                <span class="aff_tag mtinside"><?php echo $merchant; ?></span>
                            </a>                                                
                        </div>
                    </div>
                </div>                
                <?php if ($item['description']): ?>
                    <p><?php echo $item['description']; ?></p>                    
                <?php endif; ?>              
            </div>           
        </div> 
    </div>  
    <div class="clearfix"></div>
<?php endforeach; ?>     