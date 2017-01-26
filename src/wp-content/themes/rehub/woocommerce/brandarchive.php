<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$tagid = get_queried_object()->term_id; 
$tagobj = get_term_by('id', $tagid, 'store');
$tagname = $tagobj->name;
$brandimage = get_term_meta( $tagid, 'brandimage', true );
$brandseconddesc = get_term_meta( $tagid, 'brand_second_description', true );
?>

<!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
        <!-- Main Side -->
        <div class="main-side woocommerce page clearfix">
            <article class="post" id="page-<?php the_ID(); ?>">
               <?php
                    /**
                     * woocommerce_before_main_content hook
                     *
                     * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                     * @hooked woocommerce_breadcrumb - 20
                     */
                    do_action( 'woocommerce_before_main_content' );
                ?>   
                <div class="woo-tax-wrap">
                    <?php                              
                    if (!empty ($brandimage)) { 
                        $showbrandimg = new WPSM_image_resizer();
                        $showbrandimg->height = '60';
                        $showbrandimg->src = $brandimage;                                   
                        echo '<div class="woo-tax-logo">';
                        $showbrandimg->show_resized_image();  
                        echo '</div>';
                    }?>
                    <h3><?php echo $tagname;?></h3>
                    <?php echo rehub_get_user_rate('admin', 'tax'); ?>                              
                </div>                                                 
                <?php
                    $description = wc_format_content( term_description() );
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
                    <?php
                        /**
                         * woocommerce_before_shop_loop hook.
                         *
                         * @hooked woocommerce_result_count - 20
                         * @hooked woocommerce_catalog_ordering - 30
                         */
                        do_action( 'woocommerce_before_shop_loop' );
                    ?>
                    <div class="woo_offer_list">
                        <?php while ( have_posts() ) : the_post(); ?>                                
                            <?php include(rh_locate_template('inc/parts/woolistpart.php')); ?>                                
                        <?php endwhile; // end of the loop. ?>
                    </div>
                    <?php
                        /**
                         * woocommerce_after_shop_loop hook.
                         *
                         * @hooked woocommerce_pagination - 10
                         */
                        do_action( 'woocommerce_after_shop_loop' );
                    ?>
                <?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
                    <?php wc_get_template( 'loop/no-products-found.php' ); ?>
                <?php endif; ?>

                <div class="woostore_tax_second_desc">
                    <?php echo do_shortcode($brandseconddesc);?>
                </div>

                <?php
                    /**
                     * woocommerce_after_main_content hook.
                     *
                     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                     */
                    do_action( 'woocommerce_after_main_content' );
                ?> 

            </article>
        </div>
    <!-- /Main Side --> 

    <!-- Sidebar -->
    <aside class="sidebar">                 
        <!-- SIDEBAR WIDGET AREA -->
        <?php if ( is_active_sidebar( 'woostore-sidebar' ) ) : ?>
            <?php dynamic_sidebar( 'woostore-sidebar' ); ?>
        <?php else : ?>
            <p><?php _e('No widgets added. Add widgets inside Woo brand archive sidebar in Appearance - Widgets', 'rehub_framework'); ?></p>
        <?php endif; ?>                                     
    </aside>
    <!-- /Sidebar --> 

    </div>
</div>
<!-- /CONTENT -->