<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel; 


use App\Model\RapidShipmentRecord;
use App\Model\RapidPreshipmentList;
use App\Model\PreshipmentApproving;
use App\Model\RapidPreshipment;
use App\Model\UserAccess;


use App\Exports\PendingTwoDaysExport;
use App\Exports\PendingPastTwoDaysExport;


use Carbon\Carbon;
use Mail;

class MailerController extends Controller
{
    public function automail_pending_preshipment(Request $request){
        date_default_timezone_set('Asia/Manila');

        $result = array();

        $now = Carbon::today(); // GET THE DATE TODAY
        $now->addDays(-2);
        $now_for_where = Carbon::parse($now)->format('Y-m-d 07:30:00');
        $now_for_collect = Carbon::parse($now)->format('Y-m-d');

        $get_pending_mh_preshipment = PreshipmentApproving::with([
            'preshipment',
        ])
        ->whereIn('status',[1,2,3])
        ->where('logdel',0)
        ->where('updated_at','<=', $now_for_where)
        ->select('*', DB::raw('DATE(`created_at`) as petsa'))
        ->get();

        $result['mh_2days_only'] = collect($get_pending_mh_preshipment)->whereIn('status', [1,2])->where('petsa','=' ,$now_for_collect)->flatten(0);
        $result['mh_past_2days_only'] = collect($get_pending_mh_preshipment)->whereIn('status', [1,2])->where('petsa', '<', $now_for_collect)->flatten(0);

        $result['supp_2days_only'] = collect($get_pending_mh_preshipment)->where('status', 3)->where('petsa','=' ,$now_for_collect)->flatten(0);
        $result['supp_past_2days_only'] = collect($get_pending_mh_preshipment)->where('status', 3)->where('petsa','<', $now_for_collect)->flatten(0);

        $date_today = Carbon::today();

        $filename_2days = "List of Pending Pre-shipment as of " . Carbon::parse($date_today)->format('Y-m-d') . ".xlsx";
        $filename_past_2days = "List of Pending Pre-shipment after 2 days as of " . Carbon::parse($date_today)->format('Y-m-d') . ".xlsx";
        // return $result;

        $path = "/var/www/OnlinePreShipment/storage/app/";
        
        $user_details = DB::table('user_access')
        ->select(DB::raw('distinct(email)'))
        ->whereIn('department', ['CN WHSE','TS WHSE'])
        ->where('logdel', 0)
        ->get();
        
        $to_email = array();
      
        for($x = 0; $x<count($user_details); $x++){
            array_push($to_email, $user_details[$x]->email);
        }
        if(count($result['mh_2days_only']) > 0 || count($result['supp_2days_only']) > 0){
            Excel::store(new PendingTwoDaysExport($date_today,$result),$filename_2days);

            // $to_email = "cpagtalunan@pricon.ph";
            $attachment_path = $path.$filename_2days;
            $data = ['data' => "0"];

            Mail::send('mail.automail_pending', $data, function($message) use ($to_email, $attachment_path) {
                $message->to($to_email,'kaapines@pricon.ph');
                $message->attach($attachment_path);
                $message->subject("ALERT !! -- Pending Preshipment! <Do Not Reply>");
                $message->bcc('cpagtalunan@pricon.ph');
            });


        }
        if(count($result['mh_past_2days_only']) > 0 || count($result['supp_past_2days_only']) > 0){
            Excel::store(new PendingPastTwoDaysExport($date_today,$result),$filename_past_2days);
            
            $attachment_path = $path.$filename_past_2days;
            $data = ['data' => "1"];
            Mail::send('mail.automail_pending', $data, function($message) use ($to_email, $attachment_path) {
                $message->to($to_email,'kaapines@pricon.ph');
                $message->cc('rnsunga@pricon.ph');
                $message->attach($attachment_path);
                $message->bcc('cpagtalunan@pricon.ph');
                $message->subject("ALERT !! -- Pending Preshipment Past 2 days! <Do Not Reply>");
            });
        }
    }
}
