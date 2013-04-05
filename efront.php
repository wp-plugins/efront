<?php
/*
 Plugin Name: eFront
 Plugin URI:
 Description: This plugin integrates <a href="http://www.efrontlearning.net/">eFront</a> with Wordpress. Promote your eFront content through your WordPress site.
 Version: 2.2.3
 Author: Vasilis Proutzos / Epignosis LTD
 Author URI: http://www.efrontlearning.net/
 License: GPL2
 */

define("_VERSION_", "2.2.3");
define("_BASEPATH_", dirname(__FILE__));
define("_BASEURL_", plugin_dir_url(__FILE__));

require_once (_BASEPATH_ . '/eFront-PHPlib/lib/eFront.php');
require_once (_BASEPATH_ . '/utils/utils.php');
require_once (_BASEPATH_ . '/utils/db.php');
require_once (_BASEPATH_ . '/admin/admin.php');

require_once (_BASEPATH_ . '/widgets/reg_widgets.php');

function start_talentlms_session() {
	if (!session_id()) {
		session_start();
	}
}

add_action('init', 'start_talentlms_session', 1);

function install() {

	ef_db_setup();

	/* Main configuration */
	update_option('efront-domain', '');
	update_option('efront-admin-username', '');
	update_option('efront-admin-password', '');

	/* Catalog configuration */
	update_option('ef-catalog-template', 'ef-catalog-template-pagination');
	update_option('ef-catalog-template-pagination-opt', 'categories-left');

	update_option('ef-catalog-pagination-top', true);
	update_option('ef-catalog-pagination-bottom', true);
	update_option('ef-catalog-pagination-per-page', 10);

	/* Singup configuration*/
	update_option('ef-post-signup', 'stay');

	/* Sync eFront and WP users configuration */
	update_option('ef-sync-signup-users', true);

	ef_setup_catalog_page();
	ef_setup_signup_page();
}

register_activation_hook(__FILE__, 'install');

function uninstall() {
	/* Main configuration */
	delete_option('efront-domain');
	delete_option('efront-admin-username');
	delete_option('efront-admin-password');

	/* Catalog configuration */
	delete_option('ef-catalog-template');
	delete_option('ef-catalog-template-pagination-opt');

	delete_option('ef-catalog-pagination-top');
	delete_option('ef-catalog-pagination-bottom');
	delete_option('ef-catalog-pagination-per-page');

	/* Singup configuration*/
	delete_option('ef-post-signup');

	/* Sync eFront and WP users configuration */
	delete_option('ef-sync-signup-users');

	ef_delete_catalog_page();
	ef_delete_signup_page();

	ef_db_drop();
}

register_deactivation_hook(__FILE__, 'uninstall');

function ef_setup_catalog_page() {
	global $wpdb;

	$the_page_title = 'Catalog';
	$the_page_name = 'catalog';

	// the menu entry...
	delete_option("ef_catalog_page_title");
	add_option("ef_catalog_page_title", $the_page_title, '', 'yes');
	// the slug...
	delete_option("ef_catalog_page_name");
	add_option("ef_catalog_page_name", $the_page_name, '', 'yes');
	// the id...
	delete_option("ef_catalog_page_id");
	add_option("ef_catalog_page_id", '0', '', 'yes');

	$the_page = get_page_by_title($the_page_title);

	if (!$the_page) {
		// Create post object
		$_p = array();
		$_p['post_title'] = $the_page_title;
		$_p['post_content'] = "[efront-catalog]";
		$_p['post_status'] = 'publish';
		$_p['post_type'] = 'page';
		$_p['comment_status'] = 'closed';
		$_p['ping_status'] = 'closed';
		$_p['post_category'] = array(1);

		// Insert the post into the database
		$the_page_id = wp_insert_post($_p);

	} else {
		$the_page_id = $the_page -> ID;
		//make sure the page is not trashed...
		$the_page -> post_status = 'publish';
		$the_page_id = wp_update_post($the_page);
	}

	delete_option('ef_catalog_page_id');
	add_option('ef_catalog_page_id', $the_page_id);
}

function ef_delete_catalog_page() {
	global $wpdb;

	$the_page_title = get_option("ef_catalog_page_title");
	$the_page_name = get_option("ef_catalog_page_name");

	//  the id of our page...
	$the_page_id = get_option('ef_catalog_page_id');
	if ($the_page_id) {
		wp_delete_post($the_page_id);
		// this will trash, not delete
	}
	delete_option("ef_catalog_page_title");
	delete_option("ef_catalog_page_name");
	delete_option("ef_catalog_page_id");
}

function ef_setup_signup_page() {
	global $wpdb;

	$the_page_title = 'Signup';
	$the_page_name = 'signup';

	// the menu entry...
	delete_option("ef_signup_page_title");
	add_option("ef_signup_page_title", $the_page_title, '', 'yes');
	// the slug...
	delete_option("ef_signup_page_name");
	add_option("ef_signup_page_name", $the_page_name, '', 'yes');
	// the id...
	delete_option("ef_signup_page_id");
	add_option("ef_signup_page_id", '0', '', 'yes');

	$the_page = get_page_by_title($the_page_title);

	if (!$the_page) {
		// Create post object
		$_p = array();
		$_p['post_title'] = $the_page_title;
		$_p['post_content'] = "[efront-signup]";
		$_p['post_status'] = 'publish';
		$_p['post_type'] = 'page';
		$_p['comment_status'] = 'closed';
		$_p['ping_status'] = 'closed';
		$_p['post_category'] = array(1);

		// Insert the post into the database
		$the_page_id = wp_insert_post($_p);

	} else {
		$the_page_id = $the_page -> ID;
		//make sure the page is not trashed...
		$the_page -> post_status = 'publish';
		$the_page_id = wp_update_post($the_page);
	}

	delete_option('ef_signup_page_id');
	add_option('ef_signup_page_id', $the_page_id);
}

function ef_delete_signup_page() {
	global $wpdb;

	$the_page_title = get_option("ef_signup_page_title");
	$the_page_name = get_option("ef_signup_page_name");

	//  the id of our page...
	$the_page_id = get_option('ef_signup_page_id');
	if ($the_page_id) {
		wp_delete_post($the_page_id);
		// this will trash, not delete
	}
	delete_option("ef_signup_page_title");
	delete_option("ef_signup_page_name");
	delete_option("ef_signup_page_id");
}
