<?php
/**
    @wrapper for pdf class
 * */
include_once(__DIR__ . "/class/PDF.class.php");
include_once(__DIR__ . "/class/Session.class.php");
include_once(__DIR__ . "/Param.helper.php");
include_once(__DIR__ . "/Session.helper.php");

class PDFHelper{

    public function __construct () {
        $this->generateReport();
        
    }
    static function generateReport(){
        new PDFClass();
    }
}


    
?>