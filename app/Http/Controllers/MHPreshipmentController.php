<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;



// use App\Model\Preshipment;
use App\Model\PreshipmentList;
use App\Model\RapidPreshipment;
use App\Model\RapidPreshipmentList;
use App\Model\PreshipmentApproving;
use App\Model\UserAccess;

use DataTables;
use Mail;


class MHPreshipmentController extends Controller
{
    public function get_Preshipment(){
        $preshipment = RapidPreshipment::where('rapidx_MHChecking','0')
        ->orWhere('rapidx_QCChecking', 1)
        ->orWhere('remarks','!=','null')
        ->orderBy('id', 'DESC')
        ->where('logdel', 0)
        ->get();
      
        return DataTables::of($preshipment)
        ->addColumn('status', function($preshipment){
            $result = "<center>";
            if($preshipment->rapidx_MHChecking == 0){
                $result .='<span class="badge badge-warning">For MH Checking</span>';
            }

            if($preshipment->rapidx_QCChecking == 1){
                $result .='<span class="badge badge-info">For QC Checking</span>';
            }

            if(($preshipment->rapidx_QCChecking == 3 && $preshipment->remarks != null) || ($preshipment->to_edit == 1 && $preshipment->remarks != null)){
                $result .='<span class="badge badge-danger">Disapproved</span>';
                $result .='<br><strong>Remarks:</strong><br>'.$preshipment->remarks;
            }
            $result .= "</center>";
            return $result;
        })
        ->addColumn('action', function($preshipment) {
            $result = "";
            if($preshipment->rapidx_MHChecking == 0){
                $result .= '<center><button class="btn btn-primary btn-sm btn-openshipment"  data-toggle="modal" data-target="#modalViewMaterialHandlerChecksheets" checksheet-id="'.$preshipment->Packing_List_CtrlNo.'"><i class="fas fa-eye"></i></button></center>';
            }
            if($preshipment->rapidx_QCChecking == 1){
                $result .= '<center><button class="btn btn-primary btn-sm btn-openshipment"  data-toggle="modal" data-target="#modalViewMaterialHandler" checksheet-id="'.$preshipment->Packing_List_CtrlNo.'"><i class="fas fa-eye"></i></button></center>';
            }
         
            // $result .= $preshipment->Packing_List_CtrlNo;

            return $result;
        })
        ->rawColumns(['action','status'])
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
    // public function getpreshipmentbyCtrlNoWhse(Request $request){

    //     $preshipment = RapidPreshipment::where('Packing_List_CtrlNo',$request->preshipment_ctrl_id)
    //     ->get();

    //     if(count($preshipment) > 0){
    //         return response()->json(['response' => 1, 'preshipment' => $preshipment]);
    //     }
    //     else{
    //         return response()->json(['response' => 0]);

    //     }
    // }

    

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
    
        $get_to_emails = UserAccess::where('department', 'inspector')
        ->where('logdel',0)
        ->get();

        $get_cc_emails = UserAccess::where('department', 'material handler')
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

        
        // $to_email = ['cbretusto@pricon.ph'];
        // $cc_email = ['cpagtalunan@pricon.ph'];
        // return $cc_email;

        $data = array(
            'packingCtrlNo' => $request->packingCtrlNo, 
            'packingDate' => $request->packingDate, 
            'packingDestination' => $request->packingDestination,
            'packingShipmentDate' => $request->packingShipmentDate,
            'packingStation' => $request->packingStation,
            'packing_id' => $request->packing_id
        );

        $packing_ctrl_num = $request->packingDestination."-".$request->packingCtrlNo;

        Mail::send('mail.material_handler_notification', $data, function($message) use ($to_email,$cc_email,$packing_ctrl_num){
            $message->to($to_email);
            $message->cc($cc_email);
            $message->bcc('cpagtalunan@pricon.ph');
            $message->subject("Online Preshipment for Inspection-".$packing_ctrl_num);
        });
    
        // if (Mail::failures()) {
        //     return response()->json(['result' => 0]);
        //     // return Mail::failures()[0];
        // }
        // else{
            return response()->json(['result' => 1]);
        // }
        // return response()->json(['result' => 1,]);

    }

    // Function to get internal preshipment for MH
    public function get_for_whse_transaction(){

        // $mh_whse_transaction = 
        $preshipment = PreshipmentApproving::with([
            // 'Preshipment_for_approval',
            'preshipment',
        ])
        ->whereIN('status', [0,1,2,3,4])
        ->where('logdel', 0)
        ->orderBy('fk_preshipment_id', 'DESC')
        ->get();

        // $preshipmentlist = PreshipmentList::where('fkControlNo',$preshipment[0]->id)
        // ->get();

        // return $preshipment;
      
        return DataTables::of($preshipment)
        ->addColumn('action', function($preshipment) {
            $result = "";
            $result .= "<center>";
            $result .= '<button class="btn btn-primary btn-sm btn-openshipmentWhse mr-1"  data-toggle="modal" data-target="#modalViewMaterialHandler" checksheet-id="'.$preshipment->preshipment->Packing_List_CtrlNo.'" title="View Preshipment"><i class="fa fa-eye"></i></button>';
            
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
        ->addColumn('status', function($preshipment){
            $result = "";

            $result .="<center>";
            if($preshipment->status == 0){
                $result .='<span class="badge badge-warning">For PPS Checking</span>';
            }
            else if($preshipment->status == 1 || $preshipment->status == 2){
                $result .='<span class="badge badge-warning">For TS/CN Warehouse Approval</span>';
            }
            else if($preshipment->status == 3){
                $result .='<span class="badge badge-warning">For TS/CN Superior Approval</span>';
            }
            else if($preshipment->status == 4){
                $result .='<span class="badge badge-success">Done</span>';
            }
            // else if($preshipment->status == 6){
            //     $result .='<span class="badge badge-danger">Disapproved</span>';
            //     $result .='<br><strong>Remarks:</strong><br>'.$preshipment->remarks;
            // }

            // if()
            $result .="</center>";

            return $result;
        })  
        ->rawColumns(['action','status'])
        ->make(true);
    }

    public function get_for_whse_ext_transaction(Request $request){
        $preshipment = PreshipmentApproving::with([
            // 'Preshipment_for_approval',
            'preshipment',
        ])
        ->where('status', 5)
        ->where('logdel', 0)
        ->orderBy('fk_preshipment_id', 'DESC')
        ->get();

        // $preshipmentlist = PreshipmentList::where('fkControlNo',$preshipment[0]->id)
        // ->get();

        // return $preshipment;
      
        return DataTables::of($preshipment)
        ->addColumn('action', function($preshipment) {
            $result = "";
            $result .= "<center>";
            $result .= '<button class="btn btn-primary btn-sm btn-openshipmentWhse mr-1"  data-toggle="modal" data-target="#modalViewMaterialHandler" checksheet-id="'.$preshipment->preshipment->Packing_List_CtrlNo.'" title="View Preshipment"><i class="fa fa-eye"></i></button>';
            
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
        ->addColumn('status', function($preshipment){
            $result = "";

            $result .="<center>";
            $result .='<span class="badge badge-success">Done</span>';
            $result .="</center>";

            return $result;
        })  
        ->rawColumns(['action','status'])
        ->make(true);
    }





    
  

    
}
