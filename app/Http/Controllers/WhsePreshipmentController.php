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
use App\Model\RapidShipmentInvoice;

use DataTables;

class WhsePreshipmentController extends Controller
{
    public function get_preshipment_for_whse(){
        $whse_preshipment = PreshipmentApproving::with([
            'Preshipment_for_approval'
        ])
        // ->whereIn('status', [0,1])
        ->get();


        return DataTables::of($whse_preshipment)
        ->addColumn('status', function($whse_preshipment){
            $result = "<center>";

            if($whse_preshipment->status == 0){
                $result .='<span class="badge badge-warning">For Approval</span>';
            }
            else if($whse_preshipment->status == 1){
                $result .='<span class="badge badge-warning">For '.strtoupper($whse_preshipment->send_to).'-Whse Approval</span>';
            }
            else if($whse_preshipment->status >= 2){
                $result .='<span class="badge badge-success">'.strtoupper($whse_preshipment->send_to).'-Whse Accepted</span>';
            }

            $result .="</center>";

            return $result;
        })
        ->addColumn('action', function($whse_preshipment) {
            $result = "";
            // $result .= '<center><button class="btn btn-primary btn-sm btn-openshipment"  data-toggle="modal" data-target="#modalViewMaterialHandlerChecksheets" checksheet-id="'.$preshipment->Packing_List_CtrlNo.'"><i class="fas fa-eye"></i></button></center>';
            // $result .= $preshipment->Packing_List_CtrlNo;

            // return $result;
            // <button type="button" class="btn btn-outline-dark btn-sm fa fa-edit text-center actionEditCashAdvance" style="width:105px;margin:2%;" cash_advance-id="3" data-toggle="modal" data-target="#modalEditCashAdvance" data-keyboard="false"> Edit</button>
            $result .= '<center><button class="btn btn-outline-primary btn-sm btn-whs-view " data-toggle="modal" data-target="#modalViewWhsePreshipment" style="width:105px;margin:2%;" preshipment-id="'.$whse_preshipment->id.'"> View</button></center>';

            if($whse_preshipment->status == 0){
                $result .= '<center><button class="btn btn-outline-success btn-sm btn-approve-whse"  data-toggle="modal" data-target="#modalWhsApprove" preshipment-id="'.$whse_preshipment->id.'" style="width:105px;margin:2%;" preshipment-id=""> Approve</button></center>';

            }
            // else if($whse_preshipment->status == 1){
            //     $result .= '<center><button class="btn btn-outline-success btn-sm btn-openshipment " style="width:105px;margin:2%;" preshipment-id="">Excel</button></center>';
            //     $result .= '<center><button class="btn btn-outline-warning btn-sm btn-openshipment " style="width:105px;margin:2%;" preshipment-id="">Uploaded</button></center>';

            // }

            return $result;

        })
        ->rawColumns(['status','action'])
        ->make(true);

    }

    public function get_preshipment_by_id_for_whse(Request $request){

        $approver = PreshipmentApproving::with([
            'from_user_details',
            'from_user_details.rapidx_user_details'
        ])
        ->where('id', $request->preshipment_id)
        ->first();
        
      
        $preshipment_id = Preshipment::where('id', $approver->fk_preshipment_id)->first();


        // $preshipment_list = PreshipmentList::where('fkControlNo',$preshipment_id->id)->get();

        return response()->json(['result' => 1, 'preshipment' => $preshipment_id, 'approver' => $approver]);
    }


    public function get_preshipment_list_for_whse(Request $request){

        // return $request->preshipmentCtrlNo;

        $preshipment_list = PreshipmentList::where('fkcontrolNo',$request->preshipmentId)->get();

        return DataTables::of($preshipment_list)
        ->make(true);


    }

    public function get_preshipment_by_id_for_approval_whse(Request $request){
        $preshipment_details = PreshipmentApproving::with([
            'Preshipment_for_approval',
            'Preshipment_for_approval.qc_approver_details',
            'Preshipment_for_approval.qc_approver_details.rapidx_user_details'
        ])
        ->where('id', $request->preshipmentId)->first();

        // return $preshipment_details;

        return response()->json(['result' => $preshipment_details]);
    }

