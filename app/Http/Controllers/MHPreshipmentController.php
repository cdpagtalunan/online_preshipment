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
use App\Model\RapidDieset;
use App\Model\RapidStamping;


use App\Model\MhPreshipmentCheck;

use DataTables;
use Mail;


class MHPreshipmentController extends Controller
{
    public function get_Preshipment(){
        $preshipment = RapidPreshipment::where('rapidx_MHChecking','0')
        // ->orWhere('rapidx_QCChecking', 1)
        ->where('grinding','0') 
        ->orderBy('id', 'DESC')
        ->where('logdel', 0)
        ->get();
      
        return DataTables::of($preshipment)
        ->addColumn('status', function($preshipment){ 
            $result = "<center>";
            if($preshipment->rapidx_MHChecking == 0){
                $result .='<span class="badge badge-warning">For MH Checking</span>';
            }

            // if($preshipment->rapidx_QCChecking == 1){
            //     $result .='<span class="badge badge-info">For QC Checking</span>';
            // }

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
            // if($preshipment->rapidx_QCChecking == 1){
            //     $result .= '<center><button class="btn btn-primary btn-sm btn-openshipment"  data-toggle="modal" data-target="#modalViewMaterialHandler" checksheet-id="'.$preshipment->Packing_List_CtrlNo.'"><i class="fas fa-eye"></i></button></center>';
            // }
         
            // $result .= $preshipment->Packing_List_CtrlNo;

            return $result;
        })
        ->rawColumns(['action','status'])
        ->make(true);
    }
    public function getpreshipmentbyCtrlNo(Request $request){

        $preshipment = RapidPreshipment::where('Packing_List_CtrlNo',$request->preshipment_ctrl_id)
        ->get();

        $preshipment_list = MhPreshipmentCheck::where('fkControlNo',$preshipment[0]['Packing_List_CtrlNo'])
        ->where('logdel', 0)
        ->get();

        if(count($preshipment) > 0){
            return response()->json(['response' => 1, 'preshipment' => $preshipment , 'preshipmentList' => $preshipment_list]);
        }
        else{
            return response()->json(['response' => 0]);

        }
    }
    // public function get_Preshipment_list(Request $request){

    //     $preshipment_list = RapidPreshipmentList::with([
    //         'dieset_info'
    //     ])
    //     ->where('fkControlNo', $request->preshipmentCtrlNo)
    //     ->where('logdel', 0)
    //     ->get();

    //     $rapid_preshipment = RapidPreshipment::where('Packing_List_CtrlNo', $request->preshipmentCtrlNo)
    //     ->where('logdel', 0)
    //     ->first();
      
    //     // return $rapid_preshipment;
    //     return DataTables::of($preshipment_list)

    //     ->addColumn('hide_input', function($preshipment) {
    //         $result = "";
    //         /*
    //             this is for the scanning of qr code for package qty.
    //             this will get the last value of the array.
    //             this will accept - or ~ only.
    //         */
    //         $result = "";

    //         if($preshipment->PackageQty == "DO"){
    //             $result .= "DO";
    //         }

    //         if (str_contains($preshipment->PackageQty, '-')){
    //             $exploded = explode("-",$preshipment->PackageQty);
    //             // $result .= $exploded[1];
    //             $exploded_last_index = $exploded[1];
    //             $package_qty_for_hidden_scan = "";

    //             for($x = 1; $x<=$exploded_last_index; $x++){

    //                 $package_qty_for_hidden_scan .= $x."/".$exploded_last_index."";
    //             }
    //             $result .= $package_qty_for_hidden_scan;
    //         }
    //         else if(str_contains($preshipment->PackageQty, '~')){
    //             $exploded = explode("~",$preshipment->PackageQty);
    //             // $result .=$exploded[1];
    //             $exploded_last_index = $exploded[1];
    //             $package_qty_for_hidden_scan = "";
    //             for($x = 1; $x<=$exploded_last_index; $x++){
    //                 $package_qty_for_hidden_scan .= $x."/".$exploded_last_index."";
    //             }
    //             $result .= $package_qty_for_hidden_scan;
    //             // return $package_qty_for_hidden_scan;
    //         }
    //         else if($preshipment->PackageQty != "DO"){
    //             $result .= $preshipment->PackageQty;
    //         }

