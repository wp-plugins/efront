<?php
class eFront_Category extends eFront {

	/**
	 * Get Categories
	 * 
	 * Request all categories. The application must provide its token. The module checks whether the provided token is valid and whether its status is logged. If so, it processes the request and provides information about the categories.
	 * 
	 * @link 
	 * @param string $token token to communicate with the XML API module
	 * @return SimpleXMLElement Object general information about a category
	 * */
		
	public static function getCategories($token) {
		$xml_response = simplexml_load_file(self::$apiBase . "?action=categories" . "&token=" . $token);
		if ($xml_response -> status == 'error') {
			throw new eFront_ApiError($xml_response -> message);
		} else {
			return $xml_response;
		}
	}

	/**
	 * Get Category
	 * 
	 * Request of info for a specific category. The application must provide its token, and the category (id). The module checks whether the provided token is valid and whether its status is logged. If so, it processes the request and provides information about the corresponding category.
	 * 
	 * @link 
	 * @param string $token token to communicate with the XML API module
	 * @param int $category the category id of the corresponding category
	 * @return SimpleXMLElement Object general information about a category
	 * */

	public static function getCategory($token, $category_id) {
		$xml_response = simplexml_load_file(self::$apiBase . "?action=category" . "&token=" . $token . "&category=" . $category_id);
		if ($xml_response -> status == 'error') {
			throw new eFront_ApiError($xml_response -> message);
		} else {
			return $xml_response;
		}
	}


}
?>