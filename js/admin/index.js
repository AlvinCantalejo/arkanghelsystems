import App from "../class/App.class.js";
import TableHelper from "../class/Table.class.js";
import ButtonHelper from "../class/Button.class.js";
import CookieClass from "../class/Cookie.class.js";
import User from "../model/User.model.js";
import Appointment from "../model/Appointment.model.js";

$(document).ready(function() {
    
    bindActionButtons();
    App.checkIfLoggedIn(userRole);
    App.handlePageRestore();
    renderProfileDetails();
    renderFilter();
    getAppointments();
    getDonations();
});

var userRole = CookieClass.getCookie(User.USER_ROLE);
var errorMessage = $("#error-message");
var donations = {};
var appointments = {};
var appointment;

function bindActionButtons (){

    App.searchBar();
    
    //CREATE NEW DONATION
    $(".add-new-donation-button").on("click", function(e){
        e.preventDefault();
        resetForm();
        renderModal("create");
    });

    $(".close-modal").on("click", function (e) {
        e.preventDefault();
        $("#new-donation-modal").modal("hide");
        $("#confirm-modal").modal("hide");
    }); 

    $("#remind-donors").on("click", function (e) {
        e.preventDefault();
        remindDonors();
    }); 
    
    var donationID;
    $("#donation-table").on("click", ".edit-button", function (e) {
        e.preventDefault();
        donationID = $(this).attr("attr");
        let donation = App.index(donationID, donations);

        $("#new-donation-modal").modal("show");
        
        
        if(donation.donation_status == "Successful"){
            $("#product-number-section").attr("hidden", false);
        }else{
            $("#product-number-section").attr("hidden", true);
        }
        renderModal("edit");    
        fillAppointmentDetails(donation, "donation");
    });

    //DELETE BUTTON
    $("#donation-table").on("click", ".delete-button", function (e) {
        e.preventDefault();

        donationID = $(this).attr("attr");
        let donation = App.index(donationID, donations);
        validateConfirmationModal("delete", donation);
    });

    $("#confirm").on("click", function (e) {
        e.preventDefault();
        
        var value = $(this).val();
        if (value == "Delete"){
            $("#confirm-modal").modal("hide");
            deleteDonation(donationID);
        }
    });

    $("#submit-form").on("click", function(e){
        e.preventDefault();

        var form = $("form#new-donation-form");
        var data = form.serialize().split("&");
        var formData = App.objectConverter(data);
        var method = $("#method").val();
        if (method == "create") {
            if(validateForm()){
                resetForm();
                //console.log(formData);
                saveNewDonation(formData);
            }
                
        } else if (method == "edit") {
            if(validateForm()){
                resetForm();
                updateDonation(formData);
            }
        }
    });

    $("#donation-filter-button").on("click", function (e) {
        e.preventDefault();

        let filter = {};
        let filterCategory = "";
        let filterType = "";
        let filterStatus = "";
        let filterBatch = "";
        let filterBatchStartDate;
        let filterBatchEndDate;

        var today = new Date();
        var year = today.getFullYear();
        var startDate;
        var endDate;

        let type = $('#donation-type-dropdown').val();
        let status = $('#donation-status-dropdown').val();
        let batch = $('#donation-batch-dropdown').val();
        let batchType = $('#donation-batch-dropdown').find(":selected").attr("attr");

        filterType = type == null || type == 'All' ? "All" : type;
        filterStatus = status == null || status == 'All' ? "All" : status;
        filterBatch = batch == null || batch == 'All' ?  "All" : "Other";

        switch(batchType){
            
            case 'mm':
                startDate = year + "-" + parseInt(batch) + "-1";
                endDate = new Date(year,parseInt(batch), 0).toISOString().slice(0, 10);
                filterBatchStartDate = startDate;
                filterBatchEndDate = endDate;
                break;
            case 'qq':
                if(batch == 1){ //Jan to Mar
                    startDate = year + "-1-1";
                    endDate = new Date(year, 3, 0).toISOString().slice(0, 10); 
                }else if(batch == 2){ //Apr to Jun
                    startDate = year + "-4-1";
                    endDate = new Date(year, 6, 0).toISOString().slice(0, 10);
                }else if(batch == 3){ //Jul to Sep 
                    startDate = year + "-7-1";
                    endDate = new Date(year, 9, 0).toISOString().slice(0, 10);
                }else if(batch == 4){ //Oct to Dec
                    startDate = year + "-10-1";
                    endDate = new Date(year, 12, 0).toISOString().slice(0, 10);
                }
                filterBatchStartDate = startDate;
                filterBatchEndDate = endDate;
                break;
            case 'yy':
                startDate = year + "-1-1";
                endDate = new Date(year, 12, 0).toISOString().slice(0, 10); 
                filterBatchStartDate = startDate;
                filterBatchEndDate = endDate;
                break;
        }

        //filter category
        filterCategory += filterType == "All" ? "T" : "";
        filterCategory += filterBatch == "All" ? "B" : "";
        filterCategory += filterStatus == "All" ? "S" : "";

        filter.filter_category = filterCategory;
        filter.donation_type = filterType;
        filter.donation_status = filterStatus;
        filter.donation_batch = filterBatch;
        filter.batch_start_date = filterBatchStartDate;
        filter.batch_end_date = filterBatchEndDate;

        filterDonations(filter);
    });


    $("#search-appointment").on("click", function(e){
        var id = $("#search-appointment-id").val();
        getAppointment(id); 
    });

    $("#donation-status").on("change", function (e) {
        e.preventDefault();
        if($(this).val() == "Successful"){
            $("#blood-product-number").val("");
            $("#product-number-section").attr("hidden", false);
        }else if($(this).val() == "Deferred"){
            $("#blood-product-number").val("");
            $("#product-number-section").attr("hidden", true);
        }
    }); 

    $("#appointment-type-dropdown").on("change", function (e) {
        e.preventDefault();
        if($(this).val() == "donation-drive"){
            $("#appointment-date-picker").prop("disabled", true);
            $("#appointment-time-dropdown").prop("disabled", true);
            $("#appointment-date-picker").val("");
            $("#appointment-time-dropdown").val("all");

        }else if ($(this).val() == "in-house"){
            $("#appointment-date-picker").prop("disabled", false);
            $("#appointment-time-dropdown").prop("disabled", true);
        }else{
            $("#appointment-date-picker").prop("disabled", true);
            $("#appointment-time-dropdown").prop("disabled", true);
            $("#appointment-date-picker").val("");
            $("#appointment-time-dropdown").val("all");
        }
    });  

    $("#appointment-date-picker").on("change", function (e) {
        e.preventDefault();
        if($(this).val() == ""){
            $("#appointment-time-dropdown").prop("disabled", true);
            $(this).val() = 'all';
        }else{
            $("#appointment-time-dropdown").prop("disabled", false);
        }
    });  
    
    $("#appointment-filter-button").on("click", function (e) {
        e.preventDefault();
        let filter = {};
        let type = $('#appointment-type-dropdown').val();
        let time = $('#appointment-time-dropdown').val();
        let date = $('#appointment-date-picker').val();;
        let status = $('#appointment-status-dropdown').val();

        if(date == "") date ="all";
        if(time == "") time ="all";
        
        filter.appointment_type = type;
        filter.appointment_time = time;
        filter.appointment_date = date;
        filter.appointment_status = status;

        filterAppointments(filter);
    });

    $("#appointment-clear-filter").on("click", function(e){
        e.preventDefault();
        $('#appointment-type-dropdown').val("all");
        $('#appointment-date-picker').val("");
        $('#appointment-status-dropdown').val("Active");
        $('#appointment-time-dropdown').val("all");
        getAppointments();
    })

    $("#download-pdf").on("click", function(e){
        e.preventDefault();
        
        let html = "<thead><tr>";
        html += "<td><b>Donation Number</b></td>";
        html += "<td><b>Donor Details</b></td>";
        html += "<td><b>Donation Details</b></td>";
        html += "<td><b>Blood Details</b></td>";
        html += "<td><b>Status</b></td></tr></thead><tbody>";
        html += document.getElementById("donation-table-body").innerHTML;
        html += "</tbody>";
        $("#trimmed-donation-table").html(html);

        $("#trimmed-donation-table tr").each(function() {
            $(this).find("td:eq(5)").remove();
            $(this).find("td:eq(5)").remove();
        });

        let trimmedhtml = document.getElementById("trimmed-donation-table").innerHTML;
        let title = $("#donation-batch-dropdown option:selected").text();
        if(title == "" || title == "Donation Batch" || title == "All")
            title = "All Donations";
        let reportData = {};
        reportData.reportAuthor = CookieClass.getCookie(User.FIRST_NAME) + " " + CookieClass.getCookie(User.LAST_NAME);
        reportData.reportTitle = "Donation Report: " + title;
        reportData.reportTable = trimmedhtml;
        reportData.reportType = "Donation";
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

function saveNewDonation(donation) {
    var apiURL = App.getApiUrl();
    if(donation.id_appointment == "")
        var endpoint = "admin/add-new-donor";
    else
        var endpoint = "admin/add-donation";
    var api = apiURL + endpoint;

    $.ajax({
        url: api,
        type: "POST",
        data: donation,
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Koauthorization",
                CookieClass.getCookie(User.TOKEN)
            );
        },
        success: function (data) {
            getDonations();
            getAppointments();
        },
        error: function (error) {
            console.log(error);
            getDonations();
            getAppointments();
        },
    });
}

function updateDonation(donation) {
    var apiURL = App.getApiUrl();
    var endpoint = "admin/update-donation";
    var api = apiURL + endpoint;

    $.ajax({
        url: api,
        type: "POST",
        data: donation,
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
        },
    });
}
function remindDonors(donation) {
    var apiURL = App.getApiUrl();
    var endpoint = "admin/remind-donors";
    var api = apiURL + endpoint;

    $.ajax({
        url: api,
        type: "POST",
        data: donation,
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Koauthorization",
                CookieClass.getCookie(User.TOKEN)
            );
        },
        success: function (data) {
            App.validateAlertModal(data.message, "success");
        },
        error: function (error) {
            App.validateAlertModal("Reminders are sent to the donors.", "success");
            console.log(error);
        },
    });
}

