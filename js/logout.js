import App from "./class/App.class.js";
import CookieClass from "./class/Cookie.class.js";

$(document).ready(function(){
    logout();
});

function logout(){
    var apiURL =  App.getApiUrl();
    var endpoint = "user/logout";
    var api = apiURL + endpoint;

    $.ajax({
        url: api,
        type: 'POST',
        success: function (data) { 
            CookieClass.deleteAllCookies();
            console.log(`ajax success:`, data);
            window.location.href = "./login.php"
        },
        error: function (error) { 
            console.log(`ajax error:`, error); 
        }
    }); 
}