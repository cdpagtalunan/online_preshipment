@php $layout = 'layouts.admin_layout'; @endphp


@extends($layout)


@section('content_page')

<style>
 
  .hidden_scanner_input {
      position: absolute;
      opacity: 0;
  }

  /* #tbl_preshipment_list_QC tbody td:last-child {
    display: none;
  } */
  /* #tbl_preshipment_list_QC tbody td:first-child {
    display: none;

  } */


  #modalViewQCChecksheets{
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
            
            <li class="breadcrumb-item active">Inspector</li>
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
                        <a class="nav-link active" id="inspection-tab" data-toggle="tab" href="#inspection" role="tab" aria-controls="inspection" aria-selected="true">For Inspection</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="done-tab" data-toggle="tab" href="#done" role="tab" aria-controls="done" aria-selected="false">Done</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" id="workloads-person-tab" data-toggle="tab" href="#workloadsPerson" role="tab" aria-controls="person" aria-selected="false">Person in Charge Tab</a>
                        </li>
                        --}}
                
                  
                    
                      </ul>
                    
                        <div class="tab-content test" id="myTabContent" >
                            <div class="tab-pane fade show active" id="inspection" role="tabpanel" aria-labelledby="inspection-tab">
                                <div class="table responsive mt-2">
                                    <table id="tblPreshipment" class="table table-sm table-bordered table-striped table-hover dt-responsive nowrap" style="width: 100%; min-width: 10%">
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

                            <div class="tab-pane fade" id="done" role="tabpanel" aria-labelledby="done-tab">
                              <div class="table responsive mt-2">
                                  <table id="tblDonePreshipment" class="table table-sm table-bordered table-striped table-hover dt-responsive nowrap" style="width: 100%; min-width: 10%">
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
  <div class="modal fade" id="modalViewQCChecksheets" data-backdrop="static" style="overflow: auto;">
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
                        <div style="float: right" id="btnDiv">
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
                {{-- <div class="modal" id="test" tabindex="-1" data-backdrop="static">
                  <div class="modal-dialog" style="width:100%;max-width:450px;"> 
                    <div class="modal-content">
                      <div class="modal-header">
                        <h3 class="modal-title">Pre-Shipmesdadnt List</h3>
                        <button id="close1" class="close"  aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div id="qrDiv" style="font-size: 20px; opacity: 80%;">
                          <center>
                              
                              <i class="fas fa-qrcode fa-10x"></i><br>
                              <input type="text" name="" id="txtForScanner">
                          </center>
                        </div> 
                      </div>
                    </div>
                  </div>
                </div> --}}
               
              </div>     
              <div class="col-sm-8">
                <h3>Checksheets</h3>
                <div class="dt-responsive table-responsive" style="margin-top: -2%;">
                  <table id="tbl_preshipment_list_QC" class="table table-striped table-bordered" style="width: 100%; font-size: 85%;">
                    <thead>
                      <tr>
                        {{-- <th style="display: none;">hidden id</th> --}}
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


  {{-- MODAL FOR DISAPPROVAL --}}
  <div class="modal fade" id="modalDisapproveId" data-backdrop="static" style="overflow: auto;">
    <div class="modal-dialog" style="margin-top: 5%;"> 
      <div class="modal-content">
        <form action="post" id="DisapproveFormid">
          {{-- @csrf --}}
          <div class="modal-header">
            <h5 class="modal-title"><i class="fa fa-pencil-square"></i>Are you sure you want to disapprove?</h5>
            <button id="close" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h5>Remarks:</h5>
            <textarea name="" id="qcRemarks" cols="50" rows="5" class="form-control"  style="resize: none;" required></textarea>
          </div>
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
            <h5 class="modal-title text-center "><i class="fa fa-pencil-square"></i>Invalid Sticker Detected.<br>Please Insert Remarks and Scan Supervisor ID to Proceed.</h5><br>
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
  var dataTablePreshipment,dataTablePreshipmentList;
    
  $(document).ready(function () {
    


    //PACKING LIST DATA TABLE
    dataTablePreshipment_QC = $("#tblPreshipment").DataTable({
      "processing" : true,
      "serverSide" : true,
      "ordering"   : false,
      "ajax" : {
          url: "get_Preshipment_QC", 
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
    dataTablePreshipmentList_QC = $("#tbl_preshipment_list_QC").DataTable({
      "processing" : false,
      "serverSide" : true,
      "paging"     : false,
      "ordering"   : false,
      "searching": false,
      "ajax" : {
          url: "get_Preshipment_list_QC",
          data: function (param){
            param.preshipmentCtrlNo = $("#packingCtrlNo_id").val();
          },
      },
      "columns":[    
          // { "data" : "hide_id"},
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
          { "data" : "hide_input"},
          { "data" : "hide_stamping"},

          
      ],
      "columnDefs": [
      {
        className: "d-none", "targets": [ 13,12 ]
      }],
    }); 

    //change 07/14/2022
    dataTablePreshipmentDone = $("#tblDonePreshipment").DataTable({
      "processing" : true,
      "serverSide" : true,
      "ordering"   : false,
      "ajax" : {
          url: "get_Preshipment_done", 
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
      // // $('#test').modal('show');
      
      // $('#txtForScanner').focus();
      // // $('#close').disable();
      // $('#close').attr('disabled','disabled');
      $('#btn_disapprove_list_id').attr('disabled','disabled');
      // $('#btn_approve_list_id').attr('disabled','disabled');
      $('#btnDoneScan').removeClass("d-none");

     
    });

    //WHEN CLOSED TR THAT DONT HAVE A GREEN HIGHLIGHT WILL BE RED
    $('#btnDoneScan').on('click', function(){

      let trArray = [];

      $('#btnDoneScan').addClass("d-none");
      $('#qrDiv').css('display','none');
      // $('#close').attr('disabled','disabled');
      $('#close').removeAttr('disabled');
      $('#btn_disapprove_list_id').removeAttr('disabled');
      $('#btn_approve_list_id').removeAttr('disabled');
      $('#tbl_preshipment_list_QC tr').each(function(row, tr){
			
        if(row>0){
          highlight = $(tr).hasClass('checked-ok');
          if(highlight == false){
            $(tr).addClass('checked-ng');
          }
          trArray.push(highlight);
        }
        row++;
				
			});

      if(jQuery.inArray(false, trArray) == -1){
        // console.log('enable button');
        $('#btn_approve_list_id').prop('disabled', false);
      }
      else{
        $('#btn_approve_list_id').prop('disabled', true);
      }
      

    });


    $(document).on('click', '.btn-openshipment', function(){
      let checksheetId = $(this).attr('checksheet-id');
      // console.log(checksheetId);
        GetPreshipmentList_QC(checksheetId);
        $('#btn_approve_list_id').prop('disabled', true);

        // readLoadForQC(checksheetId);

    });

    //FOR BARCODE SCANNING
    var timer = '', scannedItem = "";
    // $('input#txtForScanner').keypress( function() {
      
    //   var txtForScanning = $(this); // copy of this object for further usage
     
    //     clearTimeout(timer);
    //     timer = setTimeout(function() {
    //       scannedItem = txtForScanning.val().toUpperCase();
    //       // scannedItem = txtForScanning.val();
    //       console.log(scannedItem);
    //       var arr = scannedItem.split(',');
    //       itemVerificationQC(arr);
    //       txtForScanning.val("");
    //     }, 500);
    // });
    $('#txtScanPreshipment').keypress( function() {
      
      var txtForScanning = $(this); // copy of this object for further usage
     
        clearTimeout(timer);
        timer = setTimeout(function() {
          scannedItem = txtForScanning.val().toUpperCase();
          // // scannedItem = txtForScanning.val();
          // console.log(scannedItem);
          // var arr = scannedItem.split(', ');
          // itemVerificationQC(arr);
          var arr = scannedItem.split(',');
          // console.log(arr.length);
          if(arr.length == 7){
            itemVerificationQC(arr);
          }
          else{
            var arr = scannedItem.split(', ');

            itemVerificationQC(arr);
          }
          txtForScanning.val("");
        }, 500);
    });


    //DISAPPROVAL OF PRE-SHIPMENT
    $("#btn_disapprove_list_id").on('click', function(event){
      event.preventDefault();
      $('#modalDisapproveId').modal('show');
    });
    $('#DisapproveFormid').submit(function(event){
      event.preventDefault();
      disapprovePackingList_QC();

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
      approvePackingList_QC();
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
              let invalidModule = 'qc';
              let preshipmentId = $('#packingId').val();

              addInvalidDetails(scannedId,invalidRemarks,invalidModule,preshipmentId);
              approvePackingList_QC();

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
