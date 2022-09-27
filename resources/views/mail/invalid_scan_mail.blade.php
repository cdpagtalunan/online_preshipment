@php
    if($invalid_from == 'MH'){
        $module_name = "Material Handler";
    }
    else if($invalid_from == "QC"){
        $module_name = "Inspector";
    }
    else if($invalid_from == "ts"){
        $module_name = "TS Warehouse Receiving";
    }
    else if($invalid_from == "cn"){
        $module_name = "CN Warehouse Receiving";
    }
@endphp
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
    </head>
<body>
    <div class="row">
        <div class="col-sm-12">
            <div class="row" style="margin: 1px 10px;">
                <div class="col-sm-12">
                    <form id="frmSaveRecord">
                        <div class="row">
                            <div class="col-sm-12">
                                <label style="font-size: 18px;">Good day!</label><br>
                                <label style="font-size: 18px;">Please be informed that <strong>Invalid</strong> scanning has been detected on {{ $module_name }} Module</label>
                                <br>
                                <br>
                                <hr>
                            </div>

                            {{-- <div class="col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><b>Preshipment Details: </b></label>
                                </div>
                            </div> --}}

                            <br>
                            <br>
                            {{-- <div class="col-sm-12"> --}}
                                {{-- <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><b>Packing List Control No.           : </b><span class="text-black"> {{$data->Destination."-".$data->Packing_List_CtrlNo }}</span></label>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><b>Date    : </b><span class="text-black"> {{ $data->Date }}</span></label>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><b>Station  : </b><span class="text-black">{{ $data->Station }}</span></label>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><b>Destination.     : </b><span class="text-black">{{ $data->Destination }}</span></label>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><b>Shipment Date   : </b><span class="text-black">{{ $data->Shipment_Date }}</span></label>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><b>Remarks   : </b><span class="text-black">{{ $remarks }}</span></label> --}}
                                {{-- </div> --}}

                                {{-- <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><b>DEPARTMENT       : </b><span class="text-black"> </span></label>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><b>POSITION         : </b><span class="text-black"></span></label>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><b>AMOUNT           : </b><span class="text-black"> </span></label>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><b>AMOUNT IN WORD   : </b><span class="text-black"> </span></label>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><b>PURPOSE          : </b><span class="text-black"> </span></label>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><b>REQUESTED BY     : </b><span class="text-black"></span></label>
                                </div> --}}
                            {{-- </div> --}}

                            {{-- <br> --}}
                            {{-- <br> --}}
                            
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">For more info, please log-in to your Rapidx account. Go to http://rapidx/ and Online Pre-shipment </label>
                                </div>
                            </div>

                            <br>
                            <br>

                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label"><b> Notice of Disclaimer: </b></label>
                                    <br>
                                    <label class="col-sm-12 col-form-label"></label>   This message contains confidential information intended for a specific individual and purpose. If you are not the intended recipient, you should delete this message. Any disclosure,copying, or distribution of this message, or the taking of any action based on it, is strictly prohibited.</label>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <br><br>
                                <label style="font-size: 18px;"><b>For concerns on using the form, please contact ISS at local numbers 205, 206, or 208. You may send us e-mail at <a href="mailto: servicerequest@pricon.ph">servicerequest@pricon.ph</a></b></label>
                            </div>
                        </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</body>
</html>