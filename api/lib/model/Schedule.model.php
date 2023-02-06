<?php
include_once(__DIR__ . "/../helper/DB.helper.php");
class Schedule extends DBHelper{

    const DATE = "date";   
    const TIME = "time";   
    const SLOTS = "slots";
    
    const TIME_SLOTS_ARRAY = array('9:00AM', "10:00AM", "11:00AM", "12:00PM", "1:00PM", "2:00PM");
    /**
        @desc: Init class
    */
    public function __construct () {
        parent::__construct();
        
    }

    public function getTimeSlots($date){

        $sql = "SELECT * FROM r_donation_schedule
        WHERE date = ?";
        
        $statement = $this->db->prepare($sql);
        $statement->bind_param('s', $date);
        $statement->execute();
        $dataset = $statement->get_result();
        if ($dataset->num_rows > 0){
            while ($row = $dataset->fetch_assoc()) {
                $time = $row['time'];
                $slots = $row['slots'];

                $data[$time] = $slots;
                $data["message"] = "Data found";
            }
            return array(true, $data);
        }else
            return array(false, null);
    }

    public function addNewDonationDate($date){
        $timeSlots = Schedule::TIME_SLOTS_ARRAY;

        foreach ($timeSlots as $time){
            $sql = "INSERT INTO r_donation_schedule(date, time) 
            VALUES (?,?)";
            
            $statement = $this->db->prepare($sql);
            $statement->bind_param('ss',$date,
                                        $time);
            $statement->execute();
        }
        return true;
    }

    

} 