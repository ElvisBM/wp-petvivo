<?php
/*
  Name: Images from Amazon
 */
use ContentEgg\application\helpers\TemplateHelper;  
?>

<?php $random_key = rand(0, 50);?>
<script>
jQuery(document).ready(function($) {
    'use strict'; 
    $('.gallery_images_zon .pretty_woo a').attr('rel', 'prettyPhoto[rehub_product_gallery_<?php echo $random_key;?>]');
    $(".gallery_images_zon .pretty_woo a[rel^='prettyPhoto']").prettyPhoto({social_tools:false});
});
</script>
<div class="gallery_images_zon">
<?php foreach ($items as $item): ?>
    <?php $offer_title = (!empty($item['title'])) ? $item['title'] : ''; ?> 
    <?php $gallery_images = (!empty ($item['extra']['imageSet'])) ? $item['extra']['imageSet'] : ''?>
            <?php if (!empty ($gallery_images)) :?>
                <div class="pretty_woo">
                    <?php wp_enqueue_script('prettyphoto');
                        foreach ($gallery_images as $gallery_img) {
                            ?> 
                            <a href="<?php echo esc_attr($gallery_img['LargeImage']) ;?>"> 
                            <img src="<?php echo esc_attr($gallery_img['MediumImage']) ;?>" alt="<?php echo esc_attr($offer_title); ?>" />  
                            </a>
                            <?php
                        }
                    ?>
                </div>
            <?php endif ;?>      
<?php endforeach; ?>
</div>
<div class="clearfix"></div>