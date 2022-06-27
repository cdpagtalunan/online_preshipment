@php $layout = 'layouts.admin_layout'; @endphp


@extends($layout)


@section('content_page')
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
                                            <th>Transfer Date and Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- MH WHSE Transaction Modal -->
            <div class="modal fade" id="modalViewWhsePreshipment" data-backdrop="static" style="overflow: auto;">
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
                        
                                            {{-- <input type="hidden" class="form-control" name="device_id" id="txtDeviceId" readonly> --}}
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

            {{-- MODAL APPROVE --}}
            <div class="modal fade" id="modalWhsApprove" data-backdrop="static" style="overflow: auto;">
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
                                    <input type="hidden" name="preshipment_approval_id" id="txt_preshipment_approval_id">
                                
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
                                        {{-- <input type="text" class="form-control" name="accept_shipment_send_to" readonly id="txtAcceptShipSendTo" aria-label="Default" aria-describedby="inputGroup-sizing-default"> --}}
                                    </div>
                            </div>

                            <div class="modal-footer">
                                
                                    <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Cancel</button>
                                    <button type="submit" class="btn btn-success" id="btnWhseSendShipment">Send</button>
                                
                            </div>
                        </form>


                    </div>
                </div>
            </div>

            {{-- MODAL DISAPPROVE --}}
            <div class="modal fade" id="modalWhsDisapprove" data-backdrop="static" style="overflow: auto;">
                <div class="modal-dialog" style="margin-top: 5%;">
                    <div class="modal-content">
                        <form action="post" id="formDisapprovePreshipmentId">
                            @csrf
                            <div class="modal-header">
                                
                                <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="disPreshipmentId" name="disapprove_preshipment">

                                <h5 class="modal-title"><i class="fa fa-pencil-square"></i>Are you sure you want to disapprove?</h5><br>
                                <h6>Remarks:</h6>
                                <textarea name="pps_disapprove_remarks" id="ppsDisapproveRemarks" class="form-control" rows="5" required></textarea>
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
    </section>

</div>
<!--     {{-- JS CONTENT --}} -->
@section('js_content')

<script>
$(document).ready(function () {
    dataTableWhsePreshipment = $("#tbl_whse_preshipment").DataTable({
      "processing" : true,
      "serverSide" : true,
      "ordering"  : false,
      "ajax" : {
          url: "get_preshipment_for_whse", 
      },
      "columns":[    
          { "data" : "status"},
          { "data" : "preshipment.Date" },
          { "data" : "preshipment.Station" },
          { "data" : "preshipment.Packing_List_CtrlNo"},
          { "data" : "preshipment.Shipment_Date"},
          { "data" : "preshipment.Destination"},
          { "data" : "from_whse_noter_date_time"},
          { "data" : "action"},
          
      ],
    });

    dataTableWhsePreshipmentList = $("#tbl_whs_preshipment_list").DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
          url: "get_preshipment_list_for_whse",
          data: function (param){
            // param.preshipmentId = $("#preshipmentId").val();
            param.preshipmentCtrlId = $("#packingControlNoId").val();
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

    $(document).on('click', '.btn-whs-view', function(){
        let preshipment_id = $(this).attr('preshipment-id');
        getPreshipmentDetailsById(preshipment_id);
        // dataTableWhsePreshipmentList.draw();
    });

    $(document).on('click', '.btn-approve-whse', function(){
        let preshipmentId = $(this).attr('preshipment-id');
        getPreshipmentDetailsForApproval(preshipmentId);
    });

    $('#btnWhseSendShipment').on('click', function(event){
        event.preventDefault();
        sendPreshipmentToWhse();

    });
    $('#txtAcceptShipSendTo').on('click', function(e){
        e.preventDefault();
        return false;
    });

    $(document).on('click', '.btn-disapprove-whse', function(){
        let preshipmentId = $(this).attr('preshipment-id');
        $('#disPreshipmentId').val(preshipmentId);
    });

    $('#formDisapprovePreshipmentId').submit(function(event){
        event.preventDefault();
        disapprovePreshipment();
    });
});
</script>
@endsection

@endsection
