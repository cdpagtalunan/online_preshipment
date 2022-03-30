//============================== ADD BILLING/LICENCE ==============================
function AddReminder(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    let formData = new FormData($('#formAddreminder')[0]);

	$.ajax({
        url: "add_reminder",
        method: "post",
        processData: false,
        contentType: false,
        data: formData,
        dataType: "json",
        beforeSend: function(){
            $("#iBtnAddWorkloadIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddWorkload").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validation'] == 'hasError'){
                toastr.error('Saving Billing/License failed!');
                if(response['error']['reminder_name'] === undefined){
                    $("#txtAddBillingName").removeClass('is-invalid');
                    $("#txtAddBillingName").attr('title', '');
                }
                else{
                    $("#txtAddBillingName").addClass('is-invalid');
                    $("#txtAddBillingName").attr('title', response['error']['reminder_name']);
                }

                if(response['error']['reminder_duedate'] === undefined){
                    $("#txtAddDuedate").removeClass('is-invalid');
                    $("#txtAddDuedate").attr('title', '');
                }
                else{
                    $("#txtAddDuedate").addClass('is-invalid');
                    $("#txtAddDuedate").attr('title', response['error']['reminder_duedate']);
                }

                if(response['error']['reminder_personincharge'] === undefined){
                    $("#txtAddPerson").removeClass('is-invalid');
                    $("#txtAddPerson").attr('title', '');
                }
                else{
                    $("#txtAddPerson").addClass('is-invalid');
                    $("#txtAddPerson").attr('title', response['error']['reminder_personincharge']);
                }
            }
            else if(response['result'] == 1){
                $("#txtAddPerson").removeClass('is-invalid');
                $("#txtAddDuedate").removeClass('is-invalid');
                $("#txtAddBillingName").removeClass('is-invalid');
                
                $("#txtAddPerson").val("0").trigger('change');


                $("#modalAddreminder").modal('hide');
                $("#formAddreminder")[0].reset();
                toastr.success('Billing/License was succesfully saved!');

                dataTableUsers.draw(); // reload the tables after insertion
            }

            $("#iBtnAddWorkloadIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddWorkload").removeAttr('disabled');
            $("#iBtnAddWorkloadIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            console.log(data);
            console.log(xhr);
            console.log(status);
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnAddWorkloadIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddWorkload").removeAttr('disabled');
            $("#iBtnAddWorkloadIcon").addClass('fa fa-check');
        }
    });
}

// =========================ADD PERSON IN CHARGE=======================
function AddPerson(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    let formData = new FormData($('#formAddPerson')[0]);

    $.ajax({
        url: "add_person",
        method: "post",
        processData: false,
        contentType: false,
        data: formData,
        dataType: "json",
        beforeSend: function(){
            $("#iBtnAddWorkloadIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddWorkload").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validation'] == 'hasError'){
                toastr.error('Adding person in charge failed!');
                if(response['error']['person_name'] === undefined){
                    $("#txtAddPersonName").removeClass('is-invalid');
                    $("#txtAddPersonName").attr('title', '');
                }
                else{
                    $("#txtAddPersonName").addClass('is-invalid');
                    $("#txtAddPersonName").attr('title', response['error']['person_name']);
                }


            }
            else if(response['result'] == 1){
                $("#txtAddPersonName").removeClass('is-invalid');


                $("#modalAddPerson").modal('hide');
                $("#formAddPerson")[0].reset();
                $
                toastr.success('Person in charge was succesfully added!');

                dataTablePerson.draw(); // reload the tables after insertion\
                dataTableUsers.draw();
            }

            $("#iBtnAddPersonIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddPerson").removeAttr('disabled');
            $("#iBtnAddPersonIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            console.log(data);
            console.log(xhr);
            console.log(status);
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnAddPersonIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddPerson").removeAttr('disabled');
            $("#iBtnAddPersonIcon").addClass('fa fa-check');
        }
    });

}

