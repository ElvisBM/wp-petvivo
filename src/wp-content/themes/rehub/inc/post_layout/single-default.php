<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
        <!-- Main Side -->
        <div class="main-side single<?php if(vp_metabox('rehub_post_side.post_size') == 'full_post') : ?> full_width<?php endif; ?> clearfix">            
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="post post-inner <?php $category = get_the_category($post->ID); if ($category) {$first_cat = $category[0]->term_id; echo 'category-'.$first_cat.'';} ?>" id="post-<?php the_ID(); ?>">               
                    <!-- Title area -->
                    <div class="rh_post_layout_metabig">
                        <div class="title_single_area">
                            <?php if(is_singular('post') && rehub_option('compare_btn_single') !='') :?>
                                <?php $compare_cats = (rehub_option('compare_btn_cats') != '') ? ' cats="'.esc_html(rehub_option('compare_btn_cats')).'"' : '' ;?>
                                <?php echo do_shortcode('[wpsm_compare_button'.$compare_cats.']'); ?> 
                            <?php endif;?>
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
                            <?php echo re_badge_create('labelsmall'); ?><?php rh_post_header_cat('post', true);?>                        
                            <h1><?php the_title(); ?></h1>                                
                            <div class="meta post-meta-big">
                                <?php rh_post_header_meta_big();?> 
                            </div> 
                            <?php if(rehub_option('rehub_disable_share_top') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                            <?php else :?>
                                <div class="top_share">
                                    <?php include(rh_locate_template('inc/parts/post_share.php')); ?>
                                </div>
                                <div class="clearfix"></div> 
                            <?php endif; ?>   
                                                       
                        </div>
                    </div>     
                    <?php include(rh_locate_template('inc/parts/top_image.php')); ?>                                
                    <?php if(rehub_option('rehub_single_before_post') && vp_metabox('rehub_post_side.show_banner_ads') != '1') : ?><div class="mediad mediad_before_content"><?php echo do_shortcode(rehub_option('rehub_single_before_post')); ?></div><?php endif; ?>

                    <?php the_content(); ?>

                    <?php echo rh_get_post_thumbnails(array('video'=>1, 'height'=>240, 'columns'=>'all', 'justify'=>1));?>

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