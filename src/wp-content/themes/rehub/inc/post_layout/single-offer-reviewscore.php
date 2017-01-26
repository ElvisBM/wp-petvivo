<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">   
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
                        <?php if(rehub_option('hotmeter_disable') !='1') :?><?php echo getHotLike($post->ID); ?><?php endif ;?>                                                 
                        <div class="wpsm-one-third wpsm-column-first compare-full-images">
                            <figure><?php echo re_badge_create('tablelabel'); ?>
                                <?php           
                                    $image_id = get_post_thumbnail_id(get_the_ID());  
                                    $image_url = wp_get_attachment_image_src($image_id,'full');
                                    $image_url = $image_url[0]; 
                                ?>  
                                <a href="<?php echo $image_url;?>" target="_blank">     
                                    <?php WPSM_image_resizer::show_static_resized_image(array('lazy'=>true, 'thumb'=> true, 'crop'=> false, 'width'=> 500, 'no_thumb_url' => get_template_directory_uri() . '/images/default/noimage_500_500.png'));?>
                                </a>
                            </figure> 
                            <?php echo rh_get_post_thumbnails(array('video'=>1, 'columns'=>4, 'height'=>50));?>                                         
                        </div>
                        <div class="wpsm-two-third wpsm-column-last">
                            <div class="flowhidden">
                                <span class="floatleft meta post-meta">
                                    <?php rh_post_header_meta('full', false, true, true, true);?>
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
                                    $offer_post_url = get_post_meta($post->ID, 'rehub_offer_product_url', true );
                                    $offer_url = apply_filters('rh_post_offer_url_filter', $offer_post_url );
                                    $offer_price = get_post_meta($post->ID, 'rehub_offer_product_price', true );
                                    $offer_price_clean = rehub_price_clean($offer_price);
                                    $offer_btn_text = get_post_meta($post->ID, 'rehub_offer_btn_text', true );
                                    $offer_price_old = get_post_meta($post->ID, 'rehub_offer_product_price_old', true );
                                    $offer_currency = get_post_meta($post->ID, 'rehub_main_product_currency', true );
                                    $domain = get_post_meta($post->ID, 'rehub_offer_domain', true );
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
                                        <?php else :?>                            
                                            <div class="brand_logo_small"> 
                                                <?php WPSM_Postfilters::re_show_brand_tax('logo'); //show brand logo?>
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
                                <?php $amazon_key = get_post_meta($post->ID, '_cegg_data_Amazon', true);?>
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
                                    <?php include(rh_locate_template('inc/parts/post_share.php')); ?>
                                </div>
                                <div class="clearfix"></div> 
                            <?php endif; ?>                                                                                                
                        </div> 
                    </div>

                    <div class="rh-line mb25"></div>

                    <?php $no_featured_image_layout = 1;?>
                    <?php include(rh_locate_template('inc/parts/top_image.php')); ?>

                    <?php if(rehub_option('rehub_single_before_post') && vp_metabox('rehub_post_side.show_banner_ads') != '1') : ?><div class="mediad mediad_before_content"><?php echo do_shortcode(rehub_option('rehub_single_before_post')); ?></div><?php endif; ?>                                        

                    <?php the_content(); ?>                               

                </article>
                <div class="clearfix"></div>
                <?php include(rh_locate_template('inc/post_layout/single-common-footer.php')); ?>                    
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