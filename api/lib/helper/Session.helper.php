<?php
/**
    @wrapper for session class
 * */
include_once(__DIR__ . "/Param.helper.php");
include_once(__DIR__ . "/class/Session.class.php");

class SessionHelper extends SessionClass {

    var $session = "";
    var $sessionName = "REDLIFEPH_SESSION";
    
    /**
    *  @desc: Init class
    */
    public function __construct () {

        // init API
        parent::__construct($this->sessionName);
    }

	
	/**
	 * @desc: checks the session of the requester if valid
	 * @return: Bool
	 * */
	public function isCallNotAllowed () {
        $this->refreshSession();

        $headers = function_exists('apache_request_headers')? apache_request_headers() : $this->c_apache_request_headers();
       
        $authToken = ParamHelper::param($headers, $this->tokenKey); // from requester   
        
        $sessionToken =  $this->get(User::TOKEN, "no_token"); // from registered token

        $match = ($sessionToken == $authToken);
        
        if (!$match) {
            error_log("sessionToken: [{$sessionToken}]", 0);
            error_log("authToken: [{$authToken}]", 0);
        }
        return !$match;
	}

	//CUSTOM FUNCTIONS 
	function c_apache_request_headers() { 
	    $headers = [];
	    foreach ($_SERVER as $name => $value) {
	        if (substr($name, 0, 5) == 'HTTP_') {
	            $key = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
	            $headers[$key] = $value;
	        }
	    }
	    return $headers;

	}
}

?>