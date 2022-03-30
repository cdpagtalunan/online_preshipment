<?php

namespace App\Http\Controllers;


// use DB;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; 
use App\Exports\UsersExports;

use App\Model\RapidShipmentRecord;
use App\Model\RapidPreshipmentList;
use App\Model\WbsIqcMatrix;


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


        // return $invoice_number;

        $date = date('Ymd',strtotime(NOW()));
        return Excel::download(new UsersExports($date,$rapid_shipment_records,$packing_list_ctrl_num,$packingListProductLine), 'Test.xlsx');
    }
}
