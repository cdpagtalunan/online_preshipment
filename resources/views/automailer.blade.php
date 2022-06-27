<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>Document</title> --}}
  @include('shared.css_links.css_links')

</head>
<body>
    <div class="container-fluid">
        {{-- <input type="text" name="" id="clock"> --}}
        <div style="margin-top: 8%;">
            <h4 class="text-center">Online Pre-Shipment Mailer</h4>

            <hr class="my-4 ">

            <h1 class="display-2 text-center">DO NOT CLOSE</h1>
            
            <hr class="my-4 ">
            
            <p class="text-center">Auto Mail Notification</p>
            <p class="text-center" id="time"></p>
    
        </div>
      </div>
</body>
@include('shared.js_links.js_links')
<script>
    $(document).ready(function(){
        setInterval(myTimer, 1000);
            sendEmailForPendingShipment();
        
        function myTimer() {
            const d = new Date();
            var current_time = d.toLocaleString("en-US", {
                    timeZone: 'Asia/Manila',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
            });
            $("#time").html(current_time);
            // if(current_time == "08:30:00 AM"){
            //     sendEmailForPendingShipment();
            // }
            // sendEmailForPendingShipment();
        }

        function sendEmailForPendingShipment(){
            $.ajax({
                url: "automail_pending_preshipment",
                method: "get",
                // data: $('#formApproveWhse').serialize(),
                dataType: "json",
                success : function(){

                }
            })
        }
    });
</script>
</html>