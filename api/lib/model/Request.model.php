<?php
include_once(__DIR__ . "/../helper/DB.helper.php");
class Request extends DBHelper{

    const ID = "id";    
    const PATIENT_NAME = "patient_name";    
    const PHONE_NUMBER = "phone_number";   
    const CLINIC = "clinic";   
    const UNIT = "unit";   
    const BLOOD_TYPE = "blood_type";
    const RELEASE_NUMBER = "release_number";
    const REQUEST_DATE = "request_date";
    const REQUEST_STATUS = "request_status";
    const POSTED_BY = "posted_by";
    
    /**
        @desc: Init class
    */
    public function __construct () {
        parent::__construct();
    }
    public function filterRequest($status){
        if($status == "All")
            $sql = "SELECT r_request.*, 
                        r_user.first_name,
                        r_user.last_name
                    FROM r_request
                    LEFT JOIN r_user
                        ON r_request.posted_by = r_user.id
                    WHERE r_request.request_status <> ? 
                    ORDER BY r_request.request_date ASC";
        else
            $sql = "SELECT r_request.*, 
                        r_user.first_name,
                        r_user.last_name
                    FROM r_request
                    LEFT JOIN r_user
                        ON r_request.posted_by = r_user.id
                    WHERE r_request.request_status = ? 
                    ORDER BY r_request.request_date ASC";

        $statement = $this->db->prepare($sql);
        $statement->bind_param('s', $status);
        $statement->execute();
        $dataset = $statement->get_result();
        return $dataset;
    }
    
    public function addNewRequest(  $patientName,
                                    $phoneNumber,
                                    $clinic,
                                    $unit,
                                    $bloodType,
                                    $releaseNumber,
                                    $requestDate,
                                    $postedBy){

        $sql = "INSERT INTO r_request
                    (patient_name, phone_number, clinic, unit, blood_type, release_number, request_date, posted_by)
                VALUES(?,?,?,?,?,?,?,?)";
                
        $statement = $this->db->prepare($sql);
        $statement->bind_param('ssssssss',  $patientName,
                                            $phoneNumber,
                                            $clinic,
                                            $unit,
                                            $bloodType,
                                            $releaseNumber,
                                            $requestDate,
                                            $postedBy);
        $executed = $statement->execute();
        return $executed;
    }

    public function updateRequest (     $id,
                                        $patientName,
                                        $phoneNumber,
                                        $clinic,
                                        $unit,
                                        $bloodType,
                                        $requestDate,
                                        $requestStatus,
                                        $postedBy){

        $sql = "UPDATE r_request
                SET patient_name = ?, 
                    phone_number = ?, 
                    clinic = ?,
                    unit = ?, 
                    blood_type = ?, 
                    request_date = ?, 
                    request_status = ?,
                    posted_by = ?
                WHERE id = ?";
                
        $statement = $this->db->prepare($sql);
        $statement->bind_param('sssssssss', $patientName,
                                            $phoneNumber,
                                            $clinic,
                                            $unit,
                                            $bloodType,
                                            $requestDate,
                                            $requestStatus,
                                            $postedBy,
                                            $id);
        $executed = $statement->execute();
        return $executed;
    }

    public function deleteRequest ($id){

        $sql = "UPDATE r_request
                SET request_status = 'Deleted'
                WHERE id = ?";
                
        $statement = $this->db->prepare($sql);
        $statement->bind_param('s', $id);
        $executed = $statement->execute();
        return $executed;
    }

    public function getAllRequests(){
        $sql = "SELECT r_request.*, 
                    r_user.first_name,
                    r_user.last_name
                FROM r_request
                LEFT JOIN r_user
                    ON r_request.posted_by = r_user.id
                WHERE r_request.request_status <> 'Deleted' 
                ORDER BY r_request.request_date ASC";
        
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $dataset = $statement->get_result();
        return $dataset;
    }

    public function trackRequest($releaseNumber){
        $sql = "SELECT r_request.*
                FROM r_request
                WHERE r_request.request_status <> 'Deleted'
                    AND r_request.release_number = ?
                ORDER BY r_request.request_date ASC";
        
        $statement = $this->db->prepare($sql);
        $statement->bind_param('s', $releaseNumber);
        $statement->execute();
        $dataset = $statement->get_result();
        return $dataset;
    }