    //         return $result;
    //     })
    //     ->addColumn('hide_stamping', function($preshipment) use ($rapid_preshipment){
    //         $result = "";

    //         if($rapid_preshipment->Stamping == 1){
    //             $result .= "stamping";
    //         }
            
    //         return $result;
    //     })
    //     ->addcolumn('drawing_no', function($preshipment) use ($rapid_preshipment){
    //         $result = "";

    //         if($rapid_preshipment->Stamping == 0 && $rapid_preshipment->for_pps_cn_transfer == 0){
    //             if(isset($preshipment->dieset_info)){
    //                 $result .= $preshipment->dieset_info->DrawingNo;
    //             }
    //         }
    //         else{
    //             $stamping = RapidStamping::where('device_code','LIKE', '%'.$preshipment->Partscode.'%')
    //             ->where('logdel', 0)
    //             ->first();

    //             if(isset($stamping)){
    //                 $result .= $stamping->drawing_no;
    //             }
              
    //         }
            
    //         return $result;
    //     })
    //     ->addcolumn('rev', function($preshipment) use ($rapid_preshipment){
    //         $result = "";

    //         if($rapid_preshipment->Stamping == 0 && $rapid_preshipment->for_pps_cn_transfer == 0){
    //             if(isset($preshipment->dieset_info)){
    //                 $result .= $preshipment->dieset_info->Rev;
    //             }
    //         }
    //         else{
    //             $stamping = RapidStamping::where('device_code','LIKE', '%'.$preshipment->Partscode.'%')
    //             ->where('logdel', 0)
    //             ->first();

    //             if(isset($stamping)){
    //                 // $exploded_drawing = explode(' ', $stamping->drawing_no);
    //                 $result .= $stamping->rev;
    //                 // $result .= $stamping->drawing_no;
    //             }
    //         }
          
    //         return $result;
    //     })
    //     /* old code */
    //     // ->addcolumn('drawing_no', function($preshipment){
    //     //     $result = "";

    //     //     if(isset($preshipment->dieset_info)){
    //     //         $result .= $preshipment->dieset_info->DrawingNo;
    //     //     }

    //     //     return $result;
    //     // })
    //     // ->addcolumn('rev', function($preshipment){
    //     //     $result = "";

    //     //     if(isset($preshipment->dieset_info)){
    //     //         $result .= $preshipment->dieset_info->Rev;
    //     //     }

    //     //     return $result;
    //     // })
    //     ->rawColumns(['hide_input', 'hide_stamping','drawing_no', 'rev'])
    //     ->make(true);
        

    // }

