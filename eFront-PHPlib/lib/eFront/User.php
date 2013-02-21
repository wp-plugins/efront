<?php

class eFront_User extends eFront {

	/**
	 * User info
	 * 
	 * Another provided action is the request of general information about a user. The application must provide its token and the login of the user. The module checks whether the provided token is valid and whether its status is logged. If so, it processes the request and provides general information about the corresponding user.
	 * 
	 * @link http://docs.efrontlearning.net/index.php/XML_API2#User_info
	 * @param string $token token to communicate with the XML API module
	 * @param string $login the login of the corresponding user
	 * @return SimpleXMLElement Object general information about a user
	 * */
	public static function getInfo($token, $login) {
		$xml_response = simplexml_load_file(self::$apiBase . "?action=user_info" . "&token=" . $token . "&login=" . $login);
		if ($xml_response -> status == 'error') {
			throw new eFront_ApiError($xml_response -> message);
		} else {
			return $xml_response;
		}		
	}

	/**
	 * Create a new user
	 * 
	 * The most used action is the creation of a new user. The application must provide its token, the login and the password of the new user, his name and surname, his email and his language. The module checks whether the provided token is valid and whether its status is logged. If so, it processes the request and creates the new user, otherwise it responses an error message.
	 * 
	 * @link http://docs.efrontlearning.net/index.php/XML_API2#Create_a_new_user
	 * @param string $token token to communicate with the XML API module
	 * @param string $login the login of the corresponding new user
	 * @param string $password the password of the corresponding new user
	 * @param string $name the name of the corresponding new user
	 * @param string $surname the surname of the corresponding new user
	 * @param string $languages the languages of the corresponding new user
	 * @param string $email the email of the corresponding new user  
	 * @return string|eFront_ApiError 
	 * */	
	public static function createUser($token, $login, $password, $name, $surname, $languages, $email) {
		$xml_response = simplexml_load_file(self::$apiBase . "?action=create_user" . "&token=" . $token . "&login=" . $login . "&password=" . $password . "&name=" . $name . "&surname=" . $surname . "&languages=" . $languages . "&email=" . $email);
		if ($xml_response -> status == 'error') {
			throw new eFront_ApiError($xml_response -> message);
		} else {
			return $xml_response -> status;
		}
	}

	/**
	 * Update an existing user
	 * 
	 * Using this action, the application can update the password, name and surname of an existing user. The application must provide its token, the login of the existing user, his new password, his new name and his new surname. The module checks whether the provided token is valid and whether its status is logged. If so, it processes the request and updates the user, otherwise it responses an error message.
	 * 
	 * @link http://docs.efrontlearning.net/index.php/XML_API2#Update_an_existing_user
	 * 
	 * @param string $token token to communicate with the XML API module
	 * @param string $login the login of the corresponding user
	 * @param string $password the password of the corresponding user
	 * @param string $name the name of the corresponding user
	 * @param string $surname the surname of the corresponding user
	 * @param string $email the email of the corresponding user  
	 * 
	 * @return string|eFront_ApiError 
	 * */
	public static function updateUser($token, $login, $password, $name, $surname, $email) {
		$xml_response = simplexml_load_file(self::$apiBase . "?action=update_user" . "&token=" . $token . "&login=" . $login . "&password=" . $password . "&name=" . $name . "&surname=" . $surname . "&email=" . $email);
		if ($xml_response -> status == 'error') {
			throw new eFront_ApiError($xml_response -> message);
		} else {
			return $xml_response -> status;
		}
	}

	/**
	 * Activate a user
	 * 
	 * Another provided action is the activation of an existing user. The application must provide its token and the login of the user to be activated. The module checks whether the provided token is valid and whether its status is logged. If so, it processes the request and activates the corresponding user.
	 * 
	 * @link http://docs.efrontlearning.net/index.php/XML_API2#Activate_a_user
	 * @param string $token token to communicate with the XML API module
	 * @param string $login the login of the corresponding user
	 * @return string|eFront_ApiError 
	 * */
	public static function activateUser($token, $login) {
		$xml_response = simplexml_load_file(self::$apiBase . "?action=activate_user" . "&token=" . $token . "&login=" . $login);
		if ($xml_response -> status == 'error') {
			throw new eFront_ApiError($xml_response -> message);
		} else {
			return $xml_response -> status;
		}
	}

