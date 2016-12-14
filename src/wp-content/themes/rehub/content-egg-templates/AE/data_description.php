<?php
/*
  Name: Item description
 */

?>

<?php foreach ($items as $item): ?>
	<?php $description = (!empty($item['description'])) ? $item['description'] : ''; ?>
	<?php if($description):?>
		<?php $result_no_links = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $description);?>
		<?php echo wp_kses_post($result_no_links);?>
	<?php endif;?>
<?php endforeach; ?>     