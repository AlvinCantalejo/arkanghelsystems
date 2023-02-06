<?php
/**
    @desc: Handles the request from client
    https://localhost/likhaph/redlifeph/api/ENDPOINT_NAME/ACTION_NAME
*/


    // comment the 3 lines below to disable error display
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    // import necessary file
    include_once (__DIR__ . "/lib/Router.api.php");

    // determine request method
    $method = $_SERVER["REQUEST_METHOD"];

    // instantiate main class
    $api = new RouterAPI($method, $_REQUEST["request"]);

    // process the request
    echo $api->process();
?>