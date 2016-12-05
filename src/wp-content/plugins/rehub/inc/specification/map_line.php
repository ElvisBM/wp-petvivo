<?php 
$map_line_location = (!empty($row['map_line_location'])) ? $row['map_line_location'] : '';
$map_line_longitude = (!empty($row['map_line_longitude'])) ? $row['map_line_longitude'] : '';
$map_line_latitude = (!empty($row['map_line_latitude'])) ? $row['map_line_latitude'] : '';
?>

<?php if ($map_line_location || $map_line_longitude):?>
    <?php if($map_line_location):?>
    <div class="wpsm_spec_map_row mt20 mb20">
        <?php $location = get_post_meta($postID, $map_line_location, true);?>
        <?php echo do_shortcode('[wpsm_googlemap location="'.$location.'"]');?>
    </div>
    <?php elseif($map_line_longitude && $map_line_latitude):?>
        <?php $lat = get_post_meta($postID, $map_line_latitude, true);?>
        <?php $lng = get_post_meta($postID, $map_line_longitude, true);?>        
        <?php echo do_shortcode('[wpsm_googlemap lat="'.$lat.'" lng="'.$lng.'"]');?>        
    <?php endif;?>
<?php endif;?>