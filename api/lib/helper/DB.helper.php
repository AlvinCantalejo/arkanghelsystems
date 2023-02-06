<?php

/**
    @desc: Database helper
 */
class DBHelper {
    private $dbhost = "";
    private $dbuser = "";
    private $dbpass = "";
    private $dbname = "";

    public $db;

    function __construct() {
        $conf_array = parse_ini_file("config/conf.ini");
        $this->dbhost = $conf_array["host"];
        $this->dbuser = $conf_array["username"];
        $this->dbpass = $conf_array["password"];
        $this->dbname = $conf_array["database"];

        $this->initDB();
    }

    /**
        @desc: initializes database
    */
    private function initDB() {
        $this->db = new mysqli(
            $this->dbhost,
            $this->dbuser,
            $this->dbpass,
            $this->dbname)
            or die ("Failed to connect");
    }

    /**
        @desc: prepares sql statements
    */
    public function prepare ($sql) {
        $statement = $this->db->prepare ($sql) 
                    or die(error_log("[prepare error]" . $this->db->error, 0));
        return $statement;
    }
}
?>