function getPreshipmentDetailsById(preshipment_id){
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
        url: "get_preshipment_by_id_for_whse",
        method: "get",
        data: {
            preshipment_id: preshipment_id
        },
        dataType: "json",
        beforeSend: function(){
           

        },
        success: function(response){
        
            console.log(response);
            $('#preshipmentId').val(response['preshipment']['id']);

            $('#packingControlNoId').val(response['preshipment']['Packing_List_CtrlNo']);
            $('#packingDateId').val(response['preshipment']['Date']);
            $('#packingShipmentDateId').val(response['preshipment']['Shipment_Date']);
            $('#packingStationId').val(response['preshipment']['Station']);
            $('#packingDestinationId').val(response['preshipment']['Destination']);
            // $('#txtCheckby').val(response['approver']['from_user_details']['rapidx_user_details']['name']);
            
            dataTableWhsePreshipmentList.draw();
        },
        // error: function(data, xhr, status){
        //     toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        //     $("#iBtnSignInIcon").removeClass('fa fa-spinner fa-pulse');
        //     $("#btnSignIn").removeAttr('disabled');
        //     $("#iBtnSignInIcon").addClass('fa fa-check');
        // }
    });
}


function getPreshipmentDetailsForApproval(preshipmentId){
    $.ajax({
        url: "get_preshipment_by_id_for_approval_whse",
        method: "get",
        data: {
            preshipmentId: preshipmentId
        },
        dataType: "json",
        success: function(response){
            console.log(response);
           
            var ctrlNo = `${response['result']['preshipment']['Destination']}-${response['result']['preshipment']['Packing_List_CtrlNo']}`;
            $('#txt_preshipment_approval_id').val(response['result']['id'])
            $('#txtAcceptDate').val(response['result']['preshipment']['Date']);
            $('#txtAcceptShipCtrlNo').val(ctrlNo);
            $('#txtAcceptShipDate').val(response['result']['preshipment']['Shipment_Date']);
            $('#txtAcceptShipDestination').val(response['result']['preshipment']['Destination']);
            $('#txtAcceptShipQcChecker').val(response['result']['qc_approver_details']['rapidx_user_details']['name']);

            var ts = ["Burn-in Sockets","Grinding"];
            var cn = ["Flexicon & Connectors","FUS/FRS/FMS Connector","Card Connector","TC/DC Connector"];
            

        
            if(jQuery.inArray(response['result']['preshipment']['Destination'], ts) != -1){
                // console.log('ts');
                $('#txtAcceptShipSendTo').val('ts').trigger('change');

            }
            else if(jQuery.inArray(response['result']['preshipment']['Destination'], cn) != -1){
                // console.log('cn');
                $('#txtAcceptShipSendTo').val('cn').trigger('change');


            }

        },
    });
}

function sendPreshipmentToWhse(){
    $.ajax({
        url: "send_preshipment_from_whse_to_whse",
        method: "get",
        data: $('#formApproveWhse').serialize(),
        dataType: "json",
        beforeSend: function(){
            $('#btnWhseSendShipment').prop('disabled', true);
        },
        success: function(response){
            if(response['result'] == 1){
                toastr.success('Transaction Successful');
                $('#modalWhsApprove').modal('hide');
                dataTableWhsePreshipment.draw();

                $('#btnWhseSendShipment').prop('disabled', false);

            }
        },  
    });
}

