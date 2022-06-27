<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    {{-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> --}}

</head>
<body>
    <div class="row">
        <div class="col-sm-12">
            <div class="row" style="margin: 1px 10px;">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <label style="font-size: 18px;">Dear Ma'am / Sir,</label><br>
                            <label style="font-size: 18px;">Good day!</label><br>
                            <label style="font-size: 18px;">Please be reminded on the pending Pre-shipments with below details;</label>
                            <br>
                            <hr>
                        </div>

                        {{-- <div class="col-sm-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label"><b>Preshipment</b></label>
                            </div>
                        </div> --}}
                        <br>
                        <br>

                        <div>
                            <table align="center" border="1" cellpadding="0" cellspacing="0" style="width:100%;">
                                <caption><strong>Pre-shipment Details</strong></caption>
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Station</th>
                                        <th>Packing List Control No</th>
                                        <th>Shipment Date</th>
                                        <th>Destination</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $data)
                                        <tr>
                                            <td></td>
                                            <td>{{ $data->Date }}</td>
                                            <td>{{ $data->Station }}</td>
                                            <td>{{ $data->Packing_List_CtrlNo }}</td>
                                            <td>{{ $data->Shipment_Date }}</td>
                                            <td>{{ $data->Destination }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
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
            </div>

        </div>
    </div>
</body>
</html>