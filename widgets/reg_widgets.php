<?php

require_once (_BASEPATH_ . '/widgets/efront_login_widget.php');

function register_widgets() {
	register_widget('eFront_login');
}

add_action('widgets_init', 'register_widgets');
?>