<?php 
    $mdtf_line = (!empty($row['mdtf_line'])) ? $row['mdtf_line'] : '';       
?>

<?php if ($mdtf_line):?>
    <?php $section_title = get_the_title($mdtf_line);?>
    <?php $section_fields = get_post_meta($mdtf_line, 'html_items', true);?>

    <?php if (!empty($section_fields)):?>
        <div class="wpsm_spec_meta_row">
            <div class="wpsm_spec_meta_label">
                <?php echo $section_title;?>
            </div>
            <div class="wpsm_spec_meta_value">
            <?php foreach ($section_fields as $section_field) :?>
                <?php $value = ($section_field['is_reflected'] !=0 && $section_field['is_reflected'] !='') ? get_post_meta($postID, $section_field['is_reflected'], true) : get_post_meta($postID, $section_field['meta_key'], true);?>
                <?php if ($value && $section_field['type'] !='checkbox') :?>
                    <?php if (!empty($section_field['name'])) :?><span class="wpsm_spec_mdtf_value_pre"><?php echo $section_field['name'];?>: </span><?php endif;?> 
                    <span class="wpsm_spec_meta_value_s"><?php echo $value ?></span>
                    <div class="mb10"></div>
                <?php elseif ($section_field['type'] =='checkbox') :?>
                    <?php $field_value_check = ($value =='1' || $value =='on') ? '<i class="fa fa-check"></i>' : '<i class="fa fa-ban"></i>' ?>
                    <span class="wpsm_spec_meta_value_icon"><?php echo $field_value_check; ?></span>
                    <?php if (!empty($section_field['name'])) :?><span class="wpsm_spec_mdtf_value_pre"><?php echo $section_field['name'];?></span><?php endif;?>
                    <div class="mb10"></div>
                <?php endif;?>                
            <?php endforeach;?>
            </div>
        </div>
    <?php endif;?>
<?php endif;?>