function deleteDonation(id) {
    var apiURL = App.getApiUrl();
    var endpoint = "admin/delete-donation";
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
        },
    });
}

function getDonations() {
    var apiURL = App.getApiUrl();
    var endpoint = "admin/donations";
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
            donations = data;
            displayDonationTable(donations);
        },
        error: function (error) {
            console.log(error);
            donations = "";
            displayDonationTable(donations);
        },
    });
}

function getAppointment(id) {
    var apiURL = App.getApiUrl();
    var endpoint = "admin/appointment";
    var api = apiURL + endpoint;
    var parameters = {
        "id" : id
    }
    $.ajax({
        url: api,
        type: "GET",
        data: parameters,
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Koauthorization",
                CookieClass.getCookie(User.TOKEN)
            );
        },
        success: function (data) {
            appointment = data;
            $(".search_message").text("");
            fillAppointmentDetails(appointment, "appointment");
        },
        error: function (error) {
            console.log(error);
            $(".search_message").text("No appointment found.");
            resetForm();

        },
    });
    
}

function getAppointments() {
    var apiURL = App.getApiUrl();
    var endpoint = "admin/appointments";
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
            appointments = data;
            displayTable(appointments);
        },
        error: function (error) {
            appointments = "";
            displayTable(appointments);
        },
    });
}

