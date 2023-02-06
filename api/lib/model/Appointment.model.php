<?php
include_once(__DIR__ . "/../helper/DB.helper.php");
class Appointment extends DBHelper{

    const ID = "id";   
    const ID_APPOINTMENT = "id_appointment";   
    const ID_DONOR = "id_donor";   
    const ID_DONATION_DRIVE = "id_donation_drive";   
    const APPOINTMENT_TYPE = "appointment_type";
    const APPOINTMENT_DATE = "appointment_date";
    const APPOINTMENT_TIME = "appointment_time";
    const APPOINTMENT_LOCATION = "appointment_location";
    const APPOINTMENT_STATUS = "appointment_status";

    const TIME_COUNTER = "time_counter";
    /**
        @desc: Init class
    */
    public function __construct () {
        parent::__construct();
    }

    public function addNewAppointment(  $id,
                                        $idDonor,
                                        $idDonationDrive,
                                        $appointmentType,
                                        $appointmentDate,
                                        $appointmentTime,
                                        $appointmentLocation){

        $sql = "INSERT INTO r_donation_appointment
                (id, id_donor, id_donation_drive, appointment_type, appointment_date, appointment_time, appointment_location)
                VALUES(?,?,?,?,?,?,?)";
                
        $statement = $this->db->prepare($sql);
        $statement->bind_param('ssissss',$id,
                                        $idDonor,
                                        $idDonationDrive,
                                        $appointmentType,
                                        $appointmentDate,
                                        $appointmentTime,
                                        $appointmentLocation);
        $executed = $statement->execute();
        if($appointmentType == "in-house"){
            Appointment::decrementSlot($appointmentDate,$appointmentTime);
        }  
        return $executed;
    }

    public function rescheduleAppointment(  $appointmentDate,
                                            $appointmentTime,
                                            $appointmentLocation,
                                            $id){

        $sql = "UPDATE r_donation_appointment 
                SET appointment_date = ?, 
                    appointment_time = ?, 
                    appointment_location = ? 
                WHERE id = ?";
                
        $statement = $this->db->prepare($sql);
        $statement->bind_param('ssss',  $appointmentDate,
                                        $appointmentTime,
                                        $appointmentLocation,
                                        $id);
        $executed = $statement->execute();

        Appointment::decrementSlot($appointmentDate,$appointmentTime);
        return $executed;
    }

    public function cancelAppointment($id){
        $status = "Cancelled";
        $sql = "UPDATE r_donation_appointment 
                SET appointment_status = ? 
                WHERE id = ?";
                
        $statement = $this->db->prepare($sql);
        $statement->bind_param('ss',$status, $id);
        $executed = $statement->execute();
        return $executed;
    }

    public function successAppointment($id){
        $status = "Success";
        $sql = "UPDATE r_donation_appointment 
                SET appointment_status = ? 
                WHERE id = ?";
                
        $statement = $this->db->prepare($sql);
        $statement->bind_param('ss',$status, $id);
        $executed = $statement->execute();
        return $executed;
    }

    public function decrementSlot($appointmentDate,$appointmentTime){

        $sql = "UPDATE r_donation_schedule 
                SET slots = slots - 1
                WHERE date = ?
                AND time = ?;";
                
        $statement = $this->db->prepare($sql);
        $statement->bind_param('ss',$appointmentDate, $appointmentTime);
        $statement->execute();
    }

    public function doesScheduleDateExists($date){

        $sql = "SELECT * FROM r_appointment_schedule
                WHERE date = ?";
                
        $statement = $this->db->prepare($sql);
        $statement->bind_param('s',$date);
        $statement->execute();
        $dataset = $statement->get_result();
        return $dataset;
    }

    public function hasActiveAppointment($idDonor){
        $status = "Active";
        $sql = "SELECT id FROM r_donation_appointment
                WHERE id_donor = ?
                AND appointment_status = ?";
                
        $statement = $this->db->prepare($sql);
        $statement->bind_param('ss',$idDonor, $status);
        $statement->execute();
        $dataset = $statement->get_result();
        return $dataset;
    }

