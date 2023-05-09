@php $layout = 'layouts.admin_layout'; @endphp


@extends($layout)


@section('content_page')

<style>
 
.hidden_scanner_input {
    position: absolute;
    opacity: 0;
}

#modalViewMaterialHandlerChecksheets{
    scroll-behavior: smooth;
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
            
            <li class="breadcrumb-item active">Material Handler</li>
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
                        <a class="nav-link active" id="MH-checking-tab" data-toggle="tab" href="#MH-checking" role="tab" aria-controls="MH-checking" aria-selected="true">Pending Transactions</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="MH-inspector-tab" data-toggle="tab" href="#MH-inspector" role="tab" aria-controls="MH-inspector" aria-selected="false">For QC Transaction</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="MH-whse-int-tab" data-toggle="tab" href="#MH-int-whse" role="tab" aria-controls="MH-int-whse" aria-selected="false">Internal Transactions</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="MH-whse-ext-tab" data-toggle="tab" href="#MH-ext-whse" role="tab" aria-controls="MH-ext-whse" aria-selected="false">External Transactions</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="MH-grinding-tab" data-toggle="tab" href="#MH-grinding" role="tab" aria-controls="MH-grinding" aria-selected="false">Grinding</a>
                        </li>
                </ul>
                    
                <div class="tab-content" id="myTabContent" >
                    <div class="tab-pane fade show active" id="MH-checking" role="tabpanel" aria-labelledby="MH-checking-tab">
                        <div class="table responsive mt-2">
                            <table id="tblPreshipment" class="table table-sm table-bordered table-striped table-hover dt-responsive wrap" style="width: 100%; min-width: 10%; ">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">Status</th>
                                        <th>Date</th>
                                        <th>Station</th>
                                        <th>Packing List Control No</th>
                                        <th>Shipment Date</th>
                                        <th>Destination</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="MH-inspector" role="tabpanel" aria-labelledby="MH-inspector-tab">
                      <div class="table responsive mt-2">
                          <table id="tbl_qc_transaction" class="table table-sm table-bordered table-striped table-hover dt-responsive nowrap" style="width: 100%; min-width: 10%">
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
                              <tbody>

                              </tbody>
                          </table>
                      </div>
                    </div>

                    <div class="tab-pane fade" id="MH-int-whse" role="tabpanel" aria-labelledby="MH-whse-int-tab">
                      <div class="table responsive mt-2">
                          <table id="tbl_whse_int_transaction" class="table table-sm table-bordered table-striped table-hover dt-responsive nowrap" style="width: 100%; min-width: 10%">
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
                              <tbody>

                              </tbody>
                          </table>
                      </div>
                    </div>

                    <div class="tab-pane fade" id="MH-ext-whse" role="tabpanel" aria-labelledby="MH-whse-ext-tab">
                      <div class="table responsive mt-2">
                          <table id="tbl_whse_ext_transaction" class="table table-sm table-bordered table-striped table-hover dt-responsive nowrap" style="width: 100%; min-width: 10%">
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
                              <tbody>

                              </tbody>
                          </table>
                      </div>
                    </div>
                    
                    
                    <div class="tab-pane fade" id="MH-grinding" role="tabpanel" aria-labelledby="MH-grinding-tab">
                      <div class="table responsive mt-2">
                          <table id="tbl_preshipment_grinding" class="table table-sm table-bordered table-striped table-hover dt-responsive nowrap" style="width: 100%; min-width: 10%">
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
      </div>
  </section>
 
    <!-- Checksheets Modal -->
  <div class="modal fade" id="modalViewMaterialHandlerChecksheets" data-backdrop="static" style="overflow: auto;">
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
                    <form method="post" id="form_packing_list">
                      @csrf
                      <input type="hidden" id="packingId" name="packing_id">
                      <input type="hidden" id="txtInvalidChecker">
                      <div class="input-group input-group-sm mb-3">
                          <div class="input-group-prepend w-50">
                            <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Packing List Control No:</span>
                          </div>
                          
                            <input type="text" class="form-control" name="packingCtrlNo" id="packingCtrlNo_id" readonly>
      
                      </div>
                    
                    
                      <div class="d-flex">
                          <div class="input-group input-group-sm mb-3">
                              <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Date:</span>
                              </div>
          
                              {{-- <input type="hidden" class="form-control" name="device_id" id="txtDeviceId" readonly> --}}
                              <input type="text" class="form-control" name="packingDate" id="packingDate_id" readonly>
          
                          </div>
      
                          <div class="input-group input-group-sm mb-3 ml-2">
                              <div class="input-group-prepend w-50">
                                  <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Shipment Date:</span>
                              </div>
                              
                              <input type="text" class="form-control" name="packingShipmentDate" id="packingShipmentDate_id" readonly>
      
                          </div> 
                      </div>
                    
                      <div class="input-group input-group-sm mb-3">
                          <div class="input-group-prepend w-50">
                              <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Station:</span>
                          </div>
                          
                          <input type="text" class="form-control" name="packingStation" id="packingStation_id" readonly>

                      </div> 
                      <div class="input-group input-group-sm mb-3">
                          <div class="input-group-prepend w-50">
                            <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Destination:</span>
                          </div>
                          
                          <input type="text" class="form-control" name="packingDestination" id="packingDestination_id" readonly>
      
                      </div>    
                      </div>
                      <div class="card-footer">
                        <div style="float: right" id="divFooter">
                          <button class="btn btn-outline-danger" id="btn_disapprove_list_id"><i class="far fa-times-circle"></i> Disapprove</button>
                          <button type="submit" class="btn btn-outline-success " id="btn_approve_list_id" disabled><i class="far fa-check-circle"></i> Approve</button>
                        </div>
                      </div>
                    </form>
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
                <div class="dt-responsive table-responsive" style="margin-top: -2%;">
                  <table id="tbl_preshipment_list" class="table table-striped table-bordered" style="width: 100%; font-size: 85%;">
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
                        <th style="text-align: center;">hidden inputs</th>
                        <th style="text-align: center;">hidden stamping</th>                    
                                                 
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

    <!-- MH WHSE Transaction Modal -->
    <div class="modal fade" id="modalViewMaterialHandler" data-backdrop="static" style="overflow: auto;">
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
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend w-50">
                              <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Packing List Control No:</span>
                            </div>
                            
                              <input type="text" class="form-control" name="packingCtrlNo" id="whse_packingCtrlNo_id" readonly>
        
                        </div>
                      
                      
                        <div class="d-flex">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend w-50">
                                  <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Date:</span>
                                </div>
            
                                {{-- <input type="hidden" class="form-control" name="device_id" id="txtDeviceId" readonly> --}}
                                <input type="text" class="form-control" name="packingDate" id="whse_packingDate_id" readonly>
            
                            </div>
        
                            <div class="input-group input-group-sm mb-3 ml-2">
                                <div class="input-group-prepend w-50">
                                    <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Shipment Date:</span>
                                </div>
                                
                                <input type="text" class="form-control" name="packingShipmentDate" id="whse_packingShipmentDate_id" readonly>
        
                            </div> 
                        </div>
                      
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Station:</span>
                            </div>
                            
                            <input type="text" class="form-control" name="packingStation" id="whse_packingStation_id" readonly>
  
                        </div> 
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend w-50">
                              <span class="input-group-text w-100" id="basic-addon1" style="background-color: #17a2b8; color: white;">Destination:</span>
                            </div>
                            
                            <input type="text" class="form-control" name="packingDestination" id="whse_packingDestination_id" readonly>
        
                        </div>    
                        </div>
                       
                      
                    <!-- /.card-body -->
                  </div>   
                           
                  <div class="modal-footer">
                   
                  </div>
                  <div class="card">
                      
                  </div>     
                                      
                 
                </div>     
                <div class="col-sm-8">
                  <h3>Checksheets</h3>
                  <div class="dt-responsive table-responsive">
                    <table id="tbl_MH_preshipment" class="table table-striped table-bordered" style="width: 100%; font-size: 85%;">
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







  {{-- MODAL FOR DISAPPROVAL --}}
  <div class="modal fade" id="modalDisapproveId" data-backdrop="static" style="overflow: auto;">
    <div class="modal-dialog" style="margin-top: 5%;"> 
      <div class="modal-content">
        <form action="post" id="DisapproveFormid">
          <div class="modal-header">
            <h5 class="modal-title"><i class="fa fa-pencil-square"></i>Are you sure you want to disapprove?</h5>
            <button id="close" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          {{-- <div class="modal-body">
            <h5>Remarks:</h5>
            <textarea name="" id="" cols="50" rows="5" class="form-control"  style="resize: none;" required></textarea>
          </div> --}}
          <div class="modal-footer">
            <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Cancel</button>
            <button type="submit" class="btn btn-success">Yes</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  {{-- MODAL FOR APPROVAL --}}
  <div class="modal fade" id="modalapproveId" data-backdrop="static" style="overflow: auto;">
    <div class="modal-dialog" style="margin-top: 5%;"> 
      <div class="modal-content">
        <form action="post" id="approveFormid">
          <div class="modal-header">
            <h5 class="modal-title"><i class="fa fa-pencil-square"></i>Are you sure you want to approve?</h5>
            <button id="close" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-footer">
            <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Cancel</button>
            <button type="submit" id="btnApprove" class="btn btn-success">Yes</button>
          </div>
        </form>
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
    <div class="modal-dialog modal-sm " role="document">
        <div class="modal-content">
            <div class="modal-body">
              <div class="text-center text-dark"><h4>Please scan your ID.</h4>
                <h1><i class="fa fa-barcode fa-lg"></i></h1>
              </div>
              <input type="text" class="w-100 hidden_scanner_input" id="txtScanEmployeeId" name="" autocomplete="off">
            </div>
        </div>
    </div>
  </div>

  {{-- SCANNING CHECKING OF PRESHIPMENT --}}
  <div class="modal fade" id="modalScanPreshipment" data-formid="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document" style="margin-right: 75%;">
        <div class="modal-content">
            <div class="modal-body">
              <div class="text-center text-dark">
                <h1><i class="fa fa-qrcode fa-2x"></i></h1>
                <h4>Please Scan QR Code.</h4>
              </div>
              <input type="text" class="w-100 hidden_scanner_input" id="txtScanPreshipment" name="" autocomplete="off">
            </div>
        </div>
    </div>
  </div>



 



