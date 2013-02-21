<?php
/**
 * Utilities
 * */
?>
<?php
require_once (_BASEPATH_ . '/utils/template_utils/catalog_pagination_utils.php');
require_once (_BASEPATH_ . '/utils/template_utils/catalog_tree_utils.php');

/**
 * Get eFront language
 *
 * @param string $key key for efront language
 * @return string language
 * */
function get_ef_language($key) {
	$key = trim($key);
	$efront_languages = array('brazilian' => 'Brasileira', 'catalan' => 'Català', 'czech' => 'Česky', 'danish' => 'Dansk', 'german' => 'Deutsch', 'english-enterprise' => 'English', 'spanish' => 'Español', 'greek-enterprise' => 'Eλληνικά', 'filipino' => 'Filipino', 'french' => 'Français', 'galician' => 'Galego', 'croatian' => 'Hrvatski', 'indonesian' => 'Indonesia', 'italian' => 'Italiano', 'latvian' => 'Latviešu', 'lithuanian' => 'Lietuviškai', 'hungarian' => 'Magyar', 'dutch' => 'Nederlands', 'norwegian' => 'Norsk', 'polish' => 'Polski', 'portuguese' => 'Português', 'russian' => 'Pусский', 'romanian' => 'Română', 'albanian' => 'Shqipe', 'slovak' => 'Slovenčina', 'slovenian' => 'Slovenski', 'finnish' => 'Suomi', 'swedish' => 'Svenska', 'turkish' => 'Türkçe', 'bulgarian' => 'Български', 'ukrainian' => 'Українське', );

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
?>