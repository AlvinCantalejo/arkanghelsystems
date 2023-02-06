<?php
/**
	@desc: SessionClass handles the session functions
*/

class SessionClass {

	var $tokenKey = "Koauthorization";
	var $sessionName = "session";
	var $timeout = 12 * 60 * 60; // hr * min * sec

	function __construct ($sessionName = "") {
		if(session_status() == PHP_SESSION_NONE){
		    //session has not started
		    session_start();
		}

		$this->sessionName = $sessionName;
		$this->checkSession();
	}

	public function checkSession () {
		if ($this->hasActiveSession()) {
			$this->refreshSession();
		}
	}

	public function refreshSession () {
		if (isset($_SESSION[$this->sessionName])) {
			if (time() - $_SESSION[$this->sessionName] > $this->timeout) {
				$this->destroySession();
			}
			else {
				$_SESSION[$this->sessionName] = time();
			}
			return;
		}
		$this->destroySession();
	}

	public function createSession ($data = "") {
		// make sure that the data is an array
		if (!is_array($data)) {
			return false;
		}

		// set session start time
		$_SESSION[$this->sessionName] = time();

		// generate ID
		session_regenerate_id(true);

		// store data to session
		if (count($data) > 0) {
			foreach ($data as $key => $value) {
				$_SESSION[$key] = $value;
			}
		}

		return true;
	}

	public static function addValueToSession($key, $value = ""){
		
		$_SESSION[$key] = $value;
		if(isset($_SESSION[$key]))
			return true;
		return false;
	}

	public static function destroySession () {
		unset($_SESSION);
		session_destroy();
	}

	public function hasActiveSession ($key = "token") {
		if (isset($_SESSION[$this->sessionName]) && isset($_SESSION[$key])) {
			if ($_SESSION[$key] != "") {
				return true;
			}
		}else{
			return false;
		}
		
	}


	public static function get (
		$key,
		$defaultValue = ""
	) {
		if (isset($_SESSION[$key])) {
			if ($_SESSION[$key] != "") {
				return $_SESSION[$key];
			}
		}
		return $defaultValue;
	}
}

?>