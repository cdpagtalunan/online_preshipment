function GetPreshipmentList_QC(checksheetId){

    // var preShipmentCtrlId = checksheetId;

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
        url: "getpreshipmentbyCtrlNo_QC",
        method: "get",
        data: {
            preshipment_ctrl_id: checksheetId
        },
        dataType: "json",
        beforeSend: function(){
            $("#packingCtrlNo_id").val("");
            $("#packingDate_id").val("");
            $('#packingShipmentDate_id').val("");
            $('#packingStation_id').val("");
            $('#packingDestination_id').val("");

        },
        success: function(response){
            console.log(response);
            if(response['response'] == 1){
                // console.log(response['preshipment'][0]['Destination']);
                $('#packingCtrlNo_id').val(response['preshipment'][0]['Packing_List_CtrlNo']);
                $('#packingDate_id').val(response['preshipment'][0]['Date']);
                $('#packingShipmentDate_id').val(response['preshipment'][0]['Shipment_Date']);
                $('#packingStation_id').val(response['preshipment'][0]['Station']);
                $('#packingDestination_id').val(response['preshipment'][0]['Destination']);
                dataTablePreshipmentList_QC.draw();

                
            }
            else{
                console.log('wala');
            }
           
        },
        // error: function(data, xhr, status){
        //     toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        //     $("#iBtnSignInIcon").removeClass('fa fa-spinner fa-pulse');
        //     $("#btnSignIn").removeAttr('disabled');
        //     $("#iBtnSignInIcon").addClass('fa fa-check');
        // }
    });
}

function itemVerificationQC(arr){
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
   
    var table = document.getElementById("tbl_preshipment_list_QC");
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

function disapprovePackingList_QC(){
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
        url: "disapprove_list_QC",
        method: "post",
        data: $('#form_packing_list').serialize(),
        dataType: "json",
       
        success: function(response){
            if(response['result'] == 1){
                toastr.success('Pre-Shipment has been Disapproved');
                $('#modalViewQCChecksheets').modal('hide');
                $('#modalDisapproveId').modal('hide');
                dataTablePreshipment_QC.draw();

            }
        },
        // error: function(data, xhr, status){
        //     toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        //     $("#iBtnEditUserIcon").removeClass('fa fa-spinner fa-pulse');
        //     $("#btnEditUser").removeAttr('disabled');
        //     $("#iBtnEditUserIcon").addClass('fa fa-check');
        // }
    });
}

function approvePackingList_QC(){
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
        url: "approve_list_QC",
        method: "post",
        data: $('#form_packing_list').serialize(),
        dataType: "json",
       
        success: function(response){
            if(response['result'] == 1){
                toastr.success('Pre-Shipment has been Approved');
                $('#modalViewQCChecksheets').modal('hide');
                $('#modalapproveId').modal('hide');
                dataTablePreshipment_QC.draw();

            }
        },
        // error: function(data, xhr, status){
        //     toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        //     $("#iBtnEditUserIcon").removeClass('fa fa-spinner fa-pulse');
        //     $("#btnEditUser").removeAttr('disabled');
        //     $("#iBtnEditUserIcon").addClass('fa fa-check');
        // }
    });
}