// ===========================GET PERSON IN CHARGE ID FOR EDIT===========================
function GetPersonById(personID){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "get_person_id",
        method: "get",
        data: {
            person_id: personID
        },
        dataType: "json",
        beforeSend: function(){
            
        },
        success: function(response){
            let person = response['person'];
            if(person.length > 0){
                $("#txtEditUserName").val(person[0].person_name);

            }
            else{
                // toastr.warning('No User Record Found!');
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

// ======================GET BILLING ID FOR EDIT=======================

function GetBillingByID(billingID){

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

      $.ajax({
        url: "get_billing_id",
        method: "get",
        data: {
            billing_id: billingID
        },
        dataType: "json",
        beforeSend: function(){
            
        },
        success: function(response){
            let billing = response['billing'];
            if(billing.length > 0){

                mydate = new Date(billing[0].reminder_duedate);

                mydatestring =   mydate.getFullYear()  + '-'
                +  ('0' + (mydate.getMonth()+1)).slice(-2) + '-'
                + ('0' + mydate.getDate()).slice(-2) ;

                $("#txtEditBillingName").val(billing[0].reminder_name);
                $("#txtEditDueDate").val(mydatestring);
                $("#txtEditPersonincharge").val(billing[0].reminder_personincharge_id).trigger('change');

            }
            else{
                toastr.warning('No User Record Found!');
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}



// =================================EDIT PERSON IN CHARGE==========================

function EditUser(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "edit_person",
        method: "post",
        data: $('#formEditUser').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnEditUserIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnEditUser").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validation'] == 'hasError'){
                toastr.error('Updating User Failed!');

                if(response['error']['person_name'] === undefined){
                    $("#txtEditUserName").removeClass('is-invalid');
                    $("#txtEditUserName").attr('title', '');
                }
                else{
                    $("#txtEditUserName").addClass('is-invalid');
                    $("#txtEditUserName").attr('title', response['error']['person_name']);
                }
            }else{
                if(response['result'] == 1){
                    $("#modalEditPerson").modal('hide');
                    $("#formEditUser")[0].reset();  

                    

                    dataTablePerson.draw();
                    // console.log(response['result']);
                    
                    toastr.success('Person in charge was succesfully updated!');
                }
                // else{
                //     toastr.warning(response['tryCatchError'] + "<br>" +
                //     'Try Catch Error');
                // }
            }
            
            $("#iBtnEditUserIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditUser").removeAttr('disabled');
            $("#iBtnEditUserIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnEditUserIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditUser").removeAttr('disabled');
            $("#iBtnEditUserIcon").addClass('fa fa-check');
        }
    });
}

// =========================EDIT BILLING===================
function EditBilling(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "edit_billing",
        method: "post",
        data: $('#formEditBilling').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnEditBilling").addClass('fa fa-spinner fa-pulse');
            $("#btnEditBilling").prop('disabled', 'disabled');
        },
        success: function(response){
             if(response['validation'] == 'hasError'){
                toastr.error('Updating User Failed!');

                if(response['error']['edtBillingname'] === undefined){
                    $("#txtEditBillingName").removeClass('is-invalid');
                    $("#txtEditBillingName").attr('title', '');
                }
                else{
                    $("#txtEditBillingName").addClass('is-invalid');
                    $("#txtEditBillingName").attr('title', response['error']['edtBillingname']);
                }

                if(response['error']['edtBillingDueDate'] === undefined){
                    $("#txtEditDueDate").removeClass('is-invalid');
                    $("#txtEditDueDate").attr('title', '');
                }
                else{
                    $("#txtEditDueDate").addClass('is-invalid');
                    $("#txtEditDueDate").attr('title', response['error']['edtBillingDueDate']);
                }

                if(response['error']['edtBillingPersonincharge'] === undefined){
                    $("#txtEditPersonincharge").removeClass('is-invalid');
                    $("#txtEditPersonincharge").attr('title', '');
                }
                else{
                    $("#txtEditPersonincharge").addClass('is-invalid');
                    $("#txtEditPersonincharge").attr('title', response['error']['edtBillingPersonincharge']);
                }

                $("#iBtnEditBilling").removeClass('fa fa-spinner fa-pulse');
                $("#btnEditBilling").removeAttr('disabled');
                $("#iBtnEditBilling").addClass('fa fa-check');
            }else{
                if(response['result'] == 1){
                    $("#modalEditBilling").modal('hide');
                    $("#formEditBilling")[0].reset();  



                    

                    dataTableUsers.draw();
                    // console.log(response['result']);
                    
                    toastr.success('Billing/License was succesfully updated!');
                }
                else{
                    toastr.warning(response['tryCatchError'] + "<br>" +
                    'Try Catch Error');
                }
            }
            
            $("#iBtnEditBilling").removeClass('fa fa-spinner fa-pulse');
            $("#btnEditBilling").removeAttr('disabled');
            $("#iBtnEditBilling").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
           
        }
    });
}


// =======================GET LIST OF PERSON IN CHARGE FOR SELECT====================

