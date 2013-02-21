<?php

class eFront_ApiError extends Exception {
	public function __construct($message = null) {
		parent::__construct($message);
	}

}
?>