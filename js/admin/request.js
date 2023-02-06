import App from "../class/App.class.js";
import TableHelper from "../class/Table.class.js";
import ButtonHelper from "../class/Button.class.js";
import CookieClass from "../class/Cookie.class.js";
import User from "../model/User.model.js";

$(document).ready(function() {
    
    bindActionButtons();
    App.checkIfLoggedIn(userRole);
    App.handlePageRestore();
    
    renderProfileDetails();
    getRequests();

});

var userRole = CookieClass.getCookie(User.USER_ROLE);
var errorMessage = $("#error-message");
var requests = {};

function bindActionButtons (){

    App.searchBar();
    
    //CREATE NEW DONATION
    $(".add-new-request-button").on("click", function(e){
        e.preventDefault();
        resetForm();
        renderModal("create");
    });

    var requestID;
    $("#request-table").on("click", ".update-button", function (e) {
        e.preventDefault();
        requestID = $(this).attr("attr");
        let request = App.index(requestID, requests);

        renderModal("update");   
        fillRequestDetails(request);
    });

    $("#submit-form").on("click", function(e){
        e.preventDefault();

        var form = $("form#new-request-form");
        var data = form.serialize().split("&");
        var formData = App.objectConverter(data);
        var method = $("#method").val();
        if (method == "create") {
            if(validateForm()){
                saveNewRequest(formData);
            }
                
        } else if (method == "update") {
            if(validateForm()){
                updateRequest(formData);
            }
        }
    });

     //DELETE BUTTON
    $("#request-table").on("click", ".delete-button", function (e) {
        e.preventDefault();

        requestID = $(this).attr("attr");
        let request = App.index(requestID, requests);
        validateConfirmationModal("delete", request);
    });

    $("#request-apply-filter").on("click", function (e) {
        e.preventDefault();
        let filter = {};
        let status = $('#request-status-dropdown').val();

        filter.request_status = status;
        filterRequests(filter);
    });

    $("#confirm").on("click", function (e) {
        e.preventDefault();
        
        var value = $(this).val();
        if (value == "Delete"){
            $("#confirm-modal").modal("hide");
            deleteRequest(requestID);
        }
    });
    

    $(".close-modal").on("click", function (e) {
        e.preventDefault();
        $("#request-modal").modal("hide");
        $("#confirm-modal").modal("hide");
    });

    $("#download-pdf").on("click", function(e){
        e.preventDefault();
        
        let html = "<thead><tr>";
        html += "<td><b>Release Number</b></td>";
        html += "<td><b>Patient Info</b></td>";
        html += "<td><b>Blood Product Info</b></td>";
        html += "<td><b>Status</b></td></tr></thead><tbody>";
        html += document.getElementById("request-table-body").innerHTML;
        html += "</tbody>";
        $("#trimmed-request-table").html(html);

        $("#trimmed-request-table tr").each(function() {
            $(this).find("td:eq(5)").remove();
            $(this).find("td:eq(5)").remove();
        });

        let trimmedhtml = document.getElementById("trimmed-request-table").innerHTML;
        let title = $("#request-status-dropdown option:selected").text();
        if(title == "" || title == "Status" || title == "All")
            title = "All Requests";
        else
            title = "(Status: " + title + ")";
        let reportData = {};
        reportData.reportAuthor = CookieClass.getCookie(User.FIRST_NAME) + " " + CookieClass.getCookie(User.LAST_NAME);
        reportData.reportTitle = "Request Report: " + title;
        reportData.reportTable = trimmedhtml;
        reportData.reportType = "Request";
        generateReport(reportData);

    })
}

//========================================AJAX CALLS=========================================================
function generateReport(reportData) {
    var apiURL = App.getApiUrl();
    var endpoint = "admin/generate-report";
    var api = apiURL + endpoint;

    $.ajax({
        url: api,
        type: "POST",
        data: reportData,
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Koauthorization",
                CookieClass.getCookie(User.TOKEN)
            );
        },
        success: function (data) {
            window.open('./../../module/admin/generate-report.php', "_blank") || window.location.replace('./../../module/admin/generate-report.php');

        },
        error: function (error) {
            console.log(error);
        },
    });
}

