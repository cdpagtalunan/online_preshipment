<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
Use \Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\Exportable;

// use Maatwebsite\Excel\Concerns\RegistersEventListeners;


use PhpOffice\PhpSpreadsheet\Cell\DataType;


use App\Model\RapidPreshipmentList;
use App\Model\WbsIqcMatrix;
use App\Model\SubsystemWbsCN;
use App\Model\SubsystemWbsTS;



class WbsExports implements  FromView, WithTitle, WithEvents, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    protected $date;
    protected $rapid_shipment_records;
    protected $packing_list_ctrl_num;
    protected $packingListProductLine;


    
    function __construct($date, $rapid_shipment_records,$packing_list_ctrl_num,$packingListProductLine)
    {
        $this->date = $date;
        $this->rapid_shipment_records = $rapid_shipment_records;
        $this->packing_list_ctrl_num = $packing_list_ctrl_num;
        $this->packingListProductLine = $packingListProductLine;

        
    }

    public function view(): View {
       
            return view('exports.wbs_for_load', ['date' => $this->date]);
        
	}

    public function title(): string
    {
        return 'Grinding Inventory';
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
        return [
            AfterSheet::class => function(AfterSheet $event) use ($style1,$rapid_shipment_records1,$packing_list_ctrl_num,$packingListProductLine)  {
                $colno = 2;

                for($i = 0; $i<count($rapid_shipment_records1); $i++){


                    $event->sheet->setCellValue('A'.$colno, $this->return_whse_receive_num($rapid_shipment_records1[$i]['ControlNumber'],$packingListProductLine));
                    $event->sheet->setCellValue('B'.$colno,$rapid_shipment_records1[$i]['ControlNumber']);
                    $event->sheet->setCellValueExplicit('C'.$colno, $rapid_shipment_records1[$i]['ItemCode'],DataType::TYPE_STRING);
                    $event->sheet->setCellValue('D'.$colno,$rapid_shipment_records1[$i]['TotalShipoutQty']);
                    $event->sheet->setCellValue('E'.$colno,$this->return_package_category($rapid_shipment_records1[$i]['ControlNumber'],$rapid_shipment_records1[$i]['OrderNo'],$rapid_shipment_records1[$i]['ItemCode'],$rapid_shipment_records1[$i]['LotNo']));
                    $event->sheet->setCellValue('F'.$colno,$this->return_package_qty($packing_list_ctrl_num,$rapid_shipment_records1[$i]['OrderNo'],$rapid_shipment_records1[$i]['ItemCode'],$rapid_shipment_records1[$i]['LotNo']));
                    $event->sheet->setCellValueExplicit('G'.$colno, $rapid_shipment_records1[$i]['LotNo'],DataType::TYPE_STRING);
                    $event->sheet->setCellValue('H'.$colno,'PPS');
                    $event->sheet->setCellValue('I'.$colno,$this->return_iqc_matix( $rapid_shipment_records1[$i]['ItemCode']));
                    $event->sheet->setCellValue('J'.$colno,$rapid_shipment_records1[$i]['DateIssued']);

                    






                    
                    $colno++;
                }

                
            },
         
        ];
    }

    // public function collection()
    // {
    //     return Basemold::all();
    // }

    public function return_package_category($ControlNumber, $PO,$Partscode,$LotNo){
    
        $package_category = RapidPreshipmentList::where('PONo',$PO)
        ->where('Partscode',$Partscode)
        ->where('LotNo',$LotNo)
        ->where('logdel',0)
        ->orderBy('id')
        ->offset(0)
        ->limit(1)
        ->get();

        return $package_category[0]['PackageCategory'];
    }


    public function return_package_qty($packing_list_ctrl_num, $PO,$Partscode,$LotNo){
    
        $package_qty = RapidPreshipmentList::where('fkControlNo', $packing_list_ctrl_num)
        ->where('PONo',$PO)
        ->where('Partscode',$Partscode)
        ->where('LotNo',$LotNo)
        ->where('logdel',0)
        ->sum('PackageQty');

        return $package_qty;
    }

    public function return_iqc_matix($Partscode){
        $matrix_query = WbsIqcMatrix::where('item', $Partscode)
        ->offset(0)
        ->limit(1)
        ->get();

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
            $wbs_receive_no = SubsystemWbsTS::where('invoice_no', $ControlNumber)->first();
            if($wbs_receive_no != null){
                return $wbs_receive_no->receive_no;
            }
            else{
                return "";

            }

        }
        else if($packingListProductLine == 'cn'){
            $wbs_receive_no = SubsystemWbsCN::where('invoice_no', $ControlNumber)->first();
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