    public function filterDonations($category, 
                                    $type, 
                                    $status, 
                                    $batchStartDate, 
                                    $batchEndDate){
        switch($category){
            case "TBS":
                $sql = "SELECT r_donation.*, 
                            r_user.first_name,
                            r_user.last_name,
                            r_user.phone_number,
                            r_donor.gender,
                            r_donor.birth_date,
                            r_donor.blood_type 
                        FROM r_donation
                        LEFT JOIN r_donor
                            ON r_donation.id_donor = r_donor.id
                        LEFT JOIN r_user
                            ON r_donor.id_user = r_user.id
                        WHERE r_donation.donation_status <> 'Deleted' 
                        ORDER BY r_donation.donation_date ASC";
        
                $statement = $this->db->prepare($sql);
                break;

            case "TB":
                $sql = "SELECT r_donation.*, 
                            r_user.first_name,
                            r_user.last_name,
                            r_user.phone_number,
                            r_donor.gender,
                            r_donor.birth_date,
                            r_donor.blood_type 
                        FROM r_donation
                        LEFT JOIN r_donor
                            ON r_donation.id_donor = r_donor.id
                        LEFT JOIN r_user
                            ON r_donor.id_user = r_user.id
                        WHERE r_donation.donation_status <> 'Deleted'
                            AND  r_donation.donation_status = ?
                        ORDER BY r_donation.donation_date ASC";

                $statement = $this->db->prepare($sql);
                $statement->bind_param('s', $status);
                break;

            case "BS":
                $sql = "SELECT r_donation.*, 
                            r_user.first_name,
                            r_user.last_name,
                            r_user.phone_number,
                            r_donor.gender,
                            r_donor.birth_date,
                            r_donor.blood_type 
                        FROM r_donation
                        LEFT JOIN r_donor
                            ON r_donation.id_donor = r_donor.id
                        LEFT JOIN r_user
                            ON r_donor.id_user = r_user.id
                        WHERE r_donation.donation_status <> 'Deleted'
                            AND  r_donation.donation_type = ?
                        ORDER BY r_donation.donation_date ASC";

                $statement = $this->db->prepare($sql);
                $statement->bind_param('s', $type);
                break;
            case "TS":
                $sql = "SELECT r_donation.*, 
                            r_user.first_name,
                            r_user.last_name,
                            r_user.phone_number,
                            r_donor.gender,
                            r_donor.birth_date,
                            r_donor.blood_type 
                        FROM r_donation
                        LEFT JOIN r_donor
                            ON r_donation.id_donor = r_donor.id
                        LEFT JOIN r_user
                            ON r_donor.id_user = r_user.id
                        WHERE r_donation.donation_status <> 'Deleted'
                            AND  DATE(r_donation.donation_date) BETWEEN ? AND ?
                        ORDER BY r_donation.donation_date ASC";

                $statement = $this->db->prepare($sql);
                $statement->bind_param('ss', $batchStartDate, $batchEndDate);
                break;
            case "T":
                $sql = "SELECT r_donation.*, 
                            r_user.first_name,
                            r_user.last_name,
                            r_user.phone_number,
                            r_donor.gender,
                            r_donor.birth_date,
                            r_donor.blood_type 
                        FROM r_donation
                        LEFT JOIN r_donor
                            ON r_donation.id_donor = r_donor.id
                        LEFT JOIN r_user
                            ON r_donor.id_user = r_user.id
                        WHERE r_donation.donation_status = ?
                            AND  DATE(r_donation.donation_date) BETWEEN ? AND ?
                        ORDER BY r_donation.donation_date ASC";

                $statement = $this->db->prepare($sql);
                $statement->bind_param('sss', $status, $batchStartDate, $batchEndDate);
                break;
            case "B":
                $sql = "SELECT r_donation.*, 
                            r_user.first_name,
                            r_user.last_name,
                            r_user.phone_number,
                            r_donor.gender,
                            r_donor.birth_date,
                            r_donor.blood_type 
                        FROM r_donation
                        LEFT JOIN r_donor
                            ON r_donation.id_donor = r_donor.id
                        LEFT JOIN r_user
                            ON r_donor.id_user = r_user.id
                        WHERE r_donation.donation_status = ?
                            AND  r_donation.donation_type = ?
                        ORDER BY r_donation.donation_date ASC";

                $statement = $this->db->prepare($sql);
                $statement->bind_param('ss', $status, $type);
                break;
            case "S":
                $sql = "SELECT r_donation.*, 
                            r_user.first_name,
                            r_user.last_name,
                            r_user.phone_number,
                            r_donor.gender,
                            r_donor.birth_date,
                            r_donor.blood_type 
                        FROM r_donation
                        LEFT JOIN r_donor
                            ON r_donation.id_donor = r_donor.id
                        LEFT JOIN r_user
                            ON r_donor.id_user = r_user.id
                        WHERE r_donation.donation_type = ?
                            AND  DATE(r_donation.donation_date) BETWEEN ? AND ?
                        ORDER BY r_donation.donation_date ASC";

                $statement = $this->db->prepare($sql);
                $statement->bind_param('sss', $type, $batchStartDate, $batchEndDate);
                break;
            default:
                $sql = "SELECT r_donation.*, 
                            r_user.first_name,
                            r_user.last_name,
                            r_user.phone_number,
                            r_donor.gender,
                            r_donor.birth_date,
                            r_donor.blood_type 
                        FROM r_donation
                        LEFT JOIN r_donor
                            ON r_donation.id_donor = r_donor.id
                        LEFT JOIN r_user
                            ON r_donor.id_user = r_user.id
                        WHERE r_donation.donation_type = ?
                            AND  r_donation.donation_status = ? 
                            AND  DATE(r_donation.donation_date) BETWEEN ? AND ?
                        ORDER BY r_donation.donation_date ASC";

                $statement = $this->db->prepare($sql);
                $statement->bind_param('ssss', $type, $status, $batchStartDate, $batchEndDate);
                break;
        }
        $statement->execute();
        $dataset = $statement->get_result();
        return $dataset;
    }

} 