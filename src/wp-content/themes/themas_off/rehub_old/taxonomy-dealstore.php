<?php get_header(); ?>

    <!-- CONTENT -->
    <div class="content"> 
        <div class="clearfix">
              <!-- Main Side -->
              <div class="main-side page clearfix">

                <article class="post"> 
                    <?php 
                        $tagid = get_queried_object()->term_id; 
                        $tagobj = get_term_by('id', $tagid, 'dealstore');
                        $tagname = $tagobj->name;
                        $brandimage = get_term_meta( $tagid, 'brandimage', true );
                        $brandseconddesc = get_term_meta( $tagid, 'brand_second_description', true );                              
                        echo '<div class="woo-tax-wrap">';
                        if (!empty ($brandimage)) { 
                            $showbrandimg = new WPSM_image_resizer();
                            $showbrandimg->height = '60';
                            $showbrandimg->src = $brandimage;                                   
                            echo '<div class="woo-tax-logo">';
                            $showbrandimg->show_resized_image();  
                            echo '</div>';
                        }
                        echo '<h3>'.$tagname.'</h3>';
                        echo rehub_get_user_rate('admin', 'tax');                               
                        echo '</div>';                                                  
                    ?> 
                    <?php
                        $description = term_description();
                        if ( $description && !is_paged() ) {
                            echo '<div class="term-description">' . $description . '</div>';
                        }
                    ?>
                    <?php if ( have_posts() ) : ?>
                        <div id="re_filter_instore">
                            <strong class="show_filter_label">
                                <?php _e('Show:', 'rehub_framework'); ?>
                            </strong>
                            <span class="all active"><?php _e('All', 'rehub_framework'); ?></span>
                            <span class="coupontype"><?php _e('Coupons', 'rehub_framework'); ?></span>
                            <span class="saledealtype"><?php _e('Sales', 'rehub_framework'); ?></span>
                        </div> 
                        <div class="clearfix"></div>                           
                        <div class="woo_offer_list">
                            <?php while ( have_posts() ) : the_post(); ?>                                
                                <?php include(locate_template('inc/parts/postlistpart.php')); ?>          
                            <?php endwhile; // end of the loop. ?>
                        </div>
                        <div class="pagination"><?php rehub_pagination();?></div>
                    <?php endif;?>

                    <div class="dealstore_tax_second_desc">
                        <?php echo do_shortcode($brandseconddesc);?>
                    </div>
                
                </article>
            </div>  
            <!-- /Main Side --> 
            <!-- Sidebar -->
            <aside class="sidebar">                 
                <!-- SIDEBAR WIDGET AREA -->
                <?php if ( is_active_sidebar( 'dealstore-sidebar' ) ) : ?>
                    <?php dynamic_sidebar( 'dealstore-sidebar' ); ?>
                <?php else : ?>
                    <p><?php _e('No widgets added. Add widgets inside Deal store archive sidebar in Appearance - Widgets', 'rehub_framework'); ?></p>
                <?php endif; ?>                                     
            </aside>
            <!-- /Sidebar --> 

        </div>
    </div>
    <!-- /CONTENT -->     

<!-- FOOTER -->
<?php get_footer(); ?>