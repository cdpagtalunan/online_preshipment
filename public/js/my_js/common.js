//Verify User Access
function verifyUser(loginUserId){
    $.ajax({
        url : "get_user_for_verify_login",
        method : "get",
        data : {
            loginUserId : loginUserId
        },
        dataType : "json",
        success : function(response){
            let x;

            if(response['result'] == 1){
                if(response['admin'] == 1){
                    $('#divMaterialHandlerId').css('display','block');
                    $('#divInspectorId').css('display','block');
                    $('#divPPSWarehouseId').css('display','block');
                    $('#divTSCNWarehouseId').css('display','block');
                    $('#divUserManagementId').css('display','block');
                    $('#divDestinationManagementId').css('display','block');

                    $('#h-material-handler').css('display','block');
                    $('#h-inspector').css('display','block');
                    $('#h-pps-whse').css('display','block');
                    $('#h-tscn-whse').css('display','block');

                    $('#whse-approver-tab').css('display','block');

                }
                else{
                    for(x = 0; x<response['userDetails'].length; x++){
                        console.log(response['userDetails'][x]['department']);
                        console.log(response['userDetails'][x]['approver']);
                        if(response['userDetails'][x]['department'] == 'material handler'){
                            
                            $('#divMaterialHandlerId').css('display','block');
                            $('#h-material-handler').css('display','block');
                        }
                        if(response['userDetails'][x]['department'] == 'inspector'){
                            $('#divInspectorId').css('display','block');
                            $('#h-inspector').css('display','block');

                        }
                        if(response['userDetails'][x]['department'] == 'PPS WHSE'){
                            $('#divPPSWarehouseId').css('display','block');
                            $('#h-pps-whse').css('display','block');
                        }
                        if(response['userDetails'][x]['department'] == 'TS WHSE' || response['userDetails'][x]['department'] == 'CN WHSE' || response['userDetails'][x]['department'] == 'TS/CN WHSE'){
                            if(response['userDetails'][x]['approver'] == 1){
                                $('#whse-approver-tab').css('display','block');
                            }
                            $('#divTSCNWarehouseId').css('display','block');
                            $('#h-tscn-whse').css('display','block');
                        }
                    }
                }
            }
            else{
                window.location.href = 'error';

            }
        },
    });
}



// Reset Form values function
function resetFormUploadValues() {
    // Reset values

    $('#txtApprovingID').val('');
    $('#txtPreshipmentId').val('');
    $('#txtPreshipmentProductLine').val('');
    $('#txtApprovingPackingListControlNo').val('');
    $('#txtApprovingDate').val('');
    $('#txtApproveShipDate').val('');
    $('#txtApprovingStation').val('');
    $('#txtApprovingDestination').val('');
    $('#txtApprovingCheckBy').val('');
    $('#txtApprovingInvoinceNo').val('');
    $('#txtApprovingReceivingNo').val('');

    $('#chckWbsLocalMatRecId').prop('checked', false);
    $('#txtApprovingInvoinceNo').prop('readonly', true);

}

// Reset values when modalAddCustomerClaim(Modal) is closed
$("#modalViewWhsePreshipmentForUpload").on('hidden.bs.modal', function () {
    console.log('modal is closed');
    resetFormUploadValues();
});



// Reset Form values function
function resetAddValues() {
    // Reset values

    $('#add_user_form')[0].reset();
    $('#checkboxWhseApprover').prop('checked', false);
}

// Reset values when modalAddCustomerClaim(Modal) is closed
$("#modalAddUser").on('hidden.bs.modal', function () {
    console.log('modal #modalAddUser is closed');
    resetAddValues();
});



// Reset MH values function
function resetMHModalValues() {
    // Reset values

    $('#form_packing_list')[0].reset();
    $('#btnScanItem').removeClass('d-none');
    $('#divFooter').removeClass('d-none');
    console.log('#form_packing_list has been reset');
    // $('#checkboxWhseApprover').prop('checked', false);
}