    public function addNewSchedule($date, $time){

        $sql = "INSERT INTO r_appointment_schedule(date, time) 
                VALUES (?,?)";
                
        $statement = $this->db->prepare($sql);
        $statement->bind_param('ss',$date,
                                    $time);
        $executed = $statement->execute();
        return $executed;
    }

    public function getAppointment( $id){

        $status = "Active";
        $sql = "SELECT  r_donation_appointment.*, 
                        r_user.first_name, 
                        r_user.last_name,
                        r_user.phone_number,
                        r_donor.blood_type,
                        r_donor.birth_date,
                        r_donor.gender
                FROM r_donation_appointment
                LEFT JOIN r_donor
                    ON r_donation_appointment.id_donor = r_donor.id
                LEFT JOIN r_user
                    ON r_donor.id_user = r_user.id
                WHERE r_donation_appointment.id = ?
                AND r_donation_appointment.appointment_status = ?
                ORDER BY r_donation_appointment.appointment_date ASC";
        
        $statement = $this->db->prepare($sql);
        $statement->bind_param('ss', $id, $status);
        $statement->execute();
        $dataset = $statement->get_result();
        return $dataset;
    }

    public function getAllAppointments(){
        $status = "Active";
        $sql = "SELECT r_donation_appointment.*, 
                    CONCAT(r_user.first_name, ' ', r_user.last_name) as fullname,
                    r_donor.blood_type 
                FROM r_donation_appointment
                LEFT JOIN r_donor
                    ON r_donation_appointment.id_donor = r_donor.id
                LEFT JOIN r_user
                    ON r_donor.id_user = r_user.id
                WHERE r_donation_appointment.appointment_status = ?
                ORDER BY r_donation_appointment.appointment_date ASC";
        
        $statement = $this->db->prepare($sql);
        $statement->bind_param('s', $status);
        $statement->execute();
        $dataset = $statement->get_result();
        return $dataset;
    }

    public function filterAppointments( $type, $status){

        if($type == "all"){    // All type is selected
            if($status == "all"){
                $sql = "SELECT r_donation_appointment.*, 
                        CONCAT(r_user.first_name, ' ', r_user.last_name) as fullname,
                        r_donor.blood_type 
                        FROM r_donation_appointment
                        LEFT JOIN r_donor
                        ON r_donation_appointment.id_donor = r_donor.id
                        LEFT JOIN r_user
                        ON r_donor.id_user = r_user.id";
                $statement = $this->db->prepare($sql);
                $statement->execute();
                $dataset = $statement->get_result();
                return $dataset;
            }else{  
                $sql = "SELECT r_donation_appointment.*, 
                        CONCAT(r_user.first_name, ' ', r_user.last_name) as fullname,
                        r_donor.blood_type 
                        FROM r_donation_appointment
                        LEFT JOIN r_donor
                        ON r_donation_appointment.id_donor = r_donor.id
                        LEFT JOIN r_user
                        ON r_donor.id_user = r_user.id
                        WHERE r_donation_appointment.appointment_status = ?";
                $statement = $this->db->prepare($sql);
                $statement->bind_param('s', $status);
                $statement->execute();
                $dataset = $statement->get_result();
                return $dataset;
            }
        }
        else{   //Donation Drive type is selected

            if($status == "all"){
                $sql = "SELECT r_donation_appointment.*, 
                        CONCAT(r_user.first_name, ' ', r_user.last_name) as fullname,
                        r_donor.blood_type 
                        FROM r_donation_appointment
                        LEFT JOIN r_donor
                        ON r_donation_appointment.id_donor = r_donor.id
                        LEFT JOIN r_user
                        ON r_donor.id_user = r_user.id
                        WHERE r_donation_appointment.appointment_type = ?";
                $statement = $this->db->prepare($sql);
                $statement->bind_param('s', $type);
                $statement->execute();
                $dataset = $statement->get_result();
                return $dataset;
            }else{
                $sql = "SELECT r_donation_appointment.*, 
                        CONCAT(r_user.first_name, ' ', r_user.last_name) as fullname,
                        r_donor.blood_type 
                        FROM r_donation_appointment
                        LEFT JOIN r_donor
                        ON r_donation_appointment.id_donor = r_donor.id
                        LEFT JOIN r_user
                        ON r_donor.id_user = r_user.id
                        WHERE r_donation_appointment.appointment_status = ?
                        AND r_donation_appointment.appointment_type = ?";
            $statement = $this->db->prepare($sql);
            $statement->bind_param('ss', $status, $type);
            $statement->execute();
            $dataset = $statement->get_result();
            return $dataset;
            }
        }
    }