function itemVerificationTSCNWhse(arr){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "2000",
        "timeOut": "1000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };
    let check_data = false;
   
    setTimeout(() => {
        $('#tbl_whs_preshipment_list tbody tr').each(function(index, tr){
           

            var po_num = $(tr).find('td:eq(2)').text().toUpperCase();
            var partcode = $(tr).find('td:eq(3)').text().toUpperCase();
            var device_name = $(tr).find('td:eq(4)').text().toUpperCase();
            var lot_no = $(tr).find('td:eq(5)').text().toUpperCase();
            var qty = $(tr).find('td:eq(6)').text().toUpperCase();
            var package_category = $(tr).find('td:eq(7)').text().toUpperCase();
            var package_qty = $(tr).find('td:eq(8)').text();


            var hdInputVal = $(tr).find('td:eq(12)').text();

            // var hdInputVal = tr1.getElementsByTagName("td")[11].innerHTML;
            // console.log(arr[0].toUpperCase());

            var checkedOk = $(tr).hasClass('checked-ok');
            console.log('checking:'+checkedOk);
            if(arr[0].trim() == po_num && arr[1].trim() == partcode && arr[2].trim() == device_name && arr[3].trim() == lot_no && arr[4].trim() == qty && arr[5].trim() == package_category){
                // if(checkedOk != true){

                // }
                // else{
                    check_data = true;

                    if(hdInputVal == "" || hdInputVal == 1){
                        if(arr[6].trim() == "1/1" || arr[6].trim() == "1"){
                            $(tr).removeClass('checked-ng');
                            $(tr).addClass('checked-ok');
                            // $(tr).scrollIntoView({behavior: "smooth"});
                            // tr.getElementsByTagName("td")[11].innerHTML = "0";
                            $(tr).find('td:eq(12)').text("0");
                            console.log("checked-green");
                            
                            let hiddenColumnId = $(tr).find('td:eq(1)').text();
    
                            console.log(hiddenColumnId);
    
                            $('#toScrollId').attr('href', "#"+hiddenColumnId);
    
                            $('#toScrollId')[0].click();
    
                        
    
                            saveInfoForWhse(po_num,partcode,device_name,lot_no,qty,package_category,package_qty);
                            // $('#btnScanItem')[0].click();
                            // setTimeout(() => {
                            //     $('#txtForScanner').focus();
                            // }, 500);
                            const element = document.getElementById('txtForScanner')
    
                            element.focus({
                                preventScroll: true
                            });

                            return false;
    
                        }
                        else{
                            $(tr).removeClass('checked-ng');
                            $(tr).addClass('checked-ok');
                            // $(tr).scrollIntoView({behavior: "smooth"});
                            // tr.getElementsByTagName("td")[11].innerHTML = "0";
                            $(tr).find('td:eq(12)').text("0");
    
                            let hiddenColumnId = $(tr).find('td:eq(1)').text();
                            console.log(hiddenColumnId);
    
                            $('#toScrollId').attr('href', "#"+hiddenColumnId);
    
                            $('#toScrollId')[0].click();
                            
    
    
    
                            saveInfoForWhse(po_num,partcode,device_name,lot_no,qty,package_category,package_qty);
                            // setTimeout(() => {
                            //     $('#txtForScanner').focus();
                            // }, 500);
                            const element = document.getElementById('txtForScanner')
    
                            element.focus({
                                preventScroll: true
                            });
                            return false;

    
                        }
                    }
                    else if(hdInputVal != 1 && hdInputVal != "DO"){
                        if(hdInputVal != 0){
                            // hdInputVal = hdInputVal - 1;
                            // tr.getElementsByTagName("td")[11].innerHTML = hdInputVal;
                            
                            let replacedInputVal = "";
    
                            replacedInputVal = hdInputVal.replace(arr[6].trim(),'');
                            console.log(hdInputVal);
                            console.log(replacedInputVal);
                            $(tr).find('td:eq(12)').text(replacedInputVal);
                            $(tr).addClass('checked-partial');
                            // $(tr).addClass('checked-ok');
    
    
                            if(replacedInputVal == ""){
                                $(tr).removeClass('checked-partial');
                                // console.log('123');
                                $(tr).addClass('checked-ok');
                                saveInfoForWhse(po_num,partcode,device_name,lot_no,qty,package_category,package_qty);
                                return false;

    
                            }
    
                            let hiddenColumnId = $(tr).find('td:eq(1)').text();
                            $('#toScrollId').attr('href', "#"+hiddenColumnId);
    
                            $('#toScrollId')[0].click();
                            
                            const element = document.getElementById('txtForScanner')
    
                            element.focus({
                                preventScroll: true
                            });
                            return false;

                            // console.log("checked need to scasn "+hdInputVal+" more");
    
                            // console.log(typeof hdInputVal);
    
    
                        }
                    }
                    else if(hdInputVal == "DO"){
                        if(arr[6].trim() == "1/1"){
                            $(tr).removeClass('checked-ng');
                            $(tr).addClass('checked-ok');
                            // $(tr).scrollIntoView({behavior: "smooth"});
                            // tr.getElementsByTagName("td")[11].innerHTML = "0";
                            $(tr).find('td:eq(12)').text("0");
    
                            let hiddenColumnId = $(tr).find('td:eq(1)').text();
                            console.log(hiddenColumnId);
    
                            $('#toScrollId').attr('href', "#"+hiddenColumnId);
    
                            $('#toScrollId')[0].click();
                            
    
                            saveInfoForWhse(po_num,partcode,device_name,lot_no,qty,package_category,package_qty);
                            // $('#btnScanItem')[0].click();
                            // setTimeout(() => {
                            //     $('#txtForScanner').focus();
                            // }, 500);
                            const element = document.getElementById('txtForScanner')
    
                            element.focus({
                                preventScroll: true
                            });
                            return false;

    
                        }
                    }
                // }

                
                            
            }
            // else{
            //     check_data = false;
            // }
            // console.log(checkedOk);
        });
        setTimeout(() => {
            if(arr.length <= 6){
                toastr.error('Invalid! QR is not for Preshipment.');
                console.log('invalid  QR is not for Preshipment');
            }
            else if(!check_data){
                // toastr.error('Invalid! No Data Found.')
                alert('Invalid! No Data Found.');

                console.log('invalid scanning data');
                $.ajax({
                    url: "add_invalid_whse",
                    type: "post",
                    data:{
                        preshipment_id: $('#preshipmentId').val(),
                        from : $('#txtPreshipmentProductLine').val()
                    },
                    dataType: "json",
                    success: function (response) {
                        $('#txtInvalidChecker').val('1').trigger('change');
                    }
                });
            }
        }, 400);
    }, 400);


}
function saveInfoForWhse(po_num,partcode,device_name,lot_no,qty,package_category,package_qty){

    // console.log($('#packingControlNoId').val());
    $.ajax({
        url: "insert_preshipmentlist_for_whse_check",
        method: "get",
        data:{
            po_num : po_num,
            partcode : partcode,
            device_name : device_name,
            lot_no : lot_no,
            qty : qty,
            package_category : package_category,
            package_qty : package_qty,
            preshipment_ctrl_no : $('#packingControlNoId').val()

        },
        dataType: "json",
        success: function(response){
            
        },
    });
}


