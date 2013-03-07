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
	foreach($user_lessons['lesson'] as $lesson){
		$lesson_ids[] = $lesson['id'];
	}
	if(in_array($lesson_id, $lesson_ids)){
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
	foreach($user_courses['course'] as $course){
		$course_ids[] = $course['id'];
	}
	if(in_array($course_id, $course_ids)){
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
function ef_is_efront_domain($domain){
	return preg_match("/^[a-z0-9-\.]{1,100}\w+$/", $domain) AND (strpos($domain, 'efrontlearning.com') !== false);
}
?>