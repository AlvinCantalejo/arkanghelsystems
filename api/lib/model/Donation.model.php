<?php
include_once(__DIR__ . "/../helper/DB.helper.php");
class Donation extends DBHelper{

    const ID = "id";    
    const ID_DONATION = "id_donation";    
    const ID_DONOR = "id_donor";   
    const ID_APPOINTMENT = "id_appointment";   
    const DONATION_TYPE = "donation_type";   
    const DONATION_DATE = "donation_date";
    const DONATION_LOCATION = "donation_location";
    const DONATION_STATUS = "donation_status";
    const PRC_PERSONNEL = "prc_personnel";
    const BLOOD_PRODUCT_NUMBER = "blood_product_number";
    const BLOOD_TYPE = "blood_type";
    const BATCH_START_DATE = "batch_start_date";
    const BATCH_END_DATE = "batch_end_date";
    const FILTER_CATEGORY = "filter_category";

    /**
        @desc: Init class
    */
    public function __construct () {
        parent::__construct();
    }

    public function remindDonors(){
        $sql = "SELECT r_user.*, r_donor.id AS id_donor 
                FROM r_user
                LEFT JOIN r_donor
                    ON r_user.id = r_donor.id_user
                LEFT JOIN r_donation
                    ON r_donation.id_donor = r_donor.id
                LEFT JOIN r_reminder
                    ON r_reminder.id_donor = r_donor.id
                WHERE r_donation.donation_date <= NOW() - INTERVAL 3 MONTH
                    AND r_user.email <> ''
                    AND r_reminder.is_reminded = 0";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $dataset = $statement->get_result();
        $this->userReminded();
        return $dataset;
    }

    public function userReminded(){
        $sql = "UPDATE r_reminder
                    SET is_reminded = 1
                WHERE is_reminded = 0";
        
        $statement = $this->db->prepare($sql);
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return;
    }
    public function addReminder( $idDonor){
        $sql = "INSERT INTO r_reminder
                    (id_donor)
                    VALUES(?)";
        
        $statement = $this->db->prepare($sql);
        $statement->bind_param('s',  $idDonor);
        $executed = $statement->execute();
        return $executed;
    }
    public function addNewDonation( $id,
                                    $idDonor,
                                    $donationType,
                                    $donationDate,
                                    $donationLocation,
                                    $donationStatus,
                                    $prcPersonnel,
                                    $bloodProductNumber){

        $sql = "INSERT INTO r_donation
                (id, id_donor, donation_type, donation_date, donation_location, donation_status, prc_personnel, blood_product_number)
                VALUES(?,?,?,?,?,?,?,?)";
                
        $statement = $this->db->prepare($sql);
        $statement->bind_param('ssssssss',  $id,
                                            $idDonor,
                                            $donationType,
                                            $donationDate,
                                            $donationLocation,
                                            $donationStatus,
                                            $prcPersonnel,
                                            $bloodProductNumber);
        $executed = $statement->execute();
        $this->addReminder($idDonor);
        return $executed;
    }

    public function updateDonation ($id,
                                    $idDonor,
                                    $bloodType,
                                    $donationType,
                                    $donationDate,
                                    $donationLocation,
                                    $donationStatus,
                                    $prcPersonnel,
                                    $bloodProductNumber){

        $sql = "UPDATE r_donation
                SET donation_type = ?,
                    donation_date = ?,
                    donation_location = ?,
                    donation_status = ?,
                    prc_personnel = ?,
                    blood_product_number = ?
                WHERE id = ?";
                
        $statement = $this->db->prepare($sql);
        $statement->bind_param('sssssss',   $donationType,
                                            $donationDate,
                                            $donationLocation,
                                            $donationStatus,
                                            $prcPersonnel,
                                            $bloodProductNumber,
                                            $id);
        $executed = $statement->execute();
        $this->updateDonorInfo($idDonor, $bloodType);
        return $executed;
    }

    public function deleteDonation ($id){

        $sql = "UPDATE r_donation
                SET donation_status = 'Deleted'
                WHERE id = ?";
                
        $statement = $this->db->prepare($sql);
        $statement->bind_param('s', $id);
        $executed = $statement->execute();
        return $executed;
    }

    public function updateDonorInfo($idDonor, $bloodType){
        $sql = "UPDATE r_donor
                SET blood_type = ?
                WHERE id = ?";
                
        $statement = $this->db->prepare($sql);
        $statement->bind_param('ss',$bloodType, $idDonor);
        $statement->execute();
    }

    public function getAllDonations(){
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
        $statement->execute();
        $dataset = $statement->get_result();
        return $dataset;
    }

    public function getDonations( $idDonor){
        $sql = "SELECT r_donation.*, 
                        COUNT(DISTINCT IF ( r_donation.donation_status = 'Successful',
                                            r_donation.donation_status, NULL))  AS donation_count,
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
                            AND r_donor.id = ?
                        ORDER BY r_donation.donation_date ASC";
        
        $statement = $this->db->prepare($sql);
        $statement->bind_param('s', $idDonor);
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