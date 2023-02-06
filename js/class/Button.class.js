class ButtonHelper {

    static alertMessage(message, title){
        return "<p class='my-auto text-center' style='font-size:15px;'>"
        + "<span><strong>"+ title +" </strong></span>"
        + "<span>"+ message +"</span></p>";
    }

    static viewPartipants(id, eventTitle){
        return "<button class='btn btn-sm btn-info view-participants-button' attr='"+ id +"' event_title='"+ eventTitle +"'>View Participants</button>";
    }

    static editButton(id){
        return "<button class='btn btn-sm btn-warning edit-button' attr='"+ id +"'>Edit</button>";
    }
    
    static updateButton(id){
        return "<button class='btn btn-sm btn-warning update-button' attr='"+ id +"'>Update</button>";
    }

    static deleteButton(id){
        return "<button class='btn btn-sm btn-danger delete-button' attr='"+ id +"'>Delete</button>";
    }

    static rescheduleButton(id){
        return "<button class='btn btn-sm btn-warning reschedule-button' attr='"+ id +"'>Reschedule</button>";
    }
    static disabledRescheduleButton(id){
        return "<button class='btn btn-sm btn-warning reschedule-button' attr='"+ id +"' disabled>Reschedule</button>";
    }

    static cancelButton(id){
        return "<button class='btn btn-sm btn-danger cancel-button' attr='"+ id +"'>Cancel</button>";
    }

    static viewExamination(examinationID){
        return "<a href='javascript:void(0)' class='view-examination-link' attr='"+ examinationID +"'>" + examinationID + "</a>"
    }
}
export default ButtonHelper