<?php
try {

	$token = eFront::requestToken();
	eFront::loginModule($token, get_option('efront-admin-username'), get_option('efront-admin-password'));
	
	/* Login from dialog */
	if($_POST['action'] == 'dialog-post'){
		if ($_POST['ef-login'] && $_POST['ef-password']) {
			session_start();
			$_SESSION['ef-user-login'] = $_POST['ef-login'];
			$_SESSION['ef-user-password'] = $_POST['ef-password'];
			try {
				eFront::login($token, $_SESSION['ef-user-login']);
				$user = eFront_User::getInfo($token, $_SESSION['ef-user-login']);
				$user_autologin_key = eFront_User::getAutologinKey($token, $_SESSION['ef-user-login']);
				if(!$user_autologin_key->autologin_key){
					eFront_User::setAutologinKey($token, $_SESSION['ef-user-login']);
					$user_autologin_key = eFront_User::getAutologinKey($token, $_SESSION['ef-user-login']);
				}				
				$output .= "<div class='alert alert-success'>";
				$output .= "<span style='display:block'>" . _('Welcome back') . " <b>" . $user -> general_info -> name . "</b></span>";
				$output .= "<span style='display:block'>" . _('You can visit your learning portal') . " <a target='_blank' href='" . get_option('efront-domain') . "/index.php?autologin=".$user_autologin_key->autologin_key."'>" . _('here') . "</a></span>";
				$output .= "</div>";
			} catch(Exception $e) {
				$output .= "<div class=\"alert alert-error\">";
				$output .= $e -> getMessage();
				$output .= "</div>";
			}
		} else {
			$output .= "<div class=\"alert alert-error\">";
			$output .= _('Login or password incorrect');
			$output .= "</div>";
		}
	}

	
	
	if (isset($_GET['lesson']) && $_GET['lesson'] != '') {
		$lesson = simplexml_load_string(ef_get_cache_value('lesson_' . $_GET['lesson']));
		if (!$lesson) {
			$lesson = eFront_Lesson::getInfo($token, $_GET['lesson']);
			ef_add_cache_value(array('name' => 'lesson_' . $_GET['lesson'], 'value' => $lesson -> asXML()));
		}
		include (_BASEPATH_ . '/templates/lesson_single.php');

	} else if (isset($_GET['course']) && $_GET['course'] != '') {
		$course = simplexml_load_string(ef_get_cache_value('course_' . $_GET['course']));
		if (!$course) {
			$course = eFront_Course::getInfo($token, $_GET['course']);
			ef_add_cache_value(array('name' => 'course_' . $_GET['course'], 'value' => $course -> asXML()));

		}
		$course_lessons = simplexml_load_string(ef_get_cache_value('course_lessons_' . $_GET['course']));
		if (!$course_lessons) {
			$course_lessons = eFront_Course::getCourseLessons($token, $_GET['course']);
			ef_add_cache_value(array('name' => 'course_lessons' . $_GET['course'], 'value' => $course_lessons -> asXML()));
		}
		include (_BASEPATH_ . '/templates/course_single.php');
	} else {
		$categories = unserialize(ef_get_cache_value('categories'));
		if (!$categories) {
			$categories = eFront_Category::getCategories($token);
			$categories = xml2array($categories);
			ef_add_cache_value(array('name' => 'categories', 'value' => serialize($categories)));
		}

		if (get_option('ef-catalog-template') == 'ef-catalog-template-pagination') {

			if ($_GET['category'] == 'all' || !$_GET['category']) {
				$courses_lessons = array();
				foreach ($categories['categories'][0]['category'] as $category) {
					foreach ($category['content'][0]['item'] as $item) {
						$courses_lessons[] = $item;
					}
				}
			} else {
				$category = unserialize(ef_get_cache_value('category_' . $_GET['category']));
				if (!$category) {
					$category = eFront_Category::getCategory($token, $_GET['category']);
					$category = xml2array($category);
					ef_add_cache_value(array('name' => 'category_' . $_GET['category'], 'value' => serialize($category)));
				}

				$courses_lessons = array();
				foreach ($category['category'][0]['content'][0]['item' ] as $item) {
					$courses_lessons[] = $item;
				}
			}
			// Setup pagination
			if (get_option('ef-catalog-pagination-per-page')) {
				$pagination_details = ef_setup_pagination($courses_lessons, $_GET['paging']);
				extract($pagination_details);
			}

			$categories = ef_build_categories_tree($categories['categories'][0]['category']);
			switch(get_option('ef-catalog-template-pagination-opt')) {
				case 'categories-right' :
					include (_BASEPATH_ . '/templates/catalog_pagination/catalog_pagination_categories_right.php');
					break;
				case 'categories-left' :
					include (_BASEPATH_ . '/templates/catalog_pagination/catalog_pagination_categories_left.php');
					break;
				case 'categories-top' :
					include (_BASEPATH_ . '/templates/catalog_pagination/catalog_pagination_categories_top.php');
					break;
			}

		} else if (get_option('ef-catalog-template') == 'ef-catalog-template-tree') {

			// Setup pagination
			if (get_option('ef-catalog-pagination-per-page')) {
				$pagination_details = ef_setup_pagination($courses_lessons, $_GET['paging']);
				extract($pagination_details);
			}
			$categories = ef_build_catalog_tree($categories['categories'][0]['category']);
			include (_BASEPATH_ . '/templates/catalog_tree.php');
		}
	}

} catch(Exception $e) {
	$output .= "<div class=\"alert alert-error\">";
	$output .= $e -> getMessage();
	$output .= "</div>";
}
?>