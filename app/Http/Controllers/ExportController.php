<?php

namespace App\Http\Controllers;


// use DB;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; 
use App\Exports\WbsExports;
use App\Exports\PreshipmentExport;

use App\Model\RapidShipmentRecord;
use App\Model\RapidPreshipmentList;
use App\Model\WbsIqcMatrix;
use App\Model\PreshipmentApproving;


use PDF;
use DOMElement;
use DOMXPath;
use Dompdf\Dompdf;
use Dompdf\Helpers;
use Dompdf\Exception;
use Dompdf\FontMetrics;
use Dompdf\Frame\FrameTree;



class ExportController extends Controller
{
    public function export(Request $request, $invoice_number, $packing_list_ctrl_num, $packingListProductLine){




        $rapid_shipment_records = RapidShipmentRecord::selectRaw('*, SUM(ShipoutQty) AS TotalShipoutQty')
        ->groupBy('ControlNumber','ItemCode','LotNo')
        ->where('ControlNumber',$invoice_number)
        ->orderBy('id')
        ->get();


        // $rapid_preshipment_list = RapidPreshipmentList::where('PONo','PR2120030157')->where('Partscode','108486001')->where('LotNo','A211108/A220101A-G')->where('logdel',0)->get('PackageCategory');
        
        // $rapid_preshipment_qty = RapidPreshipmentList::where('fkControlNo','2201-03')->where('PONo','PR2120030157')->where('Partscode','108486001')->where('LotNo','A211108/A220101A-G')->where('logdel',0)->sum('PackageQty');


        // $wbs_matrix = WbsIqcMatrix::where('item','108486001')->get();


        // if(count($wbs_matrix) != null){
        //     $count = 0;
        // }
        // else{
        //     $count = 1;
        // }


        // return $rapid_shipment_records;

        $date = date('Ymd',strtotime(NOW()));
        return Excel::download(new WbsExports($date,$rapid_shipment_records,$packing_list_ctrl_num,$packingListProductLine), 'wbs-upload.xlsx');
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
        // return $get_preshipment;

        $pdf = PDF::loadView('pdf_preshipment', 
        array('preshipment' =>  $get_preshipment,
            'preshipment_list' => $get_rapid_preshipment_list
        ));
        $pdf->setPaper('A4', 'Landscape');

        return $pdf->stream();
    }
}
