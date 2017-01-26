<?php get_header(); ?>
<?php $cursearch = get_search_query();?>
<!-- CONTENT -->
<div class="content"> 
    <div class="clearfix">
          <!-- Main Side -->
          <div class="main-side clearfix<?php if (rehub_option('rehub_framework_search_layout') == 'rehub_framework_archive_gridfull') : ?> full_width<?php endif ;?>">
            <div class="wpsm-title middle-size-title wpsm-cat-title"><h5><span><?php _e('Search Results', 'rehub_framework'); ?></span> <?php echo esc_html($cursearch); ?></h5></div>
            <?php if (rehub_option('rehub_framework_search_layout') == 'rehub_framework_archive_grid') : ?>
                <?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); wp_enqueue_script('masonry_init'); ?>
                <div class="masonry_grid_fullwidth two-col-gridhub">
            <?php elseif (rehub_option('rehub_framework_search_layout') == 'rehub_framework_archive_gridfull') : ?>   
                <?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); wp_enqueue_script('masonry_init'); ?>
                <div class="masonry_grid_fullwidth three-col-gridhub">                     
            <?php endif ;?>                        
            <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php if (rehub_option('rehub_framework_search_layout') == 'rehub_framework_archive_blog') : ?>
                    <?php include(rh_locate_template('inc/parts/query_type2.php')); ?>
                <?php elseif (rehub_option('rehub_framework_search_layout') == 'rehub_framework_archive_list') : ?>
                    <?php include(rh_locate_template('inc/parts/query_type1.php')); ?>
                <?php elseif (rehub_option('rehub_framework_search_layout') == 'rehub_framework_archive_grid' || rehub_option('rehub_framework_search_layout') == 'rehub_framework_archive_gridfull') : ?>
                    <?php include(rh_locate_template('inc/parts/query_type3.php')); ?>                    
                <?php else : ?>
                    <?php include(rh_locate_template('inc/parts/query_type1.php')); ?>    
                <?php endif ;?>
            <?php endwhile; ?>
            <?php else : ?>     
            <h5><?php _e('Sorry. No search results found', 'rehub_framework'); ?></h5> 
            <?php endif; ?> 
            <?php if (rehub_option('rehub_framework_search_layout') == 'rehub_framework_archive_grid' || rehub_option('rehub_framework_search_layout') == 'rehub_framework_archive_gridfull') : ?></div><?php endif ;?>
            <div class="clearfix"></div>
            <?php rehub_pagination(); ?>
        </div>  
        <!-- /Main Side -->
        <?php if (rehub_option('rehub_framework_search_layout') != 'rehub_framework_archive_gridfull') : ?>
            <!-- Sidebar -->
            <?php get_sidebar(); ?>
            <!-- /Sidebar --> 
        <?php endif ;?>
    </div>
</div>
<!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>