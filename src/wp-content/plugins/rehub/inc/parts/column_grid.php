<?php 
if (isset($aff_link) && $aff_link == '1') {
    $link = rehub_create_affiliate_link ();
    $target = ' rel="nofollow" target="_blank"';
}
else {
    $link = get_the_permalink();
    $target = '';  
}
?>  
<article class="inf_scr_item col_item column_grid">      
    <figure><?php echo re_badge_create('tablelabel'); ?> 
        <?php if(function_exists('get_favorites_button')) :?> <div class="favour_in_image"><?php the_favorites_button(); ?></div> <?php endif;?>            
        <a href="<?php echo $link;?>"<?php echo $target;?>><?php wpsm_thumb ('news_big') ?></a>
    </figure>
    <?php do_action( 'rehub_after_grid_column_figure' ); ?>
    <div class="content_constructor">
        <h2><a href="<?php echo $link;?>"<?php echo $target;?>><?php the_title();?></a></h2>
        <?php do_action( 'rehub_after_grid_column_title' ); ?>
        <?php if($disable_meta !='1'):?>
            <div class="post-meta">
                <?php meta_small( true, false, true ); ?>
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