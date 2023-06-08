@php $layout = 'layouts.admin_layout'; @endphp


@extends($layout)


@section('content_page')
<style>
 
    .hidden_scanner_input {
        position: absolute;
        opacity: 0;
    }
    .hidden_scanner_bypass_input {
        position: absolute;
        opacity: 0;
    }
    #modalViewWhsePreshipmentReceiving{
        scroll-behavior: smooth;
    }
    #tbl_whs_preshipment_list tbody td:last-child {
        display: none;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Online Pre-shipment</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                
                        <li class="breadcrumb-item active">Warehouse</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary m-2" style="min-width: 700px; overflow: auto;">
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top:-13px;">
                  
                                <li class="nav-item">
                                    <a class="nav-link active" id="whse-user-pending-tab" data-toggle="tab" href="#whse-pending-user" role="tab" aria-controls="whse-user" aria-selected="true">Warehouse Pending</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="whse-user-done-tab" data-toggle="tab" href="#whse-done-user" role="tab" aria-controls="whse-done-user" aria-selected="true">Warehouse Done</a>
                                </li>
                                <li class="nav-item" style="display: none;" id="whse-approver-tab">
                                    <a class="nav-link" id="whse-approver-tab" data-toggle="tab" href="#whse-approver" role="tab" aria-controls="whse-approver" aria-selected="false">Warehouse Approver</a>
                                </li>
                            </ul>
                            
                            <div class="tab-content" id="myTabContent" >
                                <div class="tab-pane fade show active" id="whse-pending-user" role="tabpanel" aria-labelledby="whse-user-pending-tab">
                                    <div class="table responsive mt-2">
                                        <table id="tbl_whse_preshipment" class="table table-sm table-bordered table-striped table-hover dt-responsive wrap" style="width: 100%; min-width: 10%">
                                            <thead>
                                                <tr>
                                                    <th style="width: 15%;">Status</th>
                                                    <th>Date</th>
                                                    <th>Station</th>
                                                    <th>Packing List Control No</th>
                                                    <th>Invoice Number</th>
                                                    <th>Shipment Date</th>
                                                    <th>Destination</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade show " id="whse-done-user" role="tabpanel" aria-labelledby="whse-user-done-tab">
                                    <div class="table responsive mt-2">
                                        <table id="tbl_whse_done_preshipment" class="table table-sm table-bordered table-striped table-hover dt-responsive wrap" style="width: 100%; min-width: 10%">
                                            <thead>
                                                <tr>
                                                    <th style="width: 15%;">Status</th>
                                                    <th>Date</th>
                                                    <th>Station</th>
                                                    <th>Packing List Control No</th>
                                                    <th>Invoice Number</th>
                                                    <th>Shipment Date</th>
                                                    <th>Destination</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            
                                        </table>
                                    </div>
                                </div>
                            

                                
                                <div class="tab-pane fade" id="whse-approver"  role="tabpanel" aria-labelledby="whse-approver-tab">
                                    <div class="table responsive mt-2">
                                        <table id="tbl_whse_for_approver" class="table table-sm table-bordered table-striped table-hover dt-responsive nowrap" style="width: 100%; min-width: 10%">
                                            <thead>
                                                <tr>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Station</th>
                                                    <th>Packing List Control No</th>
                                                    <th>Invoice Number</th>
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
                                                <a href="" id="toScrollId" class="d-none"> Scan Item</a>
                                            </div>
                                            
                                        </div>                    
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <input type="hidden" id="txtInvalidChecker">

                                        <input type="hidden" id="preshipmentId" name="preshipmentId">
                                        <input type="hidden" id="txtPreshipmentProductLine" name="preshipment_product_line">

                                        <div class="input-group input-group-sm mb-3 d-none">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Packing List Control No:</span>
                                            </div>
                                            
                                                <input type="text" class="form-control" name="packingCtrlNo" id="packingControlNoId" readonly>
                        
                                        </div>

                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Packing List Control No:</span>
                                            </div>
                                            
                                                <input type="text" class="form-control" name="packingCtrl" id="packingControlId" readonly>
                        
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
                                            <button class="btn btn-outline-danger" id="btnRejectPreshipmentId" data-toggle="modal" data-target="#modalRejectId"><i class="far fa-times-circle"></i> Reject</button>
                                            <button type="submit" class="btn btn-outline-success" id="btnAcceptPreshipment" disabled><i class="far fa-check-circle"></i> Accept</button>
                                        </div>
                                        {{-- <div style="float: left">
                                            <button class="btn btn-warning btn-sm mt-1" id="btnBypassAccept" data-toggle="modal" data-target="#modalBypassAccept"  title="Bypass Scan"><i class="fas fa-barcode"></i></button>
                                        </div> --}}
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
                                        <th style="text-align: center;">Drawing No.</th>                           
                                        <th style="text-align: center;">Drawing Rev #</th>                           
                                        <th style="text-align: center;">Remarks</th>                           
                                        <th style="text-align: center; display: none;">hidden inputs</th>
                                                                
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
                                    <div class="card-header ">
                                        <div class="row d-flex justify-content-between">
                                            <div>
                                                <h3 class="card-title">
                                                    <i class="fa fa-info-circle"></i>
                                                    Pre-Shipment Info
                                                </h3>  
                                            </div>
                                            <div>
                                                <i class="fas fa-sync" id="iconRefresh" style="cursor: pointer;"></i>  
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

                                        <input type="hidden" id="txtApprovingID" name="approving_id">
                                        <input type="hidden" id="txtPreshipmentId" name="preshipment_id">
                                        <input type="hidden" id="txtPreshipmentProductLine" name="preshipment_product_line">
                                        <input type="hidden" id="txtPreshipmentTotalQty" name="preshipment_total_qty">
                                        
                                        <div class="input-group input-group-sm mb-3 d-none">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Packing List Control No:</span>
                                            </div>
                                            
                                                <input type="text" class="form-control" name="approving_packing_list_control_no" id="txtApprovingPackingListControlNo" readonly>
                        
                                        </div>

                                        <div class="input-group input-group-sm mb-3 ">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Packing List Control No:</span>
                                            </div>
                                            
                                                <input type="text" class="form-control" name="approving_packing_list_control" id="txtApprovingPackingListControl" readonly>
                        
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

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Invoice Number:</span>
                                            </div>
                                            
                                            <input type="text" class="form-control" name="approving_invoice_no" id="txtApprovingInvoinceNo" readonly>

                                            
                                        </div>   
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="checkbox_local_mat" value="0" id="chckWbsLocalMatRecId">
                                            <label class="form-check-label" for="chckWbsLocalMatRecId">
                                                For Local Material Receiving
                                            </label>
                                        </div> 

                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">WBS Receiving Number:</span>
                                            </div>
                                            
                                            <input type="text" class="form-control" name="approving_receiving_no" id="txtApprovingReceivingNo" readonly>
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
                                        <th style="text-align: center;">Remarks</th>                           
                                                                
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



             <!--View Preshipment For Superior Approval Modal -->
            <div class="modal fade" id="modalViewWhsePreshipmentForSupApproval" data-backdrop="static" style="overflow: auto;">
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

                                        <input type="hidden" id="txtApprovingId" name="superior_approving_table_id">
                                        <input type="hidden" id="txtApprovingPreshipmentId" name="superior_approving_fkpreshipment_id">

                                        <div class="input-group input-group-sm mb-3 d-none">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Packing List Control No:</span>
                                            </div>
                        
                                            
                                            <input type="text" class="form-control" name="approving_superior_ctrl_num" id="txtApprovingSuperiorCtrlNum" readonly>
                                        </div>

                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Packing List Control No:</span>
                                            </div>
                        
                                            
                                            <input type="text" class="form-control" name="approving_superior_ctrl" id="txtApprovingSuperiorCtrl" readonly>
                                        </div>

                                       
                                        
                                        <div class="d-flex">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Date:</span>
                                                </div>
                            
                                                
                                                <input type="text" class="form-control" name="approving_superior_date" id="txtApprovingSuperiorDate" readonly>
                            
                                            </div>
                        
                                            <div class="input-group input-group-sm mb-3 ml-2">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Shipment Date:</span>
                                                </div>
                                                
                                                <input type="text" class="form-control" name="approving_superior_ship_date" id="txtApproveSuperiorShipDate" readonly>
                        
                                            </div> 
                                        </div>

                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Station:</span>
                                            </div>
                        
                                            
                                            <input type="text" class="form-control" name="approving_superior_station" id="txtApprovingSuperiorStation" readonly>
                                        </div>

                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Destination:</span>
                                            </div>
                        
                                            
                                            <input type="text" class="form-control" name="approving_superior_destination" id="txtApprovingSuperiorDestination" readonly>
                                        </div>

                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Invoice Number:</span>
                                            </div>
                        
                                            
                                            <input type="text" class="form-control" name="approving_superior_invoice_num" id="txtApprovingSuperiorInvoiceNum" readonly>
                                        </div>

                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">WBS Receiving Number:</span>
                                            </div>
                        
                                            
                                            <input type="text" class="form-control" name="approving_superior_receiving_num" id="txtApprovingSuperiorReceivingNum" readonly>
                                        </div>

                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Total Qty:</span>
                                            </div>
                        
                                            
                                            <input type="text" class="form-control" name="approving_superior_preshipment_qty" id="txtApprovingSuperiorPreshipmentQty" readonly>
                                        </div>
                                        
                                       
                                    </div>
                                    <div class="card-footer">
                                        
                                        <div class="float-right">

                                            {{-- <button class="btn btn-info btn-sm float-right" id=""><i class="fas fa-lg fa-file-csv"></i> Download for WBS</button> --}}

                                            <button class="btn btn-outline-danger" data-toggle="modal" id="btnSuperiorDisapprove" data-target="#modalSuperiorDisapprove">Disapprove</button>
                                            <button class="btn btn-outline-success" data-toggle="modal" id="btnSuperiorApprove" data-target="#modalSuperiorApprove">Approve</button>
                                        </div>
                                    </div>
                                    
                                    
                                <!-- /.card-body -->
                                </div>  
                                
                                <div class="card">
                                    <div class="card-body">
                                        <label>PPC Warehouse</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Checked By:</span>
                                            </div>
                        
                                            
                                            <input type="text" class="form-control" name="approving_superior_check_by" id="txtApprovingSuperiorCheckBy" readonly>
                                        </div>

                                        <label>TS/CN Warehouse</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Recieved By:</span>
                                            </div>
                        
                                            
                                            <input type="text" class="form-control" name="approving_superior_receive_by" id="txtApprovingSuperiorReceiveBy" readonly>
                                        </div>

                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Uploaded By:</span>
                                            </div>
                        
                                            
                                            <input type="text" class="form-control" name="approving_superior_uploaded_by" id="txtApprovingSuperiorUploadedBy" readonly>
                                        </div>
                                    </div>
                                   
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
                                <table id="tbl_whse_superior_preshipment_list" class="table table-striped table-bordered" style="width: 100%; font-size: 85%;">
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
                                        <th style="text-align: center;">Remarks</th>                           
                                                                
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



            
            <!--View Preshipment For viewing Modal -->
            <div class="modal fade" id="modalViewPreshipmentOnly" data-backdrop="static" style="overflow: auto;">
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
                                    <div class="card-header ">
                                        
                                            <div>
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
                                    <!-- /.card-header -->
                                    <div class="card-body">  
                                        <input type="hidden" id="txtViewPreshipmentId" name="preshipment_id">

                                        <div class="input-group input-group-sm mb-3 d-none">

                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Packing List Control No:</span>
                                            </div>
                                            
                                                <input type="text" class="form-control" name="whse_view_ctrl_no" id="txtViewCtrlNo" readonly>
                        
                                        </div>
                                        <div class="input-group input-group-sm mb-3">

                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Packing List Control No:</span>
                                            </div>
                                            
                                                <input type="text" class="form-control" name="whse_view_ctrl" id="txtViewCtrl" readonly>
                        
                                        </div>
                                        
                                        
                                        <div class="d-flex">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Date:</span>
                                                </div>
                            
                                                
                                                <input type="text" class="form-control" name="whse_view_date" id="txtViewDate" readonly>
                            
                                            </div>
                        
                                            <div class="input-group input-group-sm mb-3 ml-2">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Shipment Date:</span>
                                                </div>
                                                
                                                <input type="text" class="form-control" name="whse_view_ship_date" id="txtViewShipDate" readonly>
                        
                                            </div> 
                                        </div>
                                        
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Station:</span>
                                            </div>
                                            
                                            <input type="text" class="form-control" name="whse_view_station" id="txtViewStation" readonly>
                    
                                        </div> 
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Destination:</span>
                                            </div>
                                            
                                            <input type="text" class="form-control" name="whse_view_destination" id="txtViewDestination" readonly>
                        
                                        </div>    
                                        {{-- <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Checked By:</span>
                                            </div>
                                            
                                            <input type="text" class="form-control" name="whse_view_check_by" id="" readonly>
                        
                                        </div> --}}

                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Invoice Number:</span>
                                            </div>
                                            
                                            <input type="text" class="form-control" name="whse_view_invoice_num" id="txtViewInvoinceNum" readonly>
                                        </div>    

                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">WBS Receiving Number:</span>
                                            </div>
                                            
                                            <input type="text" class="form-control" name="whse_view_receiving_num" id="txtViewReceivingNum" readonly>
                                        </div>    
                                    </div>
                                    {{-- <div class="card-footer">
                                        
                                        <div class="d-flex justify-content-between">

                                            <button class="btn btn-info btn-sm" id="btnDownloadForWbs"><i class="fas fa-lg fa-file-csv"></i> Download for WBS</button>
                                            <button class="btn btn-outline-success btn-sm" id="btnDoneUpload" data-toggle="modal" data-target="#modalDoneUpload"> Done Upload</button>
                                        </div>
                                    </div> --}}
                                    
                                    
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
                                <table id="tbl_view_preshipment_list" class="table table-striped table-bordered" style="width: 100%; font-size: 85%;">
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
                                        <th style="text-align: center;">Remarks</th>                           
                                                                
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

                                <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="acceptPreshipmentId" name="accept_preshipment">
                                <h5 class="modal-title"><i class="fa fa-pencil-square"></i>Are you sure you want to accept this?</h5>
                            </div>
                            <div class="modal-footer">
                                <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Cancel</button>
                                <button type="submit" class="btn btn-success">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalRejectId" data-backdrop="static" style="overflow: auto;">
                <div class="modal-dialog" style="margin-top: 5%;"> 
                    <div class="modal-content">
                        <form action="post" id="formRejectPreshipment">
                            @csrf
                            <div class="modal-header">

                                <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="rejectPreshipmentId" name="reject_preshipment">
                                <h5 class="modal-title"><i class="fa fa-pencil-square"></i>Are you sure you want to reject this?</h5><br>
                                <h6>Remarks:</h6>
                                <textarea name="reject_remarks_preshipment" id="txtRejectRemarks" class="form-control" rows="5" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Cancel</button>
                                <button type="submit" class="btn btn-success">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="modalDoneUpload" data-backdrop="static" style="overflow: auto;">
                <div class="modal-dialog" style="margin-top: 5%;"> 
                    <div class="modal-content">
                        <form action="post" id="doneUploadId">
                            @csrf
                            <div class="modal-header">
                                <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="DoneUploadId" name="done_upload_id">
                                <input type="hidden" id="DoneUploadInvoiceNum" name="done_upload_invoice_number">
                                <input type="hidden" id="DoneUploadReceivingNum" name="done_upload_receiving_number">

                                <center><h5 class="modal-title"><i class="fa fa-pencil-square"></i>Are you sure you are done uploading?</h5></center>
                               
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Cancel</button>
                                <button type="submit" class="btn btn-success" id="btnYesDoneUpload" title="asd">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    
            <div class="modal fade" id="modalSuperiorApprove" data-backdrop="static" style="overflow: auto;">
                <div class="modal-dialog" style="margin-top: 5%;"> 
                    <div class="modal-content">
                        <div class="modal-header">
                            <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                        <form action="post" id="formSuperiorApprove">
                            @csrf
                           
                            <div class="modal-body">
                                <input type="hidden" id="txtSuperiorApprovingTblId" name="superior_approving_tbl_id">
                                <center><h5 class="modal-title"><i class="fa fa-pencil-square"></i>Are you sure you want to approve this?</h5></center>
                               
                            </div>
                            <div class="modal-footer">
                                <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Cancel</button>
                                <button type="submit" class="btn btn-success" id="btnSuppYes">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalSuperiorDisapprove" data-backdrop="static" style="overflow: auto;">
                <div class="modal-dialog" style="margin-top: 5%;"> 
                    <div class="modal-content">
                        <div class="modal-header">
                            <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                        <form action="post" id="formSuperiorDisapprove">
                            @csrf
                           
                            <div class="modal-body">
                                <input type="hidden" id="txtSuperiorDisapprovingTblId" name="superior_disapproving_tbl_id">
                                <h5 class="modal-title"><i class="fa fa-pencil-square"></i>Are you sure you want to Disapprove this?</h5>
                                <br>
                                <label>Remarks:</label><br>
                                <textarea name="remarks_superior_dis" id="txtRemarksSuperiorDis" class="form-control" rows="5" required></textarea>
                               
                            </div>
                            <div class="modal-footer">
                                <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Cancel</button>
                                <button type="submit" class="btn btn-success">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalBypassAccept" style="overflow: auto;">
                <div class="modal-dialog" style="margin-top: 5%; width: 250px;"> 
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0 pb-0">
                            <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                        {{-- <form action="post" id="formSuperiorDisapprove"> --}}
                            {{-- @csrf --}}
                           
                            <div class="modal-body">
                               <div class="text-center text-secondary">
                                    Please scan your ID.
                                    <br>
                                    <h1><i class="fas fa-barcode"></i></h1>
                                    <input type="text" class="hidden_scanner_bypass_input" id="txtBypassId">
                               </div>
                            </div>
                            {{-- <div class="modal-footer"> --}}
                                {{-- <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Cancel</button> --}}
                                {{-- <button type="submit" class="btn btn-success">Yes</button> --}}
                            {{-- </div> --}}
                        {{-- </form> --}}
                    </div>
                </div>
            </div>

            {{-- MODAL FOR HAS INVALID --}}
            <div class="modal fade" id="modalHasInvalidId" data-backdrop="static" style="overflow: auto;">
                <div class="modal-dialog" style="margin-top: 5%;"> 
                <div class="modal-content">
                    {{-- <form action="post" id="formHasInvalidId"> --}}
                    <div class="modal-header">
                        <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="moda-body p-2">
                        <h5 class="modal-title text-center"><i class="fa fa-pencil-square"></i>Invalid Sticker Detected.<br>Please Insert Remarks and Scan Supervisor ID to Proceed.</h5><br>
                        <label>Remarks:</label>
                        <textarea name="invalid_remarks" id="invalidRemarks" class="form-control" rows="5" required></textarea>            
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Cancel</button>
                        <button type="submit" id="btnInvalidScanUserId" class="btn btn-success">Scan ID</button>
                    </div>
                    {{-- </form> --}}
                </div>
                </div>
            </div>

            <div class="modal fade" id="modalScanEmployeeId" data-formid="" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <input type="text" class="w-100 hidden_scanner_input" id="txtScanEmployeeId" name="" autocomplete="off">
                            <div class="text-center text-dark"><h4>Please scan your ID.</h4>
                                <h1><i class="fa fa-barcode fa-lg"></i></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<!--     {{-- JS CONTENT --}} -->
