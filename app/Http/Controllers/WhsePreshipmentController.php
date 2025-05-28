<?php

namespace App\Http\Controllers;

use Mail;
use DataTables;
use App\Model\UserAccess;
use App\Model\Destination;



use App\Model\RapidStamping;
// use App\Model\Preshipment;
use Illuminate\Http\Request;
use App\Model\SubsystemWbsCN;
use App\Model\SubsystemWbsTS;
use App\Model\PreshipmentList;
use App\Model\RapidPreshipment;
use App\Model\SubsystemWbsLocalCN;
use App\Model\SubsystemWbsLocalTS;
use Illuminate\Support\Facades\DB;
use App\Model\PreshipmentApproving;
use App\Model\RapidPreshipmentList;
use App\Model\RapidShipmentInvoice;


use App\Model\WhsePreshipmentCheck;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class WhsePreshipmentController extends Controller
{
    public function get_preshipment_for_whse(){
        $whse_preshipment = PreshipmentApproving::with([
            // 'Preshipment_for_approval',
            'preshipment'
        ])
        ->where('logdel', 0)
        ->whereIn('status', [0])
        ->whereNotIn('status', [5])
        ->orderBy('fk_preshipment_id', 'DESC')
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
            $result = "<center>";
            // $result .= '<center><button class="btn btn-primary btn-sm btn-openshipment"  data-toggle="modal" data-target="#modalViewMaterialHandlerChecksheets" checksheet-id="'.$preshipment->Packing_List_CtrlNo.'"><i class="fas fa-eye"></i></button></center>';
            // $result .= $preshipment->Packing_List_CtrlNo;

            // return $result;
            // <button type="button" class="btn btn-outline-dark btn-sm fa fa-edit text-center actionEditCashAdvance" style="width:105px;margin:2%;" cash_advance-id="3" data-toggle="modal" data-target="#modalEditCashAdvance" data-keyboard="false"> Edit</button>
            $result .= '<button class="btn btn-primary btn-sm btn-whs-view mr-1" data-toggle="modal" data-target="#modalViewWhsePreshipment" preshipment-id="'.$whse_preshipment->preshipment->id.'"><i class="fas fa-eye"></i></button>';

            if($whse_preshipment->status == 0){
                $result .= '<button class="btn btn-success btn-sm btn-approve-whse mr-1"  data-toggle="modal" data-target="#modalWhsApprove" preshipment-id="'.$whse_preshipment->preshipment->id.'"><i class="fas fa-check-circle"></i></button>';
                $result .= '<button class="btn btn-danger btn-sm btn-disapprove-whse" data-toggle="modal" data-target="#modalWhsDisapprove" preshipment-id="'.$whse_preshipment->id.'"><i class="fas fa-times-circle"></i></button>';
            }
            // else if($whse_preshipment->status == 1){
            //     $result .= '<center><button class="btn btn-outline-success btn-sm btn-openshipment " style="width:105px;margin:2%;" preshipment-id="">Excel</button></center>';
            //     $result .= '<center><button class="btn btn-outline-warning btn-sm btn-openshipment " style="width:105px;margin:2%;" preshipment-id="">Uploaded</button></center>';

            // }
            $result .= "</center>";
            return $result;

        })
        ->rawColumns(['status','action'])
        ->make(true);

    }

    public function get_preshipment_by_id_for_whse(Request $request){

        // $approver = PreshipmentApproving::with([
        //     'from_user_details',
        //     'from_user_details.rapidx_user_details'
        // ])
        // ->where('id', $request->preshipment_id)
        // ->first();


        // $preshipment_id = Preshipment::where('id', $approver->fk_preshipment_id)->first();


        // $preshipment_list = PreshipmentList::where('fkControlNo',$preshipment_id->id)->get();

        $preshipment = RapidPreshipment::where('id', $request->preshipment_id)
        ->where('logdel', 0)
        ->first();

        $preshipment_list = PreshipmentList::where('fkControlNo',$preshipment['Packing_List_CtrlNo'])
        ->where('logdel', 0)
        ->get();



        return response()->json(['result' => 1, 'preshipment' => $preshipment, 'preshipmentList' => $preshipment_list]);
        // return response()->json(['result' => 1, 'preshipment' => $preshipment_id, 'approver' => $approver]);
    }



    public function get_preshipment_by_id_for_approval_whse(Request $request){
        $preshipment_details = PreshipmentApproving::with([
            // 'Preshipment_for_approval',
            'preshipment',
            'qc_approver_details',
            'qc_approver_details.rapidx_user_details'
        ])
        ->where('fk_preshipment_id', $request->preshipmentId)
        ->where('logdel', 0)
        ->first();

        $destination = Destination::where('destination_name', $preshipment_details->preshipment->Destination)
        ->whereNull('deleted_at')
        ->first();

        return response()->json(['result' => $preshipment_details, 'destination' => $destination]);
    }


    // Sending of PPS-warehouse to TS/CN Warehouse
    public function send_preshipment_from_whse_to_whse(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        $update_array = array(
            // 'status' => 1,
            'send_to' => $request->accept_shipment_send_to,
            'from_whse_noter' => $_SESSION['rapidx_user_id'],
            'from_whse_noter_date_time' => NOW()
        );

        if($request->accept_shipment_send_to == 'pps-cn'){
            $update_array['status'] = 6;
        }
        else{
            $update_array['status'] = 1;

        }

        PreshipmentApproving::where('id', $request->preshipment_approval_id)
        // ->update([
        //     'status' => 1,
        //     'send_to' => $request->accept_shipment_send_to,
        //     'from_whse_noter' => $_SESSION['rapidx_user_id'],
        //     'from_whse_noter_date_time' => NOW()
        // ]);
        ->update($update_array);

        $preshipment_details = PreshipmentApproving::with([
            'preshipment'
        ])
        ->where('id', $request->preshipment_approval_id)
        ->where('logdel', 0)
        ->first();

        $department = "";
        if($request->accept_shipment_send_to == 'ts'){
            $department = "TS WHSE";
        }
        if($request->accept_shipment_send_to == 'cn'){
            $department = "CN WHSE";
        }
        if($request->accept_shipment_send_to == 'pps-cn'){
            $department = "PPS-CN WHSE";
        }

        $get_to_emails = UserAccess::where('department', $department)
        ->where('logdel',0)
        ->get();

        $get_cc_emails = UserAccess::where('department', 'PPS WHSE')
        ->where('logdel',0)
        ->get();

        $to_email = array();
        $cc_email = array();

        foreach($get_to_emails as $get_to_email){
            $to_email[] = $get_to_email->email;
        }
        foreach($get_cc_emails as $get_cc_email){
            $cc_email[] = $get_cc_email->email;
        }


        $packing_ctrl_num = $preshipment_details->preshipment->Destination."-".$preshipment_details->preshipment->Packing_List_CtrlNo;
        $product_line_details = strtoupper($request->accept_shipment_send_to);


        $data = array('data' => $preshipment_details, 'product_line' => $product_line_details);


        // $to_email = ['cbretusto@pricon.ph'];
        // $cc_email = ['cpagtalunan@pricon.ph'];


        Mail::send('mail.from_whse_notification', $data, function($message) use ($to_email,$cc_email,$packing_ctrl_num,$product_line_details){
            $message->to($to_email);
            $message->cc($cc_email);
            // $message->bcc('cpagtalunan@pricon.ph');
            $message->bcc('cbretusto@pricon.ph');

            $message->subject("Online Preshipment for ".$product_line_details."-WHSE Acceptance-".$packing_ctrl_num);
        });

        // if (Mail::failures()) {
            // return response()->json(['result' => 0]);
        // }
        // else{
            return response()->json(['result' => 1]);
        // }

        // return response()->json(['result' => 1]);
        // return $data;
    }



    public function get_preshipment_for_ts_cn_whse(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();
        // $sendto_filter = "";

        $user_details = UserAccess::with([
            'rapidx_user_details'
        ])
        ->where('rapidx_id',$_SESSION['rapidx_user_id'])
        ->where('logdel',0)
        ->get();

        // return $user_details;
        $send_to = "";
        if($user_details[0]->department == "TS WHSE"){
            $send_to = "ts";
            // array_push($dept_array,'ts');
            // $whse_preshipment = collect($whse_preshipment)->where('send_to', 'ts');
        }
        else if($user_details[0]->department == "CN WHSE"){
            $send_to = "cn";
            // array_push($dept_array,'cn');
            // $whse_preshipment = collect($whse_preshipment)->where('send_to', 'cn');
        }
        else{
            $send_to = "";
        }

        $whse_preshipment = PreshipmentApproving::with([
            // 'Preshipment_for_approval'
            'preshipment'
        ])
        // ->whereIn('status', [1,2,3,4])
        ->whereIn('status', [1,2,3]) //change 07/13/2022
        ->orderBy('fk_preshipment_id', 'ASC')
        ->where('send_to', 'LIKE', "%$send_to%")
        ->where('logdel', 0)
        ->get();



        // if($user_details->department == "TS WHSE"){
        //     // return "ts";
        //     $whse_preshipment = collect($whse_preshipment)->where('send_to', 'ts');
        // }
        // else if($user_details->department == "CN WHSE"){
        //     // return "cn";
        //     $whse_preshipment = collect($whse_preshipment)->where('send_to', 'cn');
        // }

        $dept_array = array();
        if(count($user_details) > 1){
            for($x = 0; $x<count($user_details);$x++){
                if($user_details[$x]->department == "TS WHSE"){
                    // return "ts";
                    array_push($dept_array,'ts');
                }
                if($user_details[$x]->department == "CN WHSE"){
                    // return "cn";
                    array_push($dept_array,'cn');
                }
                else{
                    $dept_array = array('ts', 'cn');
                }
            }
            $whse_preshipment = collect($whse_preshipment)->whereIn('send_to', $dept_array);
        }
        else{
            if($user_details[0]->department == "TS WHSE"){
                // return "ts";
                // array_push($dept_array,'ts');
                $whse_preshipment = collect($whse_preshipment)->where('send_to', 'ts');
            }
            if($user_details[0]->department == "CN WHSE"){
                // return "cn";
                // array_push($dept_array,'cn');
                $whse_preshipment = collect($whse_preshipment)->where('send_to', 'cn');
            }
        }



        // return $dept_array;


        return DataTables::of($whse_preshipment)
        ->addColumn('preshipment_ctrl_num', function($whse_preshipment){
            $result ="";
            $result .= $whse_preshipment->preshipment->Destination."-".$whse_preshipment->preshipment->Packing_List_CtrlNo;
            return $result;
        })
        ->addColumn('rapid_invoice_num', function($whse_preshipment){
            $result = "";
            if($whse_preshipment->status == 3){
                $result = $whse_preshipment->rapid_invoice_number;
            }
            return $result;
        })
        ->addColumn('status', function($whse_preshipment){
            $result = "<center>";

            if($whse_preshipment->status == 1){
                $result .='<span class="badge badge-warning">For Checking</span>';
            }
            else if($whse_preshipment->status == 2){
                $result .='<span class="badge badge-info">Accepted Waiting for Upload</span>';
            }

            else if($whse_preshipment->status == 3){
                $result .='<span class="badge badge-info">For Supervisor approval</span>';
            }
            else if($whse_preshipment->status == 4){
                $result .='<span class="badge badge-success"> Done </span>';
            }

            if($whse_preshipment->remarks != null){
                $result .= '<br><strong>Remarks:</strong><br>'.$whse_preshipment->remarks;
            }


            $result .="</center>";

            return $result;
        })
        ->addColumn('action', function($whse_preshipment) use ($user_details) {
            $result = "<center>";

            if($whse_preshipment->status == 1){
                $result .= '<button class="btn btn-primary mr-1 btn-sm btn-whs-view-for-receiving " data-toggle="modal" data-target="#modalViewWhsePreshipmentReceiving" preshipment-id="'.$whse_preshipment->id.'"> <i class="fa fa-eye"></i></button>';
            }
            else if($whse_preshipment->status == 2){
                $result .= '<button class="btn btn-primary mr-1 btn-sm btn-whs-view-for-upload" data-toggle="modal" data-target="#modalViewWhsePreshipmentForUpload"  preshipment-id="'.$whse_preshipment->id.'">  <i class="fa fa-eye"></i></button>';
            }
            else{
                $result .= '<button class="btn btn-primary mr-1 btn-sm btn-whs-view" data-toggle="modal" data-target="#modalViewPreshipmentOnly"  preshipment-id="'.$whse_preshipment->id.'">  <i class="fa fa-eye"></i></button>';

            }

            // else if($whse_preshipment->status == 3 && $user_details->approver == 1){
            //     $result .= '<button class="btn btn-primary mr-1 btn-sm btn-whs-view-for-superior-approval" data-toggle="modal" data-target="#modalViewWhsePreshipmentForSupApproval"  preshipment-id="'.$whse_preshipment->id.'">  <i class="fa fa-eye"></i></button>';
            // }
            // else{
            //     // $result .= '<button class="btn btn-primary mr-1 btn-sm  preshipment-id="'.$whse_preshipment->id.'"> View</button>';
            //     $result .= '<button class="btn btn-primary mr-1 btn-sm btn-whs-view" data-toggle="modal" data-target="#modalViewPreshipmentOnly"  preshipment-id="'.$whse_preshipment->id.'">  <i class="fa fa-eye"></i></button>';
            // }


            if($whse_preshipment->status != 1){
                $result .= '<div class="btn-group">
                <button type="button" class="btn btn-secondary mr-1 dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Action">
                <i class="fas fa-lg fa-file-download"></i>
                </button>';
                    $result .= '<div class="dropdown-menu dropdown-menu-right">'; // dropdown-menu start

                    $result .='<a class="dropdown-item text-center" href="export_excel/'.$whse_preshipment->id.'" target="_blank">Export Excel</a>';
                    $result .='<a class="dropdown-item text-center" href="pdf_export/'.$whse_preshipment->id.'" target="_blank">Export PDF</a>';

                    $result .= '</div>'; // dropdown-menu end
                $result .= '</div>';
            }



            if($whse_preshipment->remarks != null){
                $result .= '<button class="btn btn-danger btn-sm btn-whse-reject" preshipment-id="'.$whse_preshipment->id.'" data-toggle="modal" data-target="#modalRejectId"><i class="fas fa-times-circle"></i></button>';
            }
            $result .='</center>';

            return $result;

        })
        ->rawColumns(['status','action','preshipment_ctrl_num', 'rapid_invoice_num'])
        ->make(true);

    }

    // Function for accepting of preshipment on TS/CN warehouse
    public function accept_preshipment(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();
        // Start for preshipment list PO is TS-WHSE and CN-WHSE

        $get_preshipment = PreshipmentApproving::with([
            'preshipment'
        ])
        ->where('id', $request->accept_preshipment)
        ->first();

        $getList= RapidPreshipmentList::where('fkControlNo',$get_preshipment->preshipment->Packing_List_CtrlNo)
        ->where('logdel', 0)
        ->get();

        $ctrlNo =  $getList[0]->fkControlNo;

        // return $getList;
        foreach($getList as $PO){
            $LastPONO = $PO->PONo;
        }

        $LastPONO 		= $LastPONO[0].$LastPONO[1];	//Check the OrderNo first 2 index.
        /*
            * This will identify PO No. of preshipment list if its CN-WHSE-*** or TS-WHSE-*** or WHSE-****
        */
        $internal_invoice_check = array("TS","WH","CN", "F3");

        $array_database_val = array(
            'to_whse_noter' => $_SESSION['rapidx_user_id'],
            'to_whse_noter_date_time' => NOW(),
            'is_invalid' => '0'
        );

        if( in_array($LastPONO,$internal_invoice_check) ){
            $array_database_val['status'] = 3;
        }
        else{
            $array_database_val['status'] = 2;
        }

        // END

        PreshipmentApproving::where('id', $request->accept_preshipment)
        ->update(
            // 'status' => 2,
            // 'to_whse_noter' => $_SESSION['rapidx_user_id'],
            // 'to_whse_noter_date_time' => NOW(),
            $array_database_val
        );


        $preshipment_details = PreshipmentApproving::with([
            'preshipment'
        ])
        ->where('id', $request->accept_preshipment)
        ->where('logdel', 0)
        ->first();

        $packing_ctrl_num = $preshipment_details->preshipment->Destination."-".$preshipment_details->preshipment->Packing_List_CtrlNo;
        $product_line = strtoupper($preshipment_details->send_to);


        $data = array('data' => $preshipment_details, 'product_line'=>$product_line);
        // return $data;


        $department = "";
        if($preshipment_details->send_to == 'ts'){
            $department = "TS WHSE";
        }
        if($preshipment_details->send_to == 'cn'){
            $department = "CN WHSE";
        }

        $get_to_emails = UserAccess::where('department', 'material handler')
        ->where('logdel', 0)
        ->get();

        $get_cc_emails = UserAccess::where('department', $department)
        ->where('logdel', 0)
        ->get();

        $to_email = array();
        $cc_email = array();

        foreach($get_to_emails as $get_to_email){
            $to_email[] = $get_to_email->email;
        }
        foreach($get_cc_emails as $get_cc_email){
            $cc_email[] = $get_cc_email->email;
        }

        // $to_email = ['cbretusto@pricon.ph'];
        // $cc_email = ['cpagtalunan@pricon.ph'];


        Mail::send('mail.receiver_whse_notification', $data, function($message) use ($to_email,$cc_email,$packing_ctrl_num,$product_line){
            $message->to($to_email);
            $message->cc($cc_email);
            // $message->bcc('cpagtalunan@pricon.ph');
            $message->bcc('cbretusto@pricon.ph');

            $message->subject("Online Preshipment for Material Handler Invoice-".$packing_ctrl_num);
        });

        // if (Mail::failures()) {
        //     return response()->json(['result' => 0]);
        // }
        // else{
            return response()->json(['result' => 1]);
        // }


        /*
            code email for ppc to be notify for generation of invoice number
        */

        // return response()->json(['result' => 1]);

    }

    public function get_preshipment_by_id_for_receiving(Request $request){
        $preshipment_details = PreshipmentApproving::with([
            'preshipment',
            'from_user_details',
            'from_user_details.rapidx_user_details'
        ])
        ->where('id', $request->preshipment_id)
        ->first();

        $preshipment = RapidPreshipment::where('id',$preshipment_details->fk_preshipment_id)
        ->first();

        $preshipment_list = WhsePreshipmentCheck::where('fkControlNo',$preshipment->Packing_List_CtrlNo)
        ->where('logdel', 0)
        ->get();

        // return $preshipment_list;

        // $preshipment_id = Preshipment::where('id', $approver->fk_preshipment_id)->first();


        // $preshipment_list = PreshipmentList::where('fkControlNo',$preshipment_id->id)->get();

        return response()->json(['result' => 1, 'preshipmentDetails' => $preshipment_details,'preshipmentList' => $preshipment_list]);
    }

    public function get_preshipment_details_for_upload(Request $request){

        $preshipment_approving_details = PreshipmentApproving::with([
            // 'Preshipment_for_approval',
            'preshipment',
            'from_user_details',
            'from_user_details.rapidx_user_details'
        ])
        ->where('id', $request->id)
        ->first();

        $preshipment_list_total_qty = RapidPreshipmentList::where('fkControlNo',$preshipment_approving_details->preshipment->Packing_List_CtrlNo)
        ->where('logdel',0)
        ->sum('Qty');
        // return $preshipment_approving_details;

        return response()->json(['approvingDetails' => $preshipment_approving_details , 'preshipment_total' => $preshipment_list_total_qty]);
    }

    public function get_preshipment_list_for_whse_for_upload(Request $request){

        // return $request->preshipmentCtrlNo;

        $preshipment_list = RapidPreshipmentList::where('fkcontrolNo',$request->preshipmentId)
        ->where('logdel', 0)
        ->get();

        return DataTables::of($preshipment_list)
        ->make(true);


    }

    public function get_invoice_ctrl_no_from_rapid(Request $request){
        $approving_details = PreshipmentApproving::with([
            // 'Preshipment_for_approval'
            'preshipment'
        ])
        ->where('logdel', 0)
        ->where('id', $request->id)
        ->first();


        $invoice_ctrl_no = RapidShipmentInvoice::where('id_tbl_PreShipment', $approving_details->fk_preshipment_id)
        ->where('logdel', 0)
        ->first();

        // return $invoice_ctrl_no;


        return response()->json(['ctrlNo' => $invoice_ctrl_no, 'approvingDetails' => $approving_details]);

    }
    //Function of TS/CN Warehouse for done uploading
    public function done_upload_preshipment(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        PreshipmentApproving::where('id', $request->done_upload_id)
        ->update([
            'status'               => 3,
            'whse_uploader'        => $_SESSION['rapidx_user_id'],
            'whse_uploader_date_time' => NOW(),
            'rapid_invoice_number'       => $request->done_upload_invoice_number,
            'wbs_receiving_number' => $request->done_upload_receiving_number,
            'remarks'              => null,
        ]);


        $preshipment_details = PreshipmentApproving::with([
            'preshipment'
        ])
        ->where('id', $request->done_upload_id)
        ->where('logdel', 0)
        ->first();


        $packing_ctrl_num = $preshipment_details->preshipment->Destination."-".$preshipment_details->preshipment->Packing_List_CtrlNo;
        $product_line_details = strtoupper($preshipment_details->send_to);
        // return $product_line_details;

        $data = array('data' => $preshipment_details, 'product_line' => $product_line_details);

        $department = "";
        if($preshipment_details->send_to == 'ts'){
            $department = "TS WHSE";
        }
        if($preshipment_details->send_to == 'cn'){
            $department = "CN WHSE";
        }

        $get_to_emails = UserAccess::where('department', $department)
        ->where('approver', 1)
        ->where('logdel', 0)
        ->get();

        $get_cc_emails = UserAccess::where('department', $department)
        ->where('logdel', 0)
        ->get();

        $to_email = array();
        $cc_email = array();

        foreach($get_to_emails as $get_to_email){
            $to_email[] = $get_to_email->email;
        }
        foreach($get_cc_emails as $get_cc_email){
            $cc_email[] = $get_cc_email->email;
        }

        // $to_email = ['cbretusto@pricon.ph'];
        // $cc_email = ['cpagtalunan@pricon.ph'];


        Mail::send('mail.done_upload_notification', $data, function($message) use ($to_email,$cc_email,$packing_ctrl_num,$product_line_details){
            $message->to($to_email);
            $message->cc($cc_email);
            // $message->bcc('cpagtalunan@pricon.ph');
            $message->bcc('mrronquez@pricon.ph');
            $message->bcc('cbretusto@pricon.ph');

            $message->subject("Online Preshipment for Superior's Approval-".$packing_ctrl_num);
        });

        // if (Mail::failures()) {
        //     return response()->json(['result' => 0]);
        // }
        // else{
            return response()->json(['result' => 1]);
        // }

        // return response()->json(['result' => 1]);
    }

    public function get_preshipment_details_for_superior(Request $request){
        $tbl_approving_details = PreshipmentApproving::with([
            // 'Preshipment_for_approval',
            'preshipment',
            'from_user_details',
            'from_user_details.rapidx_user_details',

            'to_whse_noter_details',
            'to_whse_noter_details.rapidx_user_details',

            'whse_uploader_details',
            'whse_uploader_details.rapidx_user_details',

            // 'whse_superior_details'
        ])
        ->where('id', $request->id)
        ->get();


        $preshipment_list_total_qty = RapidPreshipmentList::where('fkControlNo',$tbl_approving_details[0]->preshipment->Packing_List_CtrlNo)
        ->where('logdel',0)
        ->sum('Qty');

        return response()->json(['approvingDetails' => $tbl_approving_details, 'totalQty' => $preshipment_list_total_qty]);

    }

    public function get_preshipment_list_for_whse_superior(Request $request){
        $preshipment_list = RapidPreshipmentList::where('fkcontrolNo',$request->preshipmentId)
        ->where('logdel',0)
        ->get();

        return DataTables::of($preshipment_list)
        ->make(true);

    }

    public function get_wbs_receiving_number(Request $request){
        // SubsystemWbsCN
        // SubsystemWbsTS
        if($request->product_line == 'cn'){
            $receiving_number = SubsystemWbsCN::where('invoice_no', $request->ctrl_number)->where('status', '!=', 'C')->first('receive_no');
        }
        else if($request->product_line == 'ts'){
            $receiving_number = SubsystemWbsTS::where('invoice_no', $request->ctrl_number)->where('status', '!=', 'C')->first('receive_no');
        }
        else{
            $receiving_number = "";
        }

        return response()->json(['invoiceNumber' => $receiving_number]);


    }

    public function get_wbs_local_receiving_number(Request $request){
        // return $request->invoice_number;
        // $receiving_local_number = SubsystemWbsLocalTS::where('invoice_no',"GRINDING-2205-78")->get();
        if($request->product_line == 'cn'){
        //     // $receiving_local_number = SubsystemWbsLocalCN::;
            $receiving_local_number = SubsystemWbsLocalCN::where('invoice_no', $request->invoice_number)->first('receive_no');
        }
        else if($request->product_line == 'ts'){
            $receiving_local_number = SubsystemWbsLocalTS::where('invoice_no', $request->invoice_number)->first('receive_no');
        }
        else{
            $receiving_local_number = "";
        }

        return response()->json(['wbsReceivingNo' => $receiving_local_number]);

    }
    public function superior_approval(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        PreshipmentApproving::where('id', $request->superior_approving_tbl_id)
        ->update([
            'status'              => 4,
            'whse_superior_noter' => $_SESSION['rapidx_user_id'],
            'whse_superior_noter_date_time' => NOW(),
        ]);

        $preshipment_details = PreshipmentApproving::with([
            'preshipment'
        ])
        ->where('id', $request->superior_approving_tbl_id)
        ->where('logdel', 0)
        ->first();


        $packing_ctrl_num = $preshipment_details->preshipment->Destination."-".$preshipment_details->preshipment->Packing_List_CtrlNo;
        $product_line_details = strtoupper($preshipment_details->send_to);


        $data = array('data' => $preshipment_details, 'product_line' => $product_line_details);



        $department = "";
        if($preshipment_details->send_to == 'ts'){
            $department = "TS WHSE";
        }
        if($preshipment_details->send_to == 'cn'){
            $department = "CN WHSE";
        }

        $get_to_emails = UserAccess::where('department', 'material handler')
        ->where('logdel', 0)
        ->get();

        $get_cc_emails = UserAccess::where('department', $department)
        ->where('approver', 1)
        ->where('logdel', 0)
        ->get();

        $to_email = array();
        $cc_email = array();

        foreach($get_to_emails as $get_to_email){
            $to_email[] = $get_to_email->email;
        }
        foreach($get_cc_emails as $get_cc_email){
            $cc_email[] = $get_cc_email->email;
        }

        // $to_email = ['cbretusto@pricon.ph'];
        // $cc_email = ['cpagtalunan@pricon.ph'];


        Mail::send('mail.superior_notification', $data, function($message) use ($to_email,$cc_email,$packing_ctrl_num,$product_line_details){
            $message->to($to_email);
            $message->cc($cc_email);
            // $message->bcc('cpagtalunan@pricon.ph');
            $message->bcc('mrronquez@pricon.ph');
            $message->bcc('cbretusto@pricon.ph');

            $message->subject("Online Preshipment ".$product_line_details."-WHSE Superior Approval-".$packing_ctrl_num);
        });

        // if (Mail::failures()) {
            // return response()->json(['result' => 0]);
        // }
        // else{
            return response()->json(['result' => 1]);
        // }

        // return response()->json(['result' => 1]);

    }

    public function superior_disapproval(Request $request){
        $data = $request->all();

        // return $data;

        PreshipmentApproving::where('id', $request->superior_disapproving_tbl_id)
        ->where('logdel',0)
        ->update([
            'status' => 2,
            'remarks' => $request->remarks_superior_dis
        ]);



        $get_preshipment_fk_id = PreshipmentApproving::with([
            'preshipment',
        ])
        ->where('id',$request->superior_disapproving_tbl_id)
        ->where('logdel',0)
        ->first();

        if($get_preshipment_fk_id->send_to == 'cn'){
            $department = "CN WHSE";
        }
        else{
            $department = "TS WHSE";
        }
        //Start Email
        $get_to_emails = UserAccess::where('department', $department)
        ->where('logdel', 0)
        ->get();

        // $get_cc_emails = UserAccess::where('department', 'PPS WHSE')
        // ->where('logdel', 0)
        // ->get();

        $to_email = array();
        // $cc_email = array();

        foreach($get_to_emails as $get_to_email){
            $to_email[] = $get_to_email->email;
        }
        // foreach($get_cc_emails as $get_cc_email){
        //     $cc_email[] = $get_cc_email->email;
        // }

        // // // // $to_email = ['cbretusto@pricon.ph'];
        // // // // $cc_email = ['cpagtalunan@pricon.ph'];
        $preshipment_details = RapidPreshipment::where('Packing_List_CtrlNo', $get_preshipment_fk_id->preshipment->Packing_List_CtrlNo)
        ->where('logdel', 0)
        ->first();



        // return $preshipment_details;
        $packing_ctrl_num = $get_preshipment_fk_id->preshipment->Destination."-".$get_preshipment_fk_id->preshipment->Packing_List_CtrlNo;

        $data = array('data' => $preshipment_details,'remarks' => $request->pps_disapprove_remarks, 'position' => $department);


        Mail::send('mail.disapprove_mail', $data, function($message) use ($to_email,$packing_ctrl_num){
            $message->to($to_email);
            // $message->cc($cc_email);
            // $message->bcc('cpagtalunan@pricon.ph');
            $message->bcc('mrronquez@pricon.ph');
            $message->bcc('cbretusto@pricon.ph');

            $message->subject("Online Preshipment Supervisor Disapprove-".$packing_ctrl_num);
        });



        return response()->json(['result' => 1]);








        // $get_ctrl_num = PreshipmentApproving::where('id',$request->superior_disapproving_tbl_id)
        // ->first('fk_preshipment_id');

        // return $get_ctrl_num;
        // RapidPreshipment::where('id',$get_ctrl_num['fk_preshipment_id'])
        // ->update('')

        // return $rapid_preshipment;

    }

    public function get_preshipment_for_whse_view(Request $request){
        $preshipment = PreshipmentApproving::with([
            // 'Preshipment_for_approval'
            'preshipment'
        ])
        ->where('id', $request->id)
        ->where('logdel',0)
        ->first();


        return response()->json(['result' => $preshipment]);
    }

    public function get_preshipmentlist_for_view(Request $request){
        $preshipment_list = RapidPreshipmentList::where('fkcontrolNo',$request->preshipmentId)
        ->where('logdel',0)
        ->get();

        return DataTables::of($preshipment_list)
        ->make(true);

    }

    public function get_preshipment_of_ts_cn_for_approval(){
        date_default_timezone_set('Asia/Manila');
        session_start();


        $user_details = UserAccess::with([
            'rapidx_user_details'
        ])
        ->where('rapidx_id',$_SESSION['rapidx_user_id'])
        ->where('logdel',0)
        ->get();

        $send_to = "";

        if($user_details[0]->department == "TS WHSE"){
            $send_to = "ts";
            // array_push($dept_array,'ts');
            // $whse_preshipment = collect($whse_preshipment)->where('send_to', 'ts');
        }
        else if($user_details[0]->department == "CN WHSE"){
            $send_to = "cn";
            // array_push($dept_array,'cn');
            // $whse_preshipment = collect($whse_preshipment)->where('send_to', 'cn');
        }
        else{
            $send_to = "";
        }
        $whse_preshipment = PreshipmentApproving::with([
            // 'Preshipment_for_approval'
            'preshipment',
        ])
        ->whereIn('status', [3])
        ->orderBy('id', 'ASC')
        ->where('send_to',"LIKE", "%$send_to%")
        ->where('logdel', 0)
        ->get();


        // if($user_details->department == "TS WHSE"){
        //     // return "ts";
        //     $whse_preshipment = collect($whse_preshipment)->where('send_to', 'ts');
        // }
        // else if($user_details->department == "CN WHSE"){
        //     // return "cn";
        //     $whse_preshipment = collect($whse_preshipment)->where('send_to', 'cn');
        // }


        // $dept_array = array();
        // if(count($user_details) > 1){
        //     for($x = 0; $x<count($user_details);$x++){
        //         if($user_details[$x]->department == "TS WHSE"){
        //             // return "ts";
        //             array_push($dept_array,'ts');
        //             // $whse_preshipment = collect($whse_preshipment)->where('send_to', 'ts');
        //         }
        //         if($user_details[$x]->department == "CN WHSE"){
        //             // return "cn";
        //             array_push($dept_array,'cn');
        //             // $whse_preshipment = collect($whse_preshipment)->where('send_to', 'cn');
        //         }
        //     }

        //     $whse_preshipment = collect($whse_preshipment)->whereIn('send_to', $dept_array);
        // }
        // else{
        //     if($user_details[0]->department == "TS WHSE"){
        //         // return "ts";
        //         // array_push($dept_array,'ts');
        //         $whse_preshipment = collect($whse_preshipment)->where('send_to', 'ts');
        //     }
        //     if($user_details[0]->department == "CN WHSE"){
        //         // return "cn";
        //         // array_push($dept_array,'cn');
        //         $whse_preshipment = collect($whse_preshipment)->where('send_to', 'cn');
        //     }
        // }

        // return $dept_array;

        return DataTables::of($whse_preshipment)
        ->addColumn('preshipment_ctrl_num', function($whse_preshipment){
            $result = "";
            $result .= $whse_preshipment->preshipment->Destination."-".$whse_preshipment->preshipment->Packing_List_CtrlNo;
            return $result;
        })
        ->addColumn('status', function($whse_preshipment){
            $result = "";

                if($whse_preshipment->status == 3){
                    $result .='<center><span class="badge badge-warning">For Approval</span></center>';
                }
            return $result;
        })
        ->addColumn('action', function($whse_preshipment){
            $result = "<center>";

            // $result .= '<button class="btn btn-primary mr-1 btn-sm btn-whs-sup-approval" data-toggle="modal" data-target="#modalViewWhsePreshipmentForSupApproval"  preshipment-id="'.$whse_preshipment->id.'">  <i class="fa fa-eye"></i></button>';
            $result .= '<button class="btn btn-primary mr-1 btn-sm btn-whs-view-for-superior-approval" data-toggle="modal" data-target="#modalViewWhsePreshipmentForSupApproval"  preshipment-id="'.$whse_preshipment->id.'">  <i class="fa fa-eye"></i></button>';
            $result .= "</center>";

            return $result;
        })

        ->rawColumns(['status','action','preshipment_ctrl_num'])
        ->make(true);

    }

    public function pps_disapprove_preshipment(Request $request){

        $data = $request->all();

        // return $data;

        $get_preshipment_fk_id = PreshipmentApproving::with([
            'preshipment'
        ])
        ->where('id', $request->disapprove_preshipment)->first();

        RapidPreshipment::where('id', $get_preshipment_fk_id->fk_preshipment_id)
        ->update([
            'to_edit' => 1,
            'remarks' => $request->pps_disapprove_remarks,
            'has_invalid' => 0
        ]);

        PreshipmentApproving::where('id', $request->disapprove_preshipment)
        ->update([
            'logdel' => 1,
            'remarks' => $request->pps_disapprove_remarks
        ]);

        //Start Email
        $get_to_emails = UserAccess::where('department', 'material handler')
        ->where('logdel', 0)
        ->get();

        $get_cc_emails = UserAccess::where('department', 'PPS WHSE')
        ->where('logdel', 0)
        ->get();

        $to_email = array();
        $cc_email = array();

        foreach($get_to_emails as $get_to_email){
            $to_email[] = $get_to_email->email;
        }
        foreach($get_cc_emails as $get_cc_email){
            $cc_email[] = $get_cc_email->email;
        }

        // // // $to_email = ['cbretusto@pricon.ph'];
        // // // $cc_email = ['cpagtalunan@pricon.ph'];
        $preshipment_details = RapidPreshipment::where('Packing_List_CtrlNo', $get_preshipment_fk_id->preshipment->Packing_List_CtrlNo)
        ->where('logdel', 0)
        ->first();

        $packing_ctrl_num = $get_preshipment_fk_id->preshipment->Destination."-".$get_preshipment_fk_id->preshipment->Packing_List_CtrlNo;
        // return $packing_ctrl_num;

        $data = array('data' => $preshipment_details,'remarks' => $request->pps_disapprove_remarks, 'position' => "PPS WHSE");


        Mail::send('mail.disapprove_mail', $data, function($message) use ($to_email,$cc_email,$packing_ctrl_num){
            $message->to($to_email);
            $message->cc($cc_email);
            // $message->bcc('cpagtalunan@pricon.ph');
            $message->bcc('mrronquez@pricon.ph');
            $message->bcc('cbretusto@pricon.ph');

            $message->subject("Online Preshipment PPS WHSE Disapprove-".$packing_ctrl_num);
        });


        return response()->json(['result' => 1]);

    }

    public function whse_reject_preshipment(Request $request){
        $data = $request->all();


        $get_preshipment_fk_id = PreshipmentApproving::where('id', $request->reject_preshipment)->first();

        // return $get_preshipment_fk_id;
        RapidPreshipment::where('id', $get_preshipment_fk_id->fk_preshipment_id)
        ->update([
            'to_edit' => 1,
            'remarks' => $request->reject_remarks_preshipment
        ]);

        PreshipmentApproving::where('id', $request->reject_preshipment)
        ->update([
            'logdel' => 1,
            'remarks' => $request->reject_remarks_preshipment,
        ]);
        if($get_preshipment_fk_id == 'cn'){
            $department = "CN WHSE";
        }
        else{
            $department = "TS WHSE";
        }



        //Start Email
        $get_to_emails = UserAccess::where('department', 'material handler')
        ->where('logdel', 0)
        ->get();

        $get_cc_emails = UserAccess::where('department', $department)
        ->where('logdel', 0)
        ->get();

        $to_email = array();
        $cc_email = array();

        foreach($get_to_emails as $get_to_email){
            $to_email[] = $get_to_email->email;
        }
        foreach($get_cc_emails as $get_cc_email){
            $cc_email[] = $get_cc_email->email;
        }

        // // // $to_email = ['cbretusto@pricon.ph'];
        // // // $cc_email = ['cpagtalunan@pricon.ph'];
        $preshipment_details = RapidPreshipment::where('Packing_List_CtrlNo', $get_preshipment_fk_id->preshipment->Packing_List_CtrlNo)
        ->where('logdel', 0)
        ->first();

        $packing_ctrl_num = $get_preshipment_fk_id->preshipment->Destination."-".$get_preshipment_fk_id->preshipment->Packing_List_CtrlNo;
        // return $packing_ctrl_num;

        $data = array('data' => $preshipment_details,'remarks' => $request->pps_disapprove_remarks, 'position' => $department);


        Mail::send('mail.disapprove_mail', $data, function($message) use ($to_email,$cc_email,$packing_ctrl_num,$department){
            $message->to($to_email);
            $message->cc($cc_email);
            // $message->bcc('cpagtalunan@pricon.ph');
            $message->bcc('mrronquez@pricon.ph');
            $message->bcc('cbretusto@pricon.ph');

            $message->subject("Online Preshipment ".$department." Disapprove-".$packing_ctrl_num);
        });


        return response()->json(['result' => 1]);
    }

    public function insert_preshipmentlist_for_whse_check(Request $request){
        $data = $request->all();

        // return $data;
        WhsePreshipmentCheck::insert([
            'fkControlNo' => $request->preshipment_ctrl_no,
            'PONo' => $request->po_num,
            'Partscode' => $request->partcode,
            'DeviceName' => $request->device_name,
            'LotNo' => $request->lot_no,
            'Qty' => $request->qty,
            'PackageCategory' => $request->package_category,
            'PackageQty' => $request->package_qty
        ]);
    }
    //change 07/13/2022
    public function get_preshipment_done(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();
        $user_details = UserAccess::with([
            'rapidx_user_details'
        ])
        ->where('rapidx_id',$_SESSION['rapidx_user_id'])
        ->where('logdel',0)
        ->get();
        $send_to = "";


        if($user_details[0]->department == "TS WHSE"){
            $send_to = "ts";
        }
        else if($user_details[0]->department == "CN WHSE"){
            $send_to = "cn";
        }
        else{
            $send_to = "";
        }

        $whse_preshipment = PreshipmentApproving::with([
            'preshipment'
        ])
        ->whereIn('status', [4])
        // ->whereBetween('preshipment.Date', [$request->dateFrom, $request->dateTo])
        ->whereRaw("cast(whse_superior_noter_date_time as date) BETWEEN '$request->dateFrom' AND '$request->dateTo'")
        ->orderBy('fk_preshipment_id', 'DESC')
        ->where('send_to','LIKE', "%$send_to%")
        ->where('logdel', 0)
        ->get();


        // $whse_preshipment = collect($whse_preshipment)->whereBetween('preshipment.Date', [$request->dateFrom, $request->dateTo])->flatten(1);
        return DataTables::of($whse_preshipment)
        ->addColumn('preshipment_ctrl_num', function($whse_preshipment){
            $result ="";
            $result .= $whse_preshipment->preshipment->Destination."-".$whse_preshipment->preshipment->Packing_List_CtrlNo;
            return $result;
        })
        ->addColumn('status', function($whse_preshipment){
            $result = "<center>";


                $result .='<span class="badge badge-success"> Done </span>';
            $result .="</center>";

            return $result;
        })
        ->addColumn('action', function($whse_preshipment) use ($user_details) {
            $result = "<center>";


                $result .= '<button class="btn btn-primary mr-1 btn-sm btn-whs-view" data-toggle="modal" data-target="#modalViewPreshipmentOnly"  preshipment-id="'.$whse_preshipment->id.'">  <i class="fa fa-eye"></i></button>';

                $result .= '<div class="btn-group">
                <button type="button" class="btn btn-secondary mr-1 dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Action">
                <i class="fas fa-lg fa-file-download"></i>
                </button>';
                    $result .= '<div class="dropdown-menu dropdown-menu-right">'; // dropdown-menu start

                    $result .='<a class="dropdown-item text-center" href="export_excel/'.$whse_preshipment->id.'" target="_blank">Export Excel</a>';
                    $result .='<a class="dropdown-item text-center" href="pdf_export/'.$whse_preshipment->id.'" target="_blank">Export PDF</a>';

                    $result .= '</div>'; // dropdown-menu end
                $result .= '</div>';
            $result .='</center>';

            return $result;

        })
        ->rawColumns(['status','action','preshipment_ctrl_num'])
        ->make(true);

    }
    //change 07/14/2022
    public function get_preshipment_for_whse_done(Request $request){
        $whse_preshipment = PreshipmentApproving::with([
            // 'Preshipment_for_approval',
            'preshipment'
        ])
        ->where('logdel', 0)
        // ->whereIn('status', [1,2])
        ->whereNotIn('status', [0,5])
        ->orderBy('fk_preshipment_id', 'DESC')
        ->get();


        return DataTables::of($whse_preshipment)
        ->addColumn('status', function($whse_preshipment){
            $result = "<center>";

            // if($whse_preshipment->status == 0){
            //     $result .='<span class="badge badge-warning">For Approval</span>';
            // }
            if($whse_preshipment->status == 1 || $whse_preshipment->status == 6){
                $result .='<span class="badge badge-warning">For '.strtoupper($whse_preshipment->send_to).'-Whse Approval</span>';
            }
            else if($whse_preshipment->status >= 2){
                $result .='<span class="badge badge-success">'.strtoupper($whse_preshipment->send_to).'-Whse Accepted</span>';
            }

            $result .="</center>";

            return $result;
        })
        ->addColumn('action', function($whse_preshipment) {
            $result = "<center>";
            // $result .= '<center><button class="btn btn-primary btn-sm btn-openshipment"  data-toggle="modal" data-target="#modalViewMaterialHandlerChecksheets" checksheet-id="'.$preshipment->Packing_List_CtrlNo.'"><i class="fas fa-eye"></i></button></center>';
            // $result .= $preshipment->Packing_List_CtrlNo;

            // return $result;
            // <button type="button" class="btn btn-outline-dark btn-sm fa fa-edit text-center actionEditCashAdvance" style="width:105px;margin:2%;" cash_advance-id="3" data-toggle="modal" data-target="#modalEditCashAdvance" data-keyboard="false"> Edit</button>
            $result .= '<button class="btn btn-primary btn-sm btn-whs-view mr-1" data-toggle="modal" data-target="#modalViewWhsePreshipment" preshipment-id="'.$whse_preshipment->preshipment->id.'"><i class="fas fa-eye"></i></button>';

            if($whse_preshipment->status == 0){
                $result .= '<button class="btn btn-success btn-sm btn-approve-whse mr-1" preshipment-id="'.$whse_preshipment->preshipment->id.'"><i class="fas fa-check-circle"></i></button>';
                $result .= '<button class="btn btn-danger btn-sm btn-disapprove-whse" data-toggle="modal" data-target="#modalWhsDisapprove" preshipment-id="'.$whse_preshipment->id.'"><i class="fas fa-times-circle"></i></button>';
            }
            // else if($whse_preshipment->status == 1){
            //     $result .= '<center><button class="btn btn-outline-success btn-sm btn-openshipment " style="width:105px;margin:2%;" preshipment-id="">Excel</button></center>';
            //     $result .= '<center><button class="btn btn-outline-warning btn-sm btn-openshipment " style="width:105px;margin:2%;" preshipment-id="">Uploaded</button></center>';

            // }
            $result .= "</center>";
            return $result;

        })
        ->rawColumns(['status','action'])
        ->make(true);
    }

    public function add_invalid_whse(Request $request){
        PreshipmentApproving::where('id',$request->preshipment_id)
        ->update([
            'is_invalid' => 1
        ]);
        // return $data;
        $to_email = array();

        if($request->from == 'cn'){
            $get_user_email = UserAccess::where('department', 'CN WHSE')
            ->where('logdel',0)
            ->distinct()
            ->get('email');
        }
        else if($request->from == 'ts'){
            $get_user_email = UserAccess::where('department', 'TS WHSE')
            ->where('logdel',0)
            ->distinct()
            ->get('email');
        }

        foreach($get_user_email as $email){
            $to_email[] = $email->email;
        }

        $data = array(
            'invalid_from' => $request->from
        );

        Mail::send('mail.invalid_scan_mail', $data, function($message) use ($to_email){
            $message->to($to_email);
            // $message->cc($cc_email);
            // $message->bcc('cpagtalunan@pricon.ph');
            $message->bcc('mrronquez@pricon.ph');
            $message->bcc('cbretusto@pricon.ph');

            $message->subject("Invalid Scanning Alert");
        });
        return response()->json(['result' => 1]);
    }

     // Added 04/25/2023
     public function get_preshipment_for_whse_pps_cn_recieve(){
        $preshipment = PreshipmentApproving::with([
            'preshipment'
        ])
        ->where('status', 6)
        ->where('logdel', 0)
        ->get();

        return DataTables::of($preshipment)
        ->addColumn('status', function($preshipment){
            return '<center><span class="badge badge-warning">For PPS-CN Whse Receiving</span></center>';
        })
        ->addColumn('action', function($preshipment){
            $result = "";
            $result .= "<center>";
            $result .= '<button class="btn btn-primary btn-sm mr-1 btn-whs-view"  data-toggle="modal" data-target="#modalViewWhsePreshipment" preshipment-id="'.$preshipment->preshipment->id.'"><i class="fas fa-eye"></i></button>';
            $result .= '<button class="btn btn-success btn-sm mr-1 btn-pps-cn-received" preshipment-id="'.$preshipment->id.'"><i class="fas fa-check-circle"></i></button>';
            $result .= '<button class="btn btn-danger btn-sm btn-pps-cn-received-disapprove"  preshipment-id="'.$preshipment->id.'"><i class="fas fa-times-circle"></i></button>';
            $result .= "</center>";

            return $result;
        })
        ->rawColumns(['status', 'action'])
        ->make(true);

    }
     // Added 04/25/2023
    public function get_preshipment_whse_pps_cn_recieved(){
        $preshipment = PreshipmentApproving::with([
            'preshipment'
        ])
        ->orderBy('fk_preshipment_id', 'DESC')
        ->where('status', 7)
        ->where('logdel', 0)
        ->get();

        return DataTables::of($preshipment)
        ->addColumn('status', function($preshipment){
            return '<center><span class="badge badge-success">Received</span></center>';
        })
        ->addColumn('action', function($preshipment){
            $result = "";
            $result .= "<center>";
            $result .= '<button class="btn btn-primary btn-sm mr-1 btn-whs-view"  data-toggle="modal" data-target="#modalViewWhsePreshipment" preshipment-id="'.$preshipment->preshipment->id.'"><i class="fas fa-eye"></i></button>';

            $result .= '<div class="btn-group">
            <button type="button" class="btn btn-secondary mr-1 dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Exports">
            <i class="fas fa-lg fa-file-download"></i>
            </button>';
                $result .= '<div class="dropdown-menu dropdown-menu-right">'; // dropdown-menu start

                $result .='<a class="dropdown-item text-center" href="export_excel/'.$preshipment->id.'" target="_blank">Export Excel</a>';
                $result .='<a class="dropdown-item text-center" href="pdf_export/'.$preshipment->id.'" target="_blank">Export PDF</a>';

                $result .= '</div>'; // dropdown-menu end
            $result .= '</div>';

            $result .= "</center>";

            return $result;
        })
        ->rawColumns(['status', 'action'])
        ->make(true);

    }
     // Added 04/25/2023
    public function approve_pps_cn_transaction(Request $request){
        session_start();
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        PreshipmentApproving::where('id', $request->approve_preshipment)
        ->update([
            'status' => 7,
            'to_whse_noter' => $_SESSION['rapidx_user_id'],
            'to_whse_noter_date_time' => NOW(),
            'updated_at' => NOW()
        ]);

        return response()->json(['result' => 1]);
    }


    public function check_wbs_variance(Request $request){

        $result = array();
        $preshipment_send_to = PreshipmentApproving::where('id', $request->rapidx_preshipment_id)
        ->where('logdel',0)
        ->first('send_to');


        if($request->is_local_rec == 0){ // FOR MAT
            $table_name = 'tbl_wbs_material_receiving';
            $column_name = 'receive_no';
        }
        else{ // FOR LOCAL
            $table_name = 'tbl_wbs_local_receiving_batch';
            $column_name = 'wbs_loc_id';
        }

        if($preshipment_send_to->send_to == "cn"){ // FOR WBS CN
            $db_name = 'mysql_subsystem_wbs_cn';
        }
        else{ // FOR WBS TS
            $db_name = 'mysql_subsystem_wbs_ts';
        }


        if($request->receiving_number == "" && $request->invoice_number == ""){ // for preshipment that has TS-WHSE or CN-WHSE in PO Number
            $result['result'] = 0;
            $result['msg'] = "Preshipment has TS-WHSE or CN-WHSE";
        }
        else{

            $wbs_details = DB::connection($db_name)
            ->select("
            SELECT * FROM $table_name
            WHERE `$column_name` = '$request->receiving_number'
            ");


            // $result['variance'] = $variance;
            if($table_name == "tbl_wbs_material_receiving"){

                // THIS IS A QUERY FROM WBS MATERIAL RECEIVING TO GET VARIANCE
                $mrs = DB::connection($db_name)
                ->select("SELECT IFNULL(mrs.variance,s.qty) AS variance
                        FROM tbl_wbs_material_receiving_summary s
                        LEFT JOIN
                        (SELECT rs.wbs_mr_id, rs.item, SUM(b.qty) as received_qty, (rs.qty - SUM(b.qty)) as variance
                        FROM tbl_wbs_material_receiving_summary rs
                            LEFT JOIN tbl_wbs_material_receiving_batch b
                            ON b.wbs_mr_id = rs.wbs_mr_id AND b.item = rs.item
                        WHERE b.wbs_mr_id = '".$request->receiving_number."'
                        GROUP BY rs.item)mrs ON s.wbs_mr_id = mrs.wbs_mr_id
                        AND s.item = mrs.item
                        WHERE s.wbs_mr_id = '".$request->receiving_number."'");

                $variance = 0;
                foreach ($mrs as $key => $mr) {
                    $variance += $mr->variance;
                }

                if($wbs_details[0]->total_qty != $request->total_qty){
                    $result['result'] = 1;
                    $result['msg'] = "Please check QTY DISCREPANCY.";
                }
                else if($variance == 0 && $wbs_details[0]->status == 'X'){ // No Variance and status is closed
                    $result['result'] = 0;
                    $result['msg'] = "Status is closed and no variance";
                }
                else{ // With Variance or Status is not closed
                    $result['result'] = 1;
                    $result['msg'] = "Please check Variance and Status on WBS!";
                }
            }
            else{
                $sum = collect($wbs_details)->sum('qty');

                if($request->total_qty == $sum){
                    $result['result'] = 0;
                    $result['msg'] = "no variance";
                }
                else{
                    $result['result'] = 1;
                    $result['msg'] = "Please check WBS Total Quantity";
                }
            }
        }


        return response()->json($result);
    }
}
