<?php
$output .= "<h2>" . $lesson -> general_info -> name . "</h2>";

if (intval($lesson -> general_info -> price -> value)) {
	$output .= "<p><strong>" . _('Price') . ":</strong> " . $lesson -> general_info -> price -> value . " " . $lesson -> general_info -> price -> currency . "</p>";
}

$output .= "<div style='text-align: right'>";
session_start();
if(!$_SESSION['ef-user-login'] && !$_SESSION['ef-user-password']){
	$output .= "<a id='ef-dialog-open' class='btn' href='javascript:void(0);'>" . __('Login to get this lesson') . "</a> " . _('or') . " <a href='javascript:history.go(-1);'>" . _('Go Back') . "</a>";
} else {
	if ($lesson -> general_info -> price -> value == 0){
		if(ef_user_has_lesson($token, $_SESSION['ef-user-login'], $_GET['lesson'])){
			$user_autologin_key = eFront_User::getAutologinKey($token, $_SESSION['ef-user-login']);
			$output .= "<a target='_blank' href='" . get_option('efront-domain') . '/index.php?autologin='.$user_autologin_key->autologin_key.'&lessons_ID='.$_GET['lesson'] . "'>" . __('Take lesson') . "</a> " . _('or') . " <a href='javascript:history.go(-1);'>" . _('Go Back') . "</a>";
		} else {	
			$output .= "<a id='ef-get-lesson' href='javascript:void(0);'>" . __('Get this lesson') . "</a> " . _('or') . " <a href='javascript:history.go(-1);'>" . _('Go Back') . "</a>";
		}
	} else {
		$paypal_url = eFront_Lesson::buyLesson($token, $_GET['lesson'], $_SESSION['ef-user-login']);
		$output .= "<a target='_blank' href='".urldecode($paypal_url)."'>" . __('Buy this lesson') . "</a> " . _('or') . " <a href='javascript:history.go(-1);'>" . _('Go Back') . "</a>";
		
	}
}
$output .= "</div>";

$output .= "<h3>" . _('Information') . "</h3>";

$output .= "<table>";
$output .= "<tbody>";

if ($lesson -> general_info -> info -> general_description) {
	$output .= "<tr>";
	$output .= "<th>" . _('General Description') . "</th>";
	$output .= "<td>" . $lesson -> general_info -> info -> general_description . "</td>";
	$output .= "</tr>";
}
if ($lesson -> general_info -> info -> objectives) {
	$output .= "<tr>";
	$output .= "<th>" . _('Objectives') . "</th>";
	$output .= "<td>" . $lesson -> general_info -> info -> objectives . "</td>";
	$output .= "</tr>";
}
if ($lesson -> general_info -> info -> assessment) {
	$output .= "<tr>";
	$output .= "<th>" . _('Assessment') . "</th>";
	$output .= "<td>" . $lesson -> general_info -> info -> assessment . "</td>";
	$output .= "</tr>";
}
if ($lesson -> general_info -> info -> resources) {
	$output .= "<tr>";
	$output .= "<th>" . _('Resources') . "</th>";
	$output .= "<td>" . $lesson -> general_info -> info -> resources . "</td>";
	$output .= "</tr>";
}
if (!empty($lesson -> general_info -> users -> user)) {
	$output .= "<tr>";
	$output .= "<th>" . _('Professors') . "</th>";
	$output .= "<td>";
	foreach ($lesson -> general_info -> users -> user as $user) {
		$output .= $user -> name . " " . $user -> surname . " (" . $user -> email . ") ";
	}
	$output .= "</td>";
	$output .= "</tr>";
}
$units = xml2array($lesson -> general_info -> units);
if (!empty($units['unit'])) {
	$num_of_units = 0;
	$num_of_tests = 0;
	foreach ($units['unit'] as $unit) {
		if ($unit['type'] == 'tests') {
			$num_of_tests++;
		} else {
			$num_of_units++;
		}
	}

	$output .= "<tr>";
	$output .= "<th>" . _('Units') . "</th>";
	$output .= "<td>" . $num_of_units . "</td>";
	$output .= "</tr>";

	$output .= "<tr>";
	$output .= "<th>" . _('Tests') . "</th>";
	$output .= "<td>" . $num_of_tests . "</td>";
	$output .= "</tr>";
}
$output .= "</tbody>";
$output .= "</table>";
if (!empty($units['unit'])) {
	$output .= "<h3>" . _('Content') . "</h3>";
	$output .= ef_build_units_tree($units['unit']);
}

include (_BASEPATH_ . '/templates/login-dialog.php');
?>