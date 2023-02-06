<?php
/**
    @desc: API wrapper for APIClass
*/

include_once(__DIR__ . "/class/API.class.php");

class APIHelper extends APIClass {

    /**
        @desc: Init class
    */
    public function __construct (
        $request
    ) {
        // init API
        parent::__construct($request);
    }

	

    /**
        @desc: Array index handler
    */
    public static function param ($array, $key, $default = "") {
        if (isset($array[$key])) {
            if ($array[$key] == "") {
                return $default;
            }
            return $array[$key];
        }
        return $default;
    }

}

?>