function acceptPreshipment(){
    $.ajax({
        url: "accept_preshipment",
        method: "post",
        data: $('#acceptFormid').serialize(),
        dataType: "json",
        success: function(response){
           if(response['result'] == 1){
               toastr.success('Preshipment accepted!');
               $('#modalViewWhsePreshipmentReceiving').modal('hide');
               $('#modalApproveId').modal('hide');
               $('#txtInvalidChecker').val('');
               dataTableWhsePreshipment.draw();
           }
        },  
    });
}

function getPreshipmentDetailsByIdForReceiving(preshipment_id){
    $.ajax({
        url: "get_preshipment_by_id_for_receiving",
        method: "get",
        data: {
            preshipment_id: preshipment_id
        },
        dataType: "json",
        beforeSend: function(){
           

        },
        success: function(response){
        
            console.log(response);
            $('#preshipmentId').val(response['preshipmentDetails']['id']);
            $('#txtInvalidChecker').val(response['preshipmentDetails']['is_invalid']);
            $('#txtPreshipmentProductLine').val(response['preshipmentDetails']['send_to']);

            $('#packingControlNoId').val(response['preshipmentDetails']['preshipment']['Packing_List_CtrlNo']);

            $('#packingControlId').val(response['preshipmentDetails']['preshipment']['Destination']+"-"+response['preshipmentDetails']['preshipment']['Packing_List_CtrlNo']);
            $('#packingDateId').val(response['preshipmentDetails']['preshipment']['Date']);
            $('#packingShipmentDateId').val(response['preshipmentDetails']['preshipment']['Shipment_Date']);
            $('#packingStationId').val(response['preshipmentDetails']['preshipment']['Station']);
            $('#packingDestinationId').val(response['preshipmentDetails']['preshipment']['Destination']);
            $('#txtCheckby').val(response['preshipmentDetails']['from_user_details']['rapidx_user_details']['name']);
            
            dataTableWhsePreshipmentList.draw();
            let x = 0;
        

            setTimeout(() => {
                $('#tbl_whs_preshipment_list tbody tr').each(function(index, tr){

                    var po_num = $(tr).find('td:eq(2)').text().toUpperCase();
                    var partcode = $(tr).find('td:eq(3)').text().toUpperCase();
                    var device_name = $(tr).find('td:eq(4)').text().toUpperCase();
                    var lot_no = $(tr).find('td:eq(5)').text().toUpperCase();
                    var qty = $(tr).find('td:eq(6)').text().toUpperCase();
                    var package_category = $(tr).find('td:eq(7)').text().toUpperCase();
                    var package_qty = $(tr).find('td:eq(8)').text();

                    for(let i = 0; i<response['preshipmentList'].length; i++){
                        if(
                            po_num == response['preshipmentList'][i]['PONo'] &&
                            partcode == response['preshipmentList'][i]['Partscode'] &&
                            device_name == response['preshipmentList'][i]['DeviceName'] &&
                            lot_no == response['preshipmentList'][i]['LotNo'] &&
                            qty == response['preshipmentList'][i]['Qty'] &&
                            package_category == response['preshipmentList'][i]['PackageCategory'] &&
                            package_qty == response['preshipmentList'][i]['PackageQty']
                        ){
                            $(tr).addClass('checked-ok');
                        }
                    }
                    x = x + 1;
                    $(tr).find('td:eq(1)').append("<label style='opacity: 0;' id='Row"+x+"'>Row"+x+"</label>");
                });
            }, 400);

           
        },
    });
}

