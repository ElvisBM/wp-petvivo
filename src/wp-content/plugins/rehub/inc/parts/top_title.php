<!-- Title area -->
<div class="top_single_area<?php if(vp_metabox('rehub_post_side.post_size') == 'full_post') : ?> full_width<?php endif; ?>">
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
    <?php echo re_badge_create('label'); ?>
    <div class="top"><?php if (rehub_option('exclude_comments_meta') == 0) : ?><?php comments_popup_link( 0, 1, '%', 'comment_two', ''); ?><?php endif ;?></div>                            
    <h1><?php the_title(); ?></h1>                                
    <div class="meta post-meta">
        <?php meta_all(true, false, true, true);?> 
        <?php if(is_singular('post') && rehub_option('compare_btn_single') !='') :?>
            <?php $compare_cats = (rehub_option('compare_btn_cats') != '') ? ' cats="'.esc_html(rehub_option('compare_btn_cats')).'"' : '' ;?>
            <?php echo do_shortcode('[wpsm_compare_button'.$compare_cats.']'); ?> 
        <?php endif;?>
    </div>   
</div>