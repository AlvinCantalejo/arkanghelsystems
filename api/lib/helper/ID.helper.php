<?php
/**
    @desc: ID helper
 */

class IDHelper
{
    /**
     * Generate initials from a name
     *
     * @param string $name
     * @return string
     */
    static function generateDonorID(string $name) : string
    {   
        //Generate a 3-digit random number.
        $RANDOM_NUMBER_MIN = 100;
        $RANDOM_NUMBER_MAX = 999;
        $randomNumber = rand($RANDOM_NUMBER_MIN, $RANDOM_NUMBER_MAX);

        $words = explode(' ', $name);
        if (count($words) >= 2) {
            $initials = mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8') . 
                mb_substr(end($words), 0, 1, 'UTF-8'), 
            'UTF-8');
        }
        $initials = IDHelper::makeInitialsFromSingleWord($name);
        date_default_timezone_set('Asia/Manila');
        $date = date('Ymd');

        $donorID = $initials . "-" . $date . "-" . $randomNumber;
        return $donorID;

    }



    /**
     * Make initials from a word with no spaces
     *
     * @param string $name
     * @return string
     */
    static function makeInitialsFromSingleWord(string $name) : string
    {
        preg_match_all('#([A-Z]+)#', $name, $capitals);
        if (count($capitals[1]) >= 2) {
            return mb_substr(implode('', $capitals[1]), 0, 2, 'UTF-8');
        }
        return mb_strtoupper(mb_substr($name, 0, 2, 'UTF-8'), 'UTF-8');
    }

    /**
     * Make initials from a word with no spaces
     *
     * @param string $name
     * @return string
     */
    static function cleanStringDate(string $date) : string
    {
        return str_replace('-', '', $date);  
        
    }

    static function generateAppointmentID() : string
    {   
        //Generate a 3-digit random number.
        $RANDOM_NUMBER_MIN = 100;
        $RANDOM_NUMBER_MAX = 999;
        $randomNumber = rand($RANDOM_NUMBER_MIN, $RANDOM_NUMBER_MAX);

        date_default_timezone_set('Asia/Manila');
        $date = date('Ymd');

        $donorID = $date . "-" . $randomNumber;
        return $donorID;

    }

    static function generateDonationID() : string
    {   
        //Generate a 3-digit random number.
        $RANDOM_NUMBER_MIN = 100;
        $RANDOM_NUMBER_MAX = 999;
       // $LENGTH = 5;

        $randomNumber = rand($RANDOM_NUMBER_MIN, $RANDOM_NUMBER_MAX);
        //$randomletter = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $LENGTH);
        date_default_timezone_set('Asia/Manila');
        $date = date('Ymd');

        $donationID = $date . "-WB-" . $randomNumber;
        return $donationID;

    }

    static function generateReleaseNumber() : string
    {   
        //Generate a 3-digit random number.
        $RANDOM_NUMBER_MIN = 100;
        $RANDOM_NUMBER_MAX = 999;
       // $LENGTH = 5;

        $randomNumber = rand($RANDOM_NUMBER_MIN, $RANDOM_NUMBER_MAX);
        //$randomletter = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $LENGTH);
        date_default_timezone_set('Asia/Manila');
        $date = date('ym');

        $releaseNumber = "R-". $date . "-WB-" . $randomNumber;
        return $releaseNumber;

    }

    static function generateReportID($type) : string
    {   
        //Generate a 3-digit random number.
        $RANDOM_NUMBER_MIN = 100;
        $RANDOM_NUMBER_MAX = 999;
       // $LENGTH = 5;

        $randomNumber = rand($RANDOM_NUMBER_MIN, $RANDOM_NUMBER_MAX);
        //$randomletter = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $LENGTH);
        date_default_timezone_set('Asia/Manila');
        $date = date('ym');

        $releaseNumber = "R-". $type . "-" .$date . "-" . $randomNumber;
        return $releaseNumber;

    }
}