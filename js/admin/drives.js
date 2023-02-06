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
    renderDatePicker();
    renderProfileDetails();
    getDonationDrives();
});

var userRole = CookieClass.getCookie(User.USER_ROLE);
var selectedDonationDriveID;
var donationDrives = [];
var participants = [];

function bindActionButtons (){

    App.searchBar();

    //CREATE NEW DRIVE
    $(".add-new-item-button").on("click", function(e){
        e.preventDefault();
        resetForm();
        renderModal("create");
    });

    //EDIT BUTTON
    $("#donation-drive-table").on("click", ".edit-button", function (e) {
        e.preventDefault();

        selectedDonationDriveID = $(this).attr("attr");
        let index = donationDrives.findIndex(current => current.id == selectedDonationDriveID);
        let drive = donationDrives[index];

        resetForm();
        renderModal("edit");
        let id = drive.id;
        let eventTitle = drive.event_title;
        let eventLocation = drive.event_location;
        let eventDate = drive.event_date;
        let eventTime = drive.event_time;
        let eventDetails = drive.event_details;

        $("#id").val(id);
        $("#event-title").val(eventTitle);
        $("#event-location").val(eventLocation);
        $("#event-date").val(eventDate);
        $("#event-time").val(eventTime);
        $("#event-details").val(eventDetails);

        

    });

    //DELETE BUTTON
    $("#donation-drive-table").on("click", ".delete-button", function (e) {
        e.preventDefault();

        selectedDonationDriveID = $(this).attr("attr");
        let index = donationDrives.findIndex(current => current.id == selectedDonationDriveID);
        let drive = donationDrives[index];
        validateConfirmationModal("delete", drive);
    });

    $("#confirm").on("click", function (e) {
        e.preventDefault();

        var value = $(this).val();
        if (value == "Delete"){
            deleteDonationDrive(selectedDonationDriveID);
        }
    });

     //VIEW PARTICIPANT
    $("#donation-drive-table").on("click", ".view-participants-button", function (e) {
        e.preventDefault();
        let donationDriveID = $(this).attr("attr");
        let eventTitle = $(this).attr("event_title");
        participants = getParticipants(donationDriveID);
        
        $("#view-participants").modal("show");
        $(".modal-title").text(
            "Pre-registered Participants (Event: " + eventTitle + ")"
        );
    });
    //CREATE NEW DRIVE
    $("#submit-form").on("click", function(e){
        e.preventDefault();

        var form = $("form#donation-drive-form");
        var data = form.serialize().split("&");
        var formData = App.objectConverter(data);
        var method = $("#method").val();
        if (method == "create") {
            saveNewDonationDrive(formData);
        } else if (method == "edit") {
            updateDonationDrive(formData);
        }
    });

    $(".close-modal").on("click", function (e) {
        e.preventDefault();
        $("#donation-drive-modal").modal("hide");
        $("#confirm-modal").modal("hide");
        $("#view-participants").modal("hide");
    });

    //EVENT DETAILS CHARACTER LIMITER
    var maxLen = 200;   
    $('#event-details').keypress(function(event){
        var Length = $("#event-details").val().length;
        var AmountLeft = maxLen - Length;
        $('.remaining').html(AmountLeft + " characters remaining.");
        if(Length >= maxLen){
            if (event.which != 8) {
                $('.remaining').css('color', 'red');
                return false;
            }else{
                $('.remaining').css('color', 'black');
            }
        }
    });

    $('#event-details').keydown(function(event){
        var Length = $("#event-details").val().length;
        var AmountLeft = maxLen - Length;
        $('.remaining').html(AmountLeft + " characters remaining.");
        if(Length >= maxLen){
            if (event.which != 8) {
                $('.remaining').css('color', 'red');
                return false;
            }else{
                $('.remaining').css('color', 'black');
            }
        }
    });

    //EVENT PHOTO SETTER
    $('#event-photo').change(function(){
        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var image;
            var reader = new FileReader();
            
            reader.onload = function (e) {
                image = e.target.result;
                $('#drive-photo-view').attr('width', 300);
                $('#drive-photo-view').attr('src', image);
                $('#photo-file').val(image);
            }
            reader.readAsDataURL(input.files[0]);
        }
        else{
            $('#drive-photo-view').attr('alt', 'Invalid file. Please upload photo file only.');
        }
    });

    $("#download-pdf").on("click", function(e){
        e.preventDefault();
        
        let html = "<thead><tr>";
        html += "<td><b>Donor ID</b></td>";
        html += "<td><b>Name</b></td>";
        html += "<td><b>Date of Registration</b></td></tr></thead><tbody>";
        html += document.getElementById("participants-table-body").innerHTML;
        html += "</tbody>";
        $("#trimmed-participants-table").html(html);

        $("#trimmed-participants-table tr").each(function() {
            $(this).find("td:eq(5)").remove();
            $(this).find("td:eq(5)").remove();
        });

        let trimmedhtml = document.getElementById("trimmed-participants-table").innerHTML;
        let title = $("#title").text();
        let reportData = {};
        reportData.reportAuthor = CookieClass.getCookie(User.FIRST_NAME) + " " + CookieClass.getCookie(User.LAST_NAME);
        reportData.reportTitle = title;
        reportData.reportTable = trimmedhtml;
        reportData.reportType = "Drive-Participants";
        generateReport(reportData);

    })

}