@section('js_content')

<script>
$(document).ready(function () {
    let tblApprovingPrehipmentId, tblApprovingInvoiceNum, tblApprovingReceivingNum, totalQty, isLocalReceiving;
    dataTableWhsePreshipment = $("#tbl_whse_preshipment").DataTable({
      "processing" : true,
      "serverSide" : true,
      "ordering"  : false,
      "ajax" : {
          url: "get_preshipment_for_ts_cn_whse",
        //   data : function(param){
        //     param.login_id = $('#login_id').val();
        //   }
      },
      "columns":[    
          { "data" : "status"},
          { "data" : "preshipment.Date" },
          { "data" : "preshipment.Station" },
          { "data" : "preshipment_ctrl_num"},
        //   { "data" : "preshipment.Packing_List_CtrlNo"},
          { "data" : "rapid_invoice_number"},
          { "data" : "preshipment.Shipment_Date"},
          { "data" : "preshipment.Destination"},
          { "data" : "action"},
          
      ],
    });

    dataTableWhsePreshipmentList = $("#tbl_whs_preshipment_list").DataTable({
        "processing" : true,
        "serverSide" : true,
        "ordering"  : false,
            "paging" : false,
        "ajax" : {
            // url: "get_preshipment_list_for_whse",
            url: "get_Preshipment_list",
            data: function (param){
                // param.preshipmentId = $("#preshipmentId").val();
                param.preshipmentCtrlNo = $("#packingControlNoId").val();
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
            { "data" : "drawing_no"},
            { "data" : "rev"},
            { "data" : "Remarks"},
            { "data" : "hide_input"},
            
        ],
    });

  
    dataTableWhsePreshipmentListForUpload = $("#tbl_whs_preshipment_list_for_upload").DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
          url: "get_preshipment_list_for_whse_for_upload",
          data: function (param){
            // param.preshipmentId = $("#txtPreshipmentId").val();
            param.preshipmentId = $("#txtApprovingPackingListControlNo").val();
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
          { "data" : "Remarks"},
          
      ],
    });

    dataTableWhseSuperiorPreshipmentList = $("#tbl_whse_superior_preshipment_list").DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
          url: "get_preshipment_list_for_whse_superior",
          data: function (param){
            param.preshipmentId = $("#txtApprovingSuperiorCtrlNum").val();
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
          { "data" : "Remarks"},
          
      ],
    });


    dataTableWhseViewPreshipmentList = $("#tbl_view_preshipment_list").DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
          url: "get_preshipmentlist_for_view",
          data: function (param){
            param.preshipmentId = $("#txtViewCtrlNo").val();
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
          { "data" : "Remarks"},
          
      ],
    });

    dataTableWhseForApproval= $("#tbl_whse_for_approver").DataTable({
      "processing" : true,
      "serverSide" : true,
      "ordering"   : false,
      "ajax" : {
          url: "get_preshipment_of_ts_cn_for_approval",
      },
      "columns":[    
        { "data" : "status"},
        { "data" : "preshipment.Date" },
        { "data" : "preshipment.Station" },
        { "data" : "preshipment_ctrl_num"},
        // { "data" : "preshipment.Packing_List_CtrlNo"},
        { "data" : "rapid_invoice_number"},
        { "data" : "preshipment.Shipment_Date"},
        { "data" : "preshipment.Destination"},
          { "data" : "action"},
        //   { "data" : "action"},
          
      ],
    });
       // change 07/13/2022
       dataTableWhseDone= $("#tbl_whse_done_preshipment").DataTable({
      "processing" : true,
      "serverSide" : true,
      "ordering"   : false,
      "ajax" : {
          url: "get_preshipment_done",
      },
      "columns":[    
        { "data" : "status"},
        { "data" : "preshipment.Date" },
        { "data" : "preshipment.Station" },
        { "data" : "preshipment_ctrl_num"},
        // { "data" : "preshipment.Packing_List_CtrlNo"},
        { "data" : "rapid_invoice_number"},
        { "data" : "preshipment.Shipment_Date"},
        { "data" : "preshipment.Destination"},
          { "data" : "action"},
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
        $('#btnAcceptPreshipment').prop('disabled', false);
        }
        else{
        $('#btnAcceptPreshipment').prop('disabled', true);
        }


    });

    //FOR BARCODE SCANNING
    var timer = '', scannedItem = "";
    $('input#txtForScanner').keypress( function() {
      
      var txtForScanning = $(this); // copy of this object for further usage
     
        clearTimeout(timer);
        timer = setTimeout(function() {
          scannedItem = txtForScanning.val().toUpperCase();
          console.log(scannedItem);
        //   var arr = scannedItem.split(', ');
        //   itemVerificationTSCNWhse(arr);
            var arr = scannedItem.split(',');

            if(arr.length == 7){
                console.log("if",arr)
            itemVerificationTSCNWhse(arr);
            }
            else{
                
                var arr = scannedItem.split(', ');
                console.log("else",arr)
            itemVerificationTSCNWhse(arr);
            }
          txtForScanning.val("");
        }, 500);
    });


    $(document).on('click', '.btn-whs-view-for-receiving', function(){
        let preshipment_id = $(this).attr('preshipment-id');
        // console.log(preshipment_id);
        getPreshipmentDetailsByIdForReceiving(preshipment_id);
        // dataTableWhsePreshipmentList.draw();
        $('#btnAcceptPreshipment').prop('disabled', true);

       
    });

    $('#btnAcceptPreshipment').on('click', function(){
        let preshipmentId = $('#preshipmentId').val();
        $('#acceptPreshipmentId').val(preshipmentId);
        let isInvalidCheck = $('#txtInvalidChecker').val();
        if(isInvalidCheck == 0){
            $('#modalApproveId').modal('show');
        }
        else{
            $('#modalHasInvalidId').modal('show');
        }
        // console.log(preshipmentId);
    });

    $('#btnInvalidScanUserId').on('click', function(){
        if($('#invalidRemarks').val() == ""){
        $("#invalidRemarks").addClass('is-invalid');
        }
        else{
            $("#invalidRemarks").removeClass('is-invalid');
            $('#modalScanEmployeeId').modal('show');
            $('#modalScanEmployeeId').on('shown.bs.modal', function () {
                $('#txtScanEmployeeId').val("");
                $('#txtScanEmployeeId').focus();
            });
        }
    });

    $('#txtScanEmployeeId').on('keyup', function(e){

      if(e.keyCode == 13 ){
        $.ajax({
          url: "get_authorize_by_id",
          type: "get",
          data: {
            emp_id: $('#txtScanEmployeeId').val().toUpperCase()
          },
          dataType: "json",
          success: function (response) {
            // acceptPreshipment();
            // $('#txtScanEmployeeId').val("");
            // $('#modalScanEmployeeId').modal('hide');
            // $('#modalHasInvalidId').modal('hide');

            if(response['result'] == 1){
              let scannedId = $('#txtScanEmployeeId').val();
              let invalidRemarks = $('#invalidRemarks').val();
              let invalidModule = $('#txtPreshipmentProductLine').val()+'-whse';
              let preshipmentId = $('#preshipmentId').val();

              addInvalidDetails(scannedId,invalidRemarks,invalidModule,preshipmentId);
              acceptPreshipment();

              $('#modalScanEmployeeId').modal('hide');
              $('#modalHasInvalidId').modal('hide');
            }
            else{
              toastr.error('Invalid ID');
              $('#modalScanEmployeeId').modal('hide');
              setTimeout(() => {
                
                $('#modalScanEmployeeId').modal('show');
              }, 400);
            }

            $('#txtScanEmployeeId').val("");
            
          }
        });
      }
    });

    $('#acceptFormid').submit(function(event){
        event.preventDefault();
        acceptPreshipment();
    });

    $('#btnRejectPreshipmentId').on('click', function(){
        let preshipmentId = $('#preshipmentId').val();
        $('#rejectPreshipmentId').val(preshipmentId);
    });

   

    $(document).on('click', '.btn-whs-view-for-upload', function(){
        let preshipmentId = $(this).attr('preshipment-id');
        getPreshipmentDetailsForUpload(preshipmentId);
        getInvoiceCtrlNo(preshipmentId);
    });

    $(document).on('click', '.btn-whse-reject', function(){
        let preshipmentId = $(this).attr('preshipment-id');
        $('#rejectPreshipmentId').val(preshipmentId);
    });


    $('#btnDownloadForWbs').on('click', function(){
        let invoiceNum = $('#txtApprovingInvoinceNo').val();
        let packingListCtrlNo = $('#txtApprovingPackingListControlNo').val();
        let packingListProductLine = $('#txtPreshipmentProductLine').val();

        // window.location.href = `export/${invoiceNum}/${packingListCtrlNo}/${packingListProductLine}`;
        window.open(`export/${invoiceNum}/${packingListCtrlNo}/${packingListProductLine}`, '_blank');
    });

    $('#btnDoneUpload').on('click', function(){
        tblApprovingPrehipmentId = $('#txtApprovingID').val();
        tblApprovingInvoiceNum = $('#txtApprovingInvoinceNo').val();
        tblApprovingReceivingNum = $('#txtApprovingReceivingNo').val();
        isLocalReceiving = $('input[name="checkbox_local_mat"]').val();
        totalQty = $('#txtPreshipmentTotalQty').val();

        checkWBSVariance(tblApprovingPrehipmentId, tblApprovingReceivingNum, tblApprovingInvoiceNum, isLocalReceiving, totalQty, 1); // additional 05/09/2023

        $('#DoneUploadId').val(tblApprovingPrehipmentId);
        $('#DoneUploadInvoiceNum').val(tblApprovingInvoiceNum);
        $('#DoneUploadReceivingNum').val(tblApprovingReceivingNum);


    })

    $('#doneUploadId').submit(function(event){
        event.preventDefault();
        doneUploadingPreshipmentList();
    });


    $(document).on('click', '.btn-whs-view-for-superior-approval' , function(){
        let preshipmentListApprovingId = $(this).attr('preshipment-id');

        getPreshipmentDetailsbyIdForSuperior(preshipmentListApprovingId);
    });

    $('#iconRefresh').on('click', function(){
        if($('input[name="checkbox_local_mat"]').is(':checked')){
            // $('#txtApprovingInvoinceNo').prop('readonly', false);
            let invoiceNum = $('#txtApprovingInvoinceNo').val();
            let productLine = $('#txtPreshipmentProductLine').val();
            // console.log(invoiceNum+"qwe"+productLine);
            getWBSLocalReceivingNumber(invoiceNum,productLine);
        }
        else{
            // $('#txtApprovingInvoinceNo').prop('readonly', true);
            let approvingId = $('#txtApprovingID').val();
            getPreshipmentDetailsForUpload(approvingId);
            getInvoiceCtrlNo(approvingId);

        }


    });

    $('#btnSuperiorApprove').on('click', function(){
        tblApprovingPrehipmentId = $('#txtApprovingId').val();
        tblApprovingInvoiceNum = $('#txtApprovingSuperiorInvoiceNum').val();
        tblApprovingReceivingNum = $('#txtApprovingSuperiorReceivingNum').val();
        totalQty = $('#txtApprovingSuperiorPreshipmentQty').val();

        let splitted = tblApprovingReceivingNum.split("-");
        if(splitted[0] == 'MAT'){
            isLocalReceiving = 0;
        }
        else{
            isLocalReceiving = 1;
        }

        checkWBSVariance(tblApprovingPrehipmentId, tblApprovingReceivingNum, tblApprovingInvoiceNum, isLocalReceiving, totalQty, 2); // additional 05/09/2023

        $('#txtSuperiorApprovingTblId').val(tblApprovingPrehipmentId);
    });

    $('#btnSuperiorDisapprove').on('click', function(){
        let disapprovingId = $('#txtApprovingId').val();

        $('#txtSuperiorDisapprovingTblId').val(disapprovingId);
    });

    $('#formSuperiorApprove').submit(function(event){
        event.preventDefault();
        superiorApproving();
    });
    $('#formSuperiorDisapprove').submit(function(event){
        event.preventDefault();
        superiorDisapproving();
    });

    $(document).on('click', '.btn-whs-view' , function(){
        let approvingId  = $(this).attr('preshipment-id');

        getPreshipmentForView(approvingId);
    });

    $('#formRejectPreshipment').submit(function(event){
        event.preventDefault();
        rejectPreshipment();
    });

    $('#chckWbsLocalMatRecId').on('click', function(){
        if($('input[name="checkbox_local_mat"]').is(':checked')){
            $('#txtApprovingInvoinceNo').prop('readonly', false);
            $('input[name="checkbox_local_mat"]').val('1');
        }
        else{
            $('#txtApprovingInvoinceNo').prop('readonly', true);
            $('input[name="checkbox_local_mat"]').val('0');
        }
    });
});
</script>
@endsection

@endsection
