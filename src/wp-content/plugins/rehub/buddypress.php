<?php get_header(); ?>
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
          <div class="main-side buddypress-page clearfix<?php if(rehub_option('bp_full_width') == 1) : ?> full_width<?php endif; ?>">            
            <article class="post" id="page-<?php the_ID(); ?>">       
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
                <?php wp_link_pages(array( 'before' => '<div class="page-link"><span class="page-link-title">' . __( 'Pages:', 'rehub_framework' ).'</span>', 'after' => '</div>', 'pagelink' => '<span>%</span>' )); ?>
            <?php endwhile; endif; ?>      
            </article>            
        </div>	
        <!-- /Main Side -->  
        <!-- Sidebar -->
        <?php if(rehub_option('bp_full_width') == 1) : ?><?php else : ?><?php get_sidebar(); ?><?php endif; ?>
        <!-- /Sidebar --> 
    </div>
</div>
<!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>