<?php
$output .= "<h2>" . $course -> general_info -> name . "</h2>";

if (intval($course -> general_info -> price -> value)) {
	$output .= "<p><strong>" . _('Price') . ":</strong> " . $course -> general_info -> price -> value . " " . $course -> general_info -> price -> currency . "</p>";
}

$output .= "<div style='text-align: right'>";
$output .= "<a href='javascript:history.go(-1);'>" . _('Go Back') . "</a>";
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
?>