function getRequests() {
    var apiURL = App.getApiUrl();
    var endpoint = "admin/requests";
    var api = apiURL + endpoint;

    $.ajax({
        url: api,
        type: "GET",
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Koauthorization",
                CookieClass.getCookie(User.TOKEN)
            );
        },
        success: function (data) {
            requests = data;
            displayTable(requests);
        },
        error: function (error) {
            console.log(error);
            requests = "";
            displayTable(requests);
        },
    });
}

function saveNewRequest(request) {
    var apiURL = App.getApiUrl();
        var endpoint = "admin/add-request";
    var api = apiURL + endpoint;

    $.ajax({
        url: api,
        type: "POST",
        data: request,
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Koauthorization",
                CookieClass.getCookie(User.TOKEN)
            );
        },
        success: function (data) {
            resetForm();
            getRequests();
        },
        error: function (error) {
            console.log(error);
            App.validateAlertModal("Failed to add request!", "failed");
            getRequests();
        },
    });
}

function updateRequest(request) {
    var apiURL = App.getApiUrl();
    var endpoint = "admin/update-request";
    var api = apiURL + endpoint;

    $.ajax({
        url: api,
        type: "POST",
        data: request,
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Koauthorization",
                CookieClass.getCookie(User.TOKEN)
            );
        },
        success: function (data) {
            App.validateAlertModal(data.message, "success");
            getRequests();
        },
        error: function (error) {
            console.log(error);
            App.validateAlertModal("Failed to update request " + request.release_number, "failed");
            getRequests();
        },
    });
}
function filterRequests(filter) {
    var apiURL = App.getApiUrl();
    var endpoint = "admin/filter-requests";
    var api = apiURL + endpoint;

    $.ajax({
        url: api,
        type: "GET",
        data: filter,
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Koauthorization",
                CookieClass.getCookie(User.TOKEN)
            );
        },
        success: function (data) {
            displayTable(data);
        },
        error: function (error) {
            requests = {};
            requests.length = 0;
            displayTable(requests);
            console.log(error);
            
        },
    });
}
function deleteRequest(id) {
    var apiURL = App.getApiUrl();
    var endpoint = "admin/delete-request";
    var api = apiURL + endpoint;
    var parameters={
        "id" : id
    }
    $.ajax({
        url: api,
        type: "POST",
        data: parameters,
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Koauthorization",
                CookieClass.getCookie(User.TOKEN)
            );
        },
        success: function (data) {
            App.validateAlertModal(data.message, "success");
            getDonations();
        },
        error: function (error) {
            console.log(error);
            App.validateAlertModal("Failed to delete request " + id + "!", "failed");
        },
    });
}

//========================================CALLED FUNCTIONS=========================================================
function renderProfileDetails (){
    let firstName = CookieClass.getCookie(User.FIRST_NAME);
    let lastName = CookieClass.getCookie(User.LAST_NAME);
    let emailAddress = CookieClass.getCookie(User.EMAIL);
    $("#profile-name").text(firstName + " " + lastName);
    $("#email-address").text(emailAddress);
}

