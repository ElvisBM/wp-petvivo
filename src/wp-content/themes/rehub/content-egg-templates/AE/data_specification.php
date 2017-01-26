<?php
/*
  Name: Item specification
 */

use ContentEgg\application\helpers\TemplateHelper;

?>

<?php foreach ($items as $item): ?>
    <?php if (!empty ($item['extra']['features'])) {$attributes = $item['extra']['features'];}  ?>
    <?php include(rh_locate_template('inc/ce_common/item_specification.php')); ?>
<?php endforeach; ?>     