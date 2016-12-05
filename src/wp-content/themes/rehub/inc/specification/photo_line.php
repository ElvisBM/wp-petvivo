<?php 
	$photo_line = (!empty($row['photo_line'])) ? $row['photo_line'] : '';		    
?>
<?php if ($photo_line):?>
	<?php $value = get_post_meta($postID, $photo_line, true);?>
	<?php if (!empty($value)):?>
		<?php 	
			wp_enqueue_script('prettyphoto');
			wp_enqueue_script('custom_pretty');
		?>	
		<?php if (!is_array($value)) :?>
			<div class="wpsm_spec_photosingle_line">
			<?php if ( is_numeric($value) ) $value = wp_get_attachment_url( $value);?>
				<a rel="prettyPhoto" href="<?php echo $value;?>">
					<?php WPSM_image_resizer::show_static_resized_image(array('src'=> $value, 'width'=> 230, 'height'=>150, 'crop'=>true, 'title' => $imgtitle, 'lazy' => false));?>
				</a>
			</div>
		<?php elseif (is_array($value)) :?>
			<?php  $pretty_id = rand(5, 150); wp_enqueue_script('owlcarousel');?>
			<div class="media_owl_carousel carousel-style-2 loading photo_line_car pretty_photo_<?php echo $pretty_id;?> clearfix">
				<div class="re_carousel" data-showrow="5" data-auto="">
				<?php foreach ($value as $key) :?>
					<?php $imgurl = (is_array($key) && !empty($key['url'])) ? $key['url'] : $key;?>
					<?php $imgtitle = (is_array($key) && !empty($key['title'])) ? $key['title'] : '';?>
					<?php if ( is_numeric($imgurl) ) $imgurl = wp_get_attachment_url( $imgurl);?>
					<div class="photo-item">
						<a href="<?php echo $imgurl;?>" title="<?php echo $imgtitle;?>">
							<?php WPSM_image_resizer::show_static_resized_image(array('src'=> $imgurl, 'width'=> 230, 'height'=>150, 'crop'=>true, 'title' => $imgtitle, 'lazy' => false));?> 
						</a>
					</div>
				<?php endforeach;?>			
			</div>
		 	<script>jQuery(function($){$(document).ready(function($){
	     		$(".pretty_photo_<?php echo $pretty_id;?> a").attr("rel","prettyPhoto[gallery_<?php echo $pretty_id;?>]").prettyPhoto({social_tools:false});
	      	});});</script>
	    </div>
		<?php endif;?>
		
	<?php endif;?>
<?php endif;?>