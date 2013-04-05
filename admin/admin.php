<?php
/**
 *
 * Administration Menus
 *
 * @package eFront WordPress plugin
 * @author V.
 * @copyright 2013
 * @access public
 * @since 1.0
 *
 */
?>
<?php

/* Register administration menu */
function register_admininstartion_pages() {
	global $ef_admin_page, $ef_options_page, $ef_sync_page, $ef_css_page;

	$ef_admin_page = add_menu_page(__('eFront'), __('eFront'), 'manage_options', 'efront', 'efront_admin');
	$ef_options_page = add_submenu_page('efront', __('eFront Options'), __('eFront Options'), 'manage_options', 'efront-options', 'efront_options');
	$ef_sync_page = add_submenu_page('efront', __('eFront Sync'), __('eFront Sync'), 'manage_options', 'efront-sync', 'efront_sync');
	$ef_css_page = add_submenu_page('efront', __('Edit eFront CSS'), __('Edit eFront CSS'), 'manage_options', 'efront-edit-css', 'efront_edit_css');

	add_action("admin_print_scripts-$ef_options_page", 'enqueue_js_scripts');
	add_action("admin_print_scripts-$ef_sync_page", 'enqueue_js_scripts');
}

add_action('admin_menu', 'register_admininstartion_pages');

function ef_help($contextual_help, $screen_id, $screen) {
	global $ef_admin_page, $ef_options_page, $ef_sync_page, $ef_css_page;

	include (_BASEPATH_ . '/admin/pages/help.php');
}

add_filter('contextual_help', 'ef_help', 10, 3);

function enqueue_js_scripts() {
	wp_enqueue_script('ef-admin', _BASEURL_ . 'js/ef-admin.js', false, '1.0');
}

function efront_admin() {
	if ($_POST['action'] == 'ef-main-config') {

		if ($_POST['ef-domain'] && $_POST['ef-admin-username'] && $_POST['ef-admin-password']) {
			if (ef_is_efront_domain($_POST['ef-domain'])) {

				update_option('efront-domain', 'http://' . $_POST['ef-domain']);
				update_option('efront-admin-username', $_POST['ef-admin-username']);
				update_option('efront-admin-password', $_POST['ef-admin-password']);
				$action_status = "updated";
				$action_message = _('Details edited successfully');

				ef_empty_cache();
			} else {
				update_option('efront-domain', '');
				update_option('efront-admin-username', '');
				update_option('efront-admin-password', '');
				$action_status = "error";
				$action_message = $_POST['ef-domain'] . " " . _('is not a valid eFront domain');
			}
		} else {
			$action_status = "error";
			if (!$_POST['ef-domain']) {
				update_option('efront-domain', '');
				$action_message = _('eFront Domain required') . "<br />";
			}
			if (!$_POST['ef-admin-username']) {
				update_option('efront-admin-username', '');
				$action_message .= _('eFront admin username required') . "<br />";
			}
			if (!$_POST['ef-admin-password']) {
				update_option('efront-admin-password', '');
				$action_message .= _('eFront admin password required');
			}
		}
	}

	if ($_POST['action'] == "ef-cache") {
		ef_empty_cache();
		$action_status = "updated";
		$action_message = _('Cache cleared successfully');
	}

	include (_BASEPATH_ . '/admin/pages/efront_admin.php');
}

function efront_options() {

	if ($_POST['action'] == 'ef-catalog-config') {
		$action_status = "updated";
		$action_message = _('Details edited successfully');
		if ($_POST['ef-catalog-template']) {
			update_option('ef-catalog-template', $_POST['ef-catalog-template']);
		}
		if ($_POST['ef-catalog-template-pagination-opt']) {
			update_option('ef-catalog-template-pagination-opt', $_POST['ef-catalog-template-pagination-opt']);
		}
		if ($_POST['ef-catalog-pagination-per-page']) {
			if ($_POST['ef-catalog-pagination-per-page'] > 0) {
				update_option('ef-catalog-pagination-per-page', $_POST['ef-catalog-pagination-per-page']);
			} else {
				$action_status = "error";
				$action_message = _('Items per page must be a positive number.');

				update_option('ef-catalog-pagination-per-page', '');
				update_option('ef-catalog-pagination-top', false);
				update_option('ef-catalog-pagination-bottom', false);
			}
		} else {
			update_option('ef-catalog-pagination-per-page', '');
		}
		if ($_POST['ef-catalog-pagination-top']) {
			update_option('ef-catalog-pagination-top', $_POST['ef-catalog-pagination-top']);
		} else {
			update_option('ef-catalog-pagination-top', false);
		}
		if ($_POST['ef-catalog-pagination-bottom']) {
			update_option('ef-catalog-pagination-bottom', $_POST['ef-catalog-pagination-bottom']);
		} else {
			update_option('ef-catalog-pagination-bottom', false);
		}

		update_option('ef-post-signup', $_POST['post-signup']);
		update_option('ef-sync-signup-users', $_POST['ef-sync-signup-users']);
	}

	include (_BASEPATH_ . '/admin/pages/efront_options.php');
}

