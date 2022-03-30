@php $layout = 'layouts.admin_layout'; @endphp


@extends($layout)


@section('content_page')
<style>
 
    .hidden_scanner_input {
        position: absolute;
        opacity: 0;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary m-2" style="min-width: 700px;">
                        <div class="card-body">
                            <div class="table responsive mt-2">
                                <table id="tbl_whse_preshipment" class="table table-sm table-bordered table-striped table-hover dt-responsive nowrap" style="width: 100%; min-width: 10%">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Station</th>
                                            <th>Packing List Control No</th>
                                            <th>Shipment Date</th>
                                            <th>Destination</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!--View Preshipment For Receiving Modal -->
            <div class="modal fade" id="modalViewWhsePreshipmentReceiving" data-backdrop="static" style="overflow: auto;">
                <div class="modal-dialog" style="width:100%;max-width:1850px;"> 
                    <div class="modal-content">
                    
                        <div class="modal-header">
                        <h3 class="modal-title"><i class="fa fa-pencil-square"></i>Pre-Shipment List</h3>
                        <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        
                        <div class="modal-body">      
                            <div class="row">
                            <div class="col-sm-4">   
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                        <div class="col-sm-7">
                                            <h3 class="card-title">
                                            <i class="fa fa-info-circle"></i>
                                            Pre-Shipment Info
                                            </h3>                    
                                        </div>
                                        <div class="col-sm-5">
                                            <div style="float: right">
                                            <button class="btn btn-sm btn-secondary d-none" id="btnDoneScan">Done</button>
                                            <button id="btnScanItem" class="btn btn-sm btn-primary"><i class="fas fa-qrcode"></i> Scan Item</button>
                                            </div>
                                        </div>                    
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">

                                        <input type="hidden" id="preshipmentId" name="preshipmentId">
                                        
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Packing List Control No:</span>
                                            </div>
                                            
                                                <input type="text" class="form-control" name="packingCtrlNo" id="packingControlNoId" readonly>
                        
                                        </div>
                                        
                                        
                                        <div class="d-flex">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Date:</span>
                                                </div>
                            
                                                
                                                <input type="text" class="form-control" name="packingDate" id="packingDateId" readonly>
                            
                                            </div>
                        
                                            <div class="input-group input-group-sm mb-3 ml-2">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Shipment Date:</span>
                                                </div>
                                                
                                                <input type="text" class="form-control" name="packingShipmentDate" id="packingShipmentDateId" readonly>
                        
                                            </div> 
                                        </div>
                                        
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Station:</span>
                                            </div>
                                            
                                            <input type="text" class="form-control" name="packingStation" id="packingStationId" readonly>
                    
                                        </div> 
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Destination:</span>
                                            </div>
                                            
                                            <input type="text" class="form-control" name="packingDestination" id="packingDestinationId" readonly>
                        
                                        </div>    
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Checked By:</span>
                                            </div>
                                            
                                            <input type="text" class="form-control" name="checked_by" id="txtCheckby" readonly>
                        
                                        </div>    
                                    </div>
                                    <div class="card-footer">
                                        <div style="float: right">
                                            <button class="btn btn-outline-danger" id=""><i class="far fa-times-circle"></i> Reject</button>
                                            <button type="submit" class="btn btn-outline-success" id="btnAcceptPreshipment" data-toggle="modal" data-target="#modalApproveId"><i class="far fa-check-circle"></i> Accept</button>
                                        </div>
                                    </div>
                                    
                                    
                                <!-- /.card-body -->
                                </div>   
                               
                                <center>

                                    <div id="qrDiv" style="font-size: 20px; opacity: 80%; display: none; width: 60%; box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;">
                                            
                                        <i class="fas fa-qrcode fa-10x" ></i><br>
                                        <strong>Scan QR Code</strong>
                                        {{-- <input type="text" name="" id="txtForScanner" style="color: transparent;caret-color: transparent !important; background-color: transparent!important; border-color: transparent!important; outline: transparent!important;"> --}}
                                        <input type="text" class="hidden_scanner_input" name="" id="txtForScanner" >
                  
                                            
                                    </div>   
                  
                                </center>     
                                                    
                            
                            </div>     
                            <div class="col-sm-8">
                                <h3>Checksheets</h3>
                                <div class="dt-responsive table-responsive">
                                <table id="tbl_whs_preshipment_list" class="table table-striped table-bordered" style="width: 100%; font-size: 85%;">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center;">Master Carton No</th>
                                        <th style="text-align: center;">Item No.</th>
                                        <th style="text-align: center;">P.O. No.</th>
                                        <th style="text-align: center;">Parts Code</th>
                                        <th style="text-align: center;">Device Name</th>
                                        <th style="text-align: center;">Lot No.</th>
                                        <th style="text-align: center;">Qty</th>
                                        <th style="text-align: center;">Package Category</th>
                                        <th style="text-align: center;">Package Qty</th>                           
                                        <th style="text-align: center;">Weight By</th>                           
                                        <th style="text-align: center;">Packed By</th>                           
                                                                
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                </div>                                  
                            </div>       
                            </div>  
                        </div>      
                        
                    </div>
                </div>
            </div>


            <!--View Preshipment For Uploading Modal -->
            <div class="modal fade" id="modalViewWhsePreshipmentForUpload" data-backdrop="static" style="overflow: auto;">
                <div class="modal-dialog" style="width:100%;max-width:1850px;"> 
                    <div class="modal-content">
                    
                        <div class="modal-header">
                        <h3 class="modal-title"><i class="fa fa-pencil-square"></i>Pre-Shipment List</h3>
                        <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        
                        <div class="modal-body">      
                            <div class="row">
                            <div class="col-sm-4">   
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-sm-7">
                                                <h3 class="card-title">
                                                <i class="fa fa-info-circle"></i>
                                                Pre-Shipment Info
                                                </h3>                    
                                            </div>
                                            {{-- <div class="col-sm-5">
                                                <div style="float: right">
                                                <button class="btn btn-sm btn-secondary d-none" id="btnDoneScan">Done</button>
                                                <button id="btnScanItem" class="btn btn-sm btn-primary"><i class="fas fa-qrcode"></i> Scan Item</button>
                                                </div>
                                            </div>                     --}}
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">

                                        <input type="text" id="txtApprovingID" name="approving_id">
                                        <input type="text" id="txtPreshipmentId" name="preshipment_id">
                                        <input type="text" id="txtPreshipmentProductLine" name="preshipment_product_line">
                                        
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Packing List Control No:</span>
                                            </div>
                                            
                                                <input type="text" class="form-control" name="approving_packing_list_control_no" id="txtApprovingPackingListControlNo" readonly>
                        
                                        </div>
                                        
                                        
                                        <div class="d-flex">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Date:</span>
                                                </div>
                            
                                                
                                                <input type="text" class="form-control" name="approving_date" id="txtApprovingDate" readonly>
                            
                                            </div>
                        
                                            <div class="input-group input-group-sm mb-3 ml-2">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Shipment Date:</span>
                                                </div>
                                                
                                                <input type="text" class="form-control" name="approving_ship_date" id="txtApproveShipDate" readonly>
                        
                                            </div> 
                                        </div>
                                        
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Station:</span>
                                            </div>
                                            
                                            <input type="text" class="form-control" name="approving_station" id="txtApprovingStation" readonly>
                    
                                        </div> 
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Destination:</span>
                                            </div>
                                            
                                            <input type="text" class="form-control" name="approving_destination" id="txtApprovingDestination" readonly>
                        
                                        </div>    
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Checked By:</span>
                                            </div>
                                            
                                            <input type="text" class="form-control" name="approving_check_by" id="txtApprovingCheckBy" readonly>
                        
                                        </div>

                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Invoice Number:</span>
                                            </div>
                                            
                                            <input type="text" class="form-control" name="approving_invoice_no" id="txtApprovingInvoinceNo" readonly>
                                        </div>    
                                    </div>
                                    <div class="card-footer">
                                        
                                        <div class="d-flex justify-content-between">

                                            <button class="btn btn-info btn-sm" id="btnDownloadForWbs"><i class="fas fa-lg fa-file-csv"></i> Download for WBS</button>
                                            <button class="btn btn-outline-success btn-sm" id="btnDoneUpload" data-toggle="modal" data-target="#modalDoneUpload"> Done Upload</button>
                                            {{-- <a href="export" class="btn btn-info btn-sm" target="_blank"><i class="fas fa-lg fa-file-csv"></i> Download for WBS</a> --}}
                                        </div>
                                    </div>
                                    
                                    
                                <!-- /.card-body -->
                                </div>   
                    
                                {{-- <center>

                                    <div id="qrDiv" style="font-size: 20px; opacity: 80%; display: none; width: 60%; box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;">
                                            
                                        <i class="fas fa-qrcode fa-10x" ></i><br>
                                        <strong>Scan QR Code</strong>
                                        <input type="text" class="hidden_scanner_input" name="" id="" >
                  
                                            
                                    </div>   
                  
                                </center>      --}}
                                                    
                            
                            </div>     
                            <div class="col-sm-8">
                                <h3>Checksheets</h3>
                                <div class="dt-responsive table-responsive">
                                <table id="tbl_whs_preshipment_list_for_upload" class="table table-striped table-bordered" style="width: 100%; font-size: 85%;">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center;">Master Carton No</th>
                                        <th style="text-align: center;">Item No.</th>
                                        <th style="text-align: center;">P.O. No.</th>
                                        <th style="text-align: center;">Parts Code</th>
                                        <th style="text-align: center;">Device Name</th>
                                        <th style="text-align: center;">Lot No.</th>
                                        <th style="text-align: center;">Qty</th>
                                        <th style="text-align: center;">Package Category</th>
                                        <th style="text-align: center;">Package Qty</th>                           
                                        <th style="text-align: center;">Weight By</th>                           
                                        <th style="text-align: center;">Packed By</th>                           
                                                                
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                </div>                                  
                            </div>       
                            </div>  
                        </div>      
                        
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalApproveId" data-backdrop="static" style="overflow: auto;">
                <div class="modal-dialog" style="margin-top: 5%;"> 
                    <div class="modal-content">
                        <form action="post" id="acceptFormid">
                            @csrf
                            <div class="modal-header">
                                <input type="hidden" id="acceptPreshipmentId" name="accept_preshipment">

                                <h5 class="modal-title"><i class="fa fa-pencil-square"></i>Are you sure you want to approve?</h5>
                                <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-footer">
                                <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Cancel</button>
                                <button type="submit" class="btn btn-success">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    

            {{-- MODAL APPROVE --}}
            {{-- <div class="modal fade" id="modalWhsApprove" data-backdrop="static" style="overflow: auto;">
                <div class="modal-dialog" style="width:100%;max-width:700px;"> 
                    <div class="modal-content">
                    
                        <div class="modal-header">
                            <h3 class="modal-title"><i class="fa fa-pencil-square"></i>Pre-Shipment</h3>
                            <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="formApproveWhse">

                            <div class="modal-body">
                                    <input type="text" name="preshipment_approval_id" id="txt_preshipment_approval_id">
                                
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Date</span>
                                        </div>
                                        <input type="text" class="form-control" name="accept_date" readonly id="txtAcceptDate" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Control Number</span>
                                        </div>
                                        <input type="text" class="form-control" name="accept_shipment_ctrl_no" readonly id="txtAcceptShipCtrlNo" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Shipment Date</span>
                                        </div>
                                        <input type="text" class="form-control" name="accept_shipment_date" readonly id="txtAcceptShipDate" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Destination</span>
                                        </div>
                                        <input type="text" class="form-control" name="accept_shipment_destination" readonly id="txtAcceptShipDestination" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">QC Checker</span>
                                        </div>
                                        <input type="text" class="form-control" name="accept_shipment_qc_checker" readonly id="txtAcceptShipQcChecker" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="inputGroup-sizing-default">Send To</span>
                                        </div>
                                        <select name="accept_shipment_send_to" id="txtAcceptShipSendTo" class="form-control" style="pointer-events: none;">
                                            <option value="cn" >CN Warehouse</option>
                                            <option value="ts" >TS Warehouse</option>
                                        </select>
                                    </div>
                            </div>

                            <div class="modal-footer">
                                
                                    <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Cancel</button>
                                    <button type="submit" class="btn btn-success" id="btnWhseSendShipment">Send</button>
                                
                            </div>
                        </form>


                    </div>
                </div>
            </div> --}}

            
        </div>
    </section>

</div>
<!--     {{-- JS CONTENT --}} -->
@section('js_content')

<script>
$(document).ready(function () {
    dataTableWhsePreshipment = $("#tbl_whse_preshipment").DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
          url: "get_preshipment_for_ts_cn_whse", 
      },
      "columns":[    
          { "data" : "status"},
          { "data" : "preshipment_for_approval.date" },
          { "data" : "preshipment_for_approval.station" },
          { "data" : "preshipment_for_approval.packing_list_ctrlNo"},
          { "data" : "preshipment_for_approval.Shipment_date"},
          { "data" : "preshipment_for_approval.Destination"},
          { "data" : "action"},
          
      ],
    });

    dataTableWhsePreshipmentList = $("#tbl_whs_preshipment_list").DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
          url: "get_preshipment_list_for_whse",
          data: function (param){
            param.preshipmentId = $("#preshipmentId").val();
          },
      },
      "columns":[    
          { "data" : "Master_CartonNo"},
          { "data" : "ItemNo" },
          { "data" : "PONo" },
          { "data" : "Partscode"},
          { "data" : "DeviceName"},
          { "data" : "LotNo"},
          { "data" : "Qty"},
          { "data" : "PackageCategory"},
          { "data" : "PackageQty"},
          { "data" : "WeighedBy"},
          { "data" : "PackedBy"},
        //   { "data" : "action"},
          
      ],
    });

    dataTableWhsePreshipmentListForUpload = $("#tbl_whs_preshipment_list_for_upload").DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
          url: "get_preshipment_list_for_whse_for_upload",
          data: function (param){
            param.preshipmentId = $("#txtPreshipmentId").val();
          },
      },
      "columns":[    
          { "data" : "Master_CartonNo"},
          { "data" : "ItemNo" },
          { "data" : "PONo" },
          { "data" : "Partscode"},
          { "data" : "DeviceName"},
          { "data" : "LotNo"},
          { "data" : "Qty"},
          { "data" : "PackageCategory"},
          { "data" : "PackageQty"},
          { "data" : "WeighedBy"},
          { "data" : "PackedBy"},
        //   { "data" : "action"},
          
      ],
    });

    


    $('#btnScanItem').on('click',function(){
      $('#qrDiv').css('display','block');
      // $('#test').modal('show');
      
      $('#txtForScanner').focus();
      // $('#close').disable();
      $('#close').attr('disabled','disabled');
      $('#btn_disapprove_list_id').attr('disabled','disabled');
      $('#btn_approve_list_id').attr('disabled','disabled');
      $('#btnDoneScan').removeClass("d-none");

     
    });

    $('#btnDoneScan').on('click', function(){

        let test = [];

        $('#btnDoneScan').addClass("d-none");
        $('#qrDiv').css('display','none');
        // $('#close').attr('disabled','disabled');
        $('#close').removeAttr('disabled');
        // $('#btn_disapprove_list_id').removeAttr('disabled');
        // $('#btn_approve_list_id').removeAttr('disabled');
        $('#tbl_whs_preshipment_list tr').each(function(row, tr){
            
        if(row>0){
            highlight = $(tr).hasClass('checked-ok');
            if(highlight == false){
            $(tr).addClass('checked-ng');
            }
            test.push(highlight);
        }
        row++;
                
            });

        if(jQuery.inArray(false, test) == -1){
        // console.log('enable button');
        $('#btn_approve_list_id').prop('disabled', false);
        }
        else{
        $('#btn_approve_list_id').prop('disabled', true);
        }


    });

    //FOR BARCODE SCANNING
    var timer = '', scannedItem = "";
    $('input#txtForScanner').keypress( function() {
      
      var txtForScanning = $(this); // copy of this object for further usage
     
        clearTimeout(timer);
        timer = setTimeout(function() {
          scannedItem = txtForScanning.val();
          var arr = scannedItem.split(',');
          itemVerificationTSCNWhse(arr);
          txtForScanning.val("");
        }, 500);
    });


    $(document).on('click', '.btn-whs-view-for-receiving', function(){
        let preshipment_id = $(this).attr('preshipment-id');
        // console.log(preshipment_id);
        getPreshipmentDetailsByIdForReceiving(preshipment_id);
        // dataTableWhsePreshipmentList.draw();
    });

    $('#btnAcceptPreshipment').on('click', function(){
        let preshipmentId = $('#preshipmentId').val();
        $('#acceptPreshipmentId').val(preshipmentId);
        // console.log(preshipmentId);
    });

    $('#acceptFormid').submit(function(event){
        event.preventDefault();
        acceptPreshipment();
    });

    $(document).on('click', '.btn-whs-view-for-upload', function(){
        let preshipmentId = $(this).attr('preshipment-id');
        getPreshipmentDetailsForUpload(preshipmentId);
        getInvoiceCtrlNo(preshipmentId);
    });


    $('#btnDownloadForWbs').on('click', function(){
        let invoiceNum = $('#txtApprovingInvoinceNo').val();
        let packingListCtrlNo = $('#txtApprovingPackingListControlNo').val();
        let packingListProductLine = $('#txtPreshipmentProductLine').val();

        window.location.href = `export/${invoiceNum}/${packingListCtrlNo}/${packingListProductLine}`;
    })

});
</script>
@endsection

@endsection
