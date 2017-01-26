<?php
/*
  Name: User comments
 */
?>
<?php foreach ($items as $item): ?>
     <?php if (!empty($item['extra']['comments'])) {$import_comments = $item['extra']['comments'];}?>
    <?php include(rh_locate_template('inc/ce_common/user_comments.php')); ?>
<?php endforeach; ?>        