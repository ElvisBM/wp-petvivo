<?php 
global $post;
if (isset($aff_link) && $aff_link == '1') {
    $link = rehub_create_affiliate_link ();
    $target = ' rel="nofollow" target="_blank"';
}
else {
    $link = get_the_permalink();
    $target = '';  
}
?>  
<article class="inf_scr_item col_item column_grid rh-heading-hover-color rh-bg-hover-color<?php if($boxed):?> rh-cartbox no-padding<?php endif;?>">      
    <figure><?php echo re_badge_create('tablelabel'); ?> 
        <?php rh_post_header_cat('post', false);?>   
        <?php if(function_exists('get_favorites_button')) :?> 
            <div class="favour_in_image"><?php the_favorites_button(); ?></div> 
        <?php endif;?>            
        <a href="<?php echo $link;?>"<?php echo $target;?>><?php wpsm_thumb ('medium_news') ?></a>
    </figure>
    <?php do_action( 'rehub_after_grid_column_figure' ); ?>
    <div class="content_constructor">
        <h2><a href="<?php echo $link;?>"<?php echo $target;?>><?php the_title();?></a></h2>
        <?php do_action( 'rehub_after_grid_column_title' ); ?>
        <?php if($disable_meta !='1'):?>
            <div class="meta post-meta">
                <?php rh_post_header_meta( true, false, false, true, false ); ?>                               
            </div>
            <?php do_action( 'rehub_after_grid_column_meta' ); ?>
        <?php endif?>                       
        <div class="rehub_catalog_desc">                                 
            <?php kama_excerpt('maxchar='.$exerpt_count.''); ?>                       
        </div> 
        <?php if($enable_btn):?>
            <?php rehub_create_btn('yes');?>
        <?php endif?>        
        <?php do_action( 'rehub_after_grid_column_btn' ); ?>
    </div>                           
</article>