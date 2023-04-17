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

use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

use PHPExcel_Worksheet_PageSetup;


// use Maatwebsite\Excel\Concerns\RegistersEventListeners;


use PhpOffice\PhpSpreadsheet\Cell\DataType;



class PreshipmentExport implements  FromView, WithTitle, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    protected $date;
    protected $get_preshipment;
    protected $get_rapid_preshipment_list;



    function __construct($date, $get_preshipment,$get_rapid_preshipment_list)
    {
        $this->date = $date;
        $this->get_preshipment = $get_preshipment;
        $this->get_rapid_preshipment_list = $get_rapid_preshipment_list;


    }

    public function view(): View {

            return view('exports.preshipment', ['date' => $this->date, 'preshipment' => $this->get_preshipment, 'preshipment_list' => $this->get_rapid_preshipment_list]);

	}

    public function title(): string
    {
        return 'preshipment';
    }

    //for designs
    public function registerEvents(): array
    {


        $preshipment = $this->get_preshipment;
        $preshipment_list = $this->get_rapid_preshipment_list;

        $center_bottom = array(
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_BOTTOM,
            ]
        );

        $header_font = array(
            'font' => array(
                'name'      =>  'Lucida Fax',
                'size'      =>  16,
                'bold'      =>  true,
            )
        );

        $bold  = array(
            'font' => array(
                'bold'      =>  true
            )
        );

        $underline  = array(
            'font' => array(
                'underline'      =>  true
            )
        );

        $styleBorderBottomThin= [
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $styleBorderOutside = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000']

                ],
            ]
        ];
        $styleBorderAll = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        return [

            AfterSheet::class => function(AfterSheet $event) use ($preshipment,$preshipment_list,$center_bottom, $bold,$styleBorderBottomThin,$styleBorderOutside,$styleBorderAll,$underline,$header_font)  {
                $event->sheet->getPageSetup()->setFitToPage(true);
                $event->sheet ->setShowGridlines(false);
                $event->sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

                $event->sheet->getDelegate()->getStyle('A1')->applyFromArray($header_font);
                $event->sheet->getDelegate()->getStyle('A1')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(22);

                // $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(16);


                $event->sheet->getDelegate()->getStyle('A8:L9')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('A8:Q9')->applyFromArray($center_bottom);
                $event->sheet->getDelegate()->getStyle('A8:Q9')->applyFromArray($bold);
                $event->sheet->getDelegate()->getStyle('A8:Q9')->getFont()->setSize(10);
                $event->sheet->getDelegate()->mergeCells('A8:A9');
                $event->sheet->getDelegate()->mergeCells('B8:B9');
                $event->sheet->getDelegate()->mergeCells('C8:C9');
                $event->sheet->getDelegate()->mergeCells('D8:D9');
                $event->sheet->getDelegate()->mergeCells('E8:E9');
                $event->sheet->getDelegate()->mergeCells('F8:F9');
                $event->sheet->getDelegate()->mergeCells('G8:G9');
                $event->sheet->getDelegate()->mergeCells('H8:H9');
                $event->sheet->getDelegate()->mergeCells('I8:I9');
                $event->sheet->getDelegate()->mergeCells('J8:J9');
                $event->sheet->getDelegate()->mergeCells('K8:K9');
                $event->sheet->getDelegate()->mergeCells('L8:L9');



                $event->sheet->getColumnDimension('A')->setWidth(8.1);
                $event->sheet->getColumnDimension('B')->setWidth(7.5);
                $event->sheet->getColumnDimension('C')->setWidth(22);
                $event->sheet->getColumnDimension('D')->setWidth(15);
                $event->sheet->getColumnDimension('E')->setWidth(37);
                $event->sheet->getColumnDimension('F')->setWidth(25.1);
                $event->sheet->getColumnDimension('G')->setWidth(11);
                $event->sheet->getColumnDimension('H')->setWidth(11.5);
                $event->sheet->getColumnDimension('I')->setWidth(11);
                $event->sheet->getColumnDimension('J')->setWidth(9);
                $event->sheet->getColumnDimension('K')->setWidth(9);
                $event->sheet->getColumnDimension('L')->setWidth(13.6);
                $event->sheet->getColumnDimension('M')->setWidth(2);
                $event->sheet->getColumnDimension('N')->setWidth(7);
                $event->sheet->getColumnDimension('O')->setWidth(19);
                $event->sheet->getColumnDimension('P')->setWidth(2);
                $event->sheet->getColumnDimension('Q')->setWidth(17);


                $event->sheet->setCellValue('M2',$preshipment->wbs_receiving_number);
                $event->sheet->setCellValue('M3',$preshipment->rapid_invoice_number);


                $event->sheet->setCellValue('A4',"DATE:");
                $event->sheet->setCellValue('C4',$preshipment->preshipment->Date);
                $event->sheet->getDelegate()->getStyle('C4:D4')->applyFromArray($styleBorderBottomThin);


                $event->sheet->setCellValue('A5',"STATION:");
                $event->sheet->setCellValue('C5',$preshipment->preshipment->Station);
                $event->sheet->getDelegate()->getStyle('C5:D5')->applyFromArray($styleBorderBottomThin);


                $event->sheet->setCellValue('H5',"PACKING LIST CONTROL NO.:");
                $event->sheet->setCellValue('K5',$preshipment->preshipment->Destination."-".$preshipment->preshipment->Packing_List_CtrlNo);
                $event->sheet->getDelegate()->getStyle('K5:L5')->applyFromArray($styleBorderBottomThin);

                $event->sheet->setCellValue('A6',"SHIPMENT DATE:");
                $event->sheet->setCellValue('C6',$preshipment->preshipment->Shipment_Date);
                $event->sheet->getDelegate()->getStyle('C6:D6')->applyFromArray($styleBorderBottomThin);

                $event->sheet->setCellValue('I6',"DESTINATION:");
                $event->sheet->setCellValue('K6',$preshipment->preshipment->Destination);
                $event->sheet->getDelegate()->getStyle('K6:L6')->applyFromArray($styleBorderBottomThin);


                $event->sheet->setCellValue('A8',"MASTER CARTON NO.");
                $event->sheet->setCellValue('B8',"ITEM NO.");
                $event->sheet->setCellValue('C8',"P.O NO.");
                $event->sheet->setCellValue('D8',"PARTS CODE");
                $event->sheet->setCellValue('E8',"DEVICE NAME");
                $event->sheet->setCellValue('F8',"LOT NO.");
                $event->sheet->setCellValue('G8',"QTY");
                $event->sheet->setCellValue('H8',"PACKAGE CATEGORY");
                $event->sheet->setCellValue('I8',"PACKAGE QTY");
                $event->sheet->setCellValue('J8',"WEIGHED BY");
                $event->sheet->setCellValue('K8',"PACKED BY");
                $event->sheet->setCellValue('L8',"CHECKED BY");

                $event->sheet->getDelegate()->getRowDimension(9)->setRowHeight(25);


                $event->sheet->setCellValue('M8',"QC PACKING INSPECTION");

                $event->sheet->getDelegate()->mergeCells('M8:Q8');

                $event->sheet->setCellValue('M9',"RESULT");
                $event->sheet->getDelegate()->mergeCells('M9:N9');
                $event->sheet->setCellValue('O9',"QC NAME");
                $event->sheet->getDelegate()->mergeCells('O9:P9');
                $event->sheet->setCellValue('Q9',"REMARKS");


                $colno = 10;
                $sum = 0;
                for($x = 0; $x < count($preshipment_list); $x++){
                    $item_number = $x + 1;
                    $event->sheet->setCellValue('A'.$colno,$preshipment_list[$x]['Master_CartonNo']);
                    $event->sheet->setCellValue('B'.$colno,$item_number);
                    $event->sheet->setCellValue('C'.$colno,$preshipment_list[$x]['PONo']);
                    $event->sheet->setCellValue('D'.$colno,$preshipment_list[$x]['Partscode']);
                    $event->sheet->setCellValue('E'.$colno,$preshipment_list[$x]['DeviceName']);
                    $event->sheet->setCellValue('F'.$colno,$preshipment_list[$x]['LotNo']);
                    $event->sheet->setCellValue('G'.$colno,$preshipment_list[$x]['Qty']);
                    $event->sheet->setCellValue('H'.$colno,$preshipment_list[$x]['PackageCategory']);
                    $event->sheet->setCellValue('I'.$colno,$preshipment_list[$x]['PackageQty']);
                    $event->sheet->setCellValue('J'.$colno,$preshipment_list[$x]['WeighedBy']);
                    $event->sheet->setCellValue('K'.$colno,$preshipment_list[$x]['PackedBy']);

                    // $event->sheet->setCellValue('L'.$colno,$preshipment_list[$x]['CheckedBy']);
                    // if($preshipment->checked_by_details != null){

                    //     $event->sheet->setCellValue('L'.$colno,$preshipment->checked_by_details->rapidx_user_details->name);
                    // }
                    if($preshipment->checked_by_details_from_rapidx_user != null){

                        $event->sheet->setCellValue('L'.$colno,$preshipment->checked_by_details_from_rapidx_user->name);
                    }

                    $event->sheet->setCellValue('M'.$colno,"OK");
                    $event->sheet->getDelegate()->getStyle('M'.$colno)->applyFromArray($center_bottom);
                    $event->sheet->setCellValue('O'.$colno,$preshipment->qc_approver_details->rapidx_user_details->name);
                    $event->sheet->getDelegate()->getStyle('O'.$colno)->applyFromArray($center_bottom);


                    $event->sheet->getDelegate()->mergeCells('M'.$colno.':N'.$colno);
                    $event->sheet->getDelegate()->mergeCells('O'.$colno.':P'.$colno);
                    $event->sheet->setCellValue('Q'.$colno,$preshipment_list[$x]['Remarks']);
                    $colno++;

                    $sum = $sum + $preshipment_list[$x]['Qty'];
                }
                $event->sheet->getDelegate()->mergeCells('M'.$colno.':N'.$colno);

                $event->sheet->getDelegate()->mergeCells('O'.$colno.':P'.$colno);
                $event->sheet->getDelegate()->getStyle('A8:Q'.$colno)->applyFromArray($styleBorderAll);


                $colno = $colno+1;
                $event->sheet->getDelegate()->getStyle('F'.$colno)->getFont()->setSize(16);
                $event->sheet->getDelegate()->getStyle('F'.$colno)->applyFromArray($bold);
                $event->sheet->getDelegate()->getStyle('G'.$colno)->getFont()->setSize(16);
                $event->sheet->getDelegate()->getStyle('G'.$colno)->applyFromArray($bold);
                $event->sheet->setCellValue('F'.$colno,"TOTAL QTY");
                $event->sheet->setCellValue('G'.$colno, $sum);

                $colno = $colno+1;
                $event->sheet->getDelegate()->getStyle('F'.$colno)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle('F'.$colno)->applyFromArray($underline);
                $event->sheet->setCellValue('F'.$colno,"PPS WAREHOUSE");

                $event->sheet->getDelegate()->getStyle('I'.$colno)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle('I'.$colno)->applyFromArray($underline);
                $event->sheet->setCellValue('I'.$colno,"TS/CN/YF WAREHOUSE");
                $event->sheet->getDelegate()->getStyle('N'.$colno)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle('N'.$colno)->applyFromArray($underline);
                $event->sheet->setCellValue('N'.$colno,"DATE");
                $event->sheet->getDelegate()->getStyle('Q'.$colno)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle('Q'.$colno)->applyFromArray($underline);
                $event->sheet->setCellValue('Q'.$colno,"TIME");

                $event->sheet->getDelegate()->mergeCells('I'.$colno.':L'.$colno);


                $colno = $colno+1;
                $event->sheet->setCellValue('F'.$colno,"CHECKED BY:");
                if($preshipment->from_user_details != null){
                    $event->sheet->setCellValue('G'.$colno,$preshipment->from_user_details->rapidx_user_details->name);
                }
                $event->sheet->getDelegate()->mergeCells('G'.$colno.':H'.$colno);
                $event->sheet->getDelegate()->getStyle('G'.$colno.':H'.$colno)->applyFromArray($styleBorderBottomThin);



                $event->sheet->setCellValue('I'.$colno,"RECEIVED BY:");

                $date_receive = "";
                $date_format_receive = "";
                $time_format_receive = "";
                if($preshipment->to_whse_noter_details != null){

                    $event->sheet->setCellValue('K'.$colno,$preshipment->to_whse_noter_details->rapidx_user_details->name);

                    $date_receive=date_create($preshipment->to_whse_noter_date_time);
                    $date_format_receive = date_format($date_receive, "m-d-Y");
                    $time_format_receive = date_format($date_receive, "H:i");
                }

                $event->sheet->getDelegate()->mergeCells('K'.$colno.':L'.$colno);
                $event->sheet->getDelegate()->getStyle('K'.$colno.':L'.$colno)->applyFromArray($styleBorderBottomThin);





                $event->sheet->setCellValue('N'.$colno,$date_format_receive);
                $event->sheet->getDelegate()->mergeCells('N'.$colno.':O'.$colno);
                $event->sheet->getDelegate()->getStyle('N'.$colno.':O'.$colno)->applyFromArray($styleBorderBottomThin);


                $event->sheet->setCellValue('Q'.$colno,$time_format_receive);

                $event->sheet->getDelegate()->getStyle('Q'.$colno)->applyFromArray($styleBorderBottomThin);
                $event->sheet->getDelegate()->getRowDimension($colno)->setRowHeight(30);


                $colno= $colno+1;
                $event->sheet->setCellValue('I'.$colno,"UPLOADED BY:");
                $date_upload = "";
                $date_format_upload = "";
                $time_format_upload = "";
                $internal_invoice_check = array("TS","CN");
                $PO = $preshipment_list[0]['PONo'][0].$preshipment_list[0]['PONo'][1];
                if(in_array($PO,$internal_invoice_check)){
                    $event->sheet->setCellValue('K'.$colno,"N/A");
                    $event->sheet->setCellValue('N'.$colno,"N/A");
                    $event->sheet->setCellValue('Q'.$colno,"N/A");
                }
                else if ($preshipment->whse_uploader_details != null) {
                    $event->sheet->setCellValue('K'.$colno,$preshipment->whse_uploader_details->rapidx_user_details->name);
                    $date_upload=date_create($preshipment->whse_uploader_date_time);
                    $date_format_upload = date_format($date_upload, "m-d-Y");
                    $time_format_upload = date_format($date_upload, "H:i");

                    $event->sheet->setCellValue('N'.$colno,$date_format_upload);
                    $event->sheet->setCellValue('Q'.$colno,$time_format_upload);
                }
                // if($preshipment->whse_uploader_details != null){

                //     $event->sheet->setCellValue('K'.$colno,$preshipment->whse_uploader_details->rapidx_user_details->name);
                //     $date_upload=date_create($preshipment->whse_uploader_date_time);
                //     $date_format_upload = date_format($date_upload, "m-d-Y");
                //     $time_format_upload = date_format($date_upload, "H:i");
                // }






                $event->sheet->getDelegate()->mergeCells('K'.$colno.':L'.$colno);
                $event->sheet->getDelegate()->getStyle('K'.$colno.':L'.$colno)->applyFromArray($styleBorderBottomThin);

                $event->sheet->getDelegate()->mergeCells('N'.$colno.':O'.$colno);
                $event->sheet->getDelegate()->getStyle('N'.$colno.':O'.$colno)->applyFromArray($styleBorderBottomThin);


                $event->sheet->getDelegate()->getStyle('Q'.$colno)->applyFromArray($styleBorderBottomThin);
                $event->sheet->getDelegate()->getRowDimension($colno)->setRowHeight(30);


                $colno= $colno+1;
                $event->sheet->setCellValue('I'.$colno,"CHECKED BY:");
                $date_superior = "";
                $date_format_superior = "";
                $time_format_superior = "";
                if($preshipment->whse_superior_details != null){

                    $event->sheet->setCellValue('K'.$colno,$preshipment->whse_superior_details->rapidx_user_details->name);
                    $date_superior=date_create($preshipment->whse_superior_noter_date_time);
                    $date_format_superior = date_format($date_superior, "m-d-Y");
                    $time_format_superior = date_format($date_superior, "H:i");
                }




                $event->sheet->setCellValue('N'.$colno,$date_format_superior);

                $event->sheet->getDelegate()->mergeCells('K'.$colno.':L'.$colno);
                $event->sheet->getDelegate()->getStyle('K'.$colno.':L'.$colno)->applyFromArray($styleBorderBottomThin);

                $event->sheet->getDelegate()->mergeCells('N'.$colno.':O'.$colno);
                $event->sheet->getDelegate()->getStyle('N'.$colno.':O'.$colno)->applyFromArray($styleBorderBottomThin);

                $event->sheet->setCellValue('Q'.$colno,$time_format_superior);
                $event->sheet->getDelegate()->getStyle('Q'.$colno)->applyFromArray($styleBorderBottomThin);

                $event->sheet->getDelegate()->getRowDimension($colno)->setRowHeight(30);



                $colno = $colno + 2;

                $event->sheet->getDelegate()->getStyle('A4:Q'.$colno)->applyFromArray($styleBorderOutside);








            },

        ];
    }

}
