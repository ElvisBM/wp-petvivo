<!-- CONTENT -->
<div class="content"> 
    <div class="clearfix">   
        <!-- Main Side -->
        <div class="main-side single<?php if(vp_metabox('rehub_post_side.post_size') == 'full_post') : ?> full_width<?php endif; ?> clearfix">            
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="post post-inner <?php $category = get_the_category($post->ID); if ($category) {$first_cat = $category[0]->term_id; echo 'category-'.$first_cat.'';} ?>" id="post-<?php the_ID(); ?>">
                        <div class="rh_post_layout_compare_autocontent">
                            <?php 
                                $crumb = '';
                                if( function_exists( 'yoast_breadcrumb' ) ) {
                                    $crumb = yoast_breadcrumb('<div class="breadcrumb">','</div>', false);
                                }
                                if( ! is_string( $crumb ) || $crumb === '' ) {
                                    if(rehub_option('rehub_disable_breadcrumbs') == '1' || vp_metabox('rehub_post_side.disable_parts') == '1') {echo '';}
                                    elseif (function_exists('dimox_breadcrumbs')) {
                                        dimox_breadcrumbs(); 
                                    }
                                }
                                echo $crumb;  
                            ?>                         
                            <div class="title_single_area">
                            <h1 class="<?php if(rehub_option('hotmeter_disable') !='1') :?><?php echo getHotIconclass($post->ID); ?><?php endif ;?>"><?php the_title(); ?></h1>
                            </div>  
                            <div class="rh-line mb15"></div>                      
                            <div class="wpsm-one-third wpsm-column-first compare-full-images">
                                <figure><?php echo re_badge_create('tablelabel'); ?><div class="favorrightside"><?php echo getHotThumb($post->ID, false, false, true);?></div>
                                    <?php           
                                        $image_id = get_post_thumbnail_id(get_the_ID());  
                                        $image_url = wp_get_attachment_image_src($image_id,'full');
                                        $image_url = $image_url[0]; 
                                    ?> 
                                    <a href="<?php echo $image_url;?>" target="_blank">            
                                        <?php WPSM_image_resizer::show_static_resized_image(array('lazy'=>false, 'thumb'=> true, 'crop'=> false, 'width'=> 350, 'no_thumb_url' => get_template_directory_uri() . '/images/default/noimage_500_500.png'));?>
                                    </a>
                                </figure>
                                <?php $amazon_key_for_imgs = get_post_meta($post->ID, '_cegg_data_Amazon', true);?>
                                <?php $post_image_gallery = get_post_meta( $post->ID, 'rh_post_image_gallery', true );?>
                                <?php $countimages = $countme = '';?>
                                <?php if(!empty($post_image_gallery)) :?>
                                    <?php echo rh_get_post_thumbnails(array('video'=>1, 'columns'=>4, 'height'=>60));?>
                                <?php elseif(!empty($amazon_key_for_imgs)) :?> 
                                    <?php $countme = count($amazon_key_for_imgs);?>           
                                    <div class="compare-full-thumbnails limited-thumb-number mt15">
                                        <?php $i=0; foreach($amazon_key_for_imgs as $key=>$amazon_image):?>
                                            <?php $i++?>
                                            <?php if ($i>2) {break;}?>
                                            <?php $gallery_images = $amazon_image['extra']['imageSet'];?>
                                            <?php if(!empty($gallery_images)):?>
                                                <?php $countimages = count($gallery_images);?>
                                                <?php if ($countimages > 1 || $countme > 1):?>
                                                    <?php foreach ($gallery_images as $key => $gallery_img) :?>
                                                        <a href="<?php echo esc_attr($gallery_img['LargeImage']) ;?>" target="_blank"> 
                                                            <img src="<?php echo esc_attr($gallery_img['SmallImage']) ;?>" alt="<?php echo esc_attr($amazon_image['title']); ?>" />  
                                                        </a>
                                                    <?php endforeach;?>                                
                                                <?php endif;?>
                                            <?php endif;?>
                                        <?php endforeach;?>                
                                    </div>
                                    <?php if ($countimages > 1 || $countme > 1):?>
                                        <?php $random_key = rand(0, 50); wp_enqueue_script('prettyphoto');?>
                                        <script data-cfasync="false">
                                        jQuery(document).ready(function($) {
                                            'use strict'; 
                                            $('.compare-full-images a').attr('rel', 'prettyPhoto[rehub_product_gallery_<?php echo $random_key;?>]');
                                            $(".compare-full-images a[rel^='prettyPhoto']").prettyPhoto({social_tools:false});
                                        });
                                        </script>
                                    <?php endif;?>                
                                <?php endif;?>                                                                           
                            </div>
                            <div class="wpsm-two-third wpsm-column-last">
                                <div class="flowhidden">
                                    <span class="floatleft meta post-meta">
                                        <?php rh_post_header_meta(false, false, true, true, true);?>
                                    </span>
                                    <span class="floatright">
                                        <?php if(is_singular('post') && rehub_option('compare_btn_single') !='') :?>
                                            <?php $compare_cats = (rehub_option('compare_btn_cats') != '') ? ' cats="'.esc_html(rehub_option('compare_btn_cats')).'"' : '' ;?>
                                            <?php echo do_shortcode('[wpsm_compare_button'.$compare_cats.']'); ?> 
                                        <?php endif;?>                    
                                    </span>
                                </div> 
                                <div class="mb25 mt5 rh-line"></div>
                                <div class="rh_post_layout_rev_price_holder">
                                    <div class="rh_price_holder_add_links">
                                        <?php if (vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && rehub_option('type_user_review') == 'full_review' && comments_open()) :?>
                                            <a href="#respond" class="rehub_scroll add_user_review_link"><?php _e("Add your review", "rehub_framework"); ?> 
                                            </a>
                                        <?php endif;?>
                                    </div>                                
                                    <?php $overall_review = rehub_get_overall_score();?>
                                    <?php if($overall_review):?>
                                        <div class="review-top floatleft">
                                        <div class="overall-score">
                                            <span class="overall r_score_4"><?php echo $overall_review;?></span>
                                            <span class="overall-text"><?php _e('Total Score', 'rehub_framework'); ?></span>
                                        </div> 
                                        </div>                     
                                    <?php endif;?>

                                    <?php  
                                        $offer_post_url = get_post_meta(get_the_ID(), 'rehub_offer_product_url', true );
                                        $offer_url = apply_filters('rh_post_offer_url_filter', $offer_post_url );
                                        $offer_price = get_post_meta(get_the_ID(), 'rehub_offer_product_price', true );
                                        $offer_price_clean = rehub_price_clean($offer_price);
                                        $offer_btn_text = get_post_meta(get_the_ID(), 'rehub_offer_btn_text', true );
                                        $offer_price_old = get_post_meta(get_the_ID(), 'rehub_offer_product_price_old', true );
                                        $offer_currency = get_post_meta(get_the_ID(), 'rehub_main_product_currency', true );
                                        $domain = get_post_meta(get_the_ID(), 'rehub_offer_domain', true );
                                        $merchant = get_post_meta($post->ID, 'rehub_offer_merchant', true );
                                        $logo = get_post_meta($post->ID, 'rehub_offer_logo_url', true );                                         
                                    ?>
                                    <?php if ($offer_url):?>
                                        <div class="compare-button-holder">
                                            <div itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                                                <p class="price">
                                                    <ins><?php echo $offer_price;?></ins>
                                                    <del><?php echo $offer_price_old;?></del> 
                                                </p>
                                                <meta itemprop="price" content="<?php echo $offer_price_clean;?>">
                                                <meta itemprop="priceCurrency" content="<?php echo $offer_currency;?>">
                                                <link itemprop="availability" href="http://schema.org/InStock">
                                            </div>
                                            <?php if ($domain || $merchant):?>
                                                <?php $domain = rh_fix_domain($merchant, $domain);?>
                                                <div class="mb10 compare-domain-icon">
                                                <span><?php _e('Best deal on: ', 'rehub_framework');?></span>
                                                <?php if ($logo) :?>
                                                <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $logo, 'lazy'=>false, 'height'=> 25, 'title' => $domain, 'no_thumb_url' => get_template_directory_uri().'/images/default/noimage_100_70.png'));?>
                                                <?php else :?> 
                                                    <?php echo rehub_get_site_favicon('http://'.$domain); ?>                        
                                                <?php endif ;?>
                                                </div>
                                            <?php endif;?>
                                            <?php $buy_best_text = (rehub_option('buy_best_text') !='') ? esc_html(rehub_option('buy_best_text')) : __('Buy for best price', 'rehub_framework'); ?>                                            
                                            <a href="<?php echo esc_url($offer_url);?>" class="re_track_btn wpsm-button rehub_main_btn btn_offer_block" target="_blank" rel="nofollow"><?php echo $buy_best_text;?></a> 
                                        </div>  
                                        <div class="rh-line mt20 mb25"></div>                     
                                    <?php endif;?>                
                                </div>                                               
                                <?php $prosvalues = vp_metabox('rehub_post.review_post.0.review_post_pros_text');?>
                                <?php if(!empty($prosvalues)):?>
                                    <ul class="pros-list rh-flex-eq-height">        
                                        <?php $prosvalues = explode(PHP_EOL, $prosvalues);?>
                                        <?php foreach ($prosvalues as $prosvalue) {
                                            echo '<li>'.$prosvalue.'</li>';
                                        }?>
                                    </ul> 
                                    <div class="clearfix"></div>                   
                                <?php else:?>
                                    <?php $amazon_key = get_post_meta(get_the_ID(), '_cegg_data_Amazon', true);?>
                                    <?php if(!empty($amazon_key)) :?>
                                        <?php $amazon_key = reset($amazon_key);?>
                                        <?php  $features = (!empty($amazon_key['extra']['itemAttributes']['Feature'])) ? $amazon_key['extra']['itemAttributes']['Feature'] : ''?>                        
                                        <?php if (!empty ($features)) :?>
                                            <ul class="pros-list rh-flex-eq-height">
                                                <?php $length = $maxlength = '';?>
                                                <?php foreach ($features as $k => $feature): ?>
                                                    <?php $length = strlen($feature); $maxlength += $length; ?> 
                                                    <li><?php echo $feature; ?></li>
                                                    <?php if($k >= 3 || $maxlength > 150) break; ?>                             
                                                <?php endforeach; ?>
                                            </ul>                                                            
                                        <?php endif ;?>                     
                                    <?php endif;?>
                                    <div class="clearfix"></div> 
                                <?php endif;?>
                                 
                                <?php if(rehub_option('rehub_disable_share_top') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                                <?php else :?>
                                    <div class="top_share notextshare">
                                        <?php include(locate_template('inc/parts/post_share.php')); ?>
                                    </div>
                                    <div class="clearfix"></div> 
                                <?php endif; ?>                                                                                                
                            </div> 
                        </div>

                        <?php $amazonae_key = get_post_meta(get_the_ID(), '_cegg_data_AE__amazoncom', true);?>
                        <?php if (empty($amazonae_key)):?>
                            <?php $amazonae_key = get_post_meta(get_the_ID(), '_cegg_data_AE__amazonin', true);?>
                        <?php endif;?>
                        <?php $infibeam_key = get_post_meta(get_the_ID(), '_cegg_data_AE__infibeam', true);?>
                        <?php $flipkart_key = get_post_meta(get_the_ID(), '_cegg_data_Flipkart', true);?>
                        <?php $googlebook_key = get_post_meta(get_the_ID(), '_cegg_data_GoogleBooks', true);?>
                        <?php $youtube_key = get_post_meta(get_the_ID(), '_cegg_data_Youtube', true);?>
                        <?php $flipkart_specification = $feedback_true = $amazon_rev = $infibeam_rev = '';?>
                        <?php if (!empty($flipkart_key)):?>
                            <?php $flipkart_key = reset($flipkart_key);?>
                            <?php $flipkart_specification = (!empty($flipkart_key['extra']['specificationList'])) ? true : false;?>
                        <?php endif;?>
                        <?php if (!empty($amazonae_key)):?>
                            <?php foreach ($amazonae_key as $key => $item) {
                                if (!empty($item['extra']['comments'])){
                                    $feedback_true = true;
                                    $amazon_rev = true;
                                }
                            }?>
                        <?php endif;?>
                        <?php if (!empty($infibeam_key)):?>
                            <?php foreach ($infibeam_key as $key => $item) {
                                if (!empty($item['extra']['comments'])){
                                    $feedback_true = true;
                                    $infibeam_rev = true;
                                }
                            }?>
                        <?php endif;?>                                                 

                        <div class="rh-tabletext-block">
                        <div class="rh-tabletext-block-heading no-border"><span class="toggle-this-table"></span><h4><?php _e('Price list', 'rehub_framework');?></h4></div>
                        <?php echo do_shortcode('[content-egg-block template=custom/all_offers_logo]' );?>
                        </div>

                        <?php echo do_shortcode('[content-egg-block template=custom/all_pricehistory_full]' );?>
                        <?php echo do_shortcode('[content-egg-block template=custom/all_pricealert_full]' );?>

                        <?php if( $flipkart_specification):?>
                            <div class="rh-tabletext-block">
                            <div class="rh-tabletext-block-heading"><span class="toggle-this-table"></span><h4><?php _e('Specification', 'rehub_framework');?></h4></div>  
                            <div class="rh-tabletext-block-wrapper">                          
                                <?php echo do_shortcode('[content-egg module=Flipkart template=custom/specification limit=1]' );?> 
                            </div>                               
                            </div>                                
                        <?php endif;?>

                        <?php if(!empty($youtube_key)):?>
                            <div class="rh-tabletext-block">
                            <div class="rh-tabletext-block-heading"><span class="toggle-this-table"></span><h4><?php _e('Video', 'rehub_framework');?></h4></div>  
                            <div class="rh-tabletext-block-wrapper">                          
                                <?php echo do_shortcode('[content-egg module=Youtube template=custom/simple]' );?>
                            </div>                               
                            </div>                                
                        <?php endif;?> 

                        <?php if(!empty($googlebook_key)):?>
                            <div class="rh-tabletext-block">
                            <div class="rh-tabletext-block-heading"><span class="toggle-this-table"></span><h4><?php _e('Manuals', 'rehub_framework');?></h4></div>  
                            <div class="rh-tabletext-block-wrapper">                          
                                <?php echo do_shortcode('[content-egg module=GoogleBooks template=custom/simple]' );?>
                            </div>                               
                            </div>                                
                        <?php endif;?>  

                        <?php if($feedback_true):?>
                            <div class="rh-tabletext-block">
                            <div class="rh-tabletext-block-heading"><span class="toggle-this-table"></span><h4><?php _e('Feedbacks', 'rehub_framework');?></h4></div>  
                            <div class="rh-tabletext-block-wrapper">                          
                                <?php if ($amazon_rev):?>
                                    <?php echo do_shortcode('[content-egg module=AE__amazoncom template=custom/comments limit=2]' );?>
                                <?php endif;?> 
                                <?php if ($infibeam_rev):?>
                                    <?php echo do_shortcode('[content-egg module=AE__infibeam template=custom/comments]' );?>
                                <?php endif;?> 
                            </div>                               
                            </div>                                
                        <?php endif;?>

                        <div class="rh-tabletext-block">
                        <div class="rh-tabletext-block-heading"><span class="toggle-this-table"></span><h4><?php _e('Description and Review', 'rehub_framework');?></h4></div>  
                        <div class="rh-tabletext-block-wrapper">                          
                            <?php the_content(); ?>
                        </div>                               
                        </div>                                

                </article>
                <div class="clearfix"></div>
                <?php include(locate_template('inc/post_layout/single-common-footer.php')); ?>                    
            <?php endwhile; endif; ?>
            <?php comments_template(); ?>
        </div>  
        <!-- /Main Side -->  
        <!-- Sidebar -->
        <?php if(vp_metabox('rehub_post_side.post_size') == 'full_post') : ?><?php else : ?><?php get_sidebar(); ?><?php endif; ?>
        <!-- /Sidebar -->
    </div>
</div>
<!-- /CONTENT -->