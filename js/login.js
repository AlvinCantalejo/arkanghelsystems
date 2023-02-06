import App from "./class/App.class.js";
import CookieClass from "./class/Cookie.class.js";

$(document).ready(function() {
   toggleAlert();
   bindActionButtons();
});

function toggleAlert(){
    if(window.location.href.includes("#registration-successful")){
        App.validateAlertModal("Registered successfully!", "success");
    } 
}

function bindActionButtons(){

    
    $(".open-register-form").on("click", function(e){

        window.location.href = "./register.php";
    });

    $(".btn-login").on("click", function(e){
        e.preventDefault();

        var errorMessage = $("#error-message");
        var username = $("#username").val();
        var password = $("#password").val();
        
        var apiURL = App.getApiUrl();
        var endpoint = "user/login";
        var parameters = {
            "username": username,
            "password": password
        };
        var api = apiURL + endpoint;
        if(username != "" && password !="")
        {
            $.ajax({
                url: api,
                type: 'POST',
                data: parameters,
                success: function (data) { 
                    CookieClass.createCookie(data);
                    console.log("Login Success");
                    
                },
                error: function (error) { 
                    errorMessage.text("Wrong email or password!");
                    console.log(error);
                }
            });
        }
        else{
            errorMessage.text("All fields are required!");
        }
    });
    
}
    
    
