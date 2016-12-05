<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>


<?php
$res = array();
if (!empty($filter_posts))
{
    if (is_array($filter_posts))
    {
        foreach ($filter_posts as $pid)
        {
            $tmp = MetaDataFilterPage::get_html_items($pid);
            if (!empty($tmp))
            {
                if (is_array($tmp))
                {
                    foreach ($tmp as $key => $value)
                    {
                        $res[$key] = $value;
                    }
                }
            }
        }
    }
}
?>

<?php if (isset($_REQUEST['in_essentil_block'])): ?>

    <?php if (!empty($res) AND ! empty($page_meta_data_filter)): ?>

        <div class="mdf_post_features_panel_essential" id="features_panel_essential_<?php echo uniqid() ?>">

            <?php foreach ($page_meta_data_filter as $key => $value) : ?>
                <?php if (isset($res[$key])): ?>


                    <?php if ($res[$key]['type'] == 'checkbox' AND (int) $value == 1): ?>
                        <div class="mdf_post_feature mdf_title_data_checkbox <?php echo $key ?>"><?php _e($res[$key]['name']) ?></div>
                    <?php endif; ?>

                    <?php if ($res[$key]['type'] == 'select' AND $value != 'none'): ?>

                        <?php
                        $tmp = floatval($value);
                        if ($tmp > 0):
                            ?>

                            <div class="mdf_post_feature mdf_title_data_select <?php echo $key ?>"><?php _e($res[$key]['name'] . ':&nbsp;<i>' . $value . '</i>') ?></div>


                        <?php else: ?>


                            <?php
                            if (!empty($res[$key]['select']))
                            {
                                $val = "~";
                                foreach ($res[$key]['select'] as $k => $v)
                                {
                                    $select_option_key=$res[$key]['select_key'][$k];
                                    if ($select_option_key == $value)
                                    {
                                        $val = $v;
                                        break;
                                    }
                                }
                            }
                            ?>

                            <?php if ($val != '~'): ?>
                                <div class="mdf_post_feature mdf_title_data_select <?php echo $key ?>"><?php _e($res[$key]['name'] . ':&nbsp;<i>' . $val . '</i>') ?></div>
                            <?php endif; ?>

                        <?php endif; ?>


                    <?php endif; ?>


                    <?php if ($res[$key]['type'] == 'slider'): ?>
                        <?php
                        //print_r($res[$key]);
                        if ($res[$key]['slider_prettify'] == 1)
                        {
                            $value = number_format($value, 2);
                        }
                        if (!isset($res[$key]['slider_range_value']))
                        {
                            $res[$key]['slider_range_value'] = 0;
                        }
                        ?>

                        <?php if ($res[$key]['slider_range_value'] == 1): ?>
                            <?php
                            $t = get_post_meta($post_id, $key . '_to', true);
                            $f = $res[$key]['slider_prefix'] . $value . ' - ' . $t . $res[$key]['slider_postfix'];
                            ?>
                            <div class="mdf_post_feature mdf_title_data_slider <?php echo $key ?>"><?php _e($res[$key]['name']) ?>: <i><?php echo $f; ?></i></div>
                        <?php else: ?>
                            <?php $value = $res[$key]['slider_prefix'] . $value . $res[$key]['slider_postfix']; ?>
                            <div class="mdf_post_feature mdf_title_data_slider <?php echo $key ?>"><?php _e($res[$key]['name']) ?>: <i><?php echo $value; ?></i></div>
                        <?php endif; ?>

                    <?php endif; ?>


                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

<?php else: ?>

    <?php if (!empty($res) AND ! empty($page_meta_data_filter)): ?>
        <span class="mdf_title_data">
            <ul class="mdf_post_features_panel">
                <?php foreach ($page_meta_data_filter as $key => $value) : ?>
                    <?php if (isset($res[$key])): ?>


                        <?php if ($res[$key]['type'] == 'checkbox' AND (int) $value == 1): ?>
                            <li class="mdf_post_feature mdf_title_data_checkbox <?php echo $key ?>"><?php _e($res[$key]['name']) ?><?php if (!empty($res[$key]['description'])): ?><span class="mdf_tooltip2"><?php echo strip_tags(__($res[$key]['description'])); ?></span><?php endif; ?></li>
                        <?php endif; ?>

                        <?php if ($res[$key]['type'] == 'select' AND $value != 'none'): ?>

                            <?php
                            $tmp = floatval($value);
                            if ($tmp > 0):
                                ?>

                                <li class="mdf_post_feature mdf_title_data_select <?php echo $key ?>"><?php _e($res[$key]['name'] . ':&nbsp;<i>' . $value . '</i>') ?>&nbsp;<?php if (!empty($res[$key]['description'])): ?><span class="mdf_tooltip2"><?php echo strip_tags(__($res[$key]['description'])); ?></span><?php endif; ?></li>


                            <?php else: ?>


                                <?php
                                if (!empty($res[$key]['select']))
                                {
                                    $val = "~";
                                    foreach ($res[$key]['select'] as $k => $v)
                                    {
                                        $select_option_key=$res[$key]['select_key'][$k];
                                        if ($select_option_key == $value)
                                        {
                                            $val = $v;
                                            break;
                                        }
                                    }
                                }
                                ?>

                                <?php if ($val != '~'): ?>
                                    <li class="mdf_post_feature mdf_title_data_select <?php echo $key ?>"><?php _e($res[$key]['name'] . ':&nbsp;<i>' . $val . '</i>') ?>&nbsp;<?php if (!empty($res[$key]['description'])): ?><span class="mdf_tooltip2"><?php echo strip_tags(__($res[$key]['description'])); ?></span><?php endif; ?></li>
                                <?php endif; ?>

                            <?php endif; ?>


                        <?php endif; ?>


                        <?php if ($res[$key]['type'] == 'slider'): ?>
                            <?php
                            //print_r($res[$key]);
                            if ($res[$key]['slider_prettify'] == 1)
                            {
                                $value = number_format($value, 2);
                            }
                            if (!isset($res[$key]['slider_range_value']))
                            {
                                $res[$key]['slider_range_value'] = 0;
                            }
                            ?>

                            <?php if ($res[$key]['slider_range_value'] == 1): ?>
                                <?php
                                $t = get_post_meta($post_id, $key . '_to', true);
                                $f = $res[$key]['slider_prefix'] . $value . ' - ' . $t . $res[$key]['slider_postfix'];
                                ?>
                                <li class="mdf_post_feature mdf_title_data_slider <?php echo $key ?>"><?php _e($res[$key]['name']) ?>: <i><?php echo $f; ?></i><?php if (!empty($res[$key]['description'])): ?><span class="mdf_tooltip2"><?php echo strip_tags(__($res[$key]['description'])); ?></span><?php endif; ?></li>
                            <?php else: ?>
                                <?php $value = $res[$key]['slider_prefix'] . $value . $res[$key]['slider_postfix']; ?>
                                <li class="mdf_post_feature mdf_title_data_slider <?php echo $key ?>"><?php _e($res[$key]['name']) ?>: <i><?php echo $value; ?></i><?php if (!empty($res[$key]['description'])): ?><span class="mdf_tooltip2"><?php echo strip_tags(__($res[$key]['description'])); ?></span><?php endif; ?></li>
                            <?php endif; ?>

                        <?php endif; ?>


                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <div style="clear: both;"></div>
        </span>
    <?php endif; ?>



<?php endif; ?>

