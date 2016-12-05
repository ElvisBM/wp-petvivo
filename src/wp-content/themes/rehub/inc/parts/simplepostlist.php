<?php global $post;?>
<div class="item-small-news">
    <h3><?php do_action('rehub_in_title_post_list');?><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
    <div class="post-meta"> <?php meta_small( true, false, true ); ?> </div> 
    <?php do_action('rehub_after_meta_post_list');?>    
    <?php if ($nometa !='1') :?>
        <?php rehub_format_score('small');?>
    <?php endif;?>
</div>