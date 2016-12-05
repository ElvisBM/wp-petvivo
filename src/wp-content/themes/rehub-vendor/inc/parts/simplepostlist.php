<?php global $post;?>
<div class="item-small-news">
    <h3><?php do_action('rehub_in_title_post_list');?><a href="<?php the_permalink();?>"><?php the_title();?></a><?php rehub_create_price_for_list($post->ID);?></h3>
    <div class="post-meta">
    	<span class="date_ago">
            <?php printf( __( '%s ago', 'rehub_framework' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
        </span>
        <span class="comm_number_for_list"><i class="fa fa-commenting"></i> <?php echo get_comments_number(); ?></span>
    </div> 
    <?php do_action('rehub_after_meta_post_list');?>    
</div>