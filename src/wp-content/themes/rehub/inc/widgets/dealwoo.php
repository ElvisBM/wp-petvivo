<?php
/**
 * Plugin Name: News Widget
 */

add_action( 'widgets_init', 'rehub_deal_daywoo_load_widget' );

function rehub_deal_daywoo_load_widget() {
	register_widget( 'rehub_deal_daywoo_widget' );
}

class rehub_deal_daywoo_widget extends WP_Widget {

    function __construct() {
        $widget_ops = array( 'classname' => 'deal_daywoo woocommerce', 'description' => __('Widget that displays deal of the day(woocommerce). Use only in sidebar!', 'rehub_framework') );
        $control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'rehub_deal_daywoo' );
        parent::__construct('rehub_deal_daywoo', __('ReHub: Deal of day (woo)', 'rehub_framework'), $widget_ops, $control_ops);
    }

/**
 * How to display the widget on the screen.
 */
function widget( $args, $instance ) {
	extract( $args );

	/* Our variables from the widget settings. */
	$title = apply_filters('widget_title', $instance['title'] );
	$dealid = (!empty($instance['dealid'])) ? (int)$instance['dealid'] : '';
	$faketimer = (!empty($instance['faketimer'])) ? $instance['faketimer'] : '';
	$fakebar = (!empty($instance['fakebar'])) ? $instance['fakebar'] : '';
	$markettext = (!empty($instance['markettext'])) ? $instance['markettext'] : '';			
	global $post;

	if ($dealid){
		$args = array('post__in' => array($dealid), 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'post_type' => 'product', 'no_found_rows'=>1);
	}
	else{
        $args = array(
            'posts_per_page'=>'1',
            'post_type'=> 'product',            
        );	
	    $product_ids_on_sale = wc_get_product_ids_on_sale();
	    $meta_query   = array();
	    $meta_query[] = WC()->query->visibility_meta_query();
	    $meta_query[] = WC()->query->stock_status_meta_query();
	    $meta_query   = array_filter( $meta_query );
	    $args['meta_query'] = $meta_query;
	    $args['post__in'] = array_merge( array( 0 ), $product_ids_on_sale );
	    $args['no_found_rows'] = 1;        	
	}
	
	$loop = new WP_Query($args);
	
	/* Before widget (defined by themes). */
	echo $before_widget;

	if ($loop->have_posts()) :

	/* Display the widget title if one was input (before and after defined by themes). */
	if ( $title )
		echo '<div class="title">' . $title . '</div>';
	?>
		<div class="woo_spec_widget">		
		<?php  while ($loop->have_posts()) : $loop->the_post(); global $product; ?>	
			<?php $wootarget = ($product->product_type =='external') ? ' target="_blank" rel="nofollow"' : '' ;?>
			<?php $woolink = ($product->product_type =='external') ? $product->add_to_cart_url() : get_post_permalink($post->ID) ;?>
		    <figure class="centered_image_woo">
		        <a href="<?php echo $woolink ;?>"<?php echo $wootarget ;?>>
		            <?php if ( $product->is_featured() ) : ?>
		                    <?php echo apply_filters( 'woocommerce_featured_flash', '<span class="onfeatured">' . esc_html__( 'Featured!', 'woocommerce' ) . '</span>', $post, $product ); ?>
		            <?php endif; ?>        
		            <?php if ( $product->is_on_sale() ) : ?>
		                <?php 
		                $percentage=0;
		                $featured = ($product->is_featured()) ? ' onsalefeatured' : '';
		                if ($product->regular_price) {
		                    $percentage = round( ( ( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 );
		                }
		                if ($percentage) {
		                    $sales_html = '<span class="onsale'.$featured.'"><span>- ' . $percentage . '%</span></span>';
		                } else {
		                    $sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="onsale'.$featured.'">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product );
		                }
		                ?>
		                <?php echo $sales_html; ?>
		            <?php endif; ?>
		            <?php 
		            $showimg = new WPSM_image_resizer();
		            $showimg->use_thumb = true; 
		            $showimg->no_thumb = rehub_woocommerce_placeholder_img_src('');                                   
		            ?>
		            <?php $showimg->width = '300';?>
		            <?php $showimg->height = '300';?>                                                   
		            <?php $showimg->show_resized_image(); ?>
		        </a>
		        <div class="yith_float_btns">
		            <div class="button_action"> 
		                <?php if (in_array( 'yith-woocommerce-compare/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )  { ?>
		                    <?php 
		                        $yith_compare = new YITH_Woocompare_Frontend();
		                        add_shortcode( 'yith_compare_button', array( $yith_compare , 'compare_button_sc' ) );
		                        echo do_shortcode('[yith_compare_button]'); 
		                    ?>                
		                <?php } ?>
		                <?php if (in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )  { ?> 
		                    <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?> 
		                <?php } ?>                                          
		            </div> 
		        </div>          
		    </figure>
		    <div class="woo_loop_desc">      
		        <a <?php if(rehub_option('woo_thumb_enable') =='1') :?>class="<?php echo getHotIconclass($post->ID); ?>"<?php endif ;?> href="<?php echo $woolink ;?>"<?php echo $wootarget ;?>>
		            <?php echo rh_expired_or_not($post->ID, 'span');?>     
		            <?php 
		                /**
		                 * woocommerce_shop_loop_item_title hook.
		                 *
		                 * @hooked woocommerce_template_loop_product_title - 10
		                 */     
		                do_action( 'woocommerce_shop_loop_item_title' ); 
		            ?>
		        </a>
		        <?php do_action( 'rehub_vendor_show_action' ); ?>            
		    </div>
	        <div class="woo_spec_price">
				<?php wc_get_template( 'loop/price.php' ); ?>
	        </div>	
        	<?php if($fakebar):?>
        		<?php $stock_sold = 12; $stock_available = 16; $percentage = 75;?>
        	<?php else:?>
	        	<?php 
	        		$stock_sold = ( $total_sales = get_post_meta( get_the_ID(), 'total_sales', true ) ) ? round( $total_sales ) : 0;
					$stock_available 	= ( $stock = get_post_meta( get_the_ID(), '_stock', true ) ) ? round( $stock ) : 0;
					$percentage 		= ( $stock_available > 0 ? round( $stock_sold/$stock_available * 100 ) : '' );
				?>	        	
        	<?php endif;?>	
        	<?php if ($percentage || $percentage==0):?>        
	        <div class="woo_spec_bar mt30 mb20">
	        	<div class="deal-stock mb10">
	        	<span class="stock-sold floatleft">
	        		<?php echo esc_html__( 'Already Sold:', 'rehub_framework' );?> <strong><?php echo esc_html( $stock_sold ); ?></strong>
	        	</span>
	        	<span class="stock-available floatright">
	        		<?php echo esc_html__( 'Available:', 'rehub_framework' );?> <strong><?php echo esc_html( $stock_available ); ?></strong>
	        	</span>
	        	</div>
	        	<?php if ($percentage == 0) {$percentage = 10;}?>
	        	<?php echo do_shortcode('[wpsm_bar percentage="'.$percentage.'"]');?>
	        </div>	 
	        <?php endif;?>
			<div class="marketing-text mt15 mb15"><?php echo $markettext;?></div>
        	<?php if($faketimer):?>
        		<?php 
        			$now = new DateTime('now');
        			$now->modify('tomorrow');
   					$month = $now->format('m');
   					$year = $now->format('Y');
   					$day = $now->format('d');
   				?>
        	<?php else:?>
	        	<?php 
	        		$sale_price_dates_to 	= ( $date = get_post_meta( get_the_ID(), '_sale_price_dates_to', true ) ) ? date_i18n( 'Y-m-d', $date ) : '';
	        		if ($sale_price_dates_to){
	        			$expireddate = explode('-', $sale_price_dates_to);
						$year = $expireddate[0];
						$month = $expireddate[1];
						$day  = $expireddate[2];
	        		}
	        		else{
	        			$year = '';
	        		}
				?>	        	
        	<?php endif;?>
        	<?php if($year):?>
        		<div class="woo_spec_timer">
        			<?php echo do_shortcode('[wpsm_countdown year="'.$year.'" month="'.$month.'" day="'.$day.'"]');?>
        		</div>
        	<?php endif;?>		

		<?php endwhile; ?>
		<?php wp_reset_query(); ?>
		</div>
	<?php else: ?>
		<?php _e('No products for this criteria.', 'rehub_framework');  ?>
	<?php endif; ?>
			
	<?php

	/* After widget (defined by themes). */
	echo $after_widget;
}


	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['faketimer'] = strip_tags($new_instance['faketimer']);
		$instance['fakebar'] = strip_tags($new_instance['fakebar']);
		$instance['markettext'] = strip_tags($new_instance['markettext']);
		$instance['dealid'] = strip_tags( $new_instance['dealid'] );

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Deal of the day', 'rehub_framework'), 'dealid' => '','faketimer' => '','fakebar' => '','markettext' => 'Hurry Up! Offer ends soon.',);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title of widget:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'dealid' ); ?>"><?php _e('Id of product to show:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'dealid' ); ?>" name="<?php echo $this->get_field_name( 'dealid' ); ?>" value="<?php echo $instance['dealid']; ?>" size="3" />
			<small>By default, widget shows latest product which is on sale, you can specify product ID to overwrite this</small>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'faketimer' ); ?>"><?php _e('Set fake timer:', 'rehub_framework'); ?></label>
			<input id="<?php echo $this->get_field_id( 'faketimer' ); ?>" name="<?php echo $this->get_field_name( 'faketimer' ); ?>" value="true" <?php if( $instance['faketimer'] ) echo 'checked="checked"'; ?> type="checkbox" />
			<br /><small>By default, widget shows countdown base on Sale price dates of product. You can enable fake timer (always shows 12 hours)  </small>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'markettext' ); ?>"><?php _e('Add marketing text:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'markettext' ); ?>" name="<?php echo $this->get_field_name( 'markettext' ); ?>" value="<?php echo $instance['markettext']; ?>"  />
		</p>		

		<p>
			<label for="<?php echo $this->get_field_id( 'fakebar' ); ?>"><?php _e('Set fake sold bar:', 'rehub_framework'); ?></label>
			<input id="<?php echo $this->get_field_id( 'fakebar' ); ?>" name="<?php echo $this->get_field_name( 'fakebar' ); ?>" value="true" <?php if( $instance['fakebar'] ) echo 'checked="checked"'; ?> type="checkbox" />
			<br /><small>By default, widget shows real progress bar based on stock status, you can enable fake bar (shows 75% of sold)</small>
		</p>			

	<?php
	}
}

?>