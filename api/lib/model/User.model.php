<?php
include_once(__DIR__ . "/../helper/DB.helper.php");
class User extends DBHelper{

    const TOKEN = "token";   
    const ID = "id";   
    const FULL_NAME = "full_name";   
    const ADDRESS = "address";
    const CONTACT_NUMBER = "contact_number";
    const ROLE = "role";    
    const USERNAME = "username";
    const PASSWORD = "password";
    const DEL = "del";

    /**
        @desc: Init class
    */
    public function __construct () {
        parent::__construct();
    }   

    public function loginUser($username){
        $sql = "SELECT * 
                FROM as_user 
                WHERE username = ? 
                AND del <> 1   
                LIMIT 1";
                
        $statement = $this->db->prepare($sql);
        $statement->bind_param('s', $username);
        $statement->execute();
        $dataset = $statement->get_result();

        return $dataset;
    }

    public function resetUserPassword($id, $encPassword ) {

        $sql = "UPDATE r_user SET password = ? WHERE id = ?";
        $statement = $this->db->prepare($sql);
        $statement->bind_param("si", $encPassword, $id);
        $excecuted = $statement->execute();

        return $excecuted;
    }

    public function filterUserRole ($user_role) {

        $sql = "SELECT * FROM r_user WHERE user_role = ?";
        $statement = $this->db->prepare ($sql);
        $statement->bind_param('s', $user_role);
        $statement->execute();
        $dataset = $statement->get_result();
        return $dataset;
    }

    public function updateProfile ( $id,
                                    $idDonor,
                                    $firstName,
                                    $lastName,
                                    $email,
                                    $phoneNumber,
                                    $birthDate,
                                    $gender) {

        $data = new Message("Profile not updated!");

        $sql = "UPDATE r_user 
                SET first_name = ?, 
                    last_name = ?, 
                    email = ?, 
                    phone_number = ?
                WHERE id = ?";
        $statement = $this->db->prepare ($sql);
        $statement->bind_param('ssssi',     $firstName,
                                            $lastName,
                                            $email,
                                            $phoneNumber,
                                            $id);
        $statement->execute();

        $sql = "UPDATE r_donor
                SET birth_date = ?, 
                    gender = ?
                WHERE id = ?";
        $statement = $this->db->prepare ($sql);
        $statement->bind_param('sss',   $birthDate,
                                        $gender,
                                        $idDonor);
        $statement->execute();
        return true;
    }


    public function register    (   $firstName,
                                    $lastName,
                                    $phoneNumber,
                                    $email,
                                    $encPassword,
                                    $donorID,
                                    $birthDate,
                                    $gender,
                                    $bloodType ) {

        $sql = "INSERT INTO r_user(first_name, last_name, phone_number, email, password) 
                VALUES(?, ?, ?, ?, ?)";
        $statement = $this->db->prepare ($sql);
        $statement->bind_param('sssss',
                                        $firstName,
                                        $lastName,
                                        $phoneNumber,
                                        $email,
                                        $encPassword );
        
        $excecuted = $statement->execute();
        $idUser = $this->db->insert_id;

        if($excecuted){
            return $this->addDonor( $donorID, 
                                    $idUser, 
                                    $birthDate, 
                                    $gender,
                                    $bloodType );  
        }
        else{
            return false;
        }
    }

    public function addDonor(   $donorID, 
                                $idUser, 
                                $birthDate, 
                                $gender,
                                $bloodType ){

        $sql = "INSERT INTO r_donor(id, id_user, birth_date, gender, blood_type) 
        VALUES(?, ?, ?, ?, ?);";
        $statement = $this->db->prepare ($sql);
        $statement->bind_param('sisss', $donorID,
                                        $idUser,
                                        $birthDate,
                                        $gender,
                                        $bloodType);
        $excecuted = $statement->execute();
        return $excecuted;
    }

    public function getAllUsers () {

        $sql = "SELECT c_user.*, 
                GROUP_CONCAT(DISTINCT c_account.account_name SEPARATOR ', ') AS account_name, 
                c_account_user.id AS id_account_user, 
                c_account_user.id_account, 
                c_account_user.is_owner
                FROM c_user 
                LEFT JOIN c_account_user 
                ON c_user.id = c_account_user.id_user 
                LEFT JOIN c_account 
                ON c_account_user.id_account = c_account.id 
                AND c_account.account_status = 'Active'
                GROUP BY c_user.email 
                ORDER BY c_user.email";
        $statement = $this->db->prepare ($sql);
        $statement->execute();
        
        $dataset = $statement->get_result();
        return $dataset;
    }

    public function updateUser ($first_name,
                                $last_name,
                                $email,
                                $phone_number,
                                $user_status,
                                $user_role,
                                $id) {

        $sql = "UPDATE c_user 
                SET first_name = ?, 
                last_name = ?, 
                email = ?, 
                phone_number = ?, 
                user_status  = ?, 
                user_role  = ?
                WHERE id = ?";
        $statement = $this->db->prepare ($sql);
        $statement->bind_param('ssssssi',
                                            $first_name,
                                            $last_name,
                                            $email,
                                            $phone_number,
                                            $user_status,
                                            $user_role,
                                            $id);

        $excecuted = $statement->execute();
        return $excecuted;
    }

    public function updateUserStatus ($user_status, $id) {

        $sql = "UPDATE c_user 
                SET user_status = ? 
                WHERE id = ?";
        $statement = $this->db->prepare ($sql);
        $statement->bind_param('si', $user_status, $id);

        $excecuted = $statement->execute();
        return $excecuted;
    }

    public function getAllUserRoles () {

        $sql = "SELECT * FROM c_user_role";
        $statement = $this->db->prepare ($sql);
        $statement->execute();
        $dataset = $statement->get_result();
        return $dataset;
    }

    public function getAllUserStatus() {

        $sql = "SELECT * FROM c_user_status";
        $statement = $this->db->prepare ($sql);
        $statement->execute();

        $dataset = $statement->get_result();
        return $dataset;
    }

    public function getAllEmployees ($id_account){

        $sql = "SELECT c_user.* 
                FROM c_user 
                LEFT JOIN c_account_user 
                ON c_user.id = c_account_user.id_user 
                WHERE c_account_user.id_account = ?
                ORDER BY c_user.id";
        $statement = $this->db->prepare ($sql);
        $statement->bind_param('i', $id_account);
        $statement->execute();
        $dataset = $statement->get_result();
        return $dataset;
    }

    public function deleteEmployee ($id, $user_status){

        $sql = "UPDATE c_user 
                SET user_status = ? 
                WHERE id = ?";
        $statement = $this->db->prepare ($sql);
        $statement->bind_param('si', $user_status, $id);
        $excecuted = $statement->execute();
        return $excecuted;
    }

    
}

?>