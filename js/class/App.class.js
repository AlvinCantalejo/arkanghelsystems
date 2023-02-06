import CookieClass from "./Cookie.class.js";
import ButtonHelper from "./Button.class.js";
import User from "./../model/User.model.js";

class App {
    
    //API URL
    static getApiUrl (){
        return "http://localhost/arkanghelsystems/api/";
    }
    
    //CHECK IF LOGGED IN
    static checkIfLoggedIn (userRole){
        var apiURL = App.getApiUrl();
        var endpoint = "user/check-if-logged-in";
        var api = apiURL + endpoint;
       
        $.ajax({
            url: api,
            type: 'POST',
            success: function (data) { 
                return true;
            },
            error: function (error) { 
                if(userRole == User.ADMIN)
                    window.location.href = "/login.php";
            }
        });
    }
    
    static handlePageRestore () {
        window.addEventListener( "pageshow", function ( event ) {
            var historyTraversal = event.persisted;
            if ( historyTraversal ) {
              // Handle page restore
              window.location.reload();
            }
        });
    }

    static searchBar(){
        $(".search").on("keyup", function() {
            var input = $(this).val().toLowerCase();
            var rows = $("tbody tr");
            rows.filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(input) > -1);
            });
        });
    }
    //VALIDATE PHONE NUMBER
    static checkPhoneNumber(phoneNumber){

        let phoneNumberFormat = /^\(?([0-9]{4})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    
        if(phoneNumber.match(phoneNumberFormat))
            return true;
        else
            return false;
    }

    //VALIDATE EMAIL
    static checkEmail(email){
    
        let mailformat = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    
        if(email.match(mailformat))
            return true;
        else
            return false;
    }

    //VALIDATE PASSWORD
    static checkPassword (password) {
        
        let checker=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
        
        if(password.match(checker))
            return true;
        else
            return false;
    }

    //VALIDATE USER UPON LOGIN            
    static redirectUser(){
        let role = CookieClass.getCookie(User.ROLE);
        if(role == "Admin"){
            window.location.href = "module/admin/index.php";
        }
    }

    //CONVERT FORM DATA TO OBJECT
    static objectConverter(data){
        var obj={};
        for(var key in data){
            obj[data[key].split("=")[0]] = decodeURIComponent(data[key].split("=")[1]);
        }
        return obj;
    }

    static stringifyDate(date){
        return new Date(new Date(date.replace(/-/g,"/"))).toDateString();
    }

    static index(id,array){
        let index = array.findIndex(current => current.id == id);
        let temp = array[index];
        return temp;
    }

    //VALIUDATE ALERT MODALS
    static validateAlertModal(message, action){

        var alertStyle;
        var title;
        var TIME_IN_MILLISECONDS = 2000;

        if (action == "success"){
            alertStyle = "alert alert-success";
            title = "Success!";
        }
        else if (action == "failed"){
            alertStyle = "alert alert-danger";
            title = "Failed!";
        }

        $("#alert").attr("class", alertStyle);
        $("#alert").html(ButtonHelper.alertMessage(message, title));
        $('#alert-modal').modal('show');
        setTimeout(function() {
            $('#alert-modal').modal('hide');
        }, TIME_IN_MILLISECONDS);

    }
}

export default App 