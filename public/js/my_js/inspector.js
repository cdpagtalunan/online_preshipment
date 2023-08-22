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
            $('#btnScanItem').removeClass('d-none');
            $('#btnDiv').removeClass('d-none');
        },
        success: function(response){
            console.log(response);
            if(response['response'] == 1){

                if(response['preshipment'][0]['rapidx_QCChecking'] == 2){
                    $('#btnScanItem').addClass('d-none');
                    $('#btnDiv').addClass('d-none');
                }
                // console.log(response['preshipment'][0]['Destination']);
                $('#txtInvalidChecker').val(response['preshipment'][0]['has_invalid']);
                $('#packingId').val(response['preshipment'][0]['id']);
                $('#packingCtrlNo_id').val(response['preshipment'][0]['Packing_List_CtrlNo']);
                $('#packingDate_id').val(response['preshipment'][0]['Date']);
                $('#packingShipmentDate_id').val(response['preshipment'][0]['Shipment_Date']);
                $('#packingStation_id').val(response['preshipment'][0]['Station']);
                $('#packingDestination_id').val(response['preshipment'][0]['Destination']);
                dataTablePreshipmentList_QC.draw();
                let x = 0;

                setTimeout(() => {
                    $('#tbl_preshipment_list_QC tbody tr').each(function(index, tr){
                        // console.log(tr);

                        // $(tr).find('td:eq(5)').each (function (index, td) {
                        //     console.log(td)
                        //     // console.log($(this).eq(index).text());
                        // });
                        //   console.log($(tr).find('td:eq(2)').text());
                        //   console.log($(tr).find('td:eq(3)').text());
                        //   console.log($(tr).find('td:eq(4)').text());
                        //   console.log($(tr).find('td:eq(5)').text());
                        //   console.log($(tr).find('td:eq(6)').text());
                        //   console.log($(tr).find('td:eq(7)').text());
                        //   console.log($(tr).find('td:eq(8)').text());

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


    let check_data = false;
    setTimeout(() => {
        $('#tbl_preshipment_list_QC tbody tr').each(function(index, tr){
            
            // var po_num = $(tr).find('td:eq(2)').text();
            // var partcode = $(tr).find('td:eq(3)').text();
            // var device_name = $(tr).find('td:eq(4)').text();
            // var lot_no = $(tr).find('td:eq(5)').text();
            // var qty = $(tr).find('td:eq(6)').text();
            // var package_category = $(tr).find('td:eq(7)').text();

            var po_num = $(tr).find('td:eq(2)').text().trim().toUpperCase();
            var partcode = $(tr).find('td:eq(3)').text().trim().toUpperCase();
            var device_name = $(tr).find('td:eq(4)').text().trim().toUpperCase();
            var lot_no = $(tr).find('td:eq(5)').text().trim().toUpperCase();
            var qty = $(tr).find('td:eq(6)').text().trim().toUpperCase();
            var package_category = $(tr).find('td:eq(7)').text().trim().toUpperCase();

            var package_qty = $(tr).find('td:eq(8)').text().trim();

            var drawing_no = $(tr).find('td:eq(11)').text().trim().toUpperCase();
            var drawing_rev_no = $(tr).find('td:eq(12)').text().trim().toUpperCase();


            var hdInputVal = $(tr).find('td:eq(14)').text().trim();
            var hdStampingVal = $(tr).find('td:eq(15)').text().trim();


            // var hdInputVal = tr1.getElementsByTagName("td")[11].innerHTML;
            if(arr[8] == undefined){
                test = arr[8];
            }
            else{
                test = arr[8].trim();
            }

            var checkedOk = $(tr).hasClass('checked-ok');
            if(
                arr[0].trim() == po_num && 
                arr[1].trim() == partcode && 
                arr[2].trim() == device_name && 
                arr[3].trim() == lot_no && 
                arr[4].trim() == qty && 
                arr[5].trim() == package_category &&  
                (arr[7].trim() == drawing_no.trim() || arr[7].trim() == ',' || arr[7].trim() == "-") && 
                (test == drawing_rev_no || test == undefined || test == "-")
            ){
                // if(checkedOk != true){

                // }
                // else{
                    check_data = true;
                    if(hdStampingVal == 'stamping'){
                        let hiddenColumnId = $(tr).find('td:eq(1)').text();
                        console.log(hiddenColumnId);
                        $('#toScrollId').attr('href', "#"+hiddenColumnId);
                        $('#toScrollId')[0].click();
                        // const element = document.getElementById('txtForScanner')
                        const element = document.getElementById('txtScanPreshipment')
                        element.focus({
                            preventScroll: true
                        });

                        setTimeout(() => {
                            $(tr).addClass('checked-partial');
                            $(tr).find('td:eq(15)').text("");
                        }, 500);
                    }
                    else{
                        console.log(hdInputVal);
                        if(hdInputVal == "" || hdInputVal == 1){
                            if(arr[6].trim() == "1/1" || arr[6].trim() == "1"){
                                // $(tr).removeClass('checked-ng');
                                // $(tr).addClass('checked-ok');
                                // $(tr).scrollIntoView({behavior: "smooth"});
                                // tr.getElementsByTagName("td")[11].innerHTML = "0";
                                $(tr).find('td:eq(14)').text("0");
                                console.log("checked-green");
                                
                                let hiddenColumnId = $(tr).find('td:eq(1)').text();

                                console.log(hiddenColumnId);

                                $('#toScrollId').attr('href', "#"+hiddenColumnId);

                                $('#toScrollId')[0].click();

                            

                                saveInfoForQC(po_num,partcode,device_name,lot_no,qty,package_category,package_qty);
                                // $('#btnScanItem')[0].click();
                                // const element = document.getElementById('txtForScanner')
                                const element = document.getElementById('txtScanPreshipment')

                                element.focus({
                                    preventScroll: true
                                });

                                setTimeout(() => {
                                    $(tr).removeClass('checked-partial');
                                    $(tr).removeClass('checked-ng');
                                    $(tr).addClass('checked-ok');
                                }, 1000);

                            }
                            else{
                                // $(tr).removeClass('checked-ng');
                                // $(tr).addClass('checked-ok');
                                // $(tr).scrollIntoView({behavior: "smooth"});
                                // tr.getElementsByTagName("td")[11].innerHTML = "0";
                                $(tr).find('td:eq(14)').text("0");

                                let hiddenColumnId = $(tr).find('td:eq(1)').text();
                                console.log(hiddenColumnId);

                                $('#toScrollId').attr('href', "#"+hiddenColumnId);

                                $('#toScrollId')[0].click();
                                



                                saveInfoForQC(po_num,partcode,device_name,lot_no,qty,package_category,package_qty);
                                // $('#btnScanItem')[0].click();
                                // const element = document.getElementById('txtForScanner')
                                const element = document.getElementById('txtScanPreshipment')

                                element.focus({
                                    preventScroll: true
                                });

                                setTimeout(() => {
                                    $(tr).removeClass('checked-partial');
                                    $(tr).removeClass('checked-ng');
                                    $(tr).addClass('checked-ok');
                                }, 1000);

                            }
                        }
                        // else if(hdInputVal > 1){
                        else if(hdInputVal != 1 && hdInputVal != "DO"){ // For preshipment with over (1~3)
                            if(hdInputVal != 0){
                                // hdInputVal = hdInputVal - 1;
                                // // tr.getElementsByTagName("td")[11].innerHTML = hdInputVal;
                                // $(tr).find('td:eq(12)').text(hdInputVal);
                                // console.log("checked need to scan "+hdInputVal+" more");

                                let replacedInputVal = "";

                                replacedInputVal = hdInputVal.replace(arr[6].trim(),'');
                                console.log(hdInputVal);
                                console.log(replacedInputVal);
                                $(tr).find('td:eq(14)').text(replacedInputVal);
                                $(tr).addClass('checked-partial');
                                // $(tr).addClass('checked-ok');

                                // to replace the yellow highlight to green when all sticker count is scanned
                                
                                // For autoscrolling
                                let hiddenColumnId = $(tr).find('td:eq(1)').text();
                                console.log(hiddenColumnId);
                                $('#toScrollId').attr('href', "#"+hiddenColumnId);
                                
                                $('#toScrollId')[0].click();
                                // const element = document.getElementById('txtForScanner')
                                const element = document.getElementById('txtScanPreshipment')
                                
                                element.focus({
                                    preventScroll: true
                                });


                                if(replacedInputVal == ""){
                                    $(tr).removeClass('checked-partial');
                                    // console.log('123');
                                    $(tr).addClass('checked-ok');
                                    saveInfoForQC(po_num,partcode,device_name,lot_no,qty,package_category,package_qty);
                                }
                            }
                        }
                        else if(hdInputVal == "DO"){
                            if(arr[6].trim() == "1/1"){
                                // $(tr).removeClass('checked-ng');
                                // $(tr).addClass('checked-ok');
                                // $(tr).scrollIntoView({behavior: "smooth"});
                                // tr.getElementsByTagName("td")[11].innerHTML = "0";
                                $(tr).find('td:eq(14)').text("0");

                                let hiddenColumnId = $(tr).find('td:eq(1)').text();
                                console.log(hiddenColumnId);

                                $('#toScrollId').attr('href', "#"+hiddenColumnId);

                                $('#toScrollId')[0].click();
                                

                                saveInfoForQC(po_num,partcode,device_name,lot_no,qty,package_category,package_qty);
                                // $('#btnScanItem')[0].click();
                                // const element = document.getElementById('txtForScanner')
                                const element = document.getElementById('txtScanPreshipment')

                                element.focus({
                                    preventScroll: true
                                });

                                setTimeout(() => {
                                    $(tr).removeClass('checked-partial');
                                    $(tr).removeClass('checked-ng');
                                    $(tr).addClass('checked-ok');
                                }, 1000);

                            }
                        }
                    }
                // }
                
                
            }
            // else{
            //     check_data = false;
            // }
        });

        setTimeout(() => {
            if(arr.length <= 6){
                toastr.error('Invalid! QR is not for Preshipment.');
                console.log('invalid  QR is not for Preshipment');
            }
            else if(!check_data){
                toastr.error('Invalid! No Data Found.')
                console.log('invalid scanning data');

                $.ajax({
                    url: "add_invalid",
                    type: "post",
                    data:{
                        preshipment_id: $('#packingId').val(),
                        from : 'QC',
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


function saveInfoForQC(po_num,partcode,device_name,lot_no,qty,package_category,package_qty){
    $.ajax({
        url: "insert_preshimentlist_from_qc_qr_checking",
        method: "get",
        data:{
            po_num : po_num,
            partcode : partcode,
            device_name : device_name,
            lot_no : lot_no,
            qty : qty,
            package_category : package_category,
            package_qty : package_qty,
            preshipment_ctrl_no : $('#packingCtrlNo_id').val()

        },
        dataType: "json",
        success: function(response){
            
        },
    });
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
        method: "get",
        data: {
            // form: $('#form_packing_list').serialize(),
            // remarks : $('#qcRemarks').val()
            packingCtrlNo : $('#packingCtrlNo_id').val(),
            remarks : $('#qcRemarks').val()

        },
        dataType: "json",
       
        success: function(response){
            if(response['result'] == 1){
                toastr.success('Pre-Shipment has been Disapproved');
                $('#modalViewQCChecksheets').modal('hide');
                $('#modalDisapproveId').modal('hide');
                dataTablePreshipment_QC.draw();

            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            // $("#iBtnEditUserIcon").removeClass('fa fa-spinner fa-pulse');
            // $("#btnEditUser").removeAttr('disabled');
            // $("#iBtnEditUserIcon").addClass('fa fa-check');
        }
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
        beforeSend: function(){
            $('#btnApprove').prop('disabled', true);
        },
        success: function(response){
            if(response['result'] == 1){
                toastr.success('Pre-Shipment has been Approved');
                $('#modalViewQCChecksheets').modal('hide');
                $('#modalapproveId').modal('hide');
                dataTablePreshipment_QC.draw();

                $('#btnApprove').prop('disabled', false);
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

