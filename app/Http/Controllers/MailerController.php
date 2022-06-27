<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\RapidShipmentRecord;
use App\Model\RapidPreshipmentList;
use App\Model\PreshipmentApproving;
use App\Exports\PendingExport;

use Carbon\Carbon;
use Mail;
use Excel;



class MailerController extends Controller
{
    public function automail_pending_preshipment(Request $request){
        date_default_timezone_set('Asia/Manila');

        $now = Carbon::today(); // GET THE DATE TODAY
        $now->addDays(-2);
        $now = Carbon::parse($now)->format('Y-m-d');


        // return $now;

        $get_pending_preshipments = PreshipmentApproving::with([
            'preshipment',
            // 'qc_approver_details',
            // 'qc_approver_details.rapidx_user_details',
            // 'from_user_details',
            // 'from_user_details.rapidx_user_details',
            // 'to_whse_noter_details',
            // 'to_whse_noter_details.rapidx_user_details',
            // 'whse_uploader_details',
            // 'whse_uploader_details.rapidx_user_details',
            // 'whse_superior_details',
            // 'whse_superior_details.rapidx_user_details',
        ])
        ->whereNotIn('status',[4,5])
        ->where('logdel',0)
        ->get();

        $get_pending_preshipments = collect($get_pending_preshipments)->where('preshipment.Date', '>=', '2022-05-24')->where('preshipment.Date', '<=', $now)->flatten(1);
        

        return $get_pending_preshipments;
        
        $date_today = Carbon::today();

        $filename = "Summary of Pending Pre-shipment" . Carbon::parse($date_today)->format('Y-m-d') . ".xlsx";

        Excel::store(new PendingExport($date_today,$get_pending_preshipments),$filename);



        // return count($get_pending_preshipments);
        // if(count($get_pending_preshipments) > 0){
        //     $data = [
        //         'datas' => $get_pending_preshipments
        //     ];

        //     $to_email = "cpagtalunan@pricon.ph";

        //     Mail::send('mail.automail_pending', $data, function($message) use ($to_email) {
        //         $message->to($to_email);
        //         // $message->subject($subjects);
        //         // $message->from("pmiissnotif@gmail.com","CHAS NOTICE: Present Employees without CHAS");
        //     });
        // }
        
    }
}
