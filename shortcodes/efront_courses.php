<?php
if (isset($_GET['course']) && $_GET['course'] != '') {
	try {
		$token = eFront::requestToken();
		eFront::loginModule($token, get_option('efront-admin-username'), get_option('efront-admin-password'));

	} catch(Exception $e) {
		$output .= "<div class=\"alert alert-error\">";
		$output .= $e -> getMessage();
		$output .= "</div>";
	}
} else {
	try {
		$token = eFront::requestToken();
		eFront::loginModule($token, get_option('efront-admin-username'), get_option('efront-admin-password'));
		$courses = eFront_Course::getCourses($token);

		if (get_option('ef-courses-pagination-per-page')) {
			$course_pagination_details = setup_courses_pagination($courses -> courses -> course, $_GET['cpaging']);
			extract($course_pagination_details);
		}

		$output .= "<h2>" . _('Courses') . "</h2>";

		if (get_option('ef-courses-pagination-top')) {
			include (_BASEPATH_ . '/templates/courses_pagination.php');
		}

		$output .= "<table>";
		$output .= "<thead>";
		$output .= "<th>" . _('Course') . "</th>";
		$output .= "<th>" . _('Language') . "</th>";
		$output .= "<th>" . _('Price') . "</th>";
		$output .= "</thead>";
		$output .= "<tbody>";
		foreach ($courses as $course) {
			if ($course -> active && $course -> show_catalog) {
				$output .= "<tr>";
				$output .= "<td>" . "<a href=\"?course=" . $course -> id . "\">" . $course -> name . "</a>" . "</td>";
				$output .= "<td>" . get_ef_language($course -> language) . "</td>";
				$output .= "<td>" . $course -> price -> value . " " . $course -> price -> currency . "</td>";
				$output .= "</tr>";
			}
		}
		$output .= "</tbody>";
		$output .= "</table>";

		if (get_option('ef-courses-pagination-bottom')) {
			include (_BASEPATH_ . '/templates/courses_pagination.php');
		}

	} catch(Exception $e) {
		$output .= "<div class=\"alert alert-error\">";
		$output .= $e -> getMessage();
		$output .= "</div>";
	}
}
?>