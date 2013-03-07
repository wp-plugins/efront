<?php
function efront_catalog($atts) {
	wp_enqueue_style("jquery-ui-css", "http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css");

	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-dialog');

	wp_enqueue_script('ef-catalog', _BASEURL_ . 'js/ef-catalog.js', false, '1.0');
	
	session_start();
	if($_GET['course']){
		if ($_POST['ef-login'] && $_POST['ef-password']) {
			wp_localize_script( 'ef-catalog', 'ajax_object', array( 'ajax_url' => admin_url('admin-ajax.php'), 'ef_login' => $_POST['ef-login'], 'ef_password' => $_POST['ef-password'], 'course_id' => $_GET['course']));
		} else {
			wp_localize_script( 'ef-catalog', 'ajax_object', array( 'ajax_url' => admin_url('admin-ajax.php'), 'ef_login' => $_SESSION['ef-user-login'], 'ef_password' => $_SESSION['ef-user-password'], 'course_id' => $_GET['course']));
		}
	}
	if ($_GET['lesson']){
		if ($_POST['ef-login'] && $_POST['ef-password']) {
			wp_localize_script( 'ef-catalog', 'ajax_object', array( 'ajax_url' => admin_url('admin-ajax.php'), 'ef_login' => $_POST['ef-login'], 'ef_password' => $_POST['ef-password'], 'lesson_id' => $_GET['lesson']));
		} else {
			wp_localize_script( 'ef-catalog', 'ajax_object', array( 'ajax_url' => admin_url('admin-ajax.php'), 'ef_login' => $_SESSION['ef-user-login'], 'ef_password' => $_SESSION['ef-user-password'], 'lesson_id' => $_GET['lesson']));
		}		
	}
	include 'efront_catalog.php';
	return $output;
}

add_shortcode('efront-catalog', 'efront_catalog');

function efront_signup($atts) {
	include 'efront_signup.php';
	return $output;
}

add_shortcode('efront-signup', 'efront_signup');
?>