//======================================================AJAX CALLS==================================================
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
var errorMessage = $(".error-message");
function saveNewDonationDrive(event){
    let error = validateFormData(event);

    if (error != "") errorMessage.text(error);
    else{
        var apiURL = App.getApiUrl();
        var endpoint = "admin/add-donation-drive";
        var api = apiURL + endpoint;
        
        $.ajax({
            url: api,
            type: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    'Koauthorization', 
                    CookieClass.getCookie(User.TOKEN)
                );
            },
            data: event,                
            success: function (data) { 
                $("#donation-modal").modal("hide");
                window.location.reload();
            },
            error: function (error) { 
                console.log(error);
            }
        });
    }
    
}

//READ DONATION DRIVE TABLE
function getDonationDrives() {
    var apiURL = App.getApiUrl();
    var endpoint = "admin/donation-drives";
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
            donationDrives = data;
            displayTable(donationDrives);
        },
        error: function (error) {
            displayTable(donationDrives);
        },
    });

    return donationDrives;
}

function updateDonationDrive(formData) {
    var apiURL = App.getApiUrl();
    var endpoint = "admin/update-donation-drive";
    var api = apiURL + endpoint;

    $.ajax({
        url: api,
        type: "POST",
        data: formData,
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Koauthorization",
                CookieClass.getCookie(User.tOKEN)
            );
        },
        success: function (data) {
            $("#donation-drive-modal").modal("hide");
            //DELETE SUCCESSFUL
            App.validateAlertModal(data.message, "success");

            let index = donationDrives.findIndex(current => current.id == formData.id);
            let drive = donationDrives[index];
            drive.event_title = formData.event_title;
            drive.event_date = formData.event_date;
            drive.event_time = formData.event_time;
            drive.event_location = formData.event_location;
            drive.event_details = formData.event_details;
            displayTable(donationDrives);
        },
        error: function (error) {
            console.log(`ajax error:`, error);
        },
    });
}

function deleteDonationDrive(id) {
    var apiURL = App.getApiUrl();
    var endpoint = "admin/delete-donation-drive";
    var api = apiURL + endpoint;
    var parameters = {
        id: id
    };
    $.ajax({
        url: api,
        type: "POST",
        data: parameters,
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Koauthorization",
                CookieClass.getCookie(User.tOKEN)
            );
        },
        success: function (data) {
            $("#confirm-modal").modal("hide");
            //DELETE SUCCESSFUL
            App.validateAlertModal(data.message, "success");

            let index = donationDrives.findIndex(current => current.id == id);
            donationDrives.splice(index, 1);
            displayTable(donationDrives);
        },
        error: function (error) {
            console.log(`ajax error:`, error);
        },
    });
}

function getParticipants(donationDriveID) {
    var apiURL = App.getApiUrl();
    var endpoint = "admin/participants";
    var api = apiURL + endpoint;
    var parameters = {
        id: donationDriveID
    };

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
            participants = data;
            displayParticipantsTable(participants);
        },
        error: function (error) {
            participants = [];
            displayParticipantsTable(participants);
        },
    });
}
var donationDriveTableBody = $("#donation-drive-table-body");
//========================================CALLED FUNCTIONS=========================================================

function renderProfileDetails (){
    let firstName = CookieClass.getCookie(User.FIRST_NAME);
    let lastName = CookieClass.getCookie(User.LAST_NAME);
    let emailAddress = CookieClass.getCookie(User.EMAIL);
    $("#profile-name").text(firstName + " " + lastName);
    $("#email-address").text(emailAddress);
}

