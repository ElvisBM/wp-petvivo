<?php

	/* Template Name: Page builder */

?>
<?php get_header(); ?>

<?php 
if( !function_exists('title_custom_block') ) {
function title_custom_block ($title_enable, $title_name, $title_position, $title_url_title, $title_url_url ){
if (($title_enable) == 1) { 

	if($title_position == 'top_title') {
		$title_place = ' title_pos="left" title_line="under-title"';
	}
	elseif($title_position=='left_title'){
		$title_place = ' title_pos="left" title_line="inside-title"';
	}
	elseif($title_position=='center_title') {
		$title_place = ' title_pos="center" title_line="inside-title"';
	}

	echo do_shortcode ('[title_mod title_name="'.$title_name.'" title_url_title="'.$title_url_title.'" title_url_url="'.$title_url_url.'"'.$title_place.']');
}
}}
?>

    <!-- CONTENT -->
    <div class="content">

        <?php if(rehub_option('rehub_featured_toggle') && is_front_page() && !is_paged()) : ?>
            <?php get_template_part('inc/parts/featured'); ?>
        <?php endif; ?>
	    <?php if(rehub_option('rehub_homecarousel_toggle') && is_front_page() && !is_paged()) : ?>
	        <?php get_template_part('inc/parts/home_carousel'); ?>
	    <?php endif; ?>        

		<div class="clearfix">
		      <!-- Main Side -->
              <div class="main-side page page_builder clearfix">
					
				<!-- CONTENT -->
					<?php while (have_posts()) : the_post(); ?>
					<?php //the_content();?>
					
					<?php 
					
					//Loop
					$pbid=0; 

					$rows = vp_metabox('mag_builder_page.pagebuilders'); //Get the rows

					if (isset ($rows) && !empty ($rows)) {					
						foreach ($rows as $row) {					
						$element =  vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.rehub_framework_pb');

							if ($element == 'two_col_news_block') { //Two column news
								include(locate_template('inc/page_areas/two-col-block.php'));
							} else if ($element == 'gal_carousel_block') { //Photo gallery
								include(locate_template('inc/page_areas/carousel-gallery-block.php'));
							} else if ($element == 'video_block') { //Video block
								include(locate_template('inc/page_areas/video-block.php'));
							} else if ($element == 'tab_block') { //1-4 tabs block
								include(locate_template('inc/page_areas/tabbed-block.php'));			
							} else if ($element == 'woo_block') { //Woo commerce carousel
								include(locate_template('inc/page_areas/woocommerce-block.php'));
							} else if ($element == 'news_with_thumbs_block') { //News block with thumbs
								include(locate_template('inc/page_areas/news-withthumbs-block.php'));
							} else if ($element == 'post_carousel_block') { //Posts carousel block
								include(locate_template('inc/page_areas/posts-carousel-block.php'));
							} else if ($element == 'news_no_thumbs_block') { //1 big thumb + 4 news block
								include(locate_template('inc/page_areas/news-nothumbs-block.php'));
							} else if ($element == 'small_thumb_loop') { //Posts string with small thumbs
								include(locate_template('inc/page_areas/small-posts-block.php'));
							} else if ($element == 'grid_loop') { //Posts grid
								include(locate_template('inc/page_areas/grid-posts-block.php'));
							} else if ($element == 'regular_blog_loop') { //Posts string with big thumbs
								include(locate_template('inc/page_areas/big-posts-block.php'));
							} else if ($element == 'slider_block') { //Slider block
								include(locate_template('inc/page_areas/slider-block.php'));
							} else if ($element == 'custom_block') { //Custom text or banner
								include(locate_template('inc/page_areas/custom-block.php'));																																																																
							}  else {};						
						$pbid++;
						}
					}
					 //End foreach ?>

	
					<?php endwhile; ?>

			</div>	
            <!-- /Main Side -->  

            <!-- Sidebar -->
            <?php get_sidebar(); ?>
            <!-- /Sidebar --> 

        </div>
    </div>
    <!-- /CONTENT -->     

<!-- FOOTER -->
<?php get_footer(); ?>