    public function filterInHouseAppointments(  $case,
                                                $date,
                                                $time,
                                                $status){

        $type = "in-house";

        switch($case){
            case 'DTS':
                $sql = "SELECT r_donation_appointment.*, 
                        CONCAT(r_user.first_name, ' ', r_user.last_name) as fullname,
                        r_donor.blood_type 
                        FROM r_donation_appointment
                        LEFT JOIN r_donor
                        ON r_donation_appointment.id_donor = r_donor.id
                        LEFT JOIN r_user
                        ON r_donor.id_user = r_user.id
                        WHERE r_donation_appointment.appointment_type = ?";

                $statement = $this->db->prepare($sql);
                $statement->bind_param('s', $type);
                $statement->execute();
                $dataset = $statement->get_result();
                return $dataset;
                break;

            case 'DT':
                $sql = "SELECT r_donation_appointment.*, 
                        CONCAT(r_user.first_name, ' ', r_user.last_name) as fullname,
                        r_donor.blood_type 
                        FROM r_donation_appointment
                        LEFT JOIN r_donor
                        ON r_donation_appointment.id_donor = r_donor.id
                        LEFT JOIN r_user
                        ON r_donor.id_user = r_user.id 
                        WHERE r_donation_appointment.appointment_status = ? 
                        AND r_donation_appointment.appointment_type = ?";

                $statement = $this->db->prepare($sql);
                $statement->bind_param('ss', $status, $type);
                $statement->execute();
                $dataset = $statement->get_result();
                return $dataset;
                break;

            case 'TS':
                $sql = "SELECT r_donation_appointment.*, 
                        CONCAT(r_user.first_name, ' ', r_user.last_name) as fullname,
                        r_donor.blood_type 
                        FROM r_donation_appointment
                        LEFT JOIN r_donor
                        ON r_donation_appointment.id_donor = r_donor.id
                        LEFT JOIN r_user
                        ON r_donor.id_user = r_user.id
                        WHERE r_donation_appointment.appointment_date = ?
                        AND r_donation_appointment.appointment_type = ?";

                $statement = $this->db->prepare($sql);
                $statement->bind_param('ss', $date, $type);
                $statement->execute();
                $dataset = $statement->get_result();
                return $dataset;
                break;

            case 'DS':
                $sql = "SELECT r_donation_appointment.*, 
                        CONCAT(r_user.first_name, ' ', r_user.last_name) as fullname,
                        r_donor.blood_type 
                        FROM r_donation_appointment
                        LEFT JOIN r_donor
                        ON r_donation_appointment.id_donor = r_donor.id
                        LEFT JOIN r_user
                        ON r_donor.id_user = r_user.id
                        WHERE r_donation_appointment.appointment_time = ?
                        AND r_donation_appointment.appointment_type = ?;";

                $statement = $this->db->prepare($sql);
                $statement->bind_param('ss', $time, $type);
                $statement->execute();
                $dataset = $statement->get_result();
                return $dataset;
                break;

            case 'D':
                $sql = "SELECT r_donation_appointment.*, 
                        CONCAT(r_user.first_name, ' ', r_user.last_name) as fullname,
                        r_donor.blood_type 
                        FROM r_donation_appointment
                        LEFT JOIN r_donor
                        ON r_donation_appointment.id_donor = r_donor.id
                        LEFT JOIN r_user
                        ON r_donor.id_user = r_user.id
                        WHERE r_donation_appointment.appointment_time = ? 
                        AND r_donation_appointment.appointment_status = ?
                        AND r_donation_appointment.appointment_type = ?";

                $statement = $this->db->prepare($sql);
                $statement->bind_param('sss', $time, $status, $type);
                $statement->execute();
                $dataset = $statement->get_result();
                return $dataset;
                break;

            case 'T':
                $sql = "SELECT r_donation_appointment.*, 
                        CONCAT(r_user.first_name, ' ', r_user.last_name) as fullname,
                        r_donor.blood_type 
                        FROM r_donation_appointment
                        LEFT JOIN r_donor
                        ON r_donation_appointment.id_donor = r_donor.id
                        LEFT JOIN r_user
                        ON r_donor.id_user = r_user.id
                        WHERE r_donation_appointment.appointment_date = ? 
                        AND r_donation_appointment.appointment_status = ? 
                        AND r_donation_appointment.appointment_type = ?";
        
                $statement = $this->db->prepare($sql);
                $statement->bind_param('sss', $date, $status, $type);
                $statement->execute();
                $dataset = $statement->get_result();
                return $dataset;
                break;

            case 'S':
                $sql = "SELECT r_donation_appointment.*, 
                        CONCAT(r_user.first_name, ' ', r_user.last_name) as fullname,
                        r_donor.blood_type 
                        FROM r_donation_appointment
                        LEFT JOIN r_donor
                        ON r_donation_appointment.id_donor = r_donor.id
                        LEFT JOIN r_user
                        ON r_donor.id_user = r_user.id
                        WHERE r_donation_appointment.appointment_time = ?
                        AND r_donation_appointment.appointment_date = ?
                        AND r_donation_appointment.appointment_type = ?";
        
                $statement = $this->db->prepare($sql);
                $statement->bind_param('sss', $time, $date, $type);
                $statement->execute();
                $dataset = $statement->get_result();
                return $dataset;
                break;

            case "":
                $sql = "SELECT r_donation_appointment.*, 
                        CONCAT(r_user.first_name, ' ', r_user.last_name) as fullname,
                        r_donor.blood_type 
                        FROM r_donation_appointment
                        LEFT JOIN r_donor
                        ON r_donation_appointment.id_donor = r_donor.id
                        LEFT JOIN r_user
                        ON r_donor.id_user = r_user.id
                        WHERE r_donation_appointment.appointment_time = ?
                        AND r_donation_appointment.appointment_date = ?
                        AND r_donation_appointment.appointment_type = ?
                        AND r_donation_appointment.appointment_status = ?";

                $statement = $this->db->prepare($sql);
                $statement->bind_param('ssss', $time, $date, $type, $status);
                $statement->execute();
                $dataset = $statement->get_result();
                return $dataset;
                break;
        }
    }

    public function getAppointments($idDonor){
        $status = "Active";
        $sql = "SELECT * FROM r_donation_appointment
                WHERE id_donor = ?
                AND appointment_status = ?";
                
        $statement = $this->db->prepare($sql);
        $statement->bind_param('ss',$idDonor, $status);
        $statement->execute();
        $dataset = $statement->get_result();
        return $dataset;
    }

    public function getDriveRegistration($idDonor){
        $status = "Active";
        $sql = "SELECT id_donation_drive AS id 
                FROM r_donation_appointment
                WHERE id_donor = ?
                AND  id_donation_drive <> 0 
                AND appointment_status = ?";
                
        $statement = $this->db->prepare($sql);
        $statement->bind_param('ss',$idDonor, $status);
        $statement->execute();
        $dataset = $statement->get_result();
        return $dataset;
    }

} 