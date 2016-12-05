<?php get_header(); ?>
<!-- CONTENT -->
<div class="content"> 

    <div class="clearfix">
          <!-- Main Side -->
          <div class="main-side clearfix full_width">
            <div class="title"><h1><?php the_title(); ?></h1></div>
			<article class="post" id="page-<?php the_ID(); ?>"> 
            
            <?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); ?>
            <?php wp_enqueue_script('masonry_init'); ?> 

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php bp_get_template_part( 'buddypress/members/members' ); ?>
			<?php endwhile; endif; ?>  

            </article>
        </div>	

        <!-- /Main Side -->  
        <!-- Sidebar -->
        <?php //get_sidebar(); ?>
        <!-- /Sidebar --> 
    </div>
	
</div>
<!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>