<?php global $post;?>
<?php $image = (isset($image)) ? $image : '';?>
<div class="item-small-news <?php if($image):?> item-small-news-image<?php endif;?>">
	<?php if($image):?>
		<figure><a href="<?php the_permalink();?>"><?php wpsm_thumb ('med_thumbs') ?></a></figure>
	<?php endif;?>
	<div class="item-small-news-details">
	    <h3><?php do_action('rehub_in_title_post_list');?><a href="<?php the_permalink();?>"><?php the_title();?></a><?php rehub_create_price_for_list($post->ID);?></h3>
	    <div class="post-meta">
	    	<span class="date_ago">
	            <?php printf( __( '%s ago', 'rehubchild' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
	        </span>
	        <span class="comm_number_for_list"><i class="fa fa-commenting"></i> <?php echo get_comments_number(); ?></span>
	    </div> 
	    <?php do_action('rehub_after_meta_post_list');?>
    </div>    
</div>