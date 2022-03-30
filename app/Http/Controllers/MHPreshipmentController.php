<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;



use App\Model\Preshipment;
use App\Model\PreshipmentList;
use App\Model\RapidPreshipment;
use App\Model\RapidPreshipmentList;
use App\Model\PreshipmentApproving;

use DataTables;

class MHPreshipmentController extends Controller
{
    public function get_Preshipment(){
        $preshipment = RapidPreshipment::where('rapidx_MHChecking','0')
        ->get();
      
        return DataTables::of($preshipment)
        ->addColumn('action', function($preshipment) {
            $result = "";
            $result .= '<center><button class="btn btn-primary btn-sm btn-openshipment"  data-toggle="modal" data-target="#modalViewMaterialHandlerChecksheets" checksheet-id="'.$preshipment->Packing_List_CtrlNo.'"><i class="fas fa-eye"></i></button></center>';
            // $result .= $preshipment->Packing_List_CtrlNo;

            return $result;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    public function getpreshipmentbyCtrlNo(Request $request){

        $preshipment = RapidPreshipment::where('Packing_List_CtrlNo',$request->preshipment_ctrl_id)
        ->get();

        if(count($preshipment) > 0){
            return response()->json(['response' => 1, 'preshipment' => $preshipment]);
        }
        else{
            return response()->json(['response' => 0]);

        }
    }
    public function getpreshipmentbyCtrlNoWhse(Request $request){

        $preshipment = RapidPreshipment::where('Packing_List_CtrlNo',$request->preshipment_ctrl_id)
        ->get();

        if(count($preshipment) > 0){
            return response()->json(['response' => 1, 'preshipment' => $preshipment]);
        }
        else{
            return response()->json(['response' => 0]);

        }
    }

    

    public function get_Preshipment_list(Request $request){

        $preshipment_list = RapidPreshipmentList::where('fkControlNo', $request->preshipmentCtrlNo)
        ->where('logdel', 0)
        ->get();

      
        return DataTables::of($preshipment_list)
        ->make(true);
        

    }

    public function disapprove_list(Request $request){
        date_default_timezone_set('Asia/Manila');
       
            try{
                RapidPreshipment::where('Packing_List_CtrlNo', $request->packingCtrlNo)
                ->update([ // The update method expects an array of column and value pairs representing the columns that should be updated.
                    'rapidx_MHChecking' => '2'
                ]);
                
                return response()->json(['result' => "1"]);



                return $test;
            }
            catch(\Exception $e) {
               
                return response()->json(['result' => "0", 'tryCatchError' => $e->getMessage()]);
            }
    }

    public function approve_list(Request $request){

        RapidPreshipment::where('packing_List_CtrlNo', $request->packingCtrlNo)
        ->update([
            'rapidx_MHChecking' => '1',
            'rapidx_QCChecking' => '1'
        ]);
        return response()->json(['result' => 1,]);

    }


    public function get_for_whse_transaction(){

        // $mh_whse_transaction = 
        $preshipment = PreshipmentApproving::with([
            'Preshipment_for_approval',
        ])
        ->where('status',0)
        ->where('logdel', 0)
        ->get();


        // $preshipmentlist = PreshipmentList::where('fkControlNo',$preshipment[0]->id)
        // ->get();

        // return $preshipmentlist;
      
        return DataTables::of($preshipment)
        ->addColumn('action', function($preshipment) {
            $result = "";
            $result .= '<center><button style="width: 100%;" class="btn btn-outline-primary btn-sm btn-openshipmentWhse"  data-toggle="modal" data-target="#modalViewMaterialHandler" checksheet-id="'.$preshipment->preshipment_for_approval->packing_list_ctrlNo.'">View</button></center>';
            // $result .= $preshipment->Packing_List_CtrlNo;

            // $result .='<center><button style="width: 100%;" class="btn btn-outline-success btn-sm mt-1" MHToWhseTransaction-btn MHToWhseTransaction-id ="'.$preshipment->preshipment_for_approval->packing_list_ctrlNo.'">Send</button></center>';

            return $result;
        })
        ->rawColumns(['action'])
        ->make(true);
    }





    
  

    
}
