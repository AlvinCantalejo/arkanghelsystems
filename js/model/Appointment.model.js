//Donation enums
const ID = "id";
const ID_APPOINTMENT = "id_appointment";
const ID_DONOR = "id_donor";
const ID_DONATION_DRIVE = "id_donation_drive";
const APPOINTMENT_TYPE = "appointment_type";
const APPOINTMENT_DATE = "appointment_date";
const APPOINTMENT_LOCATION = "appointment_location";
const APPOINTMENT_STATUS = "appointment_status";
const DATETIME_ADDED = "datetime_added";

//APPOINTMENT TYPE Enums
const IN_HOUSE = "in-house";
const DONATION_DRIVE = "donation-drive";

class Appointment {
    static get ID(){                    return ID;                  }       
    static get ID_APPOINTMENT(){        return ID_APPOINTMENT       }
    static get ID_DONOR(){              return ID_DONOR;            }
    static get ID_DONATION_DRIVE(){     return ID_DONATION_DRIVE;   }
    static get APPOINTMENT_TYPE(){      return APPOINTMENT_TYPE;    }
    static get APPOINTMENT_DATE(){      return APPOINTMENT_DATE;    }
    static get APPOINTMENT_LOCATION() { return APPOINTMENT_LOCATION;}
    static get APPOINTMENT_STATUS() {   return APPOINTMENT_STATUS;  }
    static get DATETIME_ADDED() {       return DATETIME_ADDED;      }
    static get IN_HOUSE() {             return IN_HOUSE;            }
    static get DONATION_DRIVE() {       return DONATION_DRIVE;      }

}
    
export default Appointment