<?php

namespace App\Http\Controllers;


// use DB;
use PDF;

use DOMXPath;
use DOMElement;
use Dompdf\Dompdf;
use Dompdf\Helpers;
use Dompdf\Exception;

use Dompdf\FontMetrics;
use App\Exports\WbsExports;
use App\Model\WbsIqcMatrix;
use Dompdf\Frame\FrameTree;


use Illuminate\Http\Request;
use App\Model\RapidPreshipment;
use App\Exports\PreshipmentExport;
use App\Model\RapidShipmentRecord;
use Illuminate\Support\Facades\DB;
use App\Model\PreshipmentApproving;
use App\Model\RapidPreshipmentList;
use App\Exports\WbsExports_newformat;
use Maatwebsite\Excel\Facades\Excel; 



class ExportController extends Controller
{
    public function export(Request $request, $invoice_number, $packing_list_ctrl_num, $packingListProductLine){

        // $rapid_shipment_records = RapidShipmentRecord::selectRaw('*')
        // // ->groupBy('ControlNumber','ItemCode','LotNo')
        // ->where('ControlNumber',$invoice_number)
        // ->orderBy('id')
        // ->get();

        /* Old Code - 05032023 - Chris */
        $rapid_shipment_records = RapidShipmentRecord::selectRaw('*, SUM(ShipoutQty) AS TotalShipoutQty')
        ->groupBy('ControlNumber','ItemCode','LotNo')
        ->where('ControlNumber',$invoice_number)
        ->orderBy('id')
        ->get();

        
        $date = date('Ymd',strtotime(NOW()));
        return Excel::download(new WbsExports($date,$rapid_shipment_records,$packing_list_ctrl_num,$packingListProductLine), 'wbs-upload.xlsx');
    }

    public function export_test(Request $request, $invoice_number, $packing_list_ctrl_num, $packingListProductLine){

        $rapid_shipment_records = RapidShipmentRecord::selectRaw('*')
        // ->groupBy('ControlNumber','ItemCode','LotNo')
        ->where('ControlNumber',$invoice_number)
        ->orderBy('id')
        ->get();

        /* Old Code - 05032023 - Chris */
        // $rapid_shipment_records = RapidShipmentRecord::selectRaw('*, SUM(ShipoutQty) AS TotalShipoutQty')
        // ->groupBy('ControlNumber','ItemCode','LotNo')
        // ->where('ControlNumber',$invoice_number)
        // ->orderBy('id')
        // ->get();

        
        $date = date('Ymd',strtotime(NOW()));
        return Excel::download(new WbsExports_newformat($date,$rapid_shipment_records,$packing_list_ctrl_num,$packingListProductLine), 'wbs-upload.xlsx');
    }


    public function export_excel(Request $request, $approving_id){
        $get_preshipment = PreshipmentApproving::with([
            'preshipment',
            'checked_by_details_from_rapidx_user',
            'checked_by_details',
            'checked_by_details.rapidx_user_details',
            'qc_approver_details',
            'qc_approver_details.rapidx_user_details',
            'from_user_details',
            'from_user_details.rapidx_user_details',
            'to_whse_noter_details',
            'to_whse_noter_details.rapidx_user_details',
            'whse_uploader_details',
            'whse_uploader_details.rapidx_user_details',
            'whse_superior_details',
            'whse_superior_details.rapidx_user_details',
        ])
        ->where('id', $approving_id)
        ->where('logdel', 0)
        ->first();
        
    
       
        $get_rapid_preshipment_list = RapidPreshipmentList::where('fkControlNo', $get_preshipment->preshipment->Packing_List_CtrlNo)
        ->where('logdel', 0)
        ->get();
        // return $get_preshipment;
        $remove_special_char = preg_replace('/[\/:*?"<>|]/', '', $get_preshipment->preshipment->Destination);
        $download_name = $remove_special_char.'-'.$get_preshipment->preshipment->Packing_List_CtrlNo;
        
        $date = date('Ymd',strtotime(NOW()));
        return Excel::download(new PreshipmentExport($date, $get_preshipment, $get_rapid_preshipment_list), $download_name.'.xlsx');
    }


    public function pdf_export(Request $request, $approving_id){

        $get_preshipment = PreshipmentApproving::with([
            'preshipment',

            'checked_by_details_from_rapidx_user',

            'checked_by_details',
            'checked_by_details.rapidx_user_details',

            'qc_approver_details',
            'qc_approver_details.rapidx_user_details',

            'from_user_details',
            'from_user_details.rapidx_user_details',

            'to_whse_noter_details',
            'to_whse_noter_details.rapidx_user_details',

            'whse_uploader_details',
            'whse_uploader_details.rapidx_user_details',
            
            'whse_superior_details',
            'whse_superior_details.rapidx_user_details',
        ])
        ->where('id', $approving_id)
        ->where('logdel', 0)
        ->first();

        $get_rapid_preshipment_list = RapidPreshipmentList::where('fkControlNo', $get_preshipment->preshipment->Packing_List_CtrlNo)
        ->where('logdel', 0)
        ->get();


        $pdf = PDF::loadView('pdf_preshipment', 
        array('preshipment' =>  $get_preshipment,
            'preshipment_list' => $get_rapid_preshipment_list
        ));
        $pdf->setPaper('A4', 'Landscape');

        return $pdf->stream();
    }

    public function pdf_export_grinding(Request $request, $id){ // EXPORT FOR GRINDING ONLY
        // return $id;
        $preshipment = RapidPreshipment::with([
            'rapid_shipment_invoice_details'
        ])
        ->where('id', $id)->first();

        $get_rapid_preshipment_list = RapidPreshipmentList::where('fkControlNo', $preshipment->Packing_List_CtrlNo)
        ->where('logdel', 0)
        ->get();
        // return $preshipment;

        $pdf = PDF::loadView('pdf_preshipment_grinding', 
        array('preshipment' =>  $preshipment,
            'preshipment_list' => $get_rapid_preshipment_list
        ));
        $pdf->setPaper('A4', 'Landscape');

        return $pdf->stream();
    }
}
