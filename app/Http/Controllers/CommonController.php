<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Model\PreshipmentList;
use App\Model\RapidPreshipment;
use App\Model\RapidPreshipmentList;
use App\Model\PreshipmentApproving;
use App\Model\UserAccess;
use App\Model\RapidDieset;
use App\Model\RapidStamping;


use App\Model\MhPreshipmentCheck;

use DataTables;

class CommonController extends Controller
{
    public function get_Preshipment_list(Request $request){

        $preshipment_list = RapidPreshipmentList::with([
            'dieset_info'
        ])
        ->where('fkControlNo', $request->preshipmentCtrlNo)
        ->where('logdel', 0)
        ->get();

        $rapid_preshipment = RapidPreshipment::where('Packing_List_CtrlNo', $request->preshipmentCtrlNo)
        ->where('logdel', 0)
        ->first();
      
        // return $preshipment_list;
        return DataTables::of($preshipment_list)

        ->addColumn('hide_input', function($preshipment) {
            $result = "";
            /*
                this is for the scanning of qr code for package qty.
                this will get the last value of the array.
                this will accept - or ~ only.
            */
            $result = "";

            if($preshipment->PackageQty == "DO"){
                $result .= "DO";
            }

            if (str_contains($preshipment->PackageQty, '-')){
                $exploded = explode("-",$preshipment->PackageQty);
                // $result .= $exploded[1];
                $exploded_last_index = $exploded[1];
                $package_qty_for_hidden_scan = "";

                for($x = 1; $x<=$exploded_last_index; $x++){

                    $package_qty_for_hidden_scan .= $x."/".$exploded_last_index." ";
                }
                $result .= $package_qty_for_hidden_scan;
            }
            else if(str_contains($preshipment->PackageQty, '~')){
                $exploded = explode("~",$preshipment->PackageQty);
                // $result .=$exploded[1];
                $exploded_last_index = $exploded[1];
                $package_qty_for_hidden_scan = "";
                for($x = 1; $x<=$exploded_last_index; $x++){
                    $package_qty_for_hidden_scan .= $x."/".$exploded_last_index."";
                }
                $result .= $package_qty_for_hidden_scan;
                // return $package_qty_for_hidden_scan;
            }
            else if($preshipment->PackageQty != "DO"){
                $result .= $preshipment->PackageQty;
            }

            return $result;
        })
        ->addColumn('hide_stamping', function($preshipment) use ($rapid_preshipment){
            $result = "";

            if($rapid_preshipment->Stamping == 1){
                $result .= "stamping";
            }
            
            return $result;
        })
        ->addcolumn('drawing_no', function($preshipment) use ($rapid_preshipment){
            $result = "";

            if($rapid_preshipment->Stamping == 0 && $rapid_preshipment->for_pps_cn_transfer == 0){
                if(isset($preshipment->dieset_info)){
                    $result .= $preshipment->dieset_info->DrawingNo;
                }
            }
            else{
                $stamping = RapidStamping::where('device_code','LIKE', '%'.$preshipment->Partscode.'%')
                ->where('logdel', 0)
                ->first();

                if(isset($stamping)){
                    $result .= $stamping->drawing_no;
                }
              
            }
            
            return $result;
        })
        ->addcolumn('rev', function($preshipment) use ($rapid_preshipment){
            $result = "";

            if($rapid_preshipment->Stamping == 0 && $rapid_preshipment->for_pps_cn_transfer == 0){
                if(isset($preshipment->dieset_info)){
                    $result .= $preshipment->dieset_info->Rev;
                }
            }
            else{
                $stamping = RapidStamping::where('device_code','LIKE', '%'.$preshipment->Partscode.'%')
                ->where('logdel', 0)
                ->first();

                if(isset($stamping)){
                    // $exploded_drawing = explode(' ', $stamping->drawing_no);
                    $result .= $stamping->rev;
                    // $result .= $stamping->drawing_no;
                }
            }
          
            return $result;
        })
        /* old code */
        // ->addcolumn('drawing_no', function($preshipment){
        //     $result = "";

        //     if(isset($preshipment->dieset_info)){
        //         $result .= $preshipment->dieset_info->DrawingNo;
        //     }

        //     return $result;
        // })
        // ->addcolumn('rev', function($preshipment){
        //     $result = "";

        //     if(isset($preshipment->dieset_info)){
        //         $result .= $preshipment->dieset_info->Rev;
        //     }

        //     return $result;
        // })
        ->rawColumns(['hide_input', 'hide_stamping','drawing_no', 'rev'])
        ->make(true);
        

    }

}