function filterAppointments(filter) {
    var apiURL = App.getApiUrl();
    var endpoint = "admin/filter-appointments";
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
            appointments = {};
            appointments.length = 0;
            displayTable(appointments);
            console.log(error);
            
        },
    });
}
function filterDonations(filter) {
    var apiURL = App.getApiUrl();
    var endpoint = "admin/filter-donations";
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
            displayDonationTable(data);
        },
        error: function (error) {
            donations = {};
            donations.length = 0;
            displayDonationTable(donations);
            console.log(error);
            
        },
    });
}

//========================================CALLED FUNCTIONS=========================================================

function renderFilter (){

    var monthText;
    var quarterText;
    var annualText;
    var html = "";
    var today = new Date();
    var mm = today.getUTCMonth()+1;
    var quarter = Math.floor((today.getMonth() + 3) / 3);
    
    monthText = today.toLocaleString('default', { month: 'long' });
    if(quarter == 1)
        quarterText = "1st - Jan to Mar";
    else if(quarter == 2)
        quarterText = "2nd - Apr to Jun";
    else if(quarter == 3)
        quarterText = "3rd - July to Sep";
    else
        quarterText = "4th - Oct to Dec";
    annualText = today.getFullYear();

    html+= "<option selected disabled>Donation Batch</option>";
    html+= "<option value='All'>All</option>";
    html+= "<option value='" + mm + "' attr='mm'>Month (" + monthText + ")</option>";
    html+= "<option value='" + quarter + "' attr ='qq'>Quarter (" + quarterText + ")</option>";
    html+= "<option value='"+ annualText + "' attr='yy'>Year (" + annualText + ")</option>";
    $("#donation-batch-dropdown").html(html);
}