function getPreshipmentDetailsForUpload(id){
    $.ajax({
        url: "get_preshipment_details_for_upload",
        method: "get",
        data: {
            id: id
        },
        dataType: "json",
        success: function(response){

            $('#txtApprovingID').val(response['approvingDetails']['id']);
            $('#txtPreshipmentId').val(response['approvingDetails']['fk_preshipment_id']);
            $('#txtPreshipmentProductLine').val(response['approvingDetails']['send_to']);

            $('#txtApprovingPackingListControlNo').val(response['approvingDetails']['preshipment']['Packing_List_CtrlNo']);

            $('#txtApprovingPackingListControl').val(response['approvingDetails']['preshipment']['Destination']+"-"+response['approvingDetails']['preshipment']['Packing_List_CtrlNo']);

            $('#txtApprovingDate').val(response['approvingDetails']['preshipment']['Date']);
            $('#txtApproveShipDate').val(response['approvingDetails']['preshipment']['Shipment_Date']);
            $('#txtApprovingStation').val(response['approvingDetails']['preshipment']['Station']);
            $('#txtApprovingDestination').val(response['approvingDetails']['preshipment']['Destination']);
            $('#txtApprovingCheckBy').val(response['approvingDetails']['from_user_details']['rapidx_user_details']['name']);

            // $('#txtApprovingInvoinceNo').val(response['approvingDetails']['preshipment_for_approval']['packing_list_ctrlNo']);
            
            dataTableWhsePreshipmentListForUpload.draw();


            
            
            
        },
    });
}

