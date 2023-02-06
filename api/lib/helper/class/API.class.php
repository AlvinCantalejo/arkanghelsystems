<?php
/**
    API.class.php
    @desc: API class
*/

class APIClass {

    /**
        @desc: model or action to be executed
    */
    var $endpoint = ""; // the model/ action to be executed

    /**
        @desc: optional additional parameters/ arguments
    */
    var $args = "";

    /**
        @desc: Common response status
    */
    var $status = array (
        "200" => "Success",
        "401" => "Unauthorized access",
        "403" => "No action found",
        "404" => "Action not found",
        "500" => "Internal server error",
        "503" => "Forbidden access",
        "400" => "Error",
        "601" => "Email already exist",
        "602" => "Invalid credentials",
        "603" => "No data found",
        "604" => "Data insertion failed",
        "605" => "Data updation failed",
        "606" => "Data deletion failed"
    );

    /**
        @desc: Constructor
    */
    public function __construct (
        $request
    ) {
        //if you want to limit the access origin
        header("Access-Control-Allow-Orgin: *");
        
        //if you want to limit the allowed method in this API
        header("Access-Control-Allow-Methods: *");

        //make sure that the return is in JSON format
        header("Content-Type: application/json");


        // Catches the argument and the endpoint
        $this->args = explode('/', rtrim($request, '/'));
    }

    /**
        @desc: Response
    */
    public function response (
        $data = "",
        $status = "200"
    ) {
        header("Content-Type: application/json");
        header("HTTP/1.1 " . $status . " " . $this->status[$status]);
        return json_encode ($data);
    }

}
		
?>