function renderProfileDetails (){
    let firstName = CookieClass.getCookie(User.FIRST_NAME);
    let lastName = CookieClass.getCookie(User.LAST_NAME);
    let emailAddress = CookieClass.getCookie(User.EMAIL);
    $("#profile-name").text(firstName + " " + lastName);
    $("#email-address").text(emailAddress);
}

function fillAppointmentDetails(data, type){

    let appointmentID = $("#id-appointment");    
    let donationID = $("#id-donation");    
    let donorID = $("#id-donor");    
    let firstName = $("#first-name");    
    let lastName = $("#last-name");    
    let dateOfBirth = $("#birth-date");    
    let gender = $("#gender");    
    let phoneNumber = $("#phone-number");    
    let bloodType = $("#blood-type");    
    let donationType = $("#donation-type");    
    let donationDate = $("#donation-date");   
    let donationLocation = $("#donation-location"); 
    let prcPersonnel = $("#prc-personnel"); 
    let donationStatus = $("#donation-status"); 
    let bloodProductNumber = $("#blood-product-number"); 
    
    donorID.val(data.id_donor);
    firstName.val(data.first_name);
    lastName.val(data.last_name);
    dateOfBirth.val(data.birth_date);
    gender.val(data.gender);
    phoneNumber.val(data.phone_number);
    bloodType.val(data.blood_type);

    if(type == "appointment"){
        appointmentID.val(data.id);
        donationType.val(data.appointment_type);
        donationDate.val(data.appointment_date);
        donationLocation.val(data.appointment_location);
    }else{
        donationID.val(data.id);
        donationType.val(data.donation_type);
        donationDate.val(data.donation_date);
        donationLocation.val(data.donation_location);
        donationStatus.val(data.donation_status);
        prcPersonnel.val(data.prc_personnel);
        bloodProductNumber.val(data.blood_product_number);
    }
    

}
//DISPLAY DONATION DRIVE TABLE
var donationTableBody = $("#donation-table-body");
function displayDonationTable(donations) {

    let donationTableRow = "";
    if (donations.length <= 0) {
        donationTableRow += "<tr>";
        donationTableRow += "<tr><td colspan='6'>No records found</td></tr>";
        donationTableRow += "</tr>";
    } else {
        for (var i = 0; i < donations.length; i++) {
            let donation = donations[i];

            let donationNumber = donation.id;
            let idDonor = donation.id_donor;
            let donationType = donation.donation_type;
            let donationDate = App.stringifyDate(donation.donation_date);
            let donationLocation = donation.donation_location;
            let donationStatus = donation.donation_status;
            let prcPersonnel = donation.prc_personnel;
            let bloodProductNumber = donation.blood_product_number;
            let donorName = donation.first_name + " " + donation.last_name;
            let bloodType = donation.blood_type;

            if(bloodType == null ||bloodType == "")
                bloodType = "-";
            donationTableRow += "<tr>";
            donationTableRow += TableHelper.addData("<strong>" + donationNumber + "</strong></br>");
            donationTableRow += TableHelper.addData("<strong>" + donorName + "</strong></br>" +
                                                        "<em>" + idDonor + "</em>");

            donationTableRow += TableHelper.addData("<strong>" +donationType + "</strong></br>" + 
                                                        donationDate + "</br>" +                                       
                                                        "<em>" + donationLocation + "</em>"); 
            if(donationStatus == "Successful"){
                donationTableRow += TableHelper.addData("<strong>" +bloodProductNumber + "</strong> | <strong><em>" + 
                                                            bloodType + "</em></strong></br>Personnel: " +   
                                                            "<em>" + prcPersonnel + "</em>");
            }else{
                donationTableRow += TableHelper.addData( "<em>Not applicable</em>");
            }

            donationTableRow += TableHelper.addData("<strong>" +donationStatus + "</strong>");    
            donationTableRow += TableHelper.addButton(
                ButtonHelper.editButton(donationNumber)
            )
            donationTableRow += TableHelper.addButton(
                ButtonHelper.deleteButton(donationNumber)
            )
            
            donationTableRow += "</tr>";
        }
    }
    donationTableBody.html(donationTableRow);
}

