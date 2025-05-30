function GetUserDropdown(cboElement){
    let result = "<option value='0' selected disable>N/A</option>";

    $.ajax({
        url: 'get_rapidx_user',
        method: 'get',
        dataType: 'json',
        beforeSend: function(){
            result = '<option value="0" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function(JsonObject){

            
            result = '';
            if(JsonObject['result'].length > 0){
                result = '<option value="0" selected disabled>--Select--</option>';
                for(let index = 0; index < JsonObject['result'].length; index++){
                    
                    result += '<option value="' + JsonObject['result'][index].id + '">' + JsonObject['result'][index].name + '</option>';
                }
            }
            else{
                result = '<option value="0" selected disabled> -- No record found -- </option>';
            }

            cboElement.html(result);

        },
        // error: function(data, xhr, status){
        //     result = '<option value=""> -- Reload Again -- </option>';
        //     cboElement.html(result);
        //     console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        // }
    });
}

function addUser(){
    // test = $('#add_user_form').serialize();
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
        url: "add_user",
        method: "post",
        data: $('#add_user_form').serialize(),
        dataType: "json",
       
        success: function(response){

            if(response['validation'] == 'hasError'){
                toastr.error('Adding User Fail!');

                if(response['error']['rapidx_user'] === undefined){
                    $("#txtRapidxUser").removeClass('is-invalid');
                    $("#txtRapidxUser").attr('title', '');
                }
                else{
                    $("#txtRapidxUser").addClass('is-invalid');
                    $("#txtRapidxUser").attr('title', response['error']['rapidx_user']);
                }

                if(response['error']['access_level'] === undefined){
                    $("#selectAccessLevel").removeClass('is-invalid');
                    $("#selectAccessLevel").attr('title', '');
                }
                else{
                    $("#selectAccessLevel").addClass('is-invalid');
                    $("#selectAccessLevel").attr('title', response['error']['access_level']);
                }

                if(response['error']['user_department'] === undefined){
                    $("#selectUserDeparment").removeClass('is-invalid');
                    $("#selectUserDeparment").attr('title', '');
                }
                else{
                    $("#selectUserDeparment").addClass('is-invalid');
                    $("#selectUserDeparment").attr('title', response['error']['user_department']);
                }

                if(response['error']['autorize'] === undefined){
                    $("#selectAuthorize").removeClass('is-invalid');
                    $("#selectAuthorize").attr('title', '');
                }
                else{
                    $("#selectAuthorize").addClass('is-invalid');
                    $("#selectAuthorize").attr('title', response['error']['autorize']);
                }
            }
            
            if(response['result'] == 1){
                toastr.success('Adding User Successfully');
                $('#modalAddUser').modal('hide');
                dataTableUser.draw();
            }
            else if(response['result'] == 2){
                toastr.success('Edit User Successfully');
                $('#modalAddUser').modal('hide');
                dataTableUser.draw();
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
         
        }
    });
}

function getUserEmail(rapidxId){
    $.ajax({
        url: "get_user_email",
        method: "get",
        data:{
            rapidxId : rapidxId,
        },
        dataType: "json",
       
        success: function(response){
            // console.log(response['email']);
            if(response['email'] == null){

                $('#txtRapidxEmail').val('kiosk@pricon.ph');
            }
            else{

                $('#txtRapidxEmail').val(response['email']);
            }
        },
    });
}

function getUserDetailsForEdit(userId){
    $.ajax({
        url: "get_user_details_for_edit",
        method: "get",
        data:{
            userId : userId,
        },
        dataType: "json",
       
        success: function(response){
            console.log(response);
          $('#txtRapidxUser').val(response['result'][0]['rapidx_id']).trigger('change');
          $('#selectAccessLevel').val(response['result'][0]['access_level']).trigger('change');
          $('#selectUserDeparment').val(response['result'][0]['department']).trigger('change');
          $('#selectAuthorize').val(response['result'][0]['authorize']).trigger('change');
          if(response['result'][0]['approver'] == 1){
            $('#checkboxWhseApprover').prop("checked", true);
          }
          else{
            $('#checkboxWhseApprover').prop("checked", false);

          }
        
        },
    });
}
function userDelete(userId){
    $.ajax({
        url: "delete_user",
        method: "get",
        data:{
            userId : userId,
        },
        dataType: "json",
       
        success: function(response){
            if(response['result'] == 1){
                toastr.success('Delete user successfully');
                $('#modalUserDelete').modal('hide');
                dataTableUser.draw();
            }
        },
    });
}

function userEnable(userId){
    $.ajax({
        url: "enable_user",
        method: "get",
        data:{
            userId : userId,
        },
        dataType: "json",
       
        success: function(response){
            if(response['result'] == 1){
                toastr.success('Enable user successfully');
                $('#modalUserRestore').modal('hide');
                dataTableUser.draw();
            }
        },
    });
}