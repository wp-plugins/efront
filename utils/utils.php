<?php
/**
 * Utilities
 * */
?>
<?php
require_once (_BASEPATH_ . '/utils/template_utils/catalog_pagination_utils.php');
require_once (_BASEPATH_ . '/utils/template_utils/catalog_tree_utils.php');

/**
 * Get eFront languages
 *
 * @return array efront languages
 * */
function get_ef_languages() {
	$efront_languages = array('brazilian' => 'Brasileira', 'catalan' => 'CatalΓ ', 'czech' => 'Δ�esky', 'danish' => 'Dansk', 'german' => 'Deutsch', 'english-enterprise' => 'English', 'spanish' => 'EspaΓ±ol', 'greek-enterprise' => 'EΞ»Ξ»Ξ·Ξ½ΞΉΞΊΞ¬', 'filipino' => 'Filipino', 'french' => 'FranΓ§ais', 'galician' => 'Galego', 'croatian' => 'Hrvatski', 'indonesian' => 'Indonesia', 'italian' => 'Italiano', 'latvian' => 'LatvieΕ΅u', 'lithuanian' => 'LietuviΕ΅kai', 'hungarian' => 'Magyar', 'dutch' => 'Nederlands', 'norwegian' => 'Norsk', 'polish' => 'Polski', 'portuguese' => 'PortuguΓ�s', 'russian' => 'PΡƒΡ�Ρ�ΠΊΠΈΠΉ', 'romanian' => 'RomΓΆnΔƒ', 'albanian' => 'Shqipe', 'slovak' => 'SlovenΔ�ina', 'slovenian' => 'Slovenski', 'finnish' => 'Suomi', 'swedish' => 'Svenska', 'turkish' => 'TΓΌrkΓ§e', 'bulgarian' => 'Π‘Ρ�Π»Π³Π°Ρ€Ρ�ΠΊΠΈ', 'ukrainian' => 'Π£ΠΊΡ€Π°Ρ—Π½Ρ�Ρ�ΠΊΠµ', );
	return $efront_languages;
}

/**
 * Get eFront language
 *
 * @param string $key key for efront language
 * @return string language
 * */
function get_ef_language($key) {
	$key = trim($key);
	$efront_languages = array('brazilian' => 'Brasileira', 'catalan' => 'CatalΓ ', 'czech' => 'Δ�esky', 'danish' => 'Dansk', 'german' => 'Deutsch', 'english-enterprise' => 'English', 'spanish' => 'EspaΓ±ol', 'greek-enterprise' => 'EΞ»Ξ»Ξ·Ξ½ΞΉΞΊΞ¬', 'filipino' => 'Filipino', 'french' => 'FranΓ§ais', 'galician' => 'Galego', 'croatian' => 'Hrvatski', 'indonesian' => 'Indonesia', 'italian' => 'Italiano', 'latvian' => 'LatvieΕ΅u', 'lithuanian' => 'LietuviΕ΅kai', 'hungarian' => 'Magyar', 'dutch' => 'Nederlands', 'norwegian' => 'Norsk', 'polish' => 'Polski', 'portuguese' => 'PortuguΓ�s', 'russian' => 'PΡƒΡ�Ρ�ΠΊΠΈΠΉ', 'romanian' => 'RomΓΆnΔƒ', 'albanian' => 'Shqipe', 'slovak' => 'SlovenΔ�ina', 'slovenian' => 'Slovenski', 'finnish' => 'Suomi', 'swedish' => 'Svenska', 'turkish' => 'TΓΌrkΓ§e', 'bulgarian' => 'Π‘Ρ�Π»Π³Π°Ρ€Ρ�ΠΊΠΈ', 'ukrainian' => 'Π£ΠΊΡ€Π°Ρ—Π½Ρ�Ρ�ΠΊΠµ', );

	return $efront_languages[$key];
}

/**
 * Get current page url
 *
 * @return string current page url
 * */
