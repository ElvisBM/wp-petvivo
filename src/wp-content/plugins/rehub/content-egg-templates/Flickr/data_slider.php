<?php
/*
 * Name: Slider
 * 
 */
?>

<?php  wp_enqueue_script('flexslider'); ?>

<div class="post_slider media_slider blog_slider loading"> 
    <ul class="slides">
        <?php 
            foreach ($items as $item) {
        ?>
            <li data-thumb="<?php $params = array( 'width' => 80, 'height' => 80, 'crop' => true  ); echo bfi_thumb($item['img'], $params); ?>">
                <?php if (!empty ($item['title'])) :?>
                    <div class="bigcaption">
                        <?php echo esc_attr($item['title']); ?><br />
                        <p class="font80 mt10"><?php printf(__('Photo %s on Flickr', 'rehub_framework'), '<a href="' . $item['url'] . '" target="_blank" rel="nofollow">' . $item['extra']['author'] . '</a>'); ?></p>
                    </div>
                <?php endif;?>
                <img src="<?php $params = array( 'width' => 765, 'height' => 478, 'crop' => true    );echo bfi_thumb($item['img'], $params); ?>" />
            </li>                                                                                                                                        

        <?php
            }
        ?>
    </ul>
</div>