// Reset values when modalAddCustomerClaim(Modal) is closed
$("#modalViewMaterialHandlerChecksheets").on('hidden.bs.modal', function () {
    console.log('modal #modalViewMaterialHandlerChecksheets is closed');
    resetMHModalValues();
});


// Reset MH values function
function resetQCModalValues() {
    // Reset values

    $('#form_packing_list')[0].reset();
    $('#approveFormid')[0].reset();
    $('#DisapproveFormid')[0].reset();
    console.log('#resetQCModalValues has been reset');
    // $('#checkboxWhseApprover').prop('checked', false);
}

// Reset values when modalAddCustomerClaim(Modal) is closed
$("#modalViewQCChecksheets").on('hidden.bs.modal', function () {
    console.log('modal #modalViewQCChecksheets is closed');
    resetQCModalValues();
});


// Reset Supervisor Approval Modal values function
function resetSupervisorModalValues() {
    // Reset values

    // $('#form_packing_list')[0].reset();
    // $('#approveFormid')[0].reset();
    // $('#DisapproveFormid')[0].reset();
    $('#txtApprovingSuperiorInvoiceNum').val('');
    $('#txtApprovingSuperiorReceivingNum').val('');
    $('#txtApprovingSuperiorCheckBy').val('');
    $('#txtApprovingSuperiorReceiveBy').val('');
    $('#txtApprovingSuperiorUploadedBy').val('');
    console.log('#modalViewWhsePreshipmentForSupApproval has been reset');
    // $('#checkboxWhseApprover').prop('checked', false);
}

// Reset values when modalAddCustomerClaim(Modal) is closed
$("#modalViewWhsePreshipmentForSupApproval").on('hidden.bs.modal', function () {
    console.log('modal #modalViewWhsePreshipmentForSupApproval is closed');
    resetSupervisorModalValues();
});

// SCRIPT TO ADD DETAILS FOR INVALID PRESHIPMENT

function addInvalidDetails(scannedId,invalidRemarks,invalidModule,preshipmentId,prodLine){
    $.ajax({
        url: "add_invalid_details",
        type: "post",
        data: {
            emp_id          : scannedId,
            remarks         : invalidRemarks,
            invalid_module  : invalidModule,
            preshipment_id  : preshipmentId
        },
        dataType: "json",
        success: function (response) {
            
        }
    });
}

// Reset function
function resetDoneModal() {
    // Reset values

    $('#formDoneUploadId')[0].reset();
    
    $('#modalDoneUpload .modal-content .modal-body .modal-title').text('Are you sure you are done uploading?');
    $('#modalDoneUpload .modal-content .modal-header').removeClass('bg-danger');

    // $('#approveFormid')[0].reset();
    // $('#DisapproveFormid')[0].reset();
    // console.log('#resetQCModalValues has been reset');
    // $('#checkboxWhseApprover').prop('checked', false);
}

// Reset values when modalDoneUpload(Modal) is closed
$("#modalDoneUpload").on('hidden.bs.modal', function () {
    console.log('modal #modalDoneUpload is closed');
    resetDoneModal();
});

// Reset function
function resetDoneSuppModal() {
    // Reset values

    $('#formSuperiorApprove')[0].reset();
    
    $('#modalSuperiorApprove .modal-content .modal-body .modal-title').text('Are you sure you are done uploading?');
    $('#modalSuperiorApprove .modal-content .modal-header').removeClass('bg-danger');

    // $('#approveFormid')[0].reset();
    // $('#DisapproveFormid')[0].reset();
    // console.log('#resetQCModalValues has been reset');
    // $('#checkboxWhseApprover').prop('checked', false);
}

// Reset values when modalSuperiorApprove(Modal) is closed
$("#modalSuperiorApprove").on('hidden.bs.modal', function () {
    console.log('modal #modalSuperiorApprove is closed');
    resetDoneSuppModal();
});


