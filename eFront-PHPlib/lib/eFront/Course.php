<?php


class eFront_Course extends eFront {

	/**
	 * Course info
	 *
	 * Request of general information about a course. The application must provide its token and the id of the course. The module checks whether the provided token is valid and whether its status is logged. If so, it processes the request and provides general information about the corresponding course.
	 *
	 * @link http://docs.efrontlearning.net/index.php/XML_API2#.5bedit.5d_Course_info
	 * @param string $token token to communicate with the XML API module
	 * @param int $course_id the course id of the corresponding course
	 * @return SimpleXMLElement Object general information about a course
	 * */
	public static function getInfo($token, $course_id) {
		$xml_response = simplexml_load_file(self::$apiBase . "?action=course_info" . "&token=" . $token . "&course=" . $course_id);
		if ($xml_response -> status == 'error') {
			throw new eFront_ApiError($xml_response -> message);
		} else {
			return $xml_response;
		}
	}	
	
	/**
	 * Get course lessons 
	 * 
	 * Request of the lessons of a course. The application must provide its token and a course. The module checks whether the provided token is valid and whether its status is logged. If so, it processes the request and provides the lessons.
	 * 
	 * @link http://docs.efrontlearning.net/index.php/XML_API2#Course_lessons
	 * @param string $token token to communicate with the XML API module
	 * @param int $course_id the course id of the corresponding course
	 * @return SimpleXMLElement Object lessons of the corresponding course
	 * */
	public static function getCourseLessons($token, $course_id) {
		$xml_response = simplexml_load_file(self::$apiBase . "?action=course_lessons" . "&token=" . $token . "&course=" . $course_id);
		if ($xml_response -> status == 'error') {
			throw new eFront_ApiError($xml_response -> message);
		} else {
			return $xml_response;
		}		
	}

	/**
	 * Assign course to user
	 * 
	 * Assignment of a course to a user. The module checks whether the provided token is valid and whether its status is logged. If so, it processes the request and assigns the corresponding course to the user with the corresponding role.
	 * 
	 * @link http://docs.efrontlearning.net/index.php/XML_API2#Assign_course_to_user
	 * @param string $token token to communicate with the XML API module
	 * @param string $login the login of the corresponding user
	 * @param int $course_id the course id of the corresponding course
	 * @param string $type the corresponding role of the user in the course
	 * @return string|eFront_ApiError 
	 * */
	public static function assignToUser($token, $login, $course_id, $type) {
		$xml_response = simplexml_load_file(self::$apiBase . "?action=course_to_user" . "&token=" . $token . "&login=" . $login . "&course=" . $course_id . "&type=" . $type);
		if ($xml_response -> status == 'error') {
			throw new eFront_ApiError($xml_response -> message);
		} else {
			return $xml_response -> status;
		}
	}

	/**
	 * Remove a course from user
	 * 
	 * Removing of a course from a user. The module checks whether the provided token is valid and whether its status is logged. If so, it processes the request and removes the corresponding course from the user.
	 * 
	 * @link http://docs.efrontlearning.net/index.php/XML_API2#Remove_a_course_from_user
	 * @param string $token token to communicate with the XML API module
	 * @param string $login the login of the corresponding user
	 * @param int $course_id the course id of the corresponding course
	 * @return string|eFront_ApiError 
	 * */
	public static function removeFromUser($token, $login, $course_id) {
		$xml_response = simplexml_load_file(self::$apiBase . "?action=course_from_user" . "&token=" . $token . "&login=" . $login . "&course=" . $course_id);
		if ($xml_response -> status == 'error') {
			throw new eFront_ApiError($xml_response -> message);
		} else {
			return $xml_response -> status;
		}
	}

	/**
	 * Activate assignment for lesson to a user
	 * 
	 * Activation of an assignment for a lesson to a user. The module checks whether the provided token is valid and whether its status is logged. If so, it processes the request and completes the "pending" assignment for lesson to the user.
	 * 
	 * @link http://docs.efrontlearning.net/index.php/XML_API2#Activate_assignment_for_lesson_to_a_user
	 * @param string $token token to communicate with the XML API module
	 * @param string $login the login of the corresponding user
	 * @param int $course_id the course id of the corresponding course
	 * @return string|eFront_ApiError 
	 * */	
	public static function activateToUser($token, $login, $course_id) {
		$xml_response = simplexml_load_file(self::$apiBase . "?action=activate_user_course" . "&token=" . $token . "&login=" . $login . "&course=" . $course_id);
		if ($xml_response -> status == 'error') {
			throw new eFront_ApiError($xml_response -> message);
		} else {
			return $xml_response -> status;
		}
	}
	/**
	 * Deactivate assignment for lesson to a user
	 * 
	 * Deactivation of an assignment for a lesson to a user. The module checks whether the provided token is valid and whether its status is logged. If so, it processes the request and deactivates the assignment for lesson to the user.
	 * 
	 * @link http://docs.efrontlearning.net/index.php/XML_API2#Activate_assignment_for_lesson_to_a_user
	 * @param string $token token to communicate with the XML API module
	 * @param string $login the login of the corresponding user
	 * @param int $course_id the course id of the corresponding course
	 * @return string|eFront_ApiError 
	 * */
	public static function deactivateFromUser($token, $login, $course_id) {
		$xml_response = simplexml_load_file(self::$apiBase . "?action=deactivate_user_course" . "&token=" . $token . "&login=" . $login . "&course=" . $course_id);
		if ($xml_response -> status == 'error') {
			throw new eFront_ApiError($xml_response -> message);
		} else {
			return $xml_response -> status;
		}
	}	

	/**
	 * Get courses
	 *
	 * Request of all courses defined in platform. The application must provide its token. The module checks whether the provided token is valid and whether its status is logged. If so, it processes the request and provides information about all the courses.
	 *
	 * @link http://docs.efrontlearning.net/index.php/XML_API2#Courses
	 * @param string $token token to communicate with the XML API module
	 * @return SimpleXMLElement Object information about the courses
	 * */
	public static function getCourses($token) {
		$xml_response = simplexml_load_file(self::$apiBase . "?action=courses" . "&token=" . $token);
		if ($xml_response -> status == 'error') {
			throw new eFront_ApiError($xml_response -> message);
		} else {
			return $xml_response;
		}
	}

	/**
	 * Buy a course
	 *
	 * Buy a course. The application must provide its token, a course id and a user login. The module checks whether the provided token is valid and whether its status is logged. If so, it processes the request and provides a paypal url which the user (defined by the login) can be redirected to buy a course (defined by the course_id).
	 *
	 * @link http://docs.efrontlearning.net/index.php/XML_API2#Courses
	 * @param string $token token to communicate with the XML API module
	 * @param int $course_id the course id of the corresponding course
	 * @param string $login the login of the corresponding user
	 * @return SimpleXMLElement Object the paypal url to buy the corresponding course
	 * */
	public static function buyCourse($token, $course_id, $login) {
		$xml_response = simplexml_load_file(self::$apiBase . "?action=buy_course" . "&token=" . $token . "&course=" . $course_id . "&login=" . $login);
		if ($xml_response -> status == 'error') {
			throw new eFront_ApiError($xml_response -> message);
		} else {
			return $xml_response -> redirect_url;
		}
	}
}