<div class="news clearfix<?php if(is_sticky()) {echo " sticky";} ?>">	
	    <figure>
	        <?php echo re_badge_create('ribbon'); ?>
	        <?php rehub_formats_icons('full'); ?>
	        <a href="<?php the_permalink();?>"><?php wpsm_thumb ('list_news') ?></a>       
	    </figure>
	    
	    <?php do_action( 'rehub_after_left_list_thumb_figure' ); ?>
    <div class="detail">
	    <h3><?php if(is_sticky()) {echo "<i class='fa fa-thumb-tack'></i>";} ?><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
	    <?php do_action( 'rehub_after_left_list_thumb_title' ); ?>
	    <?php if (rehub_option('exclude_comments_meta') == 0) : ?><?php comments_popup_link( 0, 1, '%', 'comment_two', ''); ?><?php endif ;?>
	    <?php 
	    	global $post;
	    	$first_cat = '';
	    	if ('post' == get_post_type($post->ID)) {
	    		$category = get_the_category();
	    		$first_cat = $category[0]->term_id;
	    	}  
	    ?>
	    <div class="post-meta">
	    	<?php meta_all( true, $first_cat, true ); ?>
	    </div>
	    <?php rehub_format_score('small') ?>
	    <p><?php kama_excerpt('maxchar=180'); ?></p>
	    <?php do_action( 'rehub_after_left_list_thumb' ); ?>
		<?php if(rehub_option('disable_btn_offer_loop')!='1')  : ?><?php rehub_create_btn('yes') ;?><?php endif; ?>                
    </div>
</div>