function GetPerson(cboElement){
    let result = '<option value="0" selected disabled>N/A</option>';
    $.ajax({
        url: 'get_person_list',
        method: 'get',
        dataType: 'json',
        beforeSend: function(){
            result = '<option value="0" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function(JsonObject){
            result = '';
            if(JsonObject['person'].length > 0){
                result = '<option value="0" selected disabled>--Select--</option>';
                for(let index = 0; index < JsonObject['person'].length; index++){
                    
                    result += '<option value="' + JsonObject['person'][index].id + '">' + JsonObject['person'][index].person_name + '</option>';
                }
            }
            else{
                result = '<option value="0" selected disabled> -- No record found -- </option>';
            }

            cboElement.html(result);

        },
        error: function(data, xhr, status){
            result = '<option value=""> -- Reload Again -- </option>';
            cboElement.html(result);
            console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

// ======================================DELETE/PAID=======================
function GetReminderIdForDel(reminderID){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "delete_reminder",
        method: "get",
        data: {
            reminder_id: reminderID
        },
        dataType: "json",
        beforeSend: function(){
            $("#iBtnPaidIcon").addClass('fa fa-spinner fa-pulse');
            $("#paidDeleteBtn").prop('disabled', 'disabled');
        },
        success: function(response){
           
            if(response['result'] == 1){

                $("#iBtnPaidIcon").removeClass('fa fa-spinner fa-pulse');
                $("#paidDeleteBtn").removeAttr('disabled');
                $("#iBtnPaidIcon").addClass('fa fa-check');

                   $("#modalPaid"+response['id']).modal('hide');
                    // $("#formEditBilling")[0].reset();  

                dataTableUsers.draw();
                toastr.success('Billing/License was paid and moved to archive');
            }
            else{
                toastr.warning('No Record Found!');
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}



//==============================SIGN OUT==============================
function SignOut(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "sign_out",
        method: "post",
        data: $('#formSignOut').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnSignOutIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnSignOut").prop('disabled', 'disabled');
        },
        success: function(response){
            $("#iBtnSignOutIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSignOut").removeAttr('disabled');
            $("#iBtnSignOutIcon").addClass('fa fa-check');
            if(response['result'] == 1){
                window.location = "/iss_reminder/";
            }
            else{
                toastr.error('Logout Failed!');
            }
        },
        error: function(data, xhr, status){
            // toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnSignOutIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSignOut").removeAttr('disabled');
            $("#iBtnSignOutIcon").addClass('fa fa-check');
        }
    });
}
  // ================================AUTO MAILER===================

function Datecomparison(){
    
    $.ajax({
        url: "date_comparison",
        method: "get",
        dataType: "json",
        success: function(response){

            let reminders = response['date'];
            
            let i, dbdate;

          
            for(i=0;i<reminders.length;i++){
                // console.log(reminders[i].reminder_duedate);
                dbdate = reminders[i].reminder_duedate;
                dbId = reminders[i].id;

                // console.log(dbdate," dbdate");
              
                var MyDate = new Date(dbdate);

                MyDate.setMonth(MyDate.getMonth()-1);


                //  MyDateString =  MyDate.getFullYear() + '-'
                //  + ('0' + (MyDate.getMonth()+1)).slice(-2) + '-'
                //  + ('0' + MyDate.getDate()).slice(-2);

                 MyDateString =   ('0' + (MyDate.getMonth()+1)).slice(-2)+ '/'
                 + ('0' + MyDate.getDate()).slice(-2) + '/'
                 + MyDate.getFullYear();




                // console.log(MyDateString, "MyDateString 30days before the db date, for comparison");

                var start_email_date = new Date();

                // emailDate =  start_email_date.getFullYear() + '-'
                //  + ('0' + (start_email_date.getMonth()+1)).slice(-2) + '-'
                //  + ('0' + start_email_date.getDate()).slice(-2);

                emailDate = ('0' + (start_email_date.getMonth()+1)).slice(-2) + '/'
                 + ('0' + start_email_date.getDate()).slice(-2) + '/'
                 +  start_email_date.getFullYear();
                 

                // console.log(emailDate ,"emailDate (date today)");

                if( (emailDate >= MyDateString && emailDate != dbdate) && (emailDate<dbdate) ){
                    sendingEmail(dbId);
                    // console.log(dbId,"send email");
                    
                
                }
                if(dbdate <= emailDate){
                    sendingTicket(dbId);
                    // console.log('send ticket');
                }

            } 
        }
            
    });
}
function sendingEmail(dbId){
    $.ajax({
        url: "send_email",
        method: "get",
        data: {
            email_id: dbId
        },
        dataType: "json",
    });
}

function sendingTicket(dbId){
    $.ajax({
        url: "send_ticket",
        method: "get",
        data: {
            ticket_id: dbId
        },
        dataType: "json",
        success: function(response){
        
        }
            
    });
}
               
