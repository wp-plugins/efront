<?php
$output .= "<div style='text-align: right'>";
session_start();
if(!$_SESSION['ef-user-login'] && !$_SESSION['ef-user-password']){
	$output .= "<a id='ef-dialog-open' class='btn' href='javascript:void(0);'>" . __('Login to get this lesson') . "</a> " . _('or') . " <a href='javascript:history.go(-1);'>" . _('Go Back') . "</a>";
} else {
	if ($lesson -> general_info -> price -> value == 0){
		if(ef_user_has_lesson($token, $_SESSION['ef-user-login'], $_GET['lesson'])){
			$user_autologin_key = eFront_User::getAutologinKey($token, $_SESSION['ef-user-login']);
			$output .= "<a target='_blank' href='" . get_option('efront-domain') . 'www/index.php?autologin='.$user_autologin_key->autologin_key.'&lessons_ID='.$_GET['lesson'] . "'>" . __('Take lesson') . "</a> " . _('or') . " <a href='javascript:history.go(-1);'>" . _('Go Back') . "</a>";
		} else {	
			$output .= "<a id='ef-get-lesson' href='javascript:void(0);'>" . __('Get this lesson') . "</a> " . _('or') . " <a href='javascript:history.go(-1);'>" . _('Go Back') . "</a>";
		}
	} else {
		$paypal_url = eFront_Lesson::buyLesson($token, $_GET['lesson'], $_SESSION['ef-user-login']);
		$output .= "<a target='_blank' href='".urldecode($paypal_url)."'>" . __('Buy this lesson') . "</a> " . _('or') . " <a href='javascript:history.go(-1);'>" . _('Go Back') . "</a>";
		
	}
}
$output .= "</div>";

// Title
$output .= "<h1>" . $lesson -> general_info -> name . "</h1>";

// Trainers
if (!empty($lesson -> general_info -> users -> user)) {
	$output .= "<p><strong>";
	foreach ($lesson -> general_info -> users -> user as $user) {
		$output .= $user -> name . " " . $user -> surname;
	}	
	$output .= "</strong></p>";
}
// General description
if ($lesson -> general_info -> info -> general_description) {
	$output .= "<p>" . $lesson -> general_info -> info -> general_description . "</p>";
}

// Price
if (intval($lesson -> general_info -> price -> value)) {
	$output .= "<p><strong>" . _('Price') . ":</strong> " . $lesson -> general_info -> price -> value . " " . $lesson -> general_info -> price -> currency . "</p>";
}
$output .= "<hr />";

// Objectives
if ($lesson -> general_info -> info -> objectives) {
	$output .= "<h4>" . _('Objectives') . "</h4>";
	$output .= "<p>" . $lesson -> general_info -> info -> objectives . "</p>";
}
if ($lesson -> general_info -> info -> assessment) {
	$output .= "<h4>" . _('Assessment') . "</h4>";
	$output .= "<p>" . $lesson -> general_info -> info -> assessment . "</p>";
}
if ($lesson -> general_info -> info -> resources) {
	$output .= "<h4>" . _('Resources') . "</h4>";
	$output .= "<p>" . $lesson -> general_info -> info -> resources . "</p>";
}
$output .= "<hr />";

$units = xml2array($lesson -> general_info -> units);
if (!empty($units['unit'])) {
	$output .= "<h3>" . _('Content') . "</h3>";	
	$num_of_units = 0;
	$num_of_tests = 0;
	foreach ($units['unit'] as $unit) {
		if ($unit['type'] == 'tests') {
			$num_of_tests++;
		} else {
			$num_of_units++;
		}
	}

	$output .= "<p>";
	$output .= "<strong>" . _('Units') . ": </strong>" . $num_of_units . " - ";
	$output .= "<strong>" . _('Tests') . ": </strong>" . $num_of_tests . "";
	$output .= "</p>";
	
	$output .= ef_build_units_tree($units['unit']);
}

include (_BASEPATH_ . '/templates/login-dialog.php');
?>