    public function send_preshipment_from_whse_to_whse(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();
        

        PreshipmentApproving::where('id', $request->preshipment_approval_id)
        ->update([
            'status' => 1,
            'send_to' => $request->accept_shipment_send_to,
            'from_whse_noter' => $_SESSION['rapidx_user_id']
        ]);

        return response()->json(['result' => 1]);
        // return $data;
    }



    public function get_preshipment_for_ts_cn_whse(){
        $whse_preshipment = PreshipmentApproving::with([
            'Preshipment_for_approval'
        ])
        ->whereIn('status', [1,2,3])
        ->get();


        return DataTables::of($whse_preshipment)
        ->addColumn('status', function($whse_preshipment){
            $result = "<center>";

            if($whse_preshipment->status == 1){
                $result .='<span class="badge badge-info">For Checking</span>';
            }
            else if($whse_preshipment->status == 2){
                $result .='<span class="badge badge-info">Accepted Waiting for Upload</span>';
            }
          
          
            $result .="</center>";

            return $result;
        })
        ->addColumn('action', function($whse_preshipment) {
            $result = "";


            if($whse_preshipment->status == 1){
                $result .= '<center><button class="btn btn-outline-primary btn-sm btn-whs-view-for-receiving " data-toggle="modal" data-target="#modalViewWhsePreshipmentReceiving" style="width:105px;margin:2%;" preshipment-id="'.$whse_preshipment->id.'"> View</button></center>';
            }
            else if($whse_preshipment->status == 2){
                $result .= '<center><button class="btn btn-outline-primary btn-sm btn-whs-view-for-upload" data-toggle="modal" data-target="#modalViewWhsePreshipmentForUpload" style="width:105px;margin:2%;" preshipment-id="'.$whse_preshipment->id.'"> View</button></center>';
            }
            // else if($whse_preshipment->status == 1){
            //     $result .= '<center><button class="btn btn-outline-success btn-sm btn-openshipment " style="width:105px;margin:2%;" preshipment-id="">Excel</button></center>';
            //     $result .= '<center><button class="btn btn-outline-warning btn-sm btn-openshipment " style="width:105px;margin:2%;" preshipment-id="">Uploaded</button></center>';

            // }

            return $result;

        })
        ->rawColumns(['status','action'])
        ->make(true);

    }

    public function accept_preshipment(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();
        PreshipmentApproving::where('id', $request->accept_preshipment)
        ->update([
            'status' => 2,
            'to_whse_noter' => $_SESSION['rapidx_user_id'],
        ]);



        /*
            code email for ppc to be notify for generation of invoice number
        */

        return response()->json(['result' => 1]);

    }

    public function get_preshipment_by_id_for_receiving(Request $request){
        $approver = PreshipmentApproving::with([
            'from_user_details',
            'from_user_details.rapidx_user_details'
        ])
        ->where('id', $request->preshipment_id)
        ->first();
        
      
        $preshipment_id = Preshipment::where('id', $approver->fk_preshipment_id)->first();


        // $preshipment_list = PreshipmentList::where('fkControlNo',$preshipment_id->id)->get();

        return response()->json(['result' => 1, 'preshipment' => $preshipment_id, 'approver' => $approver]);
    }

    public function get_preshipment_details_for_upload(Request $request){
        $preshipment_approving_details = PreshipmentApproving::with([
            'Preshipment_for_approval',
            'from_user_details',
            'from_user_details.rapidx_user_details'
        ])
        ->where('id', $request->id)
        ->first();

        return response()->json(['approvingDetails' => $preshipment_approving_details]);
    }

    public function get_preshipment_list_for_whse_for_upload(Request $request){

        // return $request->preshipmentCtrlNo;

        $preshipment_list = PreshipmentList::where('fkcontrolNo',$request->preshipmentId)->get();

        return DataTables::of($preshipment_list)
        ->make(true);


    }

    public function get_invoice_ctrl_no_from_rapid(Request $request){
        $approving_details = PreshipmentApproving::with([
            'Preshipment_for_approval'
        ])
        ->where('logdel', 0)
        ->where('id', $request->id)
        ->first();


        $invoice_ctrl_no = RapidShipmentInvoice::where('id_tbl_PreShipment', $approving_details->preshipment_for_approval->rapid_preshipment_id)
        ->where('logdel', 0)
        ->first();
        

        return response()->json(['ctrlNo' => $invoice_ctrl_no]);
        
    }
}
