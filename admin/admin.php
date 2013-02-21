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
	global $efront_admin_page;

	$efront_admin_page = add_menu_page(__('eFront'), __('eFront'), 'manage_options', 'efront', 'efront_admin');
	$templateMenu = add_submenu_page('efront', __('eFront Options'), __('eFront Options'), 'manage_options', 'efront-options', 'efront_options');
	$cssMenu = add_submenu_page('efront', __('Edit eFront CSS'), __('Edit eFront CSS'), 'manage_options', 'efront-edit-css', 'efront_edit_css');

	add_action("admin_print_scripts-$efront_admin_page", 'enqueue_js_scripts');
}

add_action('admin_menu', 'register_admininstartion_pages');

function efront_help($contextual_help, $screen_id, $screen) {

	global $efront_admin_page;

	include (_BASEPATH_ . '/admin/pages/help.php');

}

add_filter('contextual_help', 'efront_help', 10, 3);

function enqueue_js_scripts() {
	//    wp_enqueue_script('jquery-ui-core');
	//    wp_enqueue_script('jquery-ui-progressbar');
}

function efront_admin() {

	if ($_POST['action'] == 'ef-main-config') {

		if ($_POST['ef-domain'] && $_POST['ef-admin-username'] && $_POST['ef-admin-password']) {
			update_option('efront-domain', $_POST['ef-domain']);
			update_option('efront-admin-username', $_POST['ef-admin-username']);
			update_option('efront-admin-password', $_POST['ef-admin-password']);
			$action_status = "updated";
			$action_message = _('Details edited successfully');
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
			if($_POST['ef-catalog-pagination-per-page'] > 0){
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
	}

	include (_BASEPATH_ . '/admin/pages/efront_options.php');
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
	wp_enqueue_style('efronts-css', _BASEURL_ . '/css/efront-style.css', false, '1.0');

	eFront::setDomain(get_option('efront-domain'));
	include (_BASEPATH_ . '/shortcodes/reg_shortcodes.php');
}
?>