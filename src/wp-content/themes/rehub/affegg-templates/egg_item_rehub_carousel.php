<?php
/*
  Name: Carousel
 */
?>
<?php
//$product_price_update = get_post_meta( get_the_ID(), 'affegg_product_last_update', true );
//$best_price_value = $items[0]['price'];
//$best_price_currency = $items[0]['currency'];
?>
<?php wp_enqueue_script('owlcarousel'); ?>

<!-- Carousel -->
    <div class="post_carousel_block loading carousel-style-2">
        <div class="re_carousel egg_carousel" data-showrow="4" data-auto="0" data-laizy="1">    
            
            <?php $i=0; foreach ($items as $key => $item): ?>
                <?php $offer_price = str_replace(' ', '', $item['price']); if($offer_price =='0') {$offer_price = '';} ?>
                <?php $offer_price_old = str_replace(' ', '', $item['old_price']); if($offer_price_old =='0') {$offer_price_old = '';} ?>
                <?php $offer_post_url = $item['url'] ;?>
                <?php $afflink = apply_filters('rh_post_offer_url_filter', $offer_post_url );?>
                <?php $aff_thumb = $item['img'] ;?>
                <?php $offer_title = wp_trim_words( $item['title'], 8, '...' ); ?>
                <?php $i++;?> 
                <div class="carousel-item">
                    <figure>                        
                        <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>"<?php echo $item['ga_event'] ?>>
                        <?php if(!empty($offer_price_old) && $offer_price_old !='0') : ?>
                            <span class="sale_a_proc">
                                <?php   
                                    $offer_price_calc = intval(str_replace(',', '', $item['price']));
                                    $offer_price_old_calc = intval(str_replace(',', '', $item['old_price']));
                                    $sale_proc = 0 -(100 - ($offer_price_calc / $offer_price_old_calc) * 100); 
                                    $sale_proc = round($sale_proc); 
                                    echo $sale_proc; echo '%';
                                ;?>
                            </span>
                        <?php endif ;?> 
                            <?php $params = array( 'width' => 300, 'height' => 216, 'crop' => true);  ?>
                            <?php if(!empty($aff_thumb)) : ?>
                               <?php  $thumb_src = bfi_thumb( esc_attr($aff_thumb), $params ); ?>
                            <?php else : ?>    
                                <?php  $thumb_src = get_template_directory_uri() . '/images/default/noimage_300_216.png' ; ?>
                            <?php endif ; ?>                        
                            <img class="owl-lazy" data-src="<?php echo $thumb_src;?>" alt="<?php echo esc_attr($offer_title); ?>">                           
                        </a>                           
                    </figure> 

                    <div class="text-oncarousel">
                        <h3>
                            <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>"<?php echo $item['ga_event'] ?>>
                                <?php echo esc_attr($offer_title); ?>
                            </a>
                        </h3>                           
                        <div class="egg_price_meta">
                            <?php if(!empty($offer_price)) : ?>
                                <p itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                    <span>
                                        <?php echo $item['price_formatted']; ?>
                                        <?php if(!empty($offer_price_old)) : ?>
                                        <del>
                                            <span class="amount"><?php echo $item['old_price_formatted'] ?></span>
                                        </del>
                                        <?php endif ;?>                                      
                                    </span> 
                                    <meta itemprop="price" content="<?php echo $item['price_raw'] ?>">
                                    <meta itemprop="priceCurrency" content="<?php echo $item['currency']; ?>">
                                    <?php if ($item['in_stock']): ?>
                                        <link itemprop="availability" href="http://schema.org/InStock">
                                    <?php endif ;?>                         
                                </p>
                            <?php endif ;?>                                
                        </div>
                        <div class="aff_tag mt10 small_size"><?php echo rehub_get_site_favicon($item['orig_url']); ?></div>
                    </div>                       
                </div>
            <?php endforeach; ?>
           
        </div>
    </div>     
<!-- End Carousel -->  
<div class="clearfix"></div>