<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php global $mdf_loop; ?>
<div class="clearfix"></div>
<?php while ($mdf_loop->have_posts()) : $mdf_loop->the_post(); ?>
<div class="woo_offer_list">
<?php $i=1;  $product = new WC_Product(get_the_ID()); global $product; ?>
    <?php include(rh_locate_template('inc/parts/woolistpart.php')); ?>
<?php $i++; ?>   
</div>
<?php endwhile; // end of the loop.    ?>
<div class="clearfix"></div>