function getInvoiceCtrlNo(id){
    $.ajax({
        url: "get_invoice_ctrl_no_from_rapid",
        method: "get",
        data: {
            id: id
        },
        dataType: "json",
        success: function(response){
            let ctrlNumber;
            if(response['ctrlNo'] != null){
                $('#txtApprovingInvoinceNo').val(response['ctrlNo']['ControlNumber']);

                ctrlNumber = response['ctrlNo']['ControlNumber'];
    
            }
            else{
                $('#txtApprovingInvoinceNo').val(" ");
                ctrlNumber = response['ctrlNo'];
    
            }
            let productLine = response['approvingDetails']['send_to'];


            getWBSReceivingNumber(ctrlNumber,productLine);

    
            


        },
    });
}
function getWBSReceivingNumber(ctrlNumber,productLine){
    $.ajax({
        url: "get_wbs_receiving_number",
        method: "get",
        data:{
            ctrl_number : ctrlNumber,
            product_line : productLine
        },
        dataType: "json",
        success: function(response){
            
            if(response['invoiceNumber'] != null){
                $('#txtApprovingReceivingNo').val(response['invoiceNumber']['receive_no']);
            }

            if($('#txtApprovingInvoinceNo').val() != "" && $('#txtApprovingReceivingNo').val() != ""){
                $('#btnDoneUpload').prop('disabled', false);
            }
            else{
                $('#btnDoneUpload').prop('disabled', true);
            }
          
        },
    });
}

function getWBSLocalReceivingNumber(invoiceNum,productLine){
    $.ajax({
        url: "get_wbs_local_receiving_number",
        method: "get",
        data:{
            invoice_number : invoiceNum,
            product_line : productLine
        },
        dataType: "json",
        success: function(response){
            console.log(response['wbsReceivingNo']);
            $('#txtApprovingReceivingNo').val(response['wbsReceivingNo']['receive_no']);

            if($('#txtApprovingInvoinceNo').val() != "" && $('#txtApprovingReceivingNo').val() != ""){
                $('#btnDoneUpload').prop('disabled', false);
            }
            else{
                $('#btnDoneUpload').prop('disabled', true);
            }
        },
    });
}


function doneUploadingPreshipmentList(){
    $.ajax({
        url: "done_upload_preshipment",
        method: "post",
        data: $('#doneUploadId').serialize(),
        dataType: "json",
        success: function(response){
            if(response['result'] == 1){
                toastr.success('Successfully Updated');
                $('#modalDoneUpload').modal('hide');
                $('#modalViewWhsePreshipmentForUpload').modal('hide');
                dataTableWhsePreshipment.draw();
            }
        },
    });
}

function getPreshipmentDetailsbyIdForSuperior(id){
    $.ajax({
        url: "get_preshipment_details_for_superior",
        method: "get",
        data: {
            id: id
        },
        dataType: "json",
        success: function(response){

            


            $('#txtApprovingId').val(response['approvingDetails'][0]['id']);
            $('#txtApprovingPreshipmentId').val(response['approvingDetails'][0]['fk_preshipment_id']);

            $('#txtApprovingSuperiorCtrlNum').val(response['approvingDetails'][0]['preshipment']['Packing_List_CtrlNo']);

            $('#txtApprovingSuperiorCtrl').val(response['approvingDetails'][0]['preshipment']['Destination']+'-'+response['approvingDetails'][0]['preshipment']['Packing_List_CtrlNo']);
            $('#txtApprovingSuperiorDate').val(response['approvingDetails'][0]['preshipment']['Date']);
            $('#txtApproveSuperiorShipDate').val(response['approvingDetails'][0]['preshipment']['Shipment_Date']);
            $('#txtApprovingSuperiorStation').val(response['approvingDetails'][0]['preshipment']['Station']);
            $('#txtApprovingSuperiorDestination').val(response['approvingDetails'][0]['preshipment']['Destination']);
            $('#txtApprovingSuperiorInvoiceNum').val(response['approvingDetails'][0]['rapid_invoice_number']);
            $('#txtApprovingSuperiorReceivingNum').val(response['approvingDetails'][0]['wbs_receiving_number']);
            $('#txtApprovingSuperiorPreshipmentQty').val(response['totalQty']);
            
            
            $('#txtApprovingSuperiorCheckBy').val(response['approvingDetails'][0]['from_user_details']['rapidx_user_details']['name']);
            $('#txtApprovingSuperiorReceiveBy').val(response['approvingDetails'][0]['to_whse_noter_details']['rapidx_user_details']['name']);
            if(response['approvingDetails'][0]['whse_uploader_details'] != null){
                $('#txtApprovingSuperiorUploadedBy').val(response['approvingDetails'][0]['whse_uploader_details']['rapidx_user_details']['name']);
            }
            dataTableWhseSuperiorPreshipmentList.draw();

        },
    });
}

