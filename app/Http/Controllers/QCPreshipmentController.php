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

class QCPreshipmentController extends Controller
{
    
    public function get_Preshipment_QC(){
        $preshipment = RapidPreshipment::where('rapidx_QCChecking','1')
        ->get();
      
        return DataTables::of($preshipment)
        ->addColumn('action', function($preshipment) {
            $result = "";
            $result .= '<center><button class="btn btn-primary btn-sm btn-openshipment"  data-toggle="modal" data-target="#modalViewQCChecksheets" checksheet-id="'.$preshipment->Packing_List_CtrlNo.'"><i class="fas fa-eye"></i></button></center>';
            // $result .= $preshipment->Packing_List_CtrlNo;

            return $result;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getpreshipmentbyCtrlNo_QC(Request $request){

        $preshipment = RapidPreshipment::where('Packing_List_CtrlNo',$request->preshipment_ctrl_id)
        ->get();

        if(count($preshipment) > 0){
            return response()->json(['response' => 1, 'preshipment' => $preshipment]);
        }
        else{
            return response()->json(['response' => 0]);

        }
    }

    public function get_Preshipment_list_QC(Request $request){
        
        $preshipment_list = RapidPreshipmentList::where('fkControlNo', $request->preshipmentCtrlNo)
        ->where('logdel', 0)
        ->get();

      
        return DataTables::of($preshipment_list)
        ->make(true);
        
    }

    public function disapprove_list_QC(Request $request){
        date_default_timezone_set('Asia/Manila');
       
            try{
                RapidPreshipment::where('Packing_List_CtrlNo', $request->packingCtrlNo)
                ->update([ // The update method expects an array of column and value pairs representing the columns that should be updated.
                    'rapidx_QCChecking' => '3'
                ]);
                
                return response()->json(['result' => "1"]);

                
            }
            catch(\Exception $e) {
               
                return response()->json(['result' => "0", 'tryCatchError' => $e->getMessage()]);
            }
    }

    public function approve_list_QC(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();
        // RapidPreshipment::where('packing_List_CtrlNo', $request->packingCtrlNo)
        // ->update([
        //     'rapidx_QCChecking' => '2'
        // ]);
        // return response()->json(['result' => 1,]);


          $getList= RapidPreshipmentList::where('fkControlNo',$request->packingCtrlNo)
        ->where('logdel', 0)
        ->get();


        $getPackinglist = RapidPreshipment::where('Packing_List_CtrlNo',$request->packingCtrlNo)
        ->where('logdel', 0)
        ->get();

        $ctrlNo =  $getList[0]->fkControlNo;
        
        foreach($getList as $PO){
            $LastPONO = $PO->PONo;
        }

        $LastPONO 		= $LastPONO[0].$LastPONO[1];	//Check the OrderNo first 2 index. 
        $internal_invoice_check = array("PR","AD"); // will check if the preshipment is an internal shipment of external shipment
        if( in_array( $LastPONO,$internal_invoice_check) ) {	
            // Internal Shipment
            $preshipment_id = Preshipment::insertGetId([
                'rapid_preshipment_id'      => $getPackinglist[0]->id,
                'date'                      => $getPackinglist[0]->Date,
                'station'                   => $getPackinglist[0]->Station,
                'packing_list_ctrlNo'       => $getPackinglist[0]->Packing_List_CtrlNo,
                'Shipment_date'             => $getPackinglist[0]->Shipment_Date,
                'Destination'               => $getPackinglist[0]->Destination,
                'Usename'                   => $getPackinglist[0]->Username,
                'qc_approver'               => $_SESSION['rapidx_user_id'],
            ]);
            // $preshipment_PKid = DB::getPdo()->lastInsertId();
            
            for($i = 0; $i<count($getList); $i++){
                $preshipment_list = PreshipmentList::insert([
                    'fkControlNo'       => $preshipment_id,
                    'Master_CartonNo'   => $getList[$i]->Master_CartonNo,
                    'ItemNo'            => $getList[$i]->ItemNo,
                    'PONo'              => $getList[$i]->PONo,
                    'Partscode'         => $getList[$i]->Partscode,
                    'DeviceName'        => $getList[$i]->DeviceName,
                    'LotNo'             => $getList[$i]->LotNo,
                    'Qty'               => $getList[$i]->Qty	,
                    'PackageCategory'   => $getList[$i]->PackageCategory,
                    'PackageQty'        => $getList[$i]->PackageQty,
                    'WeighedBy'         => $getList[$i]->WeighedBy,
                    'PackedBy'          => $getList[$i]->PackedBy,
                    'Remarks'           => $getList[$i]->Remarks,
                    'Username'          => $getList[$i]->Username,
                ]);
            }

            PreshipmentApproving::insert([
                'fk_preshipment_id' => $preshipment_id,
                'status' => 0,
            ]);
            
            RapidPreshipment::where('Packing_List_CtrlNo', $request->packingCtrlNo)
            ->update([ // The update method expects an array of column and value pairs representing the columns that should be updated.
                'rapidx_QCChecking' => '2'
            ]);

            return response()->json(['result' => 1]);
        } else {
            //external

            return response()->json(['result' => 1,]);
        }


    }



      // $test = PreshipmentList::with([
    //     'Preshipment'
    // ])
    // ->get();

    // $test = collect($test)->where('Preshipment.packing_list_ctrlNo', '==', '2111-03')->flatten(1);

}
