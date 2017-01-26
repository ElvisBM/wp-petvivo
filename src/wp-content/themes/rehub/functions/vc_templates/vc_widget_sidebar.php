<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
$output = $el_position = $width = $el_class = $sidebar_id = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
if ($width =='') {$width = '1/1';}
if ( $sidebar_id == '' ) return null;

$el_class = $this->getExtraClass($el_class);

ob_start();
dynamic_sidebar($sidebar_id);
$sidebar_value = ob_get_contents();
ob_end_clean();

$sidebar_value = trim($sidebar_value);
$sidebar_value = (substr($sidebar_value, 0, 3) == '<li' ) ? '<ul>'.$sidebar_value.'</ul>' : $sidebar_value;
//
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '' . $el_class, $this->settings['base'], $atts );
$output = '
	<div class="sidebar ' . esc_attr( $css_class ) . '">
		<div class="">' . $sidebar_value . '</div>
	</div>
';

echo $output;