//DISPLAY DONATION DRIVE TABLE
function displayTable(donationDrives) {

    let donationDriveTableRow = "";
    if (donationDrives.length <= 0) {
        donationDriveTableRow += "<tr>";
        donationDriveTableRow += "<tr><td colspan='6'>No records found</td></tr>";
        donationDriveTableRow += "</tr>";
    } else {
        for (var i = 0; i < donationDrives.length; i++) {
            let drive = donationDrives[i];

            let id = drive.id;
            let eventTitle = drive.event_title;
            let eventLocation = drive.event_location;
            let eventDate = App.stringifyDate(drive.event_date);
            let eventTime = drive.event_time;
            let postedBy = drive.fullname;
            let datePosted = App.stringifyDate(drive.datetime_added);

            donationDriveTableRow += "<tr>";
            donationDriveTableRow += TableHelper.addData(id);
            donationDriveTableRow += TableHelper.addData(   "<strong>" +eventTitle + "</strong></br>" + 
                                                            eventLocation + "</br>" + 
                                                            eventDate + " | " + eventTime);
            donationDriveTableRow += TableHelper.addData(postedBy);
            donationDriveTableRow += TableHelper.addData(datePosted);
            
            donationDriveTableRow += TableHelper.addButton(
                ButtonHelper.viewPartipants(id, eventTitle)
            );
            donationDriveTableRow += TableHelper.addButton(
                ButtonHelper.editButton(id)
            )
            donationDriveTableRow += TableHelper.addButton(
                ButtonHelper.deleteButton(id)
            )
            donationDriveTableRow += "</tr>";
        }
    }donationDriveTableBody.html(donationDriveTableRow);
}


var participantsTableBody = $("#participants-table-body")
//DISPLAY DONATION DRIVE TABLE
function displayParticipantsTable(participants) {

    let participantsTableRow = "";
    if (participants.length <= 0) {
        participantsTableRow += "<tr>";
        participantsTableRow += "<tr><td colspan='3'>No records found</td></tr>";
        participantsTableRow += "</tr>";
    } else {
        for (var i = 0; i < participants.length; i++) {
            let participant = participants[i];

            let donorID = participant.id_donor;
            let fullname = participant.participant_fullname;
            let dateOfRegistration = App.stringifyDate(participant.datetime_added);

            participantsTableRow += "<tr>";
            participantsTableRow += TableHelper.addData(donorID);
            participantsTableRow += TableHelper.addData(fullname);
            participantsTableRow += TableHelper.addData(dateOfRegistration);
            participantsTableRow += "</tr>";
        }
    }participantsTableBody.html(participantsTableRow);
}

function renderDatePicker (){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();

    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    } 
        
    let min = yyyy + '-' + mm + '-' + dd;
    let max = yyyy + '-' + 12 + '-' + 30;
    $("#event-date").attr("min", min);
    $("#event-date").attr("max", max);
    
}

function resetForm() {
    errorMessage.text("");
    $("#event-title").val("");
    $("#event-date").val("");
    $("#event-location").val("");
    $("#event-photo").val("");
    $("#event-details").val("");
    $("#photo-file").val("");
    $("#drive-photo-view").attr("src", "");
    $("#remaining").text("");

}

function renderModal(action) {

    if (action == "create") {
        $("#donation-drive-modal").modal("show");

        $(".event-photo").prop("hidden", false);
        $(".modal-title").html("Create New Donation Drive");
        $("#submit-form").val("Create");
        $("#method").val("create");
    }

    else if (action == "edit") {
        $("#donation-drive-modal").modal("show");

        $(".event-photo").prop("hidden", true);
        $(".modal-title").html("Edit Donation Drive");
        $("#submit-form").val("Save Changes");
        $("#method").val("edit");
    }
}
//VALIDATE FORM DATA
function validateFormData(formData) {
    let error = "";

    if (formData.event_title == "" || 
        formData.event_date == "" ||
        formData.photo_file == "" ||
        formData.location == "" ||
        formData.event_details == "")
            error += "All fields are required!";
    return error;
}

//VALIDATE MODAL (DELETE AND RESTORE)
function validateConfirmationModal(action, drive) {
    $("#confirm-modal").modal("show");

    if (action == "delete") {
        $(".modal-title").html("Delete Donation Drive");
        $("#confirm").val("Delete");
        $("#confirmation-message").html(
            "<p>Are you sure you want to delete this event?</br>Event title: <b>" 
            + drive.event_title + "</b></br> Event Location: <b>" 
            + drive.event_location + "</b></br> Event Date: <b>"
            + drive.event_date + "</b></p>"
        );
    } 
}