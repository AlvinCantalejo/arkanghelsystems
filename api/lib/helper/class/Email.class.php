<?php 


class EmailClass{

    var $EMAIL_TYPE_REGISTRATION = "registration";
    var $EMAIL_TYPE_APPOINTMENT = "appointment";
    var $EMAIL_TYPE_DRIVE_REGISTRATION = "drive-registration";
    var $EMAIL_TYPE_RESCHEDULE_APPOINTMENT = "reschedule-appointment";
    var $EMAIL_TYPE_CANCEL_APPOINTMENT = "cancel-appointment";
    var $EMAIL_TYPE_REMINDER = "reminder";
    
    
    function __construct () {
    }

    public function createEmailBody($emailType, $Name, $AdditionalDetails=""){
        switch($emailType){
            case $this->EMAIL_TYPE_REGISTRATION:
                return "<h1>Welcome to redLifeph <strong>" . $Name ."</strong>!</h1><br>"
                ."Your journey as a life saver starts here! <br>"
                ."Login now to continue with your first appointment. Thank you! <br>"
                .$AdditionalDetails
                ."<br><strong>-redLifeph</strong>";
                break;
            case $this->EMAIL_TYPE_APPOINTMENT:
                return "<h3>Greetings of Peace and Humanity, <strong>" . $Name ."</strong>!</h3><br>"
                ."Your appointment is scheduled successfully. <br>"
                ."Here is the summary of your appointment: <br><br>"
                ." <strong>Appointment ID:</strong> " . $AdditionalDetails['id']."<br>"
                ." <strong>Date:</strong> " . $AdditionalDetails['appointment_date']."<br>"
                ." <strong>Time: </strong> " . $AdditionalDetails['appointment_time']."<br>"
                ." <strong>Donation Center:</strong> " . $AdditionalDetails['appointment_location']."<br>"
                ." <strong>Address:</strong> Philippine Red Cross - Cavite Chapter Dasmariñas Branch, Emilio Aguinaldo Highway, Dasmarinas City, Cavite, Philippines<br><br>"
                ."Learn more about blood donation, do's and dont's and many more <a href='https://redlifeph.xyz/learn.php'>here</a>. <br>"
                ."Thank you and see you there, life saver!"
                ."<br><strong>-redLifeph</strong>";
                break;
            case $this->EMAIL_TYPE_DRIVE_REGISTRATION:
                return "<h3>Greetings of Peace and Humanity, <strong>" . $Name ."</strong>!</h3><br>"
                ."Your registration is successful. <br>"
                ."Here is the summary of the event: <br><br>"
                ." <strong>Event Title:</strong> " . $AdditionalDetails['event_title']."<br>"
                ." <strong>Date:</strong> " . $AdditionalDetails['appointment_date']."<br>"
                ." <strong>Time: </strong> " . $AdditionalDetails['appointment_time']."<br>"
                ." <strong>Venue:</strong> " . $AdditionalDetails['appointment_location']."<br>"
                ." <strong>Details:</strong> " . $AdditionalDetails['event_details']."<br>"
                ."Learn more about blood donation, do's and dont's and many more <a href='https://redlifeph.xyz/learn.php'>here</a>. <br>"
                ."Thank you and see you there, life saver!"
                ."<br><strong>-redLifeph</strong>";
                break;
            case $this->EMAIL_TYPE_RESCHEDULE_APPOINTMENT:
                return "<h3>Greetings of Peace and Humanity, <strong>" . $Name ."</strong>!</h3><br>"
                ."Your appointment is rescheduled successfully. <br>"
                ."Here is the summary of your new appointment: <br><br>"
                ." <strong>Appointment ID:</strong> " . $AdditionalDetails['id']."<br>"
                ." <strong>Date:</strong> " . $AdditionalDetails['appointment_date']."<br>"
                ." <strong>Time: </strong> " . $AdditionalDetails['appointment_time']."<br>"
                ." <strong>Donation Center:</strong> " . $AdditionalDetails['appointment_location']."<br>"
                ." <strong>Address:</strong> Philippine Red Cross - Cavite Chapter Dasmariñas Branch, Emilio Aguinaldo Highway, Dasmarinas City, Cavite, Philippines<br><br>"
                ."Learn more about blood donation, do's and dont's and many more <a href='https://redlifeph.xyz/learn.php'>here</a>. <br>"
                ."Thank you and see you there, life saver!"
                ."<br><strong>-redLifeph</strong>";
                break;
            case $this->EMAIL_TYPE_CANCEL_APPOINTMENT:
                return "<h3>Greetings of Peace and Humanity, <strong>" . $Name ."</strong>!</h3><br>"
                ."Your appointment is cancelled. <br>"
                ."Here is the summary of appointment you cancelled: <br><br>"
                ." <strong>Appointment ID:</strong> " . $AdditionalDetails['id']."<br>"
                ." <strong>Date:</strong> " . $AdditionalDetails['appointment_date']."<br>"
                ." <strong>Time: </strong> " . $AdditionalDetails['appointment_time']."<br>"
                ." <strong>Donation Center:</strong> " . $AdditionalDetails['appointment_location']."<br>"
                ." <strong>Address:</strong> Philippine Red Cross - Cavite Chapter Dasmariñas Branch, Emilio Aguinaldo Highway, Dasmarinas City, Cavite, Philippines<br><br>"
                ."Learn more about blood donation, do's and dont's and many more <a href='https://redlifeph.xyz/learn.php'>here</a>. <br>"
                ."Thank you for your good deeds, life saver!"
                ."<br><strong>-redLifeph</strong>";
                break;
            case $this->EMAIL_TYPE_REMINDER:
                return "<h3>Greetings of Peace and Humanity, <strong>" . $Name ."</strong>!</h3><br>"
                ."We hope that you are in the good health! <br>"
                ."We would like to let you know that you can donate blood again.<br><br>"
                ."Learn more about blood donation, do's and dont's and many more <a href='https://redlifeph.xyz/learn.php'>here</a>. <br>"
                ."Thank you for your good deeds, life saver!"
                ."<br><strong>-redLifeph</strong>";
                break;
        }   

    }
}

?>