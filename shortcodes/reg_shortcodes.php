<?php
function efront_catalog($atts) {
	wp_enqueue_script('ef-catalog', _BASEURL_ . 'js/ef-catalog.js', false, '1.0');
	include ('efront_catalog.php');
	return $output;
}

add_shortcode('efront-catalog', 'efront_catalog');

?>