<?php

$output .= "<div id=\"ef-catalog-pagination-categories-left\">";
// Categories
$output .= "<div id=\"ef-categories-container\">";
$output .= "<fieldset>";
$output .= "<legend>" . __('Categories:') . "</legend>";
$output .= $categories;
$output .= "</fieldset>";
$output .= "</div>";

// Courses and Lessons
$output .= "<div id=\"ef-courses-lessons-container\">";
if ((get_option('ef-catalog-pagination-per-page') && $numofpages > 1) && get_option('ef-catalog-pagination-top')) {
	include (_BASEPATH_ . '/templates/catalog_pagination/pagination.php');
}
if(!empty($courses_lessons)){
	$output .= "<table id=\"\">";
	$output .= "<thead>";
	$output .= "<th></th>";
	$output .= "<th>" . __('Price') . "</th>";
	$output .= "</thead>";
	$output .= "<tbody>";
	foreach ($courses_lessons as $item) {
		$output .= "<tr>";
		if ($item['type'] == 'course') {
			$output .= "<td><strong><a href=\"?course=" . $item['id'] . "\">" . $item['name'] . "</a></strong></td>";
		} else {
			$output .= "<td><a href=\"?lesson=" . $item['id'] . "\">" . $item['name'] . "</a></td>";
		}
		if(!$item['price'][0]['value']){
			$output .= "<td> - </td>";
		} else {
			$output .= "<td>" . $item['price'] . " " . $item['price'][0]['currency'] . "</td>";
		}
		$output .= "</tr>";
	}	
	$output .= "</tbody>";
	$output .= "</table>";
} else {
	$output .= "<table id=\"\">";
	$output .= "<thead>";
	$output .= "<th></th>";
	$output .= "</thead>";
	$output .= "<tbody>";
	$output .= "<tr>";
	$output .= "<td style=\"text-align: center;\">" . __('Empty category') . "</td>";	
	$output .= "</tr>";	
	$output .= "</tbody>";
	$output .= "</table>";	
}
if ((get_option('ef-catalog-pagination-per-page') && $numofpages > 1) && get_option('ef-catalog-pagination-bottom')) {
	include (_BASEPATH_ . '/templates/catalog_pagination/pagination.php');
}
$output .= "</div>";
$output .= "</div>";
$output .= "<div class=\"clear\"></div>";
?>