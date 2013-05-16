<?php
/**
 * Utility functions for catalog with pagination template.
 * */
?>
<?php
/**
 * Set up pagination for eFront catalog
 *
 * @param array $courses_lessons array with courses and lessons
 * @param int $page current page
 * @return string language
 * */
function ef_setup_pagination($courses_lessons, $page) {
	$currentpage = ($page) ? trim($page) : 0;
	$perpage = get_option('ef-catalog-pagination-per-page');

	$num_of_items = count($courses_lessons);
	$numofpages = ceil($num_of_items / $perpage);

	$start = $currentpage * $perpage;
	$end = ($currentpage * $perpage) + $perpage;

	$tmpCoursesLessons = $courses_lessons;
	unset($courses_lessons);
	for ($j = $start; $j < $end; $j++) {
		if ($tmpCoursesLessons[$j]) {
			$courses_lessons[] = $tmpCoursesLessons[$j];
		}
	}

	return array('courses_lessons' => $courses_lessons, 'numofpages' => $numofpages, 'currentpage' => $currentpage);
}

/**
 * Build categories tree, receives and array of eFront categories and outputs an HTML <ul>, <li> tree like representation 
 *
 * @param array $categories an array of eFront categories with array keys: id, name, parent_category_id
 * @return HTML the corresponding HTML tree-like representation of categories
 * */
function ef_build_categories_tree($categories) {
	// category id's as array keys
	foreach ($categories as $category) {
		$nodes[$category['id']] = $category;
	}
	
	$categories = $nodes;
	$rejected = array();
	$count = 0;
	while (sizeof($categories) > 1 && $count++ < 1000) {
		foreach ($nodes as $key => $value) {
			if ($value['parent_id'] == 0 || in_array($value['parent_id'], array_keys($nodes))) {
				$parentNodes[$value['parent_id']][]	  = $value;
				$categories[$value['parent_id']]['children'][$value['id']] = array();				
			} else {
				$rejected = $rejected + array($value['id'] => $value);
				unset($nodes[$key]);
				unset($parentNodes[$value['parent_id']]);
			}
		}
		if (isset($parentNodes)) {
			$leafNodes = array_diff(array_keys($nodes), array_keys($parentNodes));
			foreach ($leafNodes as $leaf) {
				$parent_id = $nodes[$leaf]['parent_id'];
				$categories[$parent_id]['children'][$leaf] = $categories[$leaf];
				unset($categories[$leaf]);
				unset($nodes[$leaf]);
			}
			unset($parentNodes);
		}		
	}
	if (sizeof($categories) > 0 && !isset($categories[0])) {
		$categories = array($categories);
	}
	foreach ($categories as $key => $value) {
		if ($key != 0) {
			$rejected[$key] = $value;
		}
	}
	
	$html = "<ul class=\"nav nav-list\">";
	$html .= "<li><a href=\"?category=all\">" . __("All courses") . "</a></li>";
	foreach ($categories[0]['children'] as $node) {
		if (!$node['parent_id']) {
			$html .= ef_create_tree_node($node);
		}
	}
	$html .= "</ul>";

	return $html;
}

function ef_create_tree_node($node) {
	if(is_array($node['content'][0])){
		if(is_array($node['content'][0]['item'])){
			$num_of_items = " (" . count($node['content'][0]['item']) . ")";
		} else {
			$num_of_items = "";
		}
	}
	$html = "<li>" . "<a href=\"?category=" . $node['id'] . "\">" . $node['name'] . "</a> " . $num_of_items;
	if (is_array($node['children'])) {
		$html .= '<ul>';
		foreach ($node['children'] as $child) {
			$html .= ef_create_tree_node($child);
		}
		$html .= '</ul>';
	}
	$html .= '</li>';
	return $html;
}

/**
 * Build units tree, receives and array of eFront units and outputs an HTML <ul>, <li> tree like representation 
 *
 * @param array $units an array of eFront units with array keys: id, name, parent_id
 * @return HTML the corresponding HTML tree-like representation of categories
 * */ 
function ef_build_units_tree($units) {
	
	// category id's as array keys
	foreach ($units as $unit) {
		$nodes[$unit['id']] = $unit;
	}
	
	$units = $nodes;
	$rejected = array();
	$count = 0;
	while (sizeof($units) > 1 && $count++ < 1000) {
		foreach ($nodes as $key => $value) {
			if ($value['parent_id'] == 0 || in_array($value['parent_id'], array_keys($nodes))) {
				$parentNodes[$value['parent_id']][]	  = $value;
				$units[$value['parent_id']]['children'][$value['id']] = array();				
			} else {
				$rejected = $rejected + array($value['id'] => $value);
				unset($nodes[$key]);
				unset($parentNodes[$value['parent_id']]);
			}
		}
		if (isset($parentNodes)) {
			$leafNodes = array_diff(array_keys($nodes), array_keys($parentNodes));
			foreach ($leafNodes as $leaf) {
				$parent_id = $nodes[$leaf]['parent_id'];
				$units[$parent_id]['children'][$leaf] = $units[$leaf];
				unset($units[$leaf]);
				unset($nodes[$leaf]);
			}
			unset($parentNodes);
		}		
	}
	if (sizeof($units) > 0 && !isset($units[0])) {
		$units = array($units);
	}
	foreach ($units as $key => $value) {
		if ($key != 0) {
			$rejected[$key] = $value;
		}
	}

	$html = "<ul class=\"nav nav-list\">";
	
	if($units[0]['children']) {
		foreach ($units[0]['children'] as $node) {	
			if (!$node['parent_id']) {
				$html .= ef_create_tree_node_units($node);
			}
		}
	} else {
		foreach ($units[0] as $node) {	
			if (!$node['parent_id']) {
				$html .= ef_create_tree_node_units($node);
			}
		}
	}
		
	$html .= "</ul>";

	return $html;	
}

function ef_create_tree_node_units($node) {
	$html = "<li>" . $node['name'];//"<li>" . "<a href=\"?category=" . $node['id'] . "\">" . $node['name'] . "</a>";
	if (is_array($node['children'])) {
		$html .= '<ul>';
		foreach ($node['children'] as $child) {
			$html .= ef_create_tree_node_units($child);
		}
		$html .= '</ul>';
	}
	$html .= '</li>';
	return $html;
}
?>