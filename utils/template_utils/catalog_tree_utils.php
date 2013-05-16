<?php
/**
 * Utility functions for catalog with pagination template.
 * */
?>
<?php
/**
 * Build catalog tree, receives and array of eFront categories and outputs an HTML of nested <table> tags to form a tree like representation
 *
 * @param array $categories an array of eFront categories with array keys: id, name, parent_category_id
 * @return HTML the corresponding HTML tree-like representation of categories
 * */
function ef_build_catalog_tree($categories) {
	
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


	$html = "<ul id='ef-catalog-tree-root'>";
	foreach ($categories[0]['children'] as $node) {
		if (!$node['parent_id']) {
			$html .= ef_create_catalog_tree_node($node);
		}
	}
	$html .= "</ul>";

	return $html;
}

function ef_create_catalog_tree_node($node) {
	$html = "<li>";
	$html .= "<div class='ef-toggle-category' id='ef-category-" . $node['id'] . "'>";
	$html .= "<img src='" . _BASEURL_ . "/img/arrow_down.png' />";
	$html .= "<strong>" . $node['name'] . "</strong>";
	$html .= "</div>";
	if (is_array($node['content'][0]['item'])) {
		$html .= "<ul id=\"ef-category-contents-" . $node['id'] . "\">";
		$html .= output_category_content($node);
		if(is_array($node['children'])){
			foreach ($node['children'] as $child) {
				$html .= ef_create_catalog_tree_node($child);
			}			
		}
		$html .= "</ul>";
	} else {
		$html .= "<ul id=\"ef-category-contents-" . $node['id'] . "\">";
		$html .= "<li>" . __('Empty category') . "</li>";
		$html .= "</ul>";		
	}
	$html .= '</li>';
	return $html;
}

function output_category_content($category) {
	
	foreach ($category['content'][0]['item'] as $item) {
		$output .= "<ul>";
		if ($item['type'] == 'course') {
			$output .= "<li><strong><a href=\"?course=" . $item['id'] . "\">" . $item['name'] . "</a></strong></li>";
		} else {
			$output .= "<li><a href=\"?lesson=" . $item['id'] . "\">" . $item['name'] . "</a></li>";
		}
		$output .= "</ul>";
	}
	
	return $output;
}
?>