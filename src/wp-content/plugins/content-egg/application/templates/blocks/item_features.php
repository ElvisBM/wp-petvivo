<?php if (!empty($item['extra']['itemAttributes']['Feature'])): ?>
    <div class="cegg-features-box">
        <h4 class="cegg-no-top-margin"><?php _e('Features', 'content-egg-tpl'); ?></h4>
        <ul class="cegg-feature-list">
            <?php foreach ($item['extra']['itemAttributes']['Feature'] as $k => $feature): ?>
                <li><?php echo $feature; ?></li>
                <?php if ($k >= 4) break; ?>                                    
            <?php endforeach; ?>
        </ul>
    </div>
<?php elseif (!empty($item['extra']['param'])): ?>
    <div class="cegg-features-box">
        <h4 class="cegg-no-top-margin"><?php _e('Features', 'content-egg-tpl'); ?></h4>
        <ul class="cegg-feature-list">
            <?php foreach ($item['extra']['param'] as $fname => $fvalue): ?>
                <li><?php echo '<strong>' . esc_html($fname) . '</strong>' . ': ' . esc_html($fvalue); ?></li>
            <?php endforeach; ?>
        </ul>
    </div> 
<?php elseif (!empty($item['extra']['features'])): ?>
    <div class="cegg-features-box">
        <h3 class="cegg-no-top-margin"><?php _e('Features', 'content-egg-tpl'); ?></h3>
        <ul class="cegg-feature-list">
            <?php foreach ($item['extra']['features'] as $feature): ?>
                <li><?php echo '<strong>' . esc_html($feature['name']) . '</strong>' . ': ' . esc_html($feature['value']); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php elseif (!empty($item['extra']['properties'])): ?>
    <div class="cegg-features-box">
        <h4 class="cegg-no-top-margin"><?php _e('Features', 'content-egg-tpl'); ?></h4>
        <ul class="cegg-feature-list">
            <?php foreach ($item['extra']['properties'] as $property): ?>
                <li><?php echo '<strong>' . esc_html($property['name']) . '</strong>' . ': ' . esc_html($property['value']); ?></li>
            <?php endforeach; ?>
        </ul>
    </div> 
<?php elseif (!empty($item['extra']['keySpecs'])): ?>
    <div class="cegg-features-box">
        <h4 class="cegg-no-top-margin"><?php _e('Features', 'content-egg-tpl'); ?></h4>
        <ul class="cegg-feature-list">
            <?php foreach ($item['extra']['keySpecs'] as $feature): ?>
                <li><?php echo esc_html($feature); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php elseif (!empty($item['extra']['Detail'])): ?>
    <div class="cegg-features-box">
        <h4 class="cegg-no-top-margin"><?php _e('Features', 'content-egg-tpl'); ?></h4>
        <ul class="cegg-feature-list">
            <?php foreach ($item['extra']['Detail'] as $name => $value): ?>
                <li><?php echo esc_html($name) ?>: <?php echo esc_html($value) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>   
<?php endif; ?>
<?php if (!empty($item['extra']['specificationList'])): ?>
    <div class="cegg-features-box">
        <h4 class="cegg-no-top-margin"><?php _e('Specifications', 'content-egg-tpl'); ?></h4>
        <ul class="cegg-feature-list">
            <?php $i = 0; ?>
            <?php foreach ($item['extra']['specificationList'] as $specificationList): ?>
                <?php if (!empty($specificationList['key'])) echo '<b>' . esc_html($specificationList['key']) . '</b>'; ?>
                <?php foreach ($specificationList['values'] as $feature): ?>
                    <li><?php echo '<strong>' . esc_html($feature['key']) . '</strong>' . ': ' . esc_html(join('; ', $feature['value'])); ?></li>
                    <?php $i++;
                    if ($i >= 20)
                        break;
                    ?>
                <?php endforeach; ?>
                <?php $i++;
                if ($i >= 20)
                    break;
                ?>
    <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
