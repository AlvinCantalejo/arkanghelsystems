//User enums
const ID = "id";
const FULL_NAME = "full_name"; 
const EMAIL_ADDRESS = "email_address";
const USERNAME = "username";
const TOKEN = "token";
const ROLE = "role";
const DEL = "del";
const DATE_ADDED = "date_added";

const ADMIN = "Admin";

class User {
    static get ID(){            return ID;              }       
    static get FULL_NAME(){     return FULL_NAME;       }       
    static get EMAIL_ADDRESS(){ return EMAIL_ADDRESS;   }       
    static get USERNAME(){      return USERNAME;        }       
    static get TOKEN(){         return TOKEN;           }       
    static get ROLE(){          return ROLE;            }       
    static get DEL(){           return DEL;             }       
    static get ADMIN(){         return ADMIN;           }       

}
    
export default User