function superiorApproving(){
    $.ajax({
        url : "superior_approval",
        method : "post",
        data : $('#formSuperiorApprove').serialize(),
        dataType : "json",
        success : function(response){
            if(response['result'] == 1){
                toastr.success('Successfully Approved');
                $('#modalViewWhsePreshipmentForSupApproval').modal('hide');
                $('#modalSuperiorApprove').modal('hide');
                dataTableWhsePreshipment.draw();
                dataTableWhseForApproval.draw();

            }
        },
    });
}
function superiorDisapproving(){
    $.ajax({
        url : "superior_disapproval",
        method : "post",
        data : $('#formSuperiorDisapprove').serialize(),
        dataType : "json",
        success : function(response){
            if(response['result'] == 1){
                toastr.success('Preshipment has been disapprove!');
                $('#modalSuperiorDisapprove').modal('hide');
                $('#modalViewWhsePreshipmentForSupApproval').modal('hide');
                dataTableWhsePreshipment.draw();
                dataTableWhseForApproval.draw();

            }
        },
    });
}

function getPreshipmentForView(id){
    $.ajax({
        url : "get_preshipment_for_whse_view",
        method : "get",
        data : {
            id : id,
        },
        dataType : "json",
        success : function(response){
            console.log(response['result']);
            
            $('#txtViewCtrlNo').val(response['result']['preshipment']['Packing_List_CtrlNo']);

            $('#txtViewCtrl').val(response['result']['preshipment']['Destination']+"-"+response['result']['preshipment']['Packing_List_CtrlNo']);
            $('#txtViewDate').val(response['result']['preshipment']['Date']);
            $('#txtViewShipDate').val(response['result']['preshipment']['Shipment_Date']);
            $('#txtViewStation').val(response['result']['preshipment']['Station']);
            $('#txtViewDestination').val(response['result']['preshipment']['Destination']);
            $('#txtViewInvoinceNum').val(response['result']['rapid_invoice_number']);
            $('#txtViewReceivingNum').val(response['result']['wbs_receiving_number']);

            $('#txtViewPreshipmentId').val(response['result']['fk_preshipment_id']);

            dataTableWhseViewPreshipmentList.draw();
        },
    });
}


function disapprovePreshipment(){
    $.ajax({
        url : "pps_disapprove_preshipment",
        method : "get",
        data : $('#formDisapprovePreshipmentId').serialize(),
        dataType : "json",
        success : function(response){
            if(response['result'] == 1){
                toastr.success('Preshipment disapproved!')
                $('#modalWhsDisapprove').modal('hide');
                dataTableWhsePreshipment.draw();
            }
            else{
                toastr.error('Error please contact administrator!');
            }
        },
    });
}

function rejectPreshipment(){
    $.ajax({
        url : "whse_reject_preshipment",
        method : "post",
        data : $('#formRejectPreshipment').serialize(),
        dataType : "json",
        success : function(response){
            if(response['result'] == 1){
                toastr.success('Preshipment rejected!')
                $('#modalRejectId').modal('hide');
                $('#modalViewWhsePreshipmentReceiving').modal('hide');
                dataTableWhsePreshipment.draw();
            }
            else{
                toastr.error('Error please contact administrator!');
            }
        },
    });
}


