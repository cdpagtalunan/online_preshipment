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
                        if(response['userDetails'][x]['department'] == 'TS WHSE' || response['userDetails'][x]['department'] == 'CN WHSE'){
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


// function itemVerification(arr){
//     toastr.options = {
//         "closeButton": false,
//         "debug": false,
//         "newestOnTop": true,
//         "progressBar": true,
//         "positionClass": "toast-top-right",
//         "preventDuplicates": false,
//         "onclick": null,
//         "showDuration": "300",
//         "hideDuration": "1000",
//         "timeOut": "1000",
//         "extendedTimeOut": "1000",
//         "showEasing": "swing",
//         "hideEasing": "linear",
//         "showMethod": "fadeIn",
//         "hideMethod": "fadeOut",
//     };


//     let check_data = false;
//     let isInvalid = $('#txtInvalidChecker').val();
//     setTimeout(() => {
//         $('#tbl_preshipment_list tbody tr').each(function(index, tr){
           

//             // var po_num = $(tr).find('td:eq(2)').text();
//             // var partcode = $(tr).find('td:eq(3)').text();
//             // var device_name = $(tr).find('td:eq(4)').text();
//             // var lot_no = $(tr).find('td:eq(5)').text();
//             // var qty = $(tr).find('td:eq(6)').text();
//             // var package_category = $(tr).find('td:eq(7)').text();
//             var po_num = $(tr).find('td:eq(2)').text().toUpperCase();
//             var partcode = $(tr).find('td:eq(3)').text().toUpperCase();
//             var device_name = $(tr).find('td:eq(4)').text().toUpperCase();
//             var lot_no = $(tr).find('td:eq(5)').text().toUpperCase();
//             var qty = $(tr).find('td:eq(6)').text().toUpperCase();
//             var package_category = $(tr).find('td:eq(7)').text().toUpperCase();

//             var package_qty = $(tr).find('td:eq(8)').text();


//             var hdInputVal = $(tr).find('td:eq(12)').text();
//             var hdStampingVal = $(tr).find('td:eq(13)').text();


//             // var hdInputVal = tr1.getElementsByTagName("td")[11].innerHTML;
//             console.log("is invalid: "+isInvalid);

//             var checkedOk = $(tr).hasClass('checked-ok');
//             console.log(checkedOk);
//             if(arr[0].trim() == po_num && arr[1].trim() == partcode && arr[2].trim() == device_name && arr[3].trim() == lot_no && arr[4].trim() == qty && arr[5].trim() == package_category){
//                 // console.log('qweqwe');
//                 check_data = true;
//                 // if(checkedOk != true){
//                     if(hdStampingVal == 'stamping'){
//                         let hiddenColumnId = $(tr).find('td:eq(1)').text();
//                         console.log(hiddenColumnId);
//                         $('#toScrollId').attr('href', "#"+hiddenColumnId);
//                         $('#toScrollId')[0].click();
//                         const element = document.getElementById('txtScanPreshipment')
//                         // const element = document.getElementById('txtForScanner')
//                         element.focus({
//                             preventScroll: true
//                         });
    
//                         setTimeout(() => {
//                             $(tr).removeClass('checked-ng');
//                             $(tr).addClass('checked-partial');
//                             $(tr).find('td:eq(13)').text("");
//                         }, 500);
//                         return false;

//                     }
//                     else{
//                         console.log(hdInputVal);
//                         if(hdInputVal == "" || hdInputVal == 1){
//                             if(arr[6].trim() == "1/1" || arr[6].trim() == "1"){
//                                 // $(tr).removeClass('checked-ng');
//                                 // $(tr).addClass('checked-ok');
//                                 // $(tr).scrollIntoView({behavior: "smooth"});
//                                 // tr.getElementsByTagName("td")[11].innerHTML = "0";
//                                 $(tr).find('td:eq(12)').text("0");
//                                 console.log("checked-green");
                                
//                                 let hiddenColumnId = $(tr).find('td:eq(1)').text();
    
//                                 console.log(hiddenColumnId);
    
//                                 $('#toScrollId').attr('href', "#"+hiddenColumnId);
    
//                                 $('#toScrollId')[0].click();
    
                            
    
//                                 saveInfoForMH(po_num,partcode,device_name,lot_no,qty,package_category,package_qty);
//                                 // $('#btnScanItem')[0].click();
//                                 const element = document.getElementById('txtScanPreshipment')
//                                 // const element = document.getElementById('txtForScanner')
    
//                                 element.focus({
//                                     preventScroll: true
//                                 });
    
//                                 setTimeout(() => {
//                                     $(tr).removeClass('checked-partial');
//                                     $(tr).removeClass('checked-ng');
//                                     $(tr).addClass('checked-ok');
//                                 }, 500);
//                                 return false;

    
//                             }
//                             else{
//                                 // $(tr).removeClass('checked-ng');
//                                 // $(tr).addClass('checked-ok');
//                                 // $(tr).scrollIntoView({behavior: "smooth"});
//                                 // tr.getElementsByTagName("td")[11].innerHTML = "0";
//                                 $(tr).find('td:eq(12)').text("0");
    
//                                 let hiddenColumnId = $(tr).find('td:eq(1)').text();
//                                 console.log(hiddenColumnId);
    
//                                 $('#toScrollId').attr('href', "#"+hiddenColumnId);
    
//                                 $('#toScrollId')[0].click();
                                
    
    
    
//                                 saveInfoForMH(po_num,partcode,device_name,lot_no,qty,package_category,package_qty);
//                                 // $('#btnScanItem')[0].click();
//                                 const element = document.getElementById('txtScanPreshipment')
//                                 // const element = document.getElementById('txtForScanner')
    
//                                 element.focus({
//                                     preventScroll: true
//                                 });
    
//                                 setTimeout(() => {
//                                     $(tr).removeClass('checked-partial');
//                                     $(tr).removeClass('checked-ng');
//                                     $(tr).addClass('checked-ok');
//                                 }, 500);
//                                 return false;

    
//                             }
//                         }
//                         // else if(hdInputVal > 1){
//                         else if(hdInputVal != 1 && hdInputVal != "DO"){ // For preshipment with over (1~3)
//                             if(hdInputVal != 0){
//                                 // hdInputVal = hdInputVal - 1;
//                                 // // tr.getElementsByTagName("td")[11].innerHTML = hdInputVal;
//                                 // $(tr).find('td:eq(12)').text(hdInputVal);
//                                 // console.log("checked need to scan "+hdInputVal+" more");
    
//                                 let replacedInputVal = "";
    
//                                 replacedInputVal = hdInputVal.replace(arr[6].trim(),'');
//                                 console.log(hdInputVal);
//                                 console.log(replacedInputVal);
//                                 $(tr).find('td:eq(12)').text(replacedInputVal);
//                                 $(tr).addClass('checked-partial');
//                                 // $(tr).addClass('checked-ok');
    
//                                 // to replace the yellow highlight to green when all sticker count is scanned
                                
//                                 // For autoscrolling
//                                 let hiddenColumnId = $(tr).find('td:eq(1)').text();
//                                 console.log(hiddenColumnId);
//                                 $('#toScrollId').attr('href', "#"+hiddenColumnId);
                                
//                                 $('#toScrollId')[0].click();
//                                 const element = document.getElementById('txtScanPreshipment')
//                                 // const element = document.getElementById('txtForScanner')
                                
//                                 element.focus({
//                                     preventScroll: true
//                                 });
    
    
//                                 if(replacedInputVal == ""){
//                                     $(tr).removeClass('checked-partial');
//                                     // console.log('123');
//                                     $(tr).addClass('checked-ok');
//                                     saveInfoForMH(po_num,partcode,device_name,lot_no,qty,package_category,package_qty);
//                                     return false;

//                                 }
//                                 return false;

//                             }
//                         }
//                         else if(hdInputVal == "DO"){
//                             if(arr[6].trim() == "1/1"){
//                                 // $(tr).removeClass('checked-ng');
//                                 // $(tr).addClass('checked-ok');
//                                 // $(tr).scrollIntoView({behavior: "smooth"});
//                                 // tr.getElementsByTagName("td")[11].innerHTML = "0";
//                                 $(tr).find('td:eq(12)').text("0");
    
//                                 let hiddenColumnId = $(tr).find('td:eq(1)').text();
//                                 console.log(hiddenColumnId);
    
//                                 $('#toScrollId').attr('href', "#"+hiddenColumnId);
    
//                                 $('#toScrollId')[0].click();
                                
    
//                                 saveInfoForMH(po_num,partcode,device_name,lot_no,qty,package_category,package_qty);
//                                 // $('#btnScanItem')[0].click();
//                                 const element = document.getElementById('txtScanPreshipment')
//                                 // const element = document.getElementById('txtForScanner')
    
//                                 element.focus({
//                                     preventScroll: true
//                                 });
    
//                                 setTimeout(() => {
//                                     $(tr).removeClass('checked-partial');
//                                     $(tr).removeClass('checked-ng');
//                                     $(tr).addClass('checked-ok');
//                                 }, 500);
//                                 return false;

    
//                             }
//                         }
//                     }
//                 // }
//                 // else{
//                     // check_data = false;
//                     // toastr.error('Invalid! QR already scanned.');

//                 // }
//             }
//             // else{
//             //     check_data = false;

//             // }
//         });

//         setTimeout(() => {
//             if(arr.length <= 6){
//                 toastr.error('Invalid! QR is not for Preshipment.');
//                 console.log('invalid  QR is not for Preshipment');
//             }
//             else if(!check_data){
//                 toastr.error('Invalid! No Data Found.')
//                 console.log('invalid scanning data');
//                 $.ajax({
//                     url: "add_invalid",
//                     type: "post",
//                     data:{
//                         preshipment_id: $('#packingId').val(),
//                         from : 'MH',
//                     },
//                     dataType: "json",
//                     success: function (response) {
//                         $('#txtInvalidChecker').val('1').trigger('change');
//                     }
//                 });
//             }
//         }, 400);
//     }, 400);



// }

