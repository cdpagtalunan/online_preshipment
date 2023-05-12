<?php

namespace App\Exports\Sheets;

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

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class ExportSuppPastTwoDays implements  FromView, WithTitle, WithEvents, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;
    protected $date;
    protected $preshipment_records;

    function __construct($date, $preshipment_records)
    {
        $this->date = $date;
        $this->preshipment_records = $preshipment_records;
        // $this->packing_list_ctrl_num = $packing_list_ctrl_num;
        // $this->packingListProductLine = $packingListProductLine;

        
    }

    public function view(): View {
            return view('exports.pending_twodays_supp', ['date' => $this->date]); 
	}

    public function title(): string
    {
        return 'WHSE Superior Pendings';
    }
    public function registerEvents(): array
    {
        $header_font = array(
            'font' => array(
                'name'      =>  'Lucida Fax',
                'size'      =>  16,
                'bold'      =>  true,
            )
        );
        $center = array(
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ]
        );
        $bold  = array(
            'font' => array(
                'bold'      =>  true
            )
        );

        $styleBorderAll = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $preshipment_records1 = $this->preshipment_records;
        // $packing_list_ctrl_num = $this->packing_list_ctrl_num;
        // $packingListProductLine = $this->packingListProductLine;
        return [
            AfterSheet::class => function(AfterSheet $event) use (
                $preshipment_records1,
                $header_font,
                $center,
                $bold,
                $styleBorderAll
                ){
                // $event->sheet->setCellValue('A4',count($preshipment_records1));

                $event->sheet->setCellValue('A1', 'List Of Pending Preshipments on WHSE Superior');
                $event->sheet->getDelegate()->getStyle('A1')->applyFromArray($header_font); 
                $event->sheet->getDelegate()->getStyle('A1')->applyFromArray($center); 
                $event->sheet->getDelegate()->mergeCells('A1:D1');
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(30);

                $event->sheet->setCellValue('A2', 'Preshipment Control No.');
                $event->sheet->getDelegate()->getStyle('A2')->applyFromArray($bold);
                $event->sheet->getDelegate()->getStyle('A2')->applyFromArray($center);
                $event->sheet->getDelegate()->getStyle('A2')->getFont()->setSize(12);
                $event->sheet->getDelegate()->getRowDimension(2)->setRowHeight(20);
                $event->sheet->getColumnDimension('A')->setWidth(35);
                

                $event->sheet->setCellValue('B2', 'Status');
                $event->sheet->getDelegate()->getStyle('B2')->applyFromArray($bold);
                $event->sheet->getDelegate()->getStyle('B2')->applyFromArray($center);
                $event->sheet->getDelegate()->getStyle('B2')->getFont()->setSize(12);
                $event->sheet->getColumnDimension('B')->setWidth(26);


                $event->sheet->setCellValue('C2', 'Shipment Date');
                $event->sheet->getDelegate()->getStyle('C2')->applyFromArray($bold);
                $event->sheet->getDelegate()->getStyle('C2')->applyFromArray($center);
                $event->sheet->getDelegate()->getStyle('C2')->getFont()->setSize(12);
                $event->sheet->getColumnDimension('C')->setWidth(26);


                $event->sheet->setCellValue('D2', 'Last Transaction Date');
                $event->sheet->getDelegate()->getStyle('D2')->applyFromArray($bold);
                $event->sheet->getDelegate()->getStyle('D2')->applyFromArray($center);
                $event->sheet->getDelegate()->getStyle('D2')->getFont()->setSize(12);
                $event->sheet->getColumnDimension('D')->setWidth(26);

                $row_num = 3;
                for($x = 0; $x < count($preshipment_records1); $x++){
                    $event->sheet->setCellValue('A'.$row_num, $preshipment_records1[$x]['preshipment']['Destination']."-".$preshipment_records1[$x]['preshipment']['Packing_List_CtrlNo']);
                    
                    $event->sheet->setCellValue('B'.$row_num, "For Supervisors Approval");
    
                    $shipdate = date_create($preshipment_records1[$x]['preshipment']['Shipment_Date']);

                    $shipment_date_format = date_format($shipdate, "m-d-Y");
                    $event->sheet->setCellValue('C'.$row_num, $shipment_date_format);

                    $transaction_datetime_format = date_format($preshipment_records1[$x]['updated_at'], "m-d-Y H:i");
                    $event->sheet->setCellValue('D'.$row_num,$transaction_datetime_format);
                    $event->sheet->getDelegate()->getStyle('A1:D'.$row_num)->applyFromArray($styleBorderAll);

                    $row_num++;
                }


            },
         
        ];
    }
}
