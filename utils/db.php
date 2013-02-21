<?php

global $wpdb;

define("EF_TABLE", $wpdb -> prefix . "efront");

/**
 * Setup database table for eFront plugin
 * */
function ef_db_setup() {
	global $wpdb;
	$sql = "CREATE TABLE " . EF_TABLE . " (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,name VARCHAR(64), value LONGTEXT);";
	require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}

/**
 * Drop database table for eFront plugin
 * */
function ef_db_drop() {
	global $wpdb;
	$wpdb -> query("DROP TABLE " . EF_TABLE);
}

/**
 * Get value from cache
 *
 * @param string $value_name the name of the value stored in cache
 * @return string the value of in cache
 * */
function ef_get_cache_value($value_name) {
	global $wpdb;
	$db_result = $wpdb -> get_row("SELECT value FROM " . EF_TABLE . " WHERE name = '" . $value_name . "'");
	return $db_result -> value;
}

/**
 * Add value to cache
 *
 * @param array $array array with name and value keys to add value in cache
 * */
function ef_add_cache_value($array) {
	global $wpdb;
	$wpdb -> insert(EF_TABLE, array('name' => $array['name'], 'value' => $array['value']));
}

/**
 * Update value in cache
 *
 * @param array $array array with name and value keys to update value in cache
 * */
function ef_update_cache_value($array) {
	global $wpdb;
	$wpdb -> update(EF_TABLE, array('value' => $array['value'], ), array('name' => $array['name']));
}

/**
 * Delete value from cache
 *
 * @param string $value_name array with name and value keys to be added to cache
 * */
function ef_delete_cache_value($value_name) {
	global $wpdb;
	$wpdb -> query("DELETE FROM " . EF_TABLE . " WHERE name = '" . $value_name . "'");
}

/**
 * Empty cache
 * */
function ef_empty_cache() {
	global $wpdb;
	$wpdb -> query("TRUNCATE TABLE " . EF_TABLE);
}

/**
 * Check if cache is empty
 *
 * @return boolean true if cache is empty, false otherwise
 * */
function ef_is_cache_empty() {
	global $wpdb;
	$db_result = $wpdb -> query("SELECT * FROM " . EF_TABLE);
	if (!$db_result)
		return true;
	return false;
}
?>