<?php 
	$title_enable = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.gal_carousel.0.gal_carousel_toggle_title');
	$title_name = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.gal_carousel.0.gal_carousel_module_title');
	$title_position = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.gal_carousel.0.gal_carousel_title_position');
	$title_url_title = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.gal_carousel.0.gal_carousel_url_text');
	$title_url_url = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.gal_carousel.0.two_col_news_url_url');
    $gallery_im_ids = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.gal_carousel.0.gal_carousel_group');		
?>

<?php wp_enqueue_script('owlcarousel'); wp_enqueue_script('prettyphoto');?>
<!-- gallery -->
<?php title_custom_block ($title_enable, $title_name, $title_position, $title_url_title, $title_url_url) ?>
<div class="media_owl_carousel carousel-style-2 pretty_photo_<?php $pretty_id = rand(5, 15); echo $pretty_id ; ?> clearfix">
	<div class="re_carousel" data-showrow="4" data-auto="">
		<?php foreach ($gallery_im_ids as $gallery_im_id): ?>
			<?php if (!empty ($gallery_im_id['gal_carousel_url'])) :?>
				<?php $urlgal = $gallery_im_id['gal_carousel_url']; $pretty =''; $target ='target="_blank" rel="nofollow"' ?>
			<?php else :?>
				<?php $urlgal = $gallery_im_id['gal_carousel_img']; $pretty ='class="onphoto"'; $target ='' ?>
			<?php endif ;?>	
			<?php 
				$params = array( 'width' => 200, 'height' => 140, 'crop' => true  ); $img_thumb = bfi_thumb($gallery_im_id['gal_carousel_img'], $params); 
				if (empty($img_thumb)) { $img_thumb = get_template_directory_uri() . '/images/default/noimage_200_140.png' ;} 
			?>
	      <div class="photo-item" <?php echo $pretty; ?>>
	        <a href="<?php echo $urlgal; ?>" <?php echo $target; ?>><img src="<?php echo $img_thumb ?>" alt="gallery pics"></a>
	      </div>
	    <?php endforeach; ?>
	</div>
</div>	
<script>
	jQuery(document).ready(function($) {
		'use strict';
		$('.pretty_photo_<?php echo $pretty_id ; ?> a').attr("rel","prettyPhoto[gallery_<?php echo $pretty_id ; ?>]");
		$(".onphoto a[rel^='prettyPhoto']").prettyPhoto({social_tools:false});
	});
</script>	
<!-- gallary --> 		