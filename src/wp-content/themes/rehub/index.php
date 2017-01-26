<?php get_header(); ?>
<!-- CONTENT -->
<div class="rh-container">   
    <div class="rh-content-wrap clearfix">
          <!-- Main Side -->
          <div class="main-side clearfix<?php if (rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_gridfull') : ?> full_width<?php endif ;?>">
            <div class="wpsm-title under-title-line middle-size-title"><h5><?php _e('Latest Posts', 'rehub_framework'); ?></h5></div>
            <?php
                $module_exclude = rehub_option('rehub_exclude_posts');
                if(($module_exclude) == 1) {
                        $exclude_posts = rehub_exclude_feature_posts();
                }
                else $exclude_posts ='';
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $args = array(
                  'paged' => $paged,
                  'post__not_in' => $exclude_posts
                );
            ?>
            <?php $query = new WP_Query( $args ); ?> 
            <?php if (rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_grid') : ?>
                <?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); wp_enqueue_script('masonry_init'); ?>
                <div class="masonry_grid_fullwidth two-col-gridhub">
            <?php elseif (rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_gridfull') : ?>   
                <?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); wp_enqueue_script('masonry_init'); ?>
                <div class="masonry_grid_fullwidth three-col-gridhub">                     
            <?php endif ;?>   
            <?php if ($query->have_posts()) : ?>
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <?php if (rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_blog') : ?>
                    <?php include(rh_locate_template('inc/parts/query_type2.php')); ?>
                <?php elseif (rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_list') : ?>
                    <?php include(rh_locate_template('inc/parts/query_type1.php')); ?>
                <?php elseif (rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_grid' || rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_gridfull') : ?>
                    <?php include(rh_locate_template('inc/parts/query_type3.php')); ?>                   
                <?php else : ?>
                    <?php include(rh_locate_template('inc/parts/query_type1.php')); ?>	
                <?php endif ;?>
            <?php endwhile; endif;?>
            <?php if (rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_grid' || rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_gridfull') : ?></div><?php endif ;?>
            <div class="clearfix"></div>
            <?php rehub_pagination(); ?>	
            <?php wp_reset_query(); ?>
        </div>	
        <!-- /Main Side -->
        <?php if (rehub_option('rehub_framework_archive_layout') != 'rehub_framework_archive_gridfull') : ?>
            <!-- Sidebar -->
            <?php get_sidebar(); ?>
            <!-- /Sidebar --> 
        <?php endif ;?>
    </div>
</div>
<!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>