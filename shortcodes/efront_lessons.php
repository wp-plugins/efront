<?php
if (isset($_GET['lesson']) && $_GET['lesson'] != '') {
	try {
		$token = eFront::requestToken();
		eFront::loginModule($token, get_option('efront-admin-username'), get_option('efront-admin-password'));
		$lesson = eFront_Lesson::getInfo($token, $_GET['lesson']);
		
	} catch(Exception $e) {
		$output .= "<div class=\"alert alert-error\">";
		$output .= $e -> getMessage();
		$output .= "</div>";
	}
} else {
	try {
		$token = eFront::requestToken();
		eFront::loginModule($token, get_option('efront-admin-username'), get_option('efront-admin-password'));
		$lessons = eFront_Lesson::getLessons($token);
		
		$output .= "<pre>";
		$output .= print_r($lessons, true);
		$output .= "</pre>";
		
		
	} catch(Exception $e) {
		$output .= "<div class=\"alert alert-error\">";
		$output .= $e -> getMessage();
		$output .= "</div>";
	}
}
echo 'test';
?>