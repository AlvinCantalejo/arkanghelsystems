import App from "./class/App.class.js";
import CookieClass from "./class/Cookie.class.js";

$(document).ready(function() {
    bindActionButtons();
});

function bindActionButtons(){

    $(".open-login-form").on("click", function(e){
        e.preventDefault();
        window.location.href = "./login.php";
    });
    
    $(".btn-register").on("click", function(e){
        e.preventDefault();
        

        var form = $("form#registration-form");
        var data = form.serialize().split("&");
        var formData = App.objectConverter(data);
        register(formData);
    });
}

var errorMessage = $("#error-message");

function register(formData){
    
    let error = validateFormData(formData);
    if (error != "") 
        errorMessage.text(error);
    else {
        errorMessage.text("");
        var apiURL = App.getApiUrl();
        var endpoint = "user/register";
        var api = apiURL + endpoint;
        $.ajax({
            url: api,
            type: 'POST',
            data: formData,
            success: function (data) { 
                window.location.href = "./login.php#registration-successful";
            },
            error: function (error) { 
                window.location.href = "./login.php#registration-successful";
            }
        });
    }
}

//VALIDATE REGISTRATION FORM DATA
function validateFormData(formData) {
    let error = "";
    let phoneNumber = App.checkPhoneNumber(formData.phone_number);
    let email = App.checkEmail(formData.email);
    let password = App.checkPassword(formData.password);

    if (
        formData.first_name == "" ||
        formData.last_name == "" ||
        formData.email == "" ||
        formData.password == "" ||
        formData.repeat_password == "" ||
        formData.birth_date == "" ||
        formData.gender == "" ||
        formData.phone_number == ""
    ){
        error = "Please input all fields.";
    }
    else if (!email){
        error = "Please input valid email.";
    }
    else if (!password) {
        error = "Password should be at least 8 characters, with uppercase, lowercase, special character and number.";
    }
    else if(
        formData.password !=
        formData.repeat_password
    ){
        error = "Passwords not match!";
    }
    else if (!phoneNumber) {
        error = "Please input valid phone number.";
    }else{
        $(".btn-register").text("");
        $(".btn-register").prop("disabled", true);
        $(".btn-register").html("<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>"
            +"<span class='sr-only'>Loading...</span>");
    }

    return error;
}