//DISPLAY DONATION DRIVE TABLE
var requestTableBody = $("#request-table-body");
function displayTable(requests) {

    let requestTableRow = "";
    if (requests.length <= 0) {
        requestTableRow += "<tr>";
        requestTableRow += "<tr><td colspan='5'>No records found</td></tr>";
        requestTableRow += "</tr>";
    } else {
        for (var i = 0; i < requests.length; i++) {
            let request = requests[i];

            let id = request.id;
            let releaseNumber = request.release_number;
            let patientName = request.patient_name;
            let phoneNumber = request.phone_number;
            let clinic = request.clinic;
            let bloodProduct = request.blood_product;
            let unit = request.unit;
            let bloodType = request.blood_type;
            let requestDate = App.stringifyDate(request.request_date);
            let requestStatus = request.request_status;
            let postedBy = request.first_name + " " + request.last_name;

            requestTableRow += "<tr>";
            requestTableRow += TableHelper.addData("<strong>" + releaseNumber + "</strong></br>" +
                                                        "C/O: <em>" + postedBy + "</em>");
            requestTableRow += TableHelper.addData("<strong>" + patientName + "</strong></br>" + 
                                                        phoneNumber + "</br>Admitted: " +   
                                                        "<em>" + clinic + "</em>");
            requestTableRow += TableHelper.addData("<strong>" +bloodProduct + "</strong> | "+bloodType+"</br>" +                                   
                                                        "<em>" + unit + " unit/s requested</em>");    
            requestTableRow += TableHelper.addData("<strong>" + requestStatus + "</strong></br>" +                                   
                                                        "Date of request: <em> " + requestDate + "</em>");
                                                        
            requestTableRow += TableHelper.addButton(
                ButtonHelper.updateButton(id)
            )
            requestTableRow += TableHelper.addButton(
                ButtonHelper.deleteButton(id)
            )
            requestTableRow += "</tr>";
        }
    }requestTableBody.html(requestTableRow);
}

function fillRequestDetails(request){

    let id = $("#id");
    let releaseNumber = $("#release-number");
    let patientName = $("#patient-name");
    let phoneNumber = $("#phone-number");
    let clinic = $("#patient-clinic");
    let bloodProduct = $("#blood-product");
    let unit = $("#blood-unit");
    let bloodType = $("#blood-type");
    let requestDate = $("#request-date");
    let requestStatus = $("#request-status");
    
    id.val(request.id);
    releaseNumber.val(request.release_number);
    patientName.val(request.patient_name);
    phoneNumber.val(request.phone_number);
    clinic.val(request.clinic);
    bloodProduct.val(request.blood_product);
    unit.val(request.unit);
    bloodType.val(request.blood_type);
    requestDate.val(request.request_date);
    requestStatus.val(request.request_status);
}

function resetForm() {
    errorMessage.text("");
    $("#patient-name").val("");
    $("#phone-number").val("");
    $("#patient-clinic").val("");
    $("#request-status").val("Select");
    $("#blood-type").val("Select");
    $("#blood-unit").val("");
    $("#request-date").val("");
    $("#release-number").val("");
}

function renderModal(action) {

    if (action == "create") {
        $("#request-modal").modal("show");

        $(".modal-title").html("Add New Request");
        $("#submit-form").val("Create");
        $("#method").val("create");
        $("#release-number-section").attr("hidden", true);
        $("#update-status-section").attr("hidden", true);
    }

    else if (action == "update") {
        $("#request-modal").modal("show");

        $(".modal-title").html("Edit Request Information");
        $("#submit-form").val("Save Changes");
        $("#method").val("update");

        $("#release-number-section").attr("hidden", false);
        $("#update-status-section").attr("hidden", false);
        $("#release-number").prop("readonly", true);
    }
    
}
var errorMessage = $(".error-message");
var requestForm = $("#request-modal");
function validateForm() {
    errorMessage.text("");
    if( $("#patient-name").val() == "" ||
        $("#phone-number").val() == "" || 
        $("#patient-clinic").val() == "" ||
        $("#blood-unit").val() == "" ||
        $("#request-date").val() == "" ||
        $("#blood-type").val() == "Select" ){
        errorMessage.text("All fields are required!");
    }else{
        errorMessage.text("");
        requestForm.modal("hide");
        return true;
    }
}

function validateConfirmationModal(action, request) {
    $("#confirm-modal").modal("show");

    if (action == "delete") {
        $(".modal-title").html("Delete Request");
        $("#confirm").val("Delete");
        $("#confirmation-message").html(
            "<p>Are you sure you want to delete this request?</br>Release Number: <b>" 
            + request.release_number + "</b></br> Patient: <b>" 
            + request.patient_name + "</b> | <em>" + request.clinic + "</em><br></p>"
        );
    } 
}