</div>

<!--     {{-- JS CONTENT --}} -->
@section('js_content')
<script>
  var dataTablePreshipment,dataTablePreshipmentList,dataTableForWhse,dataTableForWhseList;
    
  $(document).ready(function () {


    //PACKING LIST DATA TABLE
    dataTablePreshipment = $("#tblPreshipment").DataTable({
      "processing" : true,
      "serverSide" : true,
      "ordering"   : false,
      "ajax" : {
          url: "get_Preshipment", 
      },
      "columns":[    
          { "data" : "status"},
          { "data" : "Date" },
          { "data" : "Station" },
          { "data" : "Packing_List_CtrlNo"},
          { "data" : "Shipment_Date"},
          { "data" : "Destination"},
          { "data" : "action"},
          
      ],
    }); 

    //PRE-SHIPMENT DATA TABLE
    dataTablePreshipmentList = $("#tbl_preshipment_list").DataTable({
      "processing" : false,
      "serverSide" : true,
      "paging"     : false,
      "ordering"   : false,
      "ajax" : {
          url: "get_Preshipment_list",
          data: function (param){
            param.preshipmentCtrlNo = $("#packingCtrlNo_id").val();
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
          { "data" : "hide_stamping"}
          
      ],
      "columnDefs": [
      {
        className: "d-none", "targets": [ 14,15 ]
      }],
    });

    //datatable for internal transaction
    dataTableForWhse = $("#tbl_whse_int_transaction").DataTable({
      "processing" : false,
      "serverSide" : true,
      // "paging"     : false,
      "ordering"   : false,
      "ajax" : {
          url: "get_for_whse_transaction", 
      },
      "columns":[    
          { "data" : "status"},
          { "data" : "preshipment.Date" },
          { "data" : "preshipment.Station" },
          { "data" : "preshipment.Packing_List_CtrlNo"},
          { "data" : "rapid_invoice_number"},
          { "data" : "preshipment.Shipment_Date"},
          { "data" : "preshipment.Destination"},
          { "data" : "action"},
          
      ],
    });

    //datatable for external transaction
    dataTableForWhseExt = $("#tbl_whse_ext_transaction").DataTable({
      "processing" : false,
      "serverSide" : true,
      // "paging"     : false,
      "ordering"   : false,
      "ajax" : {
          url: "get_for_whse_ext_transaction", 
      },
      "columns":[    
          { "data" : "status"},
          { "data" : "preshipment.Date" },
          { "data" : "preshipment.Station" },
          { "data" : "preshipment.Packing_List_CtrlNo"},
          { "data" : "preshipment.Shipment_Date"},
          { "data" : "preshipment.Destination"},
          { "data" : "action"},
          
      ],
    });

    dataTableForWhseList = $("#tbl_MH_preshipment").DataTable({
      "processing" : false,
      "serverSide" : true,
      "paging"     : false,
      "ordering"   : false,
      "ajax" : {
          url: "get_Preshipment_list",
          data: function (param){
            param.preshipmentCtrlNo = $("#packingCtrlNo_id").val();
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

    //change 07/14/2022
    dataTableForQcTransaction = $("#tbl_qc_transaction").DataTable({
      "processing" : true,
      "serverSide" : true,
      // "paging"     : false,
      "ordering"   : false,
      "ajax" : {
          url: "get_for_qc_transaction",
          // data: function (param){
          //   param.preshipmentCtrlNo = $("#packingCtrlNo_id").val();
          // },
      },
      "columns":[    
          { "data" : "status"},
          { "data" : "Date" },
          { "data" : "Station" },
          { "data" : "Packing_List_CtrlNo"},
          { "data" : "Shipment_Date"},
          { "data" : "Destination"},
          { "data" : "action"},
          
      ],
    });


    //added 04/17/2023
    dataTablePreshipmentGrinding = $("#tbl_preshipment_grinding").DataTable({
      "processing" : true,
      "serverSide" : true,
      // "paging"     : false,
      "ordering"   : false,
      "ajax" : {
          url: "get_preshipment_grinding",
          // data: function (param){
          //   param.preshipmentCtrlNo = $("#packingCtrlNo_id").val();
          // },
      },
      "columns":[    
          { "data" : "status"},
          { "data" : "Date" },
          { "data" : "Station" },
          { "data" : "Packing_List_CtrlNo"},
          { "data" : "Shipment_Date"},
          { "data" : "Destination"},
          { "data" : "action"},
          
      ],
    });

      
    //SCRIPT TO SHOW QR FOR PRESHIPMENT TO START THE SCANNING PROCESS
    $('#btnScanItem').on('click',function(){

      $('#modalScanPreshipment').modal('show');
      $('#modalScanPreshipment').on('shown.bs.modal', function () {
            $('#txtScanPreshipment').val("");
            $('#txtScanPreshipment').focus();
      });

      // $('#qrDiv').css('display','block');
      // $('#txtForScanner').focus();
      // $('#close').attr('disabled','disabled');
      $('#btn_disapprove_list_id').attr('disabled','disabled');
      // // $('#btn_approve_list_id').attr('disabled','disabled');
      $('#btnDoneScan').removeClass("d-none");

     
    });

    //WHEN CLOSED TR THAT DONT HAVE A GREEN HIGHLIGHT WILL BE RED
    $('#btnDoneScan').on('click', function(){
      $('#btnDoneScan').addClass("d-none");
      $('#qrDiv').css('display','none');
      $('#close').removeAttr('disabled');
      $('#btn_disapprove_list_id').removeAttr('disabled');
      // $('#btn_approve_list_id').removeAttr('disabled');

      let test = [];

      $('#tbl_preshipment_list tr').each(function(row, tr){
        if(row>0){
          highlight = $(tr).hasClass('checked-ok');
          if(highlight == false){
            $(tr).addClass('checked-ng');
          }
          test.push(highlight);
        }
        row++;
				
			});
      console.log(jQuery.inArray(false, test));
      if(jQuery.inArray(false, test) == -1){
        // console.log('enable button');
        $('#btn_approve_list_id').prop('disabled', false);
      }
      else{
        $('#btn_approve_list_id').prop('disabled', true);
      }

      

    });


    $(document).on('click', '.btn-openshipment', function(){
        let checksheetId = $(this).attr('checksheet-id');
        GetPreshipmentList(checksheetId);
        $('#btn_approve_list_id').prop('disabled', true);
        
    });
    $(document).on('click', '.btn-openshipmentWhse', function(){
        let checksheetId = $(this).attr('checksheet-id');
        GetPreshipmentList(checksheetId);
    });

    //FOR BARCODE SCANNING
    var timer = '', scannedItem = "";
    $('#txtScanPreshipment').keypress(function(){
      var txtForScanning = $(this); // copy of this object for further usage
     
      clearTimeout(timer);
      timer = setTimeout(function() {

        scannedItem = txtForScanning.val().toUpperCase();
        var arr = scannedItem.split(',');
        var trimStr = arr[0].trim();
        // console.log(trimStr);
        if(arr.length == 7){
          console.log("if", arr);
          itemVerification(arr);
        }
        else{
          var arr = scannedItem.split(', ');
          console.log("else",arr);
          itemVerification(arr);

        }
        // console.log(testScann);
        // itemVerification(arr);
        txtForScanning.val("");
        txtForScanning.focus();
      }, 500);
    })

    // $('input#txtForScanner').keypress( function() {
      
    //   var txtForScanning = $(this); // copy of this object for further usage
     
    //     clearTimeout(timer);
    //     timer = setTimeout(function() {
    //       scannedItem = txtForScanning.val().toUpperCase();
    //       var arr = scannedItem.split(',');
    //       itemVerification(arr);
    //       txtForScanning.val("");
    //     }, 500);
    // });


    //DISAPPROVAL OF PRE-SHIPMENT
    $("#btn_disapprove_list_id").on('click', function(event){
      event.preventDefault();
      $('#modalDisapproveId').modal('show');
    });
    $('#DisapproveFormid').submit(function(event){
      event.preventDefault();
      disapprovePackingList();

    });


    //APPROVAL OF PRE-SHIPMENT
    $("#btn_approve_list_id").on('click', function(event){
      event.preventDefault();
      let isInvalidCheck = $('#txtInvalidChecker').val();
      if(isInvalidCheck == 0){
        $('#modalapproveId').modal('show');
      }
      else{
        $('#modalHasInvalidId').modal('show');
      }
    
    });
    $('#approveFormid').submit(function(event){
      event.preventDefault();
      approvePackingList();
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
            

            if(response['result'] == 1){
              let scannedId = $('#txtScanEmployeeId').val();
              let invalidRemarks = $('#invalidRemarks').val();
              let invalidModule = 'mh';
              let preshipmentId = $('#packingId').val();

              addInvalidDetails(scannedId,invalidRemarks,invalidModule,preshipmentId);
              approvePackingList();
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


  });

</script>

@endsection

@endsection
