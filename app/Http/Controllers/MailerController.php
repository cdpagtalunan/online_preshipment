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


use App\Exports\PendingOneDayExportCN;
use App\Exports\PendingOneDayExportTS;


use Carbon\Carbon;
use Mail;

class MailerController extends Controller
{
    public function automail_pending_preshipment(Request $request){
        date_default_timezone_set('Asia/Manila');

        $result = array();

        $now = Carbon::today(); // GET THE DATE TODAY
        $now->addDays(-1);
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

        $result['mh_1day_only_cn'] = collect($get_pending_mh_preshipment)->whereIn('status', [1,2])->where('petsa','<=' ,$now_for_collect)->where('send_to', 'cn')->flatten(0);
        $result['mh_1day_only_ts'] = collect($get_pending_mh_preshipment)->whereIn('status', [1,2])->where('petsa','<=' ,$now_for_collect)->where('send_to', 'ts')->flatten(0);
        // $result['mh_past_2days_only'] = collect($get_pending_mh_preshipment)->whereIn('status', [1,2])->where('petsa', '<', $now_for_collect)->flatten(0);

        $result['supp_1day_only_cn'] = collect($get_pending_mh_preshipment)->where('status', 3)->where('petsa','<=' ,$now_for_collect)->where('send_to', 'cn')->flatten(0);
        $result['supp_1day_only_ts'] = collect($get_pending_mh_preshipment)->where('status', 3)->where('petsa','<=' ,$now_for_collect)->where('send_to', 'ts')->flatten(0);
        // $result['supp_past_2days_only'] = collect($get_pending_mh_preshipment)->where('status', 3)->where('petsa','<', $now_for_collect)->flatten(0);

        $date_today = Carbon::today();
        // return Carbon::parse($date_today)->format('Y-m-d');

        $filename_1day_CN = "List of CN Pending Pre-shipment as of " . Carbon::parse($date_today)->format('Y-m-d') . ".xlsx";
        $filename_1day_TS = "List of TS Pending Pre-shipment as of " . Carbon::parse($date_today)->format('Y-m-d') . ".xlsx";
        // return $result;

        $path = "/var/www/OnlinePreShipment/storage/app/";
        
        $user_details_ts = DB::table('user_access')
        ->select(DB::raw('distinct(email)'))
        ->whereIn('department', ['TS WHSE'])
        ->where('logdel', 0)
        ->get();

        $user_details_cn = DB::table('user_access')
        ->select(DB::raw('distinct(email)'))
        ->whereIn('department', ['CN WHSE'])
        ->where('logdel', 0)
        ->get();
        
        $to_email_ts = array();
        $to_email_cn = array();
      
        for($x = 0; $x<count($user_details_ts); $x++){
            array_push($to_email_ts, $user_details_ts[$x]->email);
        }

        for($y = 0; $y<count($user_details_cn); $y++){
            array_push($to_email_cn, $user_details_cn[$y]->email);
        }



        if(count($result['mh_1day_only_cn']) > 0 || count($result['supp_1day_only_cn']) > 0){

            Excel::store(new PendingOneDayExportCN($date_today,$result),$filename_1day_CN);

            // $to_email = "cpagtalunan@pricon.ph";
            $attachment_path = $path.$filename_1day_CN;
            $data = ['data' => "0"];

            Mail::send('mail.automail_pending', $data, function($message) use ($to_email_cn, $attachment_path) {
                $message->to($to_email_cn);
                $message->attach($attachment_path);
                $message->cc(['rnsunga@pricon.ph','kaapines@pricon.ph']);
                $message->subject("ALERT !! -- CN Pending Preshipment! <Do Not Reply>");
                $message->bcc(['cbretusto@pricon.ph']);
            });


        }
        if(count($result['mh_1day_only_ts']) > 0 || count($result['supp_1day_only_ts']) > 0){
            Excel::store(new PendingOneDayExportTS($date_today,$result),$filename_1day_TS);
            // $to_email = "cpagtalunan@pricon.ph";
            
            $attachment_path = $path.$filename_1day_TS;
            $data = ['data' => "1"];
            Mail::send('mail.automail_pending', $data, function($message) use ($to_email_ts, $attachment_path) {
                $message->to($to_email_ts);
                $message->cc(['rnsunga@pricon.ph','kaapines@pricon.ph']);
                $message->attach($attachment_path);
                $message->bcc(['cbretusto@pricon.ph']);
                $message->subject("ALERT !! -- TS Pending Preshipment! <Do Not Reply>");
            });
        }
    }
}
