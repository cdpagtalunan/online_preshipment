<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <style type="text/css">
            body{
                font-family: Arial;
                font-size: 15px;
            }

            .text-green{
                color: green;
                font-weight: bold;
            }

            /*.input[type="radio"]{
                font
            }*/
        </style>
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
                                    <label style="font-size: 18px;">Please be informed that {{ $product_line }}-WHSE accepted a preshipment</label>
                                    <br>
                                    <hr>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Preshipment Details: </b></label>
                                    </div>
                                </div>

                                <br>
                                <br>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Packing List Control No.           : </b><span class="text-black"> {{ $data->preshipment->Destination."-".$data->preshipment->Packing_List_CtrlNo }}</span></label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Date    : </b><span class="text-black"> {{ $data->preshipment->Date }}</span></label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Station  : </b><span class="text-black">{{ $data->preshipment->Station }}</span></label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Destination.     : </b><span class="text-black">{{ $data->preshipment->Destination }}</span></label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Shipment Date   : </b><span class="text-black">{{ $data->preshipment->Shipment_Date }}</span></label>
                                    </div>

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
                                </div>

                                <br>
                                <br>
                                
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


        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    </body>
</html>