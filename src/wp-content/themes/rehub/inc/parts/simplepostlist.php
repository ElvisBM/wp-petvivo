<?php global $post;?>
<?php $nometa = (isset($nometa)) ? $nometa : '';?>
<?php $image = (isset($image)) ? $image : '';?>
<div class="item-small-news<?php if($image):?> item-small-news-image<?php endif;?>">
	<?php if($image):?>
		<figure><a href="<?php the_permalink();?>"><?php wpsm_thumb ('med_thumbs') ?></a></figure>
	<?php endif;?>
	<div class="item-small-news-details">
	    <h3><?php do_action('rehub_in_title_post_list');?><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
	    <div class="post-meta"> <?php meta_small( true, false, true ); ?> </div> 
	    <?php do_action('rehub_after_meta_post_list');?>    
	    <?php if ($nometa !='1') :?>
	        <?php rehub_format_score('small');?>
	    <?php endif;?>
    </div>
</div>