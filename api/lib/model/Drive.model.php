<?php
include_once(__DIR__ . "/../helper/DB.helper.php");
class Drive extends DBHelper{

    const ID = "id";   
    const ID_DONATION_DRIVE = "id_donation_drive";   
    const EVENT_TITLE = "event_title";
    const EVENT_DATE = "event_date";
    const EVENT_TIME = "event_time";
    const EVENT_LOCATION = "event_location";
    const PHOTO_FILENAME = "photo_filename";
    const PHOTO_FILE = "photo_file";
    const EVENT_DETAILS = "event_details";
    const POSTED_BY = "posted_by";    
    const DATETIME_ADDED = "datetime_added";
    /**
        @desc: Init class
    */
    public function __construct () {
        parent::__construct();
    }   

    public function addDonationDrive(   $eventTitle,
                                        $eventDate,
                                        $eventTime,
                                        $location,
                                        $photoFilename,
                                        $eventDetails,
                                        $postedBy){
        $sql = "INSERT INTO r_donation_drive(event_title, event_date, event_time, event_location, photo_filename, event_details, posted_by) 
                VALUES (?,?,?,?,?,?,?)";
                
        $statement = $this->db->prepare($sql);
        $statement->bind_param('ssssssi',   $eventTitle,
                                            $eventDate,
                                            $eventTime,
                                            $location,
                                            $photoFilename,
                                            $eventDetails,
                                            $postedBy);
        $executed = $statement->execute();
        return $executed;
    }

    public function getAllDonationDrives(){

        $sql = "SELECT r_donation_drive.*, 
                CONCAT(r_user.first_name,' ' , r_user.last_name) AS fullname
                FROM r_donation_drive
                LEFT JOIN r_user
                ON r_user.id = r_donation_drive.posted_by";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->get_result();
    }

    public function getDonationDrive( $id){

        $sql = "SELECT r_donation_drive.*, 
                CONCAT(r_user.first_name,' ' , r_user.last_name) AS fullname
                FROM r_donation_drive
                LEFT JOIN r_user
                ON r_user.id = r_donation_drive.posted_by 
                WHERE r_donation_drive.id = ?";
                
        $statement = $this->db->prepare($sql);
        $statement->bind_param("i", $id);
        $statement->execute();
        return $statement->get_result();
    }

    public function getParticipants($id){

        $sql = "SELECT r_donation_appointment.*,
                CONCAT(r_user.first_name, ' ', r_user.last_name) AS participant_fullname
                FROM r_donation_appointment
                LEFT JOIN r_donor
                ON r_donor.id = r_donation_appointment.id_donor
                LEFT JOIN r_user
                ON r_user.id = r_donor.id_user 
                WHERE id_donation_drive = ?";
        $statement = $this->db->prepare($sql);
        $statement->bind_param('i', $id);
        $statement->execute();
        return $statement->get_result();
    }

    public function updateDonationDrive($id,
                                        $eventTitle,
                                        $eventDate,
                                        $eventTime,
                                        $eventLocation,
                                        $eventDetails){

        $sql = "UPDATE r_donation_drive
                SET event_title = ?, event_date = ?, event_time = ?, event_location = ?, event_details =?
                WHERE id = ?";
        $statement = $this->db->prepare($sql);
        $statement->bind_param('sssssi', $eventTitle,
                                        $eventDate,
                                        $eventTime,
                                        $eventLocation,
                                        $eventDetails,
                                        $id);
        $executed = $statement->execute();
        return $executed;
    }

    public function deleteDonationDrive($id){

        $sql = "DELETE FROM r_donation_drive
                WHERE id = ?";
        $statement = $this->db->prepare($sql);
        $statement->bind_param('i', $id);
        $executed = $statement->execute();
        return $executed;
    }
}
?>