function efront_sync() {
	extract(ef_list_wp_ef_users());

	if ($_POST['action'] == 'ef-sync-users') {
		$action_status = "updated";
		$action_message = _('Operation completed successfully');
			
		foreach ($ef_users as $user) {
			$wp_users[$user['login']]['login'] = $user['login'];
			$wp_users[$user['login']]['email'] = $user['email'];
			$wp_users[$user['login']]['first_name'] = $user['first_name'];
			$wp_users[$user['login']]['last_name'] = $user['last_name'];
		}
		
		$all_users =  array_merge($ef_users, $wp_users);
		$sync_errors = ef_sync_wp_ef_users($ef_users_to_wp, $wp_users_to_ef, $_POST['hard-sync'], $all_users);

		extract(ef_list_wp_ef_users());

		if(is_array($sync_errors) && !empty($sync_errors)) {
			$action_status = "error";
			$action_message = _('Operation completed but some errors have occured');
		}		
	}
	include (_BASEPATH_ . '/admin/pages/efront_sync.php');
}

function efront_edit_css() {

	if ($_POST['action'] == 'ef-edit-css') {
		file_put_contents(_BASEPATH_ . '/css/efront-style.css', stripslashes($_POST['ef-edit-css']));
		$action_status = "updated ";
		$action_message = _('File edited successfully');
	}

	include (_BASEPATH_ . '/admin/pages/efront_edit_css.php');
}

/**
 * Shortcodes
 ******************************************/

if ((!get_option('efront-domain') && !$_POST['ef-domain'])) {
	function efront_domain_warning() {
		echo "<div id='efront-warning' class='error fade'><p><strong>" . __('You need to specify an eFront domain.') . "</strong> " . sprintf(__('You must <a href="%1$s">enter your domain</a> for it to work.'), "admin.php?page=efront") . "</p></div>";
	}

	add_action('admin_notices', 'efront_domain_warning');
} else {
	wp_enqueue_script('jquery');
	wp_enqueue_style('efront-css', _BASEURL_ . '/css/efront-style.css', false, '1.0');

	eFront::setDomain(get_option('efront-domain'));
	include (_BASEPATH_ . '/shortcodes/reg_shortcodes.php');
}

/**
 * AJAX Requests
 ******************************************/

function ef_get_course_callback() {
	try {
		$token = eFront::requestToken();
		eFront::loginModule($token, get_option('efront-admin-username'), get_option('efront-admin-password'));
		eFront_Course::assignToUser($token, $_POST['ef_login'], $_POST['course_id'], 'student');
		$user_autologin_key = eFront_User::getAutologinKey($token, $_POST['ef_login']);
		$course_lessons = eFront_Course::getCourseLessons($token, $_POST['course_id']);
		$return_data = array('status' => 'ok', 'url' => get_option('efront-domain') . 'www/index.php?autologin=' . $user_autologin_key -> autologin_key . '&lessons_ID=' . $course_lessons -> lessons -> lesson[0] -> id);
		echo json_encode($return_data);
	} catch (Exception $e) {
		$return_data = array('status' => 'error', 'msg' => $e -> getMessage());
		echo json_encode($return_data);
	}
	die();
	// this is required to return a proper result
}

add_action('wp_ajax_ef_get_course', 'ef_get_course_callback');
add_action('wp_ajax_nopriv_ef_get_course', 'ef_get_course_callback');

function ef_get_lesson_callback() {
	try {
		$token = eFront::requestToken();
		eFront::loginModule($token, get_option('efront-admin-username'), get_option('efront-admin-password'));
		eFront_Lesson::assignToUser($token, $_POST['ef_login'], $_POST['lesson_id'], '');
		$user_autologin_key = eFront_User::getAutologinKey($token, $_POST['ef_login']);
		$return_data = array('status' => 'ok', 'url' => get_option('efront-domain') . 'www/index.php?autologin=' . $user_autologin_key -> autologin_key . '&lessons_ID=' . $_POST['lesson_id']);
		echo json_encode($return_data);
	} catch (Exception $e) {
		$return_data = array('status' => 'error', 'msg' => $e -> getMessage());
		echo json_encode($return_data);
	}
	die();
}

add_action('wp_ajax_ef_get_lesson', 'ef_get_lesson_callback');
add_action('wp_ajax_nopriv_ef_get_lesson', 'ef_get_lesson_callback');
?>