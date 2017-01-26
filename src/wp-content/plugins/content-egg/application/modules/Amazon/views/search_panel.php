<?php
$locales = \ContentEgg\application\modules\Amazon\AmazonConfig::getActiveLocalesList();
$default_locale = \ContentEgg\application\modules\Amazon\AmazonConfig::getInstance()->option('locale');
?>

<?php if (count($locales) > 1): ?>
    <select ng-model="query_params.Amazon.locale" ng-init="query_params.Amazon.locale = '<?php echo $default_locale; ?>'">
        <?php foreach ($locales as $value => $name): ?>
            <option value="<?php echo $value; ?>"><?php echo $name; ?></option>
        <?php endforeach; ?>
    </select>
<?php endif; ?>

<input ng-model="query_params.Amazon.associate_tag" ng-init="query_params.Amazon.associate_tag = ''" placeholder="custom associate tag" />

<select ng-model="query_params.<?php echo $module_id; ?>.min_percentage_off">
    <option value=""><?php _e('Min. discount', 'content-egg'); ?></option>
    <option value="5%"><?php _e('5%', 'content-egg'); ?></option>
    <option value="10%"><?php _e('10%', 'content-egg'); ?></option>
    <option value="15%"><?php _e('15%', 'content-egg'); ?></option>
    <option value="20%"><?php _e('20%', 'content-egg'); ?></option>
    <option value="25%"><?php _e('25%', 'content-egg'); ?></option>
    <option value="30%"><?php _e('30%', 'content-egg'); ?></option>
    <option value="35%"><?php _e('35%', 'content-egg'); ?></option>
    <option value="40%"><?php _e('40%', 'content-egg'); ?></option>
    <option value="50%"><?php _e('50%', 'content-egg'); ?></option>
    <option value="60%"><?php _e('60%', 'content-egg'); ?></option>
    <option value="70%"><?php _e('70%', 'content-egg'); ?></option>
    <option value="80%"><?php _e('80%', 'content-egg'); ?></option>
    <option value="90%"><?php _e('90%', 'content-egg'); ?></option>
</select>

