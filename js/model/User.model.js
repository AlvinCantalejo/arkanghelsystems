//User enums
const ID = "id";
const ID_DONOR = "id_donor";
const EMAIL = "email";
const FIRST_NAME = "first_name";
const LAST_NAME = "last_name";
const PHONE_NUMBER = "phone_number";
const TOKEN = "token";
const USER_ROLE = "user_role";
const BLOOD_TYPE = "blood_type";
const GENDER = "gender";
const BIRTH_DATE = "birth_date";

const ADMIN = "Admin";
const USER = "User";

class User {
    static get ID(){            return ID;              }       
    static get ID_DONOR(){      return ID_DONOR;        }       
    static get EMAIL(){         return EMAIL;           }
    static get FIRST_NAME(){    return FIRST_NAME;      }
    static get LAST_NAME(){     return LAST_NAME;       }
    static get PHONE_NUMBER(){  return PHONE_NUMBER;    }
    static get TOKEN() {        return TOKEN;           }
    static get USER_ROLE() {    return USER_ROLE;       }
    static get ADMIN() {        return ADMIN;           }
    static get USER() {         return USER;            }
    static get BLOOD_TYPE() {   return BLOOD_TYPE;      }
    static get GENDER() {       return GENDER;          }
    static get BIRTH_DATE() {   return BIRTH_DATE;      }

}
    
export default User