	/**
	 * Deactivate a user
	 * 
	 * Another provided action is the deactivation of an existing user. The application must provide its token and the login of the user to be deactivated. The module checks whether the provided token is valid and whether its status is logged. If so, it processes the request and deactivates the corresponding user.
	 * 
	 * @link http://docs.efrontlearning.net/index.php/XML_API2#Deactivate_a_user
	 * @param string $token token to communicate with the XML API module
	 * @param string $login the login of the corresponding user
	 * @return string|eFront_ApiError 
	 * */
	public static function deactivateUser($token, $login) {
		$xml_response = simplexml_load_file(self::$apiBase . "?action=deactivate_user" . "&token=" . $token . "&login=" . $login);
		if ($xml_response -> status == 'error') {
			throw new eFront_ApiError($xml_response -> message);
		} else {
			return $xml_response -> status;
		}
	}

	/**
	 * Remove an existing user
	 * 
	 * Another provided action is the removal of an existing user. The application must provide its token and the login of the user to be deleted. The module checks whether the provided token is valid and whether its status is logged. If so, it processes the request and removes the corresponding user.
	 * 
	 * @link http://docs.efrontlearning.net/index.php/XML_API2#Remove_an_existing_user
	 * @param string $token token to communicate with the XML API module
	 * @param string $login the login of the corresponding user
	 * @return string|eFront_ApiError 
	 * */
	public static function removeUser($token, $login) {
		$xml_response = simplexml_load_file(self::$apiBase . "?action=remove_user" . "&token=" . $token . "&login=" . $login);
		if ($xml_response -> status == 'error') {
			throw new eFront_ApiError($xml_response -> message);
		} else {
			return $xml_response -> status;
		}
	}

	/**
	 * User lessons
	 * 
	 * Another provided action is the request of showing the lessons of a user. The application must provide its token and the login of the user. The module checks whether the provided token is valid and whether its status is logged. If so, it processes the request returning a lesson list
	 * 
	 * @link http://docs.efrontlearning.net/index.php/XML_API2#User_lessons
	 * @param string $token token to communicate with the XML API module
	 * @param string $login the login of the corresponding user
	 * @return string|eFront_ApiError 
	 * */
	public static function getUserLessons($token, $login) {
		$xml_response = simplexml_load_file(self::$apiBase . "?action=user_lessons" . "&token=" . $token . "&login=" . $login);
		if ($xml_response -> status == 'error') {
			throw new eFront_ApiError($xml_response -> message);
		} else {
			return $xml_response;
		}
	}
	
	/**
	 * User courses
	 * 
	 * Another provided action is the request of showing the courses of a user. The application must provide its token and the login of the user. The module checks whether the provided token is valid and whether its status is logged. If so, it processes the request returning a course list
	 * 
	 * @link http://docs.efrontlearning.net/index.php/XML_API2#User_courses
	 * @param string $token token to communicate with the XML API module
	 * @param string $login the login of the corresponding user
	 * @return string|eFront_ApiError 
	 * */
	public static function getUserCourses($token, $login) {
		$xml_response = simplexml_load_file(self::$apiBase . "?action=user_courses" . "&token=" . $token . "&login=" . $login);
		if ($xml_response -> status == 'error') {
			throw new eFront_ApiError($xml_response -> message);
		} else {
			return $xml_response;
		}
	}
	
	/**
	 * Assign curriculum to user
	 * 
	 * Another provided action is the assignment of a curriculum to a user. The module checks whether the provided token is valid and whether its status is logged. If so, it processes the request and assigns the corresponding curriculum.
	 * 
	 * @link http://docs.efrontlearning.net/index.php/XML_API2#Activate_assignment_for_lesson_to_a_user
	 * @param string $token token to communicate with the XML API module
	 * @param string $login the login of the corresponding user
	 * @param int $curriculum the course id of the corresponding course
	 * @return string|eFront_ApiError 
	 * */	
	public static function assignCurriculum($token, $login, $curriculum) {
		$xml_response = simplexml_load_file(self::$apiBase . "?action=curriculum_to_user" . "&token=" . $token . "&login=" . $login . "&curriculum=" . $curriculum);
		if ($xml_response -> status == 'error') {
			throw new eFront_ApiError($xml_response -> message);
		} else {
			return $xml_response -> status;
		}
	}	
}