    public function disapprove_list(Request $request){
        date_default_timezone_set('Asia/Manila');
       
            try{
                RapidPreshipment::where('Packing_List_CtrlNo', $request->packingCtrlNo)
                ->update([ // The update method expects an array of column and value pairs representing the columns that should be updated.
                    'rapidx_MHChecking' => '2',
                    'has_invalid'       => '0'
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
            'rapidx_QCChecking' => '1',
            'has_invalid'       => '0'

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
            $message->bcc('mrronquez@pricon.ph');
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
        // ->whereIN('status', [0,1,2,3,4])
        ->where('status', '!=', '5')
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
            else if($preshipment->status == 4 || 7){
                $result .='<span class="badge badge-success">Done</span>';
            }
            else if($preshipment->status == 6){
                $result .='<span class="badge badge-warning">For PPS-CN Receive</span>';
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

    //change 07/14/2022
    public function get_for_qc_transaction(Request $request){
        $preshipment = RapidPreshipment::Where('rapidx_QCChecking', 1)
        // ->orWhere('remarks','!=','null')
        ->orderBy('id', 'DESC')
        ->where('logdel', 0)
        ->get();
      
        return DataTables::of($preshipment)
        ->addColumn('status', function($preshipment){
            $result = "<center>";
            // if($preshipment->rapidx_MHChecking == 0){
            //     $result .='<span class="badge badge-warning">For MH Checking</span>';
            // }

            if($preshipment->rapidx_QCChecking == 1){
                $result .='<span class="badge badge-info">For QC Checking</span>';
            }

            // if(($preshipment->rapidx_QCChecking == 3 && $preshipment->remarks != null) || ($preshipment->to_edit == 1 && $preshipment->remarks != null)){
            //     $result .='<span class="badge badge-danger">Disapproved</span>';
            //     $result .='<br><strong>Remarks:</strong><br>'.$preshipment->remarks;
            // }
            $result .= "</center>";
            return $result;
        })
        ->addColumn('action', function($preshipment) {
            $result = "";
            // if($preshipment->rapidx_MHChecking == 0){
            //     $result .= '<center><button class="btn btn-primary btn-sm btn-openshipment"  data-toggle="modal" data-target="#modalViewMaterialHandlerChecksheets" checksheet-id="'.$preshipment->Packing_List_CtrlNo.'"><i class="fas fa-eye"></i></button></center>';
            // }
            if($preshipment->rapidx_QCChecking == 1){
                $result .= '<center><button class="btn btn-primary btn-sm btn-openshipment"  data-toggle="modal" data-target="#modalViewMaterialHandler" checksheet-id="'.$preshipment->Packing_List_CtrlNo.'"><i class="fas fa-eye"></i></button></center>';
            }
         
            // $result .= $preshipment->Packing_List_CtrlNo;

            return $result;
        })
        ->rawColumns(['action','status'])
        ->make(true);
    }

    public function insert_preshimentlist_from_mh_qr_checking(Request $request){
        $data = $request->all();

        												
        MhPreshipmentCheck::insert([
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

    public function add_invalid(Request $request){
        // $data = $request->all();

        RapidPreshipment::where('id',$request->preshipment_id)
        ->update([
            'has_invalid' => 1
        ]);
        
        $to_email = array();

        if($request->from == 'MH'){
            $get_user_email = UserAccess::where('department', 'material handler')
            ->where('logdel',0)
            ->distinct()
            ->get('email');
        }
        else if($request->from == 'QC'){
            $get_user_email = UserAccess::where('department', 'inspector')
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
            $message->bcc('cpagtalunan@pricon.ph');
            $message->bcc('mrronquez@pricon.ph');
            $message->subject("Invalid Scanning Alert");
        });

        // return $to_email;

        return response()->json(['result' => 1]);
    }

    public function get_preshipment_grinding(){
        $preshipment_grinding = RapidPreshipment::where('grinding','1')
        ->orderBy('id', 'DESC')
        ->where('logdel', 0)
        ->get();

        return DataTables::of($preshipment_grinding)
        ->addColumn('status', function($preshipment_grinding){
            $result = "";
            $result .= '<center><span class="badge badge-success">Done</span></center>';
            return $result;
        })
        ->addColumn('action', function($preshipment) {
            $result = "";
            
            $result .= '<center><button class="btn btn-primary btn-sm btn-openshipment mr-1"  data-toggle="modal" data-target="#modalViewMaterialHandler" checksheet-id="'.$preshipment->Packing_List_CtrlNo.'"><i class="fas fa-eye"></i></button>';
            $result .= '<div class="btn-group">
            <button type="button" class="btn btn-secondary mr-1 dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Exports">
            <i class="fas fa-lg fa-file-download"></i>
            </button>';
                $result .= '<div class="dropdown-menu dropdown-menu-right">'; // dropdown-menu start

                // $result .='<a class="dropdown-item text-center" href="export_excel/'.$preshipment->id.'" target="_blank">Export Excel</a>';
                $result .='<a class="dropdown-item text-center" href="pdf_export_grinding/'.$preshipment->id.'" target="_blank">Export PDF</a>';
                
                $result .= '</div>'; // dropdown-menu end
            $result .= '</div>';
            $result .= '</center>';
            return $result;
        })
        ->rawColumns(['status','action'])
        ->make(true);
    }
}