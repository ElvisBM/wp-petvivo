<?php if(!defined('ABSPATH')) die('No direct access allowed'); ?>

<?php if(!empty($filter_post['items'])): ?>
<table style="width: 100%;">
    <tbody>
        <tr>
            <th>
                <?php if($filter_post['name']{0} !== '~'): ?>
                    <h4 class="data-filter-section-title"><?php _e($filter_post['name']); ?></h4>
                <?php endif; ?>
                    <?php
                        $icon = MetaDataFilter::get_application_uri() . 'images/tooltip-info.png';
                        $settings = MetaDataFilter::get_settings();
                        if(!empty($settings['tooltip_icon'])) {
                            $icon = $settings['tooltip_icon'];
                    }
                    ?>
            </th>
            <td>
            <?php foreach($filter_post['items'] as $key=> $item) : $uid = uniqid(); ?>

                <?php
                $is_reflected = false;
                if(isset($item['is_reflected']) AND $item['is_reflected'] == 1) {
                    $is_reflected = true;
                }
                ?>

                <?php if($item['type'] == 'slider'): ?>
                    <p>
                        <span class="name_spec"><?php _e($item['name']); ?>:</span> <span class="value_spec"><?php echo MetaDataFilter::get_field($key, $post_id, $is_reflected) ?></span>
                        <?php if(!empty($item['description'])): ?>
                            <span class="mdf_tooltip" title="<?php echo str_replace('"', "'", __($item['description'])); ?>">
                                <img alt="help" src="<?php echo $icon ?>">
                            </span>
                        <?php endif; ?>
                    </p>    
                <?php endif; ?>

                <?php if($item['type'] == 'textinput'): ?>
                    <p>
                        <span class="name_spec"><?php _e($item['name']) ?>:</span> <span class="value_spec"><?php echo MetaDataFilter::get_field($key, $post_id, $is_reflected) ?></span>
                        <?php if(!empty($item['description'])): ?>
                            <span class="mdf_tooltip" title="<?php echo str_replace('"', "'", __($item['description'])); ?>">
                                <img alt="help" src="<?php echo $icon ?>">
                            </span>
                        <?php endif; ?>
                    </p>    
                <?php endif; ?>                                 


                <?php if($item['type'] == 'checkbox'): ?>
                    <?php
                    $is_checked = (int) MetaDataFilter::get_field($key, $post_id, $is_reflected);
                    $to_show = true;
                    if(!$show_absent_items) {
                        if(!$is_checked) {
                            $to_show = false;
                        }
                    }
                    ?>
                    <?php if($to_show): ?>

                        <p><span class="value_spec"><?php _e($item['name']) ?></span>
                            <?php if(!empty($item['description'])): ?>
                                <span class="mdf_tooltip" title="<?php echo str_replace('"', "'", __($item['description'])); ?>">
                                    <img alt="help" src="<?php echo $icon ?>">
                                </span>
                            <?php endif; ?>
                        </p>

                    <?php endif; ?>
                <?php endif; ?>


                <?php if($item['type'] == 'select'): ?>
                    <?php if(!empty($item['select'])): ?>
                        <?php
                        $selected = MetaDataFilter::get_field($key, $post_id, $is_reflected);
                        $to_show = true;
                        if(!$show_absent_items) {
                            if(!$selected) {
                                $to_show = false;
                            }
                        }
                        //***
                        $val = "~";
                        foreach ($item['select'] as $kk => $value)
                        {
                            $select_option_key = $item['select_key'][$kk];
                            if ($selected == $select_option_key)
                            {
                                $val = $value;
                            }
                        }
                        ?>
                        <?php if($to_show AND ! empty($val) AND $val != '~'): ?>
                            <p> 
                                <span class="name_spec"><?php _e($item['name']) ?>:</span> <span class="value_spec"><?php echo $val ?></span>
                                <?php if(!empty($item['description'])): ?>
                                    <span class="mdf_tooltip" title="<?php echo str_replace('"', "'", __($item['description'])); ?>">
                                        <img src="<?php echo $icon ?>" alt="help" />
                                    </span>
                                <?php endif; ?>
                            </p>            
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>

            <?php endforeach; ?>
            </td>
            </tr>
        </tbody>
    </table>
    <?php

 endif;