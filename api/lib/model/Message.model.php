<?php
/**
 * 
 * 
 * @return: JSON
 * {
 * 		message: "Message content here";
 * }
 * */
class Message {
	
	public $message = "";

    /**
        @desc: Init class
    */
    public function __construct ($message = "") {
        $this->message = $message;
    }

}

?>