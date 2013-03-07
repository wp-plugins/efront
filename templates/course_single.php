<?php
$output .= "<h2>" . $course -> general_info -> name . "</h2>";

if (intval($course -> general_info -> price -> value)) {
	$output .= "<p><strong>" . _('Price') . ":</strong> " . $course -> general_info -> price -> value . " " . $course -> general_info -> price -> currency . "</p>";
}

$output .= "<div style='text-align: right'>";
session_start();
if(!$_SESSION['ef-user-login'] && !$_SESSION['ef-user-password']){
	$output .= "<a id='ef-dialog-open' class='btn' href='javascript:void(0);'>" . __('Login to get this course') . "</a> " . _('or') . " <a href='javascript:history.go(-1);'>" . _('Go Back') . "</a>";
} else {
	if ($course -> general_info -> price -> value == 0){
		if(ef_user_has_course($token, $_SESSION['ef-user-login'], $_GET['course'])){
			$user_autologin_key = eFront_User::getAutologinKey($token, $_SESSION['ef-user-login']);
			$course_lessons = eFront_Course::getCourseLessons($token, $_GET['course']);
			$output .= "<a target='_blank' href='" . get_option('efront-domain') . '/index.php?autologin='.$user_autologin_key->autologin_key.'&lessons_ID='.$course_lessons->lessons->lesson[0]->id . "'>" . __('Take course') . "</a> " . _('or') . " <a href='javascript:history.go(-1);'>" . _('Go Back') . "</a>";
		} else {
			$output .= "<a id='ef-get-course' href='javascript:void(0);'>" . __('Get this course') . "</a> " . _('or') . " <a href='javascript:history.go(-1);'>" . _('Go Back') . "</a>";;
		}
	} else {
		$paypal_url = eFront_Course::buyCourse($token, $_GET['course'], $_SESSION['ef-user-login']);
		$output .= "<a target='_blank' href='".urldecode($paypal_url)."'>" . __('Buy this course') . "</a> " . _('or') . " <a href='javascript:history.go(-1);'>" . _('Go Back') . "</a>";
	}
}
$output .= "</div>";

$output .= "<h3>" . _('Information') . "</h3>";

$output .= "<table>";
$output .= "<tbody>";

if ($course -> general_info -> info -> general_description) {
	$output .= "<tr>";
	$output .= "<th>" . _('General Description') . "</th>";
	$output .= "<td>" . $course -> general_info -> info -> general_description . "</td>";
	$output .= "</tr>";
}
if ($course -> general_info -> info -> objectives) {
	$output .= "<tr>";
	$output .= "<th>" . _('Objectives') . "</th>";
	$output .= "<td>" . $course -> general_info -> info -> objectives . "</td>";
	$output .= "</tr>";
}
if ($course -> general_info -> info -> assessment) {
	$output .= "<tr>";
	$output .= "<th>" . _('Assessment') . "</th>";
	$output .= "<td>" . $course -> general_info -> info -> assessment . "</td>";
	$output .= "</tr>";
}
if ($course -> general_info -> info -> lesson_topics) {
	$output .= "<tr>";
	$output .= "<th>" . _('Lesson Topics') . "</th>";
	$output .= "<td>" . $course -> general_info -> info -> lesson_topics . "</td>";
	$output .= "</tr>";
}
if ($course -> general_info -> info -> resources) {
	$output .= "<tr>";
	$output .= "<th>" . _('Resources') . "</th>";
	$output .= "<td>" . $course -> general_info -> info -> resources . "</td>";
	$output .= "</tr>";
}
if ($course -> general_info -> info -> other_info) {
	$output .= "<tr>";
	$output .= "<th>" . _('Other information') . "</th>";
	$output .= "<td>" . $course -> general_info -> info -> other_info . "</td>";
	$output .= "</tr>";
}
if ($course -> general_info -> info -> learning_method) {
	$output .= "<tr>";
	$output .= "<th>" . _('Learning Method') . "</th>";
	$output .= "<td>" . $course -> general_info -> info -> learning_method . "</td>";
	$output .= "</tr>";
}
$output .= "</tbody>";
$output .= "</table>";

$output .= "<hr />";
$output .= "<h2 id='ef-lesson-nav'>" . __('Course Lessons') . "</h2>";

$output .= "<ul>";
foreach ($course_lessons->lessons->lesson as $lesson) {
	$lesson_id = (string)$lesson -> id;
	$lesson_name = (string)$lesson -> name;
	$output .= "<li><a class='ef-internal' href='#ef-lesson-" . $lesson_id . "'>" . $lesson_name . "</a></li>";
}
$output .= "</ul>";

foreach ($course_lessons->lessons->lesson as $lesson) {
	$lesson_id = (string)$lesson -> id;
	$lesson = simplexml_load_string(ef_get_cache_value('lesson_' . $lesson_id));
	if (!$lesson) {
		$lesson = eFront_Lesson::getInfo($token, $lesson_id);
		ef_add_cache_value(array('name' => 'lesson_' . $lesson_id, 'value' => $lesson -> asXML()));
	}

	$output .= "<h3 id='ef-lesson-" . $lesson_id . "'>" . $lesson -> general_info -> name . "</h3>";

	$output .= "<h4>" . _('Information') . "</h4>";

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
		$output .= "<h4>" . _('Content') . "</h4>";
		$output .= ef_build_units_tree($units['unit']);
	}
	
	$output .= "<div style='text-align: right;'>";
	$output .= "<a class='ef-internal' href='#ef-lesson-nav'>" .__('Back to Top'). "</a>";
	$output .= "</div>";
}

include (_BASEPATH_ . '/templates/login-dialog.php');
?>