//DISPLAY DONATION DRIVE TABLE
var appointmentTableBody = $("#appointment-table-body");
function displayTable(appointments) {

    let appointmentTableRow = "";
    if (appointments.length <= 0) {
        appointmentTableRow += "<tr>";
        appointmentTableRow += "<tr><td colspan='4'>No records found</td></tr>";
        appointmentTableRow += "</tr>";
    } else {
        for (var i = 0; i < appointments.length; i++) {
            let appointment = appointments[i];

            let id = appointment.id;
            let appointmentType = appointment.appointment_type;
            let idDonor = appointment.id_donor;
            let bloodType = appointment.blood_type;
            let fullnameDonor = appointment.fullname;
            let appointmentLocation = appointment.appointment_location;
            let appointmentDate = App.stringifyDate(appointment.appointment_date);
            let appointmentTime = appointment.appointment_time;
            let appointmentStatus = appointment.appointment_status;
            if(bloodType == null ||bloodType == "")
                bloodType = "not yet identified";
            appointmentTableRow += "<tr>";
            appointmentTableRow += TableHelper.addData("<strong>" + id + "</strong></br>" +
                                                        "<em>" + appointmentType + "</em>");
            appointmentTableRow += TableHelper.addData("<strong>" +fullnameDonor + "</strong></br>" + 
                                                        idDonor + "</br>blood type: " +   
                                                        "<em>" + bloodType + "</em>");
            appointmentTableRow += TableHelper.addData("<strong>" +appointmentLocation + "</strong></br>" + 
                                                        appointmentDate + "</br>" +                                       
                                                        "<em>" + appointmentTime + "</em>");    
            appointmentTableRow += TableHelper.addData(appointmentStatus)
            
            appointmentTableRow += "</tr>";
        }
    }appointmentTableBody.html(appointmentTableRow);
}

function resetForm() {
    errorMessage.text("");
    $("#search-appointment-id").val("");
    $(".search_message").text("");
    $("#first-name").val("");
    $("#last-name").val("");
    $("#birth-date").val("");
    $("#gender").val("Select");
    $("#phone-number").val("");
    $("#blood-type").val("Select");
    $("#donation-type").val("Select");
    $("#donation-date").val("");
    $("#donation-location").val("");
    $("#donation-status").val("Select");
    $("#prc-personnel").val("");
    $("#blood-product-number").val("");
    $("#id-appointment").val("");
    $("#id-donor").val("");
}

var errorMessage = $(".error-message");
var donationForm = $("#new-donation-modal");
function validateForm() {
    errorMessage.text("");
    if( $("#first-name").val() == "" ||
        $("#last-name").val() == "" || 
        $("#birth-date").val() == "" ||
        $("#gender").val() == "Select" ||
        $("#phone-number").val() == "" ||
        $("#blood-type").val() == "Select" ||
        $("#donation-type").val() == "Select" ||
        $("#donation-date").val() == "" ||
        $("#donation-location").val() == "" ||
        $("#donation-status").val() == "Select" ||
        $("#prc-personnel").val() == ""){
        errorMessage.text("All fields are required!");
    }else{
        errorMessage.text("");
        donationForm.modal("hide");
        return true;
    }
        
    
}
function renderModal(action) {

    if (action == "create") {
        $("#new-donation-modal").modal("show");

        $(".modal-title").html("Add New Donation");
        $("#submit-form").val("Create");
        $("#method").val("create");
        $("#product-id-section").attr("hidden", true);
        $("#search-appointment-section").prop("hidden", false);
        $("#donation-section").prop("hidden", true);
        $("#first-name").prop("readonly", false);
        $("#last-name").prop("readonly", false); 
        $("#birth-date").prop("readonly", false);
        $("#gender").prop("disabled", false);
        $("#phone-number").prop("readonly", false);
    }

    else if (action == "edit") {
        $("#donation-drive-modal").modal("show");

        $(".modal-title").html("Edit Donation Information");
        $("#submit-form").val("Save Changes");
        $("#method").val("edit");

        $("#search-appointment-section").prop("hidden", true);
        $("#donation-section").prop("hidden", false);
        $("#first-name").prop("readonly", true);
        $("#last-name").prop("readonly", true); 
        $("#birth-date").prop("readonly", true);
        $("#gender").prop("disabled", true);
        $("#phone-number").prop("readonly", true);
    }
}

function validateConfirmationModal(action, donation) {
    $("#confirm-modal").modal("show");

    if (action == "delete") {
        $(".modal-title").html("Delete Donation Drive");
        $("#confirm").val("Delete");
        $("#confirmation-message").html(
            "<p>Are you sure you want to delete this event?</br>Donation Number: <b>" 
            + donation.id + "</b></br> Donor ID: <b>" 
            + donation.id_donor + "</b><br>Blood Product Number: <b>" + donation.blood_product_number + "</b></p>"
        );
    } 
}