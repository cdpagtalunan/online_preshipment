<?php

namespace App\Exports;

use App\Model\WbsIqcMatrix;
use App\Model\SubsystemWbsCN;
use App\Model\SubsystemWbsTS;
use Illuminate\Support\Facades\DB;
use App\Model\RapidPreshipmentList;
use Illuminate\Contracts\View\View;
Use \Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;

// use Maatwebsite\Excel\Concerns\RegistersEventListeners;


use Maatwebsite\Excel\Concerns\WithEvents;


use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;



class WbsExports_newformat implements  FromView, WithTitle, WithEvents, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    protected $date;
    protected $rapid_shipment_records;
    protected $packing_list_ctrl_num;
    protected $packingListProductLine;
    // protected $test_array;


    
    function __construct($date, $rapid_shipment_records,$packing_list_ctrl_num,$packingListProductLine)
    {
        $this->date = $date;
        $this->rapid_shipment_records = $rapid_shipment_records;
        $this->packing_list_ctrl_num = $packing_list_ctrl_num;
        $this->packingListProductLine = $packingListProductLine;
        // $this->test_array = $test_array;

        
    }

    public function view(): View {
       
            return view('exports.wbs_for_load', ['date' => $this->date]);
        
	}

    public function title(): string
    {
        return 'preshipment';
    }

    //for designs
    public function registerEvents(): array
    {
        
        $style1 = array(
            'font' => array(
                'name'      =>  'Arial',
                'size'      =>  12,
                // 'color'      =>  'red',
                'italic'      =>  true
            )
        );

        $rapid_shipment_records1 = $this->rapid_shipment_records;
        $packing_list_ctrl_num = $this->packing_list_ctrl_num;
        $packingListProductLine = $this->packingListProductLine;
        // $test_array = $this->test_array;
        return [
            AfterSheet::class => function(AfterSheet $event) use ($style1,$rapid_shipment_records1,$packing_list_ctrl_num,$packingListProductLine)  {
                $colno = 2;
                // NEW CODE
                // for ($i=0; $i < count($rapid_shipment_records1); $i++) { 
                //     $counter = 1;
                //     $over = $test_array[ $rapid_shipment_records1[$i]['LotNo']."_".$rapid_shipment_records1[$i]['ItemCode']."_counter" ];
                //     for($j=0; $j < count($test_array[$rapid_shipment_records1[$i]['LotNo']."_".$rapid_shipment_records1[$i]['ItemCode']]); $j++){
                //         // dd($test_array[$rapid_shipment_records1[$i]['LotNo']][$j]);
                //         $record = $rapid_shipment_records1[$i]['LotNo']."_".$rapid_shipment_records1[$i]['ItemCode'];

                //         $package_qty = $this->return_package_qty($packing_list_ctrl_num,$test_array[$record][$j]['OrderNo'],$test_array[$record][$j]['ItemCode'],$test_array[$record][$j]['LotNo'],$test_array[$record][$j]['ShipoutQty']);
                //         $exploded_pckage_qty = preg_split('/(-|~)/', $package_qty);

                //         if(count($exploded_pckage_qty) > 1){
                //             $package_qty_for_multiple = intval($exploded_pckage_qty[1]);
                //             $quotient_of_shipout_qty = $test_array[$record][$j]['ShipoutQty'] / $package_qty_for_multiple;
                //             for($x = 1; $x <= $package_qty_for_multiple; $x++){
                //                 // $event->sheet->setCellValueExplicit('G'.$colno, $test_array[$record][$j]['LotNo']." ".$counter."/".$over,DataType::TYPE_STRING);
                //                 // $colno++;
                //                 // $counter++;

                //                 $event->sheet->setCellValue('A'.$colno, $this->return_whse_receive_num($test_array[$record][$j]['ControlNumber'],$packingListProductLine));
                //                 $event->sheet->setCellValue('B'.$colno,$test_array[$record][$j]['ControlNumber']);
                //                 $event->sheet->setCellValueExplicit('C'.$colno, $test_array[$record][$j]['ItemCode'],DataType::TYPE_STRING);
                //                 // $event->sheet->setCellValue('D'.$colno,$test_array[$record][$j]['TotalShipoutQty']);
                //                 $event->sheet->setCellValue('D'.$colno,$quotient_of_shipout_qty);
                //                 $event->sheet->setCellValue('E'.$colno,$this->return_package_category($test_array[$record][$j]['ControlNumber'],$test_array[$record][$j]['OrderNo'],$test_array[$record][$j]['ItemCode'],$test_array[$record][$j]['LotNo'], $test_array[$record][$j]['ShipoutQty']));
                //                 // $event->sheet->setCellValue('F'.$colno,$this->return_package_qty($packing_list_ctrl_num,$test_array[$record][$j]['OrderNo'],$test_array[$record][$j]['ItemCode'],$test_array[$record][$j]['LotNo']));
                //                 $event->sheet->setCellValue('F'.$colno, 1);
                //                 $event->sheet->setCellValueExplicit('G'.$colno, $test_array[$record][$j]['LotNo']." ".$counter."/".$over,DataType::TYPE_STRING);
                //                 // $event->sheet->setCellValueExplicit('G'.$colno, $test_array[$record][$j]['LotNo'],DataType::TYPE_STRING);
                //                 $event->sheet->setCellValue('H'.$colno,'PPS');
                //                 $event->sheet->setCellValue('I'.$colno,$this->return_iqc_matix( $test_array[$record][$j]['ItemCode']));
                //                 $event->sheet->setCellValue('J'.$colno,$test_array[$record][$j]['DateIssued']);

                //                 $colno++;
                //                 $counter++;

                //             }
                //         }
                //         else{
                //             // $event->sheet->setCellValueExplicit('G'.$colno, $test_array[$record][$j]['LotNo']." ".$counter."/".$over,DataType::TYPE_STRING);
                //             // $colno++;
                //             // $counter++;
                //             $event->sheet->setCellValue('A'.$colno, $this->return_whse_receive_num($test_array[$record][$j]['ControlNumber'],$packingListProductLine));
                //             $event->sheet->setCellValue('B'.$colno,$test_array[$record][$j]['ControlNumber']);
                //             $event->sheet->setCellValueExplicit('C'.$colno, $test_array[$record][$j]['ItemCode'],DataType::TYPE_STRING);
                //             // $event->sheet->setCellValue('D'.$colno,$test_array[$record][$j]['TotalShipoutQty']);
                //             $event->sheet->setCellValue('D'.$colno,$test_array[$record][$j]['ShipoutQty']);
                //             $event->sheet->setCellValue('E'.$colno,$this->return_package_category($test_array[$record][$j]['ControlNumber'],$test_array[$record][$j]['OrderNo'],$test_array[$record][$j]['ItemCode'],$test_array[$record][$j]['LotNo'],$test_array[$record][$j]['ShipoutQty']));
                //             // $event->sheet->setCellValue('F'.$colno,$this->return_package_qty($packing_list_ctrl_num,$test_array[$record][$j]['OrderNo'],$test_array[$record][$j]['ItemCode'],$test_array[$record][$j]['LotNo']));
                //             $event->sheet->setCellValue('F'.$colno, 1);
                //             $event->sheet->setCellValueExplicit('G'.$colno, $test_array[$record][$j]['LotNo']." ".$counter."/".$over,DataType::TYPE_STRING);

                //             $event->sheet->setCellValue('H'.$colno,'PPS');
                //             $event->sheet->setCellValue('I'.$colno,$this->return_iqc_matix( $test_array[$record][$j]['ItemCode']));
                //             $event->sheet->setCellValue('J'.$colno,$test_array[$record][$j]['DateIssued']);
                //             $colno++;
                //             $counter++;
                //         }
                //     }
                // }

                // dd($rapid_shipment_records1[0]);

                for($i = 0; $i<count($rapid_shipment_records1); $i++){

                    $package_qty = $this->return_package_qty($packing_list_ctrl_num,$rapid_shipment_records1[$i]->OrderNo,$rapid_shipment_records1[$i]->ItemCode,$rapid_shipment_records1[$i]->LotNo,$rapid_shipment_records1[$i]->ShipoutQty);
                    // $exploded_pckage_qty = explode('~', $package_qty);

                    $exploded_pckage_qty = preg_split('/(-|~)/', $package_qty);

                    // $event->sheet->setCellValue('L'.$colno, $package_qty);
                    if(count($exploded_pckage_qty) > 1){
                        $package_qty_for_multiple = intval($exploded_pckage_qty[1]);
                        $quotient_of_shipout_qty = $rapid_shipment_records1[$i]->ShipoutQty / $package_qty_for_multiple;

                        
                        for($x = 1; $x <= $package_qty_for_multiple; $x++){
                            $count = $x . "/" . $package_qty_for_multiple;
                            // $event->sheet->setCellValue('k'.$colno, gettype($package_qty_for_multiple));
                            $event->sheet->setCellValue('A'.$colno, $this->return_whse_receive_num($rapid_shipment_records1[$i]->ControlNumber,$packingListProductLine));
                            $event->sheet->setCellValue('B'.$colno,$rapid_shipment_records1[$i]->ControlNumber);
                            $event->sheet->setCellValueExplicit('C'.$colno, $rapid_shipment_records1[$i]->ItemCode,DataType::TYPE_STRING);
                            // $event->sheet->setCellValue('D'.$colno,$rapid_shipment_records1[$i]['TotalShipoutQty']);
                            $event->sheet->setCellValue('D'.$colno,$quotient_of_shipout_qty);
                            $event->sheet->setCellValue('E'.$colno,$this->return_package_category($rapid_shipment_records1[$i]->ControlNumber,$rapid_shipment_records1[$i]->OrderNo,$rapid_shipment_records1[$i]->ItemCode,$rapid_shipment_records1[$i]->LotNo, $rapid_shipment_records1[$i]->ShipoutQty));
                            // $event->sheet->setCellValue('F'.$colno,$this->return_package_qty($packing_list_ctrl_num,$rapid_shipment_records1[$i]['OrderNo'],$rapid_shipment_records1[$i]['ItemCode'],$rapid_shipment_records1[$i]['LotNo']));
                            $event->sheet->setCellValue('F'.$colno, 1);
                            // $event->sheet->setCellValueExplicit('G'.$colno, $rapid_shipment_records1[$i]['LotNo']." ".$count,DataType::TYPE_STRING);
                            $event->sheet->setCellValueExplicit('G'.$colno, $rapid_shipment_records1[$i]->LotNo,DataType::TYPE_STRING);
                            $event->sheet->setCellValue('H'.$colno,'PPS');
                            $event->sheet->setCellValue('I'.$colno,$this->return_iqc_matix( $rapid_shipment_records1[$i]->ItemCode));
                            $event->sheet->setCellValue('J'.$colno,$rapid_shipment_records1[$i]->DateIssued);

                            $colno++;
                        }

                        
                    }
                    else{
                    // dd($rapid_shipment_records1[$i]['ItemCode']);

                        $event->sheet->setCellValue('A'.$colno, $this->return_whse_receive_num($rapid_shipment_records1[$i]->ControlNumber,$packingListProductLine));
                        $event->sheet->setCellValue('B'.$colno,$rapid_shipment_records1[$i]->ControlNumber);
                        $event->sheet->setCellValueExplicit('C'.$colno, $rapid_shipment_records1[$i]->ItemCode,DataType::TYPE_STRING);
                        // $event->sheet->setCellValue('D'.$colno,$rapid_shipment_records1[$i]->TotalShipoutQty);
                        $event->sheet->setCellValue('D'.$colno,$rapid_shipment_records1[$i]->ShipoutQty);
                        $event->sheet->setCellValue('E'.$colno,$this->return_package_category($rapid_shipment_records1[$i]->ControlNumber,$rapid_shipment_records1[$i]->OrderNo,$rapid_shipment_records1[$i]->ItemCode,$rapid_shipment_records1[$i]->LotNo,$rapid_shipment_records1[$i]->ShipoutQty));
                        // $event->sheet->setCellValue('F'.$colno,$this->return_package_qty($packing_list_ctrl_num,$rapid_shipment_records1[$i]->OrderNo,$rapid_shipment_records1[$i]->ItemCode,$rapid_shipment_records1[$i]->LotNo));
                        $event->sheet->setCellValue('F'.$colno, 1);
                        $event->sheet->setCellValueExplicit('G'.$colno, $rapid_shipment_records1[$i]->LotNo,DataType::TYPE_STRING);
                        $event->sheet->setCellValue('H'.$colno,'PPS');
                        $event->sheet->setCellValue('I'.$colno,$this->return_iqc_matix( $rapid_shipment_records1[$i]->ItemCode));
                        $event->sheet->setCellValue('J'.$colno,$rapid_shipment_records1[$i]->DateIssued);
                        
                        $colno++;
                    }
                    
                }
                
                
            },
         
        ];
    }
    public function return_package_category($ControlNumber, $PO,$Partscode,$LotNo, $qty){
    
        $package_category = DB::connection('mysql_rapid')
        ->table('tbl_PreShipmentTransaction')
        ->select('*')
        ->where('PONo',$PO)
        ->where('Partscode',$Partscode)
        ->where('LotNo',$LotNo)
        ->where('logdel',0)
        ->where('Qty',$qty)
        ->orderBy('id')
        ->offset(0)
        ->limit(1)
        ->get();


        // $package_category = RapidPreshipmentList::where('PONo',$PO)
        // ->where('Partscode',$Partscode)
        // ->where('LotNo',$LotNo)
        // ->where('logdel',0)
        // ->where('Qty',$qty)
        // ->orderBy('id')
        // ->offset(0)
        // ->limit(1)
        // ->get();

        // return $package_category[0]['PackageCategory'];
        return $package_category[0]->PackageCategory;
        // return $package_category;
    }


    public function return_package_qty($packing_list_ctrl_num, $PO,$Partscode,$LotNo,$ship_qty){
    
        $package_qty = DB::connection('mysql_rapid')
        ->table('tbl_PreShipmentTransaction')
        ->where('fkControlNo', $packing_list_ctrl_num)
        ->where('PONo',$PO)
        ->where('Partscode',$Partscode)
        ->where('LotNo',$LotNo)
        ->where('Qty',$ship_qty)
        ->where('logdel',0)
        ->select('PackageQty')
        ->first();

        
        // $package_qty = RapidPreshipmentList::where('fkControlNo', $packing_list_ctrl_num)
        // ->where('PONo',$PO)
        // ->where('Partscode',$Partscode)
        // ->where('LotNo',$LotNo)
        // ->where('Qty',$ship_qty)
        // ->where('logdel',0)
        // // ->sum('PackageQty');
        // ->first('PackageQty');

        // return $package_qty;
        return $package_qty->PackageQty;
    }

    public function return_iqc_matix($Partscode){

//         tbl_iqc_matrix
// mysql_subsystem_pmi_ts
        $matrix_query = DB::connection('mysql_subsystem_pmi_ts')
        ->table('tbl_iqc_matrix')
        ->select('*')
        ->where('item', $Partscode)
        ->offset(0)
        ->limit(1)
        ->get();

        // $matrix_query = WbsIqcMatrix::where('item', $Partscode)
        // ->offset(0)
        // ->limit(1)
        // ->get();

        if(count($matrix_query) == 1){
            return '0';
        }
        else{
            return '1';

        }

        // return $matrix_query;

    }

    public function return_whse_receive_num($ControlNumber,$packingListProductLine){

        if($packingListProductLine == 'ts'){
            // $wbs_receive_no = SubsystemWbsTS::where('invoice_no', $ControlNumber)->first();
            $wbs_receive_no = DB::connection('mysql_subsystem_wbs_ts')
            ->table('tbl_wbs_material_receiving')
            ->where('invoice_no', $ControlNumber)
            ->select('*')
            ->first();


            if($wbs_receive_no != null){
                return $wbs_receive_no->receive_no;
            }
            else{
                return "";

            }

        }
        else if($packingListProductLine == 'cn'){
            // $wbs_receive_no = SubsystemWbsCN::where('invoice_no', $ControlNumber)->first();
            
            $wbs_receive_no = DB::connection('mysql_subsystem_wbs_cn')
            ->table('tbl_wbs_material_receiving')
            ->where('invoice_no', $ControlNumber)
            ->select('*')
            ->first();
            if($wbs_receive_no != null){
                return $wbs_receive_no->receive_no;
            }
            else{
                return "";

            }

        }
        else{
            return "";
        }
    }
    

 
}
