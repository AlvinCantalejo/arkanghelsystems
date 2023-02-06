<?php
include_once(__DIR__ . "/../helper/DB.helper.php");

class Account extends DBHelper
{
    //constants declaration
    const ID = "id";

    /**
        @desc: Init class
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
        SAMPLE MODEL
        @desc: adds new account to c_account
     */
    public function addNewAccount($account_name, $id_user)
    {

        $sql = "INSERT INTO c_account(account_name, id_user)
                VALUES (?, ?);";

        $statement = $this->db->prepare($sql);
        $statement->bind_param('si', $account_name, $id_user);
        $excecuted = $statement->execute();
        return array($excecuted, $statement->insert_id);
    }

}
