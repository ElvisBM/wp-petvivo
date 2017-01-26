<?php if( rehub_option('rehub_enable_newstick') && (!rehub_option('rehub_enable_newstick_home') || ( rehub_option('rehub_enable_newstick_home') && is_front_page() ) ) ): ?>
<?php 
	$label_ticker = rehub_option('rehub_newstick_label');
	$cats_ticker = rehub_option('rehub_newstick_cat');
	if(!is_array($cats_ticker) && !empty($cats_ticker)) {
		$cats_ticker = array_map( 'trim', explode( ",", $cats_ticker ) );
	}
	$tags_ticker = rehub_option('rehub_newstick_tag');
	if(!is_array($tags_ticker) && !empty($tags_ticker)) {
		$tags_ticker = array_map( 'trim', explode( ",", $tags_ticker ) );
	}	
	$fetch_ticker = rehub_option('rehub_newstick_fetch');
	wp_enqueue_script('totemticker');
?>
<!-- NEWS SLIDER -->
<div class="rh-container">
	<div class="top_theme">
		<h5><strong><?php echo $label_ticker;?></strong></h5>
		<div class="scrollers"> <span class="scroller down"></span> <span class="scroller up"></span> </div>
		<ul id="vertical-ticker">
		<?php $pq = new WP_Query(array( 'category__in' => $cats_ticker, 'tag__in' => $tags_ticker, 'post_type' => 'post', 'showposts' => $fetch_ticker )); 
			  if( $pq->have_posts() ) : while($pq->have_posts()) : $pq->the_post(); ?>
			<li><a href="<?php the_permalink();?>"><?php the_title();?></a></li>
		<?php endwhile; wp_reset_postdata(); endif;?>	
		</ul>
		<div class="clearfix"></div>
	</div>
</div>
<!-- /NEWS SLIDER -->
<?php endif ;?>