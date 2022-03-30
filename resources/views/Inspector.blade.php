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
                        {{-- <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top:-13px;">
                          
                                <li class="nav-item">
                                <a class="nav-link active" id="reminder-tab" data-toggle="tab" href="#reminder" role="tab" aria-controls="reminder" aria-selected="true">Unpaid Billing/License Tab</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="reminder-archive-tab" data-toggle="tab" href="#reminderArchive" role="tab" aria-controls="archive" aria-selected="false">Paid Tab</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="workloads-person-tab" data-toggle="tab" href="#workloadsPerson" role="tab" aria-controls="person" aria-selected="false">Person in Charge Tab</a>
                                </li>
                               
                        
                          
                            
                        </ul> --}}
                    
                        <div class="tab-content test" id="myTabContent" >
                            <div class="tab-pane fade show active" id="reminder" role="tabpanel" aria-labelledby="reminder-tab">
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
                        </div>
                      </div>                    
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <form method="post" id="form_packing_list">
                      @csrf
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
                        <div style="float: right">
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
          <div class="modal-body">
            <h5>Remarks:</h5>
            <textarea name="" id="" cols="50" rows="5" class="form-control"  style="resize: none;" required></textarea>
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
            <button type="submit" class="btn btn-success">Yes</button>
          </div>
        </form>
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
      "ajax" : {
          url: "get_Preshipment_QC", 
      },
      "columns":[    
          { "data" : "id"},
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
      "ajax" : {
          url: "get_Preshipment_list_QC",
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
          
      ],
    }); 

      
    //SCRIPT TO SHOW QR FOR PRESHIPMENT TO START THE SCANNING PROCESS
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

    //WHEN CLOSED TR THAT DONT HAVE A GREEN HIGHLIGHT WILL BE RED
    $('#btnDoneScan').on('click', function(){

      let test = [];

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


    $(document).on('click', '.btn-openshipment', function(){
        let checksheetId = $(this).attr('checksheet-id');
        GetPreshipmentList_QC(checksheetId);
        $('#btn_approve_list_id').prop('disabled', true);

    });

    //FOR BARCODE SCANNING
    var timer = '', scannedItem = "";
    $('input#txtForScanner').keypress( function() {
      
      var txtForScanning = $(this); // copy of this object for further usage
     
        clearTimeout(timer);
        timer = setTimeout(function() {
          scannedItem = txtForScanning.val();
          var arr = scannedItem.split(',');
          itemVerificationQC(arr);
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
      $('#modalapproveId').modal('show');
    });
    $('#approveFormid').submit(function(event){
      event.preventDefault();
      approvePackingList_QC();
    });

 






  });

</script>

@endsection

@endsection