function current_page_url() {
	$pageURL = 'http';
	if (isset($_SERVER["HTTPS"])) {
		if ($_SERVER["HTTPS"] == "on") {
			$pageURL .= "s";
		}
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

/**
 * Converts XML object to Array
 *
 * @param SimpleXMLElement Object $xml the XML object to be converted
 * @return Array the corresponding array
 * */
function xml2array($xml) {
	$arr = array();

	foreach ($xml->children() as $r) {
		$t = array();
		if (count($r -> children()) == 0) {
			$arr[$r -> getName()] = strval($r);
		} else {
			$arr[$r -> getName()][] = xml2array($r);
		}
	}
	return $arr;
}

/**
 * Checks if a user has a lesson or not.
 *
 * @param sting $token token to communicate with the XML API module
 * @param string $login user's login
 * @param int $lesson_id the lesson id
 * @return boolean true if the user is assigned to the lesson or false if not
 * */
function ef_user_has_lesson($token, $login, $lesson_id) {
	$user_lessons = eFront_User::getUserLessons($token, $login);
	$user_lessons = xml2array($user_lessons);

	$lesson_ids = array();
	foreach ($user_lessons['lesson'] as $lesson) {
		$lesson_ids[] = $lesson['id'];
	}
	if (in_array($lesson_id, $lesson_ids)) {
		return true;
	} else {
		return false;
	}
}

/**
 * Checks if a user has a course or not.
 *
 * @param sting $token token to communicate with the XML API module
 * @param string $login user's login
 * @param int $course_id the course id
 * @return boolean true if the user is assigned to the course or false if not
 * */
function ef_user_has_course($token, $login, $course_id) {
	$user_courses = eFront_User::getUserCourses($token, $login);
	$user_courses = xml2array($user_courses);

	$course_ids = array();
	foreach ($user_courses['course'] as $course) {
		$course_ids[] = $course['id'];
	}
	if (in_array($course_id, $course_ids)) {
		return true;
	} else {
		return false;
	}
}

/**
 * Checks if a string is a valid and eFront domain.
 *
 * @param sting $domain the domain to be ckecked
 * @return boolean true if domain is a valid and eFront domain
 * */
function ef_is_efront_domain($domain) {
	return preg_match("/^[a-z0-9-\.]{1,100}\w+$/", $domain) AND (strpos($domain, 'efrontlearning.com') !== false);
}

/**
 * List users from WP and eFront and find the differences between the two sets
 * @return Array An array four arrays. One of WP users to be synced to eFront, one of eFront users to be synced to WP, 0ne of total eFront users and one of total WP users
 * */
function ef_list_wp_ef_users() {
	$token = eFront::requestToken();
	eFront::loginModule($token, get_option('efront-admin-username'), get_option('efront-admin-password'));
	$efront_users = eFront_User::getUsers($token);

	$ef_users = array();
	foreach ($efront_users->users->user as $user) {
		$user = xml2array($user);
		$ef_users[$user['login']] = array( 'ID'=>'', 'login' => $user['login'], 'first_name' => $user['name'], 'last_name' => $user['surname'], 'email' => $user['email']);
	}

	$blog_users = get_users();
	$wp_users = array();
	foreach ($blog_users as $user) {
		$wp_users[$user -> user_login] = array('ID'=> $user->ID, 'login' => $user -> user_login, 'first_name' => $firstName = get_user_meta($user -> ID, 'first_name', true), 'last_name' => $lastName = get_user_meta($user -> ID, 'last_name', true), 'email' => $user -> user_email);
	}

	$ef_users_to_wp = array_diff_key($ef_users, $wp_users);
	$wp_users_to_ef = array_diff_key($wp_users, $ef_users);
	
	return array(
		'wp_users' => $wp_users,
		'ef_users' => $ef_users,
		'ef_users_to_wp' => $ef_users_to_wp, 
		'wp_users_to_ef' => $wp_users_to_ef,
	);
}

/**
 * Sync users from WP and users from eFront
 * @param Array $ef_users_to_wp eFront users to be synced to WP
 * @param Array $wp_users_to_ef WP users to be synced to eFront
 * @param boolean $hard_sync forces WP users details to be overwritten by details in eFront
 * @param Array $all_users All the users in WP and eFront
 * @return boolean|Array true if sync was successfull or an array of sync errors
 * */
function ef_sync_wp_ef_users($ef_users_to_wp, $wp_users_to_ef, $hard_sync, $all_users) {
	
	$sync_errors = array();
	foreach ($ef_users_to_wp as $user) {
		$new_wp_user_id = wp_insert_user(array('user_login' => $user['login'], 'user_pass' => $user['password'], 'user_email' => $user['email'], 'first_name' => $user['first_name'], 'last_name' => $user['last_name']));
		if (is_wp_error($new_wp_user_id)) {
			$sync_errors[] = "User: " . $user['login'] . " cannot be synchronized from eFront.	Error: " . $new_wp_user_id -> get_error_message();
		}
	}
		
	$token = eFront::requestToken();
	eFront::loginModule($token, get_option('efront-admin-username'), get_option('efront-admin-password'));
	
	foreach ($wp_users_to_ef as $user) {
		try {
			eFront_User::createUser($token, $user['login'], $user['password'], $user['first_name'], $user['last_name'], $user['language'], $user['email']);
		} catch (Exception $e) {
			$sync_errors[] = "User: " . $user['login'] . "	Error: " . $e -> getMessage();
		}
	}		
	if($hard_sync){
		foreach ($all_users as $user) {
			wp_insert_user(array('ID' => $user['ID'], 'user_login' => $user['login'], 'user_email' => $user['email'], 'first_name' => $user['first_name'], 'last_name' => $user['last_name']));
			//if($user['ID']){
			//	update_user_meta($user['ID'], 'user_login', $user['login']);
			//	update_user_meta($user['ID'], 'user_email', $user['email']);
			//	update_user_meta($user['ID'], 'first_name', $user['first_name']);
			//	update_user_meta($user['ID'], 'last_name', $user['last_name']);
			//}
		}
	}
	
	if(!empty($sync_errors)) {
		return $sync_errors;
	} else {
		return true;
	}	
	
}
?>