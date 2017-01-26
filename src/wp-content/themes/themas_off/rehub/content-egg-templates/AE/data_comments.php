<?php
/*
  Name: User comments
 */

use ContentEgg\application\helpers\TemplateHelper;

?>

<?php foreach ($items as $item): ?>
    <?php if (!empty($item['extra']['comments'])) {
    	$import_comments = $item['extra']['comments'];
    	include(locate_template('inc/ce_common/user_comments.php'));
    }?>
<?php endforeach; ?>     