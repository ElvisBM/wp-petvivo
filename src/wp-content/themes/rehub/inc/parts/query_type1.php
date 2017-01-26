<?php global $post;?>
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
	    <div class="post-meta">
	    	<?php rh_post_header_meta( true, true, false, false, true ); ?>
	    </div>
	    <?php rehub_format_score('small') ?>
	    <p><?php kama_excerpt('maxchar=180'); ?></p>
	    <?php do_action( 'rehub_after_left_list_thumb' ); ?>
		<?php if(rehub_option('disable_btn_offer_loop')!='1')  : ?><?php rehub_create_btn('yes') ;?><?php endif; ?>
    </div>
    <?php echo getHotThumb($post->ID, false, false, true);?>
</div>