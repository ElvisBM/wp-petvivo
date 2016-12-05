<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header(); ?>

    <?php 
        $vendor_id = $vendor_pro = '';
        if (defined('wcv_plugin_dir')){
            $vendor_shop = urldecode( get_query_var( 'vendor_shop' ) );
            $vendor_id   = WCV_Vendors::get_vendor_id( $vendor_shop );
        }
        if ($vendor_id){
            return include(locate_template('inc/wcvendor/storepage.php'));
        }

    ?>

<!-- CONTENT -->
<div class="content"> 
	<div class="clearfix">
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


                <?php if (is_tax('store')):?>  
                    <?php 
                        $tagid = get_queried_object()->term_id; 
                        $tagobj = get_term_by('id', $tagid, 'store');
                        $tagname = $tagobj->name;
                        $brandimage = get_term_meta( $tagid, 'brandimage', true );                             
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
                            <span class="saledealtype"><?php _e('Deals', 'rehub_framework'); ?></span>
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
                                <?php include(locate_template('inc/parts/woolistpart.php')); ?>                                
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
                    <?php
                        /**
                         * woocommerce_after_main_content hook.
                         *
                         * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                         */
                        do_action( 'woocommerce_after_main_content' );
                    ?>                                                                         
                <?php else :?>     
    				
    				<?php do_action( 'woocommerce_archive_description' ); ?>
    				<?php if ( have_posts() ) : ?>
    					<?php
    						/**
    						 * woocommerce_before_shop_loop hook
    						 *
    						 * @hooked woocommerce_result_count - 20
    						 * @hooked woocommerce_catalog_ordering - 30
    						 */
    						do_action( 'woocommerce_before_shop_loop' );
    					?>
                        <?php woocommerce_product_subcategories(array( 'before' => '<div class="col_wrap_three products_category_box column_woo">', 'after' => '</div>')); ?>
    					<?php woocommerce_product_loop_start(); ?>   						
    						<?php while ( have_posts() ) : the_post(); ?>
    							<?php wc_get_template_part( 'content', 'product' ); ?>
    						<?php endwhile; // end of the loop. ?>
    					<?php woocommerce_product_loop_end(); ?>
    					<?php
    						/**
    						 * woocommerce_after_shop_loop hook
    						 *
    						 * @hooked woocommerce_pagination - 10
    						 */
    						do_action( 'woocommerce_after_shop_loop' );
    					?>
    				<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
    					<?php wc_get_template( 'loop/no-products-found.php' ); ?>
    				<?php endif; ?>

                <?php endif;?>
    		</article>
    	</div>
	<!-- /Main Side --> 

	<?php get_sidebar('shop'); ?>

    </div>
</div>
<!-- /CONTENT -->	

<?php get_footer(); ?>