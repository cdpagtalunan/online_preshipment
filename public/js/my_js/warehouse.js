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

            $('#packingControlNoId').val(response['preshipment']['packing_list_ctrlNo']);
            $('#packingDateId').val(response['preshipment']['date']);
            $('#packingShipmentDateId').val(response['preshipment']['Shipment_date']);
            $('#packingStationId').val(response['preshipment']['station']);
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
           
            var ctrlNo = `${response['result']['preshipment_for_approval']['Destination']}-${response['result']['preshipment_for_approval']['packing_list_ctrlNo']}`;
            $('#txt_preshipment_approval_id').val(response['result']['id'])
            $('#txtAcceptDate').val(response['result']['preshipment_for_approval']['date']);
            $('#txtAcceptShipCtrlNo').val(ctrlNo);
            $('#txtAcceptShipDate').val(response['result']['preshipment_for_approval']['Shipment_date']);
            $('#txtAcceptShipDestination').val(response['result']['preshipment_for_approval']['Destination']);
            $('#txtAcceptShipQcChecker').val(response['result']['preshipment_for_approval']['qc_approver_details']['rapidx_user_details']['name']);

            var ts = ["Burn-in Sockets","Grinding"];
            var cn = ["Flexicon & Connectors","FUS/FRS/FMS Connector","Card Connector","TC/DC Connector"];
            

        
            if(jQuery.inArray(response['result']['preshipment_for_approval']['Destination'], ts) != -1){
                // console.log('ts');
                $('#txtAcceptShipSendTo').val('ts').trigger('change');

            }
            else if(jQuery.inArray(response['result']['preshipment_for_approval']['Destination'], cn) != -1){
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
        success: function(response){
            if(response['result'] == 1){
                toastr.success('Transaction Successful');
                $('#modalWhsApprove').modal('hide');
                dataTableWhsePreshipment.draw();
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
        "hideDuration": "1000",
        "timeOut": "1000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };
   
    var table = document.getElementById("tbl_whs_preshipment_list");
	var trlength= table.getElementsByTagName("tr").length;
    let i;
    for(i=1; i<trlength; i++){
        var tr1 = table.getElementsByTagName("tr")[i];

        var po_num = tr1.getElementsByTagName("td")[2].innerHTML;
        var partcode = tr1.getElementsByTagName("td")[3].innerHTML;
        var device_name = tr1.getElementsByTagName("td")[4].innerHTML;
        var lot_no = tr1.getElementsByTagName("td")[5].innerHTML;
        var qty = tr1.getElementsByTagName("td")[6].innerHTML;
        var package_category = tr1.getElementsByTagName("td")[7].innerHTML;
        var package_qty = tr1.getElementsByTagName("td")[8].innerHTML;

        test = $(tr1).hasClass('checked-ok');
      console.log(test);
        
        if(test == true){
            if(arr[0] == po_num){
                if(arr[1] == partcode){
                    if(arr[2] == device_name){
                        if(arr[3] == lot_no){
                            if(arr[4] == qty){
                                if(arr[5] == package_category){
                                    if(arr[6] == package_qty){
                                        // console.log(po_num);
                                        // console.log(partcode);
                                        // console.log(device_name);
                                        // console.log(lot_no);
                                        // console.log(qty);
                                        // console.log(package_category);
                                        // console.log(package_qty);
                                        $(tr1).removeClass('checked-ng');

                                        $(tr1).addClass('checked-ok');

                                        // i= trlength + 1;
                                        // tr1.scrollIntoView({behavior: "smooth"});
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        else if(test == false){
            if(arr[0] == po_num){
                if(arr[1] == partcode){
                    if(arr[2] == device_name){
                        if(arr[3] == lot_no){
                            if(arr[4] == qty){
                                if(arr[5] == package_category){
                                    if(arr[6] == package_qty){
                                        // console.log(po_num);
                                        // console.log(partcode);
                                        // console.log(device_name);
                                        // console.log(lot_no);
                                        // console.log(qty);
                                        // console.log(package_category);
                                        // console.log(package_qty);
                                        $(tr1).removeClass('checked-ng');

                                        $(tr1).addClass('checked-ok');

                                        i= trlength + 1;
                                        // tr1.scrollIntoView({behavior: "smooth"});

                                       
    
                                    } 
                                } 
                            } 
                        } 
                    } 
                } 
            }
        }
    }


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
            $('#preshipmentId').val(response['preshipment']['id']);

            $('#packingControlNoId').val(response['preshipment']['packing_list_ctrlNo']);
            $('#packingDateId').val(response['preshipment']['date']);
            $('#packingShipmentDateId').val(response['preshipment']['Shipment_date']);
            $('#packingStationId').val(response['preshipment']['station']);
            $('#packingDestinationId').val(response['preshipment']['Destination']);
            $('#txtCheckby').val(response['approver']['from_user_details']['rapidx_user_details']['name']);
            
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
            $('#txtApprovingPackingListControlNo').val(response['approvingDetails']['preshipment_for_approval']['packing_list_ctrlNo']);
            $('#txtApprovingDate').val(response['approvingDetails']['preshipment_for_approval']['date']);
            $('#txtApproveShipDate').val(response['approvingDetails']['preshipment_for_approval']['Shipment_date']);
            $('#txtApprovingStation').val(response['approvingDetails']['preshipment_for_approval']['station']);
            $('#txtApprovingDestination').val(response['approvingDetails']['preshipment_for_approval']['Destination']);
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
            if(response['ctrlNo'] != null){
                $('#txtApprovingInvoinceNo').val(response['ctrlNo']['ControlNumber']);

            }
        },
    });
}