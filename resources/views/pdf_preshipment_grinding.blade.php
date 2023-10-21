<html>
    <head>
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> --}}
        {{-- <script src="{{ asset('public/template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
        <style>
            #boderan {
                border-collapse: collapse;
            }
            #boderan th, #boderan td {
                border: 1px solid black;
                border-collapse: collapse;
                /* color: red; */
            }
        </style>
    </head>
    <body>
        <center><h3>PRE-SHIPMENT LIST FOR INTERNAL SHIPMENT</h3></center>

        <div>
            <div style="width: 85%;" align="right">
                {{ $preshipment->wbs_receiving_number }}
            </div>
            <div style="width: 85%;" align="right">
                {{ $preshipment->rapid_shipment_invoice_details->ControlNumber }}
            </div>
        </div>

        <table style="width: 100%; font-size: 12px;">
            <tr>
                <td style="width: 11%;">DATE:</td>
                <td style="width: 18%;">{{ $preshipment->Date  }}</td>
                <td></td>
            </tr>
            <tr>
                <td>STATION:</td>
                <td style="border-bottom: 1px solid black; border-top: 1px solid black;">{{ $preshipment->Station }}</td>

                <td></td>

                <td style="width: 18%;">PACKING LIST CONTROL NO.:</td>
                <td style="width: 18%;">{{ $preshipment->Destination }}-{{ $preshipment->Packing_List_CtrlNo }}</td>

                <td></td>
            </tr>
            <tr>
                <td>SHIPMENT DATE:</td>
                <td style="border-bottom: 1px solid black;">{{ $preshipment->Shipment_Date }}</td>

                <td></td>

                <td>DESTINATION:</td>
                <td style="border-bottom: 1px solid black; border-top: 1px solid black;">{{ $preshipment->Destination }}</td>

                <td></td>

            </tr>
        </table>
        <table style="width: 100%; font-size: 11px; margin-top: 5px;" class="boderan" id="boderan">
            <thead >
                <tr>
                    <th rowspan="2" style="width: 3%;">MASTER CARTON NO.</th>
                    <th rowspan="2" style="width: 3%;">ITEM NO.</th>
                    <th rowspan="2">P.O NO.</th>
                    <th rowspan="2">PARTS CODE</th>
                    <th rowspan="2" style="width: 9%;">DEVICE NAME</th>
                    <th rowspan="2" style="width: 7%;">LOT NO.</th>
                    <th rowspan="2" style="width: 3%;">QTY</th>
                    <th rowspan="2">PACKAGE CATEGORY</th>
                    <th rowspan="2" style="width: 2%;">PACKAGE QTY</th>
                    <th rowspan="2">WEIGHED BY</th>
                    <th rowspan="2">PACKED BY</th>
                    <th rowspan="2">CHECKED BY</th>
                    <th colspan="3">QC PACKING INSPECTION</th>
                    {{-- <th>MASTER CARTON NO.</th> --}}
                    {{-- <th>MASTER CARTON NO.</th> --}}
                </tr>
                <tr>
                    <th style="text-align: center;">RESULT</th>
                    <th style="text-align: center;">QC NAME</th>
                    <th style="text-align: center;">REMARKS</th>
                </tr>
            </thead>
            <tbody>
            
                <?php
                    $sum = 0;
                    for($x = 0; $x < count($preshipment_list); $x++){
                        $count = $x + 1;
                        echo "<tr>";
                            echo "<td>".$preshipment_list[$x]['Master_CartonNo']."</td>";
                            echo "<td>".$count."</td>";
                            echo "<td>".$preshipment_list[$x]['PONo']."</td>";
                            echo "<td>".$preshipment_list[$x]['Partscode']."</td>";
                            echo "<td>".$preshipment_list[$x]['DeviceName']."</td>";
                            echo "<td>".$preshipment_list[$x]['LotNo']."</td>";
                            echo "<td>".$preshipment_list[$x]['Qty']."</td>";
                            echo "<td>".$preshipment_list[$x]['PackageCategory']."</td>";
                            echo "<td>".$preshipment_list[$x]['PackageQty']."</td>";
                            echo "<td>".$preshipment_list[$x]['WeighedBy']."</td>";
                            echo "<td>".$preshipment_list[$x]['PackedBy']."</td>";
                            // if($preshipment->checked_by_details != null){
                            //     echo "<td>".$preshipment->checked_by_details->rapidx_user_details->name."</td>";
                            // }
                            if($preshipment->checked_by_details_from_rapidx_user != null){
                                echo "<td>".$preshipment->checked_by_details_from_rapidx_user->name."</td>";
                            }
                            else{
                                echo "<td></td>";
                            }
                            // echo "<td>".$preshipment_list[$x]['CheckedBy']."</td>";
                            echo "<td>OK</td>";
                            // echo "<td>".$preshipment->qc_approver_details->rapidx_user_details->name."</td>";
                            echo "<td></td>";
                            echo "<td>".$preshipment_list[$x]['Remarks']."</td>";
                        echo "</tr>";

                        $sum = $sum + $preshipment_list[$x]['Qty'];
                    }
                ?>
                {{-- <tr></tr> --}}
                
            </tbody>
        </table>
        <table style="width: 100%; font-size: 12px;">
         

            <tr>
                <td style="width: 14%"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="width: 7%;">TOTAL QTY</td>
                <td style="width: 3%;">{{ $sum }}</td>
                <td style="width: 12%"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="3">PPS WAREHOUSE</td>
                <td colspan="4">TS/CN/YF WAREHOUSE</td>
                {{-- <td></td>
                <td></td> --}}
                <td colspan="2" align="center">DATE</td>
                {{-- <td></td> --}}
                <td align="center">TIME</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2">CHECKED BY:</td>
                <td style="width: 15%; border-bottom: 1px solid black;"> 
                    <?php
                        // $date_receive = "";
                        // $date_format_receive = "";
                        // $time_format_receive = "";
                        // if ($preshipment->from_user_details != null) {
                        //     $date_receive=date_create($preshipment->to_whse_noter_date_time);
                        //     $date_format_receive = date_format($date_receive, "m-d-Y");
                        //     $time_format_receive = date_format($date_receive, "H:i");

                        //     echo  $preshipment->from_user_details->rapidx_user_details->name;
                        // }
                    ?>
                </td>
                <td colspan="2" style="width: 10%;">RECEIVED BY:</td>
                {{-- <td colspan="2" style="width: 15%; border-bottom: 1px solid black;">  --}}
                    <?php
                        // if ($preshipment->to_whse_noter_details != null) {
                            // echo $preshipment->to_whse_noter_details->rapidx_user_details->name;
                        // }
                    ?>

                    @if ($preshipment->to_whse_noter_details != null)
                        {{-- <td colspan="2" style="width: 15%; border-bottom: 1px solid black;"> {{ $preshipment->to_whse_noter_details->rapidx_user_details->name }} </td> --}}
                        <td colspan="2" style="width: 15%; border-bottom: 1px solid black;"> </td>
                        <td colspan="2" style="width: 9%; border-bottom: 1px solid black;">{{ $date_format_receive }}</td>
                        <td  style="border-bottom: 1px solid black;">{{ $time_format_receive }}</td>
                    {{-- @endif --}}
                    @else
                        <td colspan="2" style="width: 15%; border-bottom: 1px solid black;"></td>
                        <td colspan="2" style="width: 9%; border-bottom: 1px solid black;"></td>
                        <td  style="border-bottom: 1px solid black;"></td>
                    @endif
                {{-- </td> --}}
                {{-- <td colspan="2" style="width: 9%; border-bottom: 1px solid black;">{{ $date_format_receive }}</td> --}}
                {{-- <td  style="border-bottom: 1px solid black;">{{ $time_format_receive }}</td> --}}
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2">UPLOADED BY:</td>
                
                    <?php
                        $date_upload = "";
                        $date_format_upload ="";
                        $time_format_upload ="";
                        
                        $internal_invoice_check = array("TS","CN"); 

                        $PO = $preshipment_list[0]['PONo'][0].$preshipment_list[0]['PONo'][1];
                        if(in_array($PO,$internal_invoice_check)){
                            echo '<td colspan="2" style="border-bottom: 1px solid black;">N/A</td>';
                            echo '<td colspan="2" style="border-bottom: 1px solid black;">N/A</td>';
                            echo '<td style="border-bottom: 1px solid black;">N/A</td>';
                        }
                        else if ($preshipment->whse_uploader_details != null) {
                            $date_upload=date_create($preshipment->whse_uploader_date_time);
                            $date_format_upload = date_format($date_upload, "m-d-Y");
                            $time_format_upload = date_format($date_upload, "H:i");
                            echo '<td colspan="2" style="border-bottom: 1px solid black;">'
                                .$preshipment->whse_uploader_details->rapidx_user_details->name.
                                '</td>';
                            echo '<td colspan="2" style="border-bottom: 1px solid black;">'
                                .$date_format_upload.'</td>';
                            echo '<td  style="border-bottom: 1px solid black;">'
                                .$time_format_upload. '</td>';
                        }
                        else{
                            echo '<td colspan="2" style="border-bottom: 1px solid black;"></td>';
                            echo '<td colspan="2" style="border-bottom: 1px solid black;"></td>';
                            echo '<td  style="border-bottom: 1px solid black;"></td>';
                        }
                    ?>
                
                
                
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2">CHECKED BY:</td>
                <td colspan="2" style="border-bottom: 1px solid black;"> 
                    <?php
                        // $date_superior = "";
                        // $date_format_superior = "";
                        // $time_format_superior = "";
                        // if ($preshipment->whse_superior_details != null) {
                        //     $date_superior=date_create($preshipment->whse_superior_noter_date_time);
                        //     $date_format_superior = date_format($date_superior, "m-d-Y");
                        //     $time_format_superior = date_format($date_superior, "H:i");

                        //     echo $preshipment->whse_superior_details->rapidx_user_details->name;
                        // }    
                    ?>
                </td>
                <td colspan="2" style="border-bottom: 1px solid black;"></td>
                <td style="border-bottom: 1px solid black;"></td>
            </tr>
        </table>


       
    </body>
</html>