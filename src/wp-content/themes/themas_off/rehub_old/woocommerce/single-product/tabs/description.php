<?php
/**
 * Description tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $post;

?>

<?php the_content(); ?>

<?php $rehub_woo_review_related = vp_metabox('rehub_framework_woo.review_woo_id'); if ($rehub_woo_review_related !='') :?>
<p><a href="<?php echo get_permalink($rehub_woo_review_related) ;?>" target="_blank"><?php _e('Read review of product', 'rehub_framework') ;?></a></p>
<?php endif ;?>