<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;


use App\Model\RapidxUser;
use App\Model\UserAccess;

use App\Model\InvalidDetails;

use DataTables;

class UserController extends Controller
{
    //

    public function get_rapidx_user(){
        $user = RapidxUser::where('user_stat', 1)
        ->get();

        return response()->json(['result' => $user]);
        
    }
    public function add_user(Request $request){
        session_start();
        date_default_timezone_set("Asia/Manila");
        $user_id =  $request->rapidx_user;
        $user_email =  $request->rapidx_email;
        $user_level =$request->access_level;
        $user_department = $request->user_department;
        $authorize = $request->authorize;
        
        $data = $request->all();
        $to_validate = [
            'rapidx_user' => 'required',
            'access_level' => 'required',
            'authorize' => 'required',
        ];
        if($user_level == "user" || $user_level == ""){
            $to_validate['user_department'] = 'required';
        }

        $validator = Validator::make($data, $to_validate);
        if($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        }
        else{
            $database_data = [
                'rapidx_id' => $user_id,
                'email' => $user_email,
                'access_level' => $user_level,
                'department' => $user_department,
                'authorize' => $authorize,
            ];

            if(isset($request->checkbox_approver)){
                $database_data['approver'] =  1;
            }
            else{
                $database_data['approver'] =  0;
            }


            // if()

            if(isset($request->edit_user_id)){
                UserAccess::where('id', $request->edit_user_id)
                ->update(
                    $database_data
                );
                return response()->json(['result' => 2]);
            }
            else{
                $database_data['created_by'] = $_SESSION['rapidx_user_id'];
                $database_data['created_at'] = NOW();
                UserAccess::insert(
                    $database_data
                );
    
                return response()->json(['result' => 1]);
    
            }    
        }

       
     

    




        // return response()->json(['test' => $user,'test1' => $user1,'test2' => $user2]);

    }

    public function get_user(){
        $users = UserAccess::with([
            'rapidx_user_details'
        ])
        ->get();
        
        return DataTables::of($users)
        ->addColumn('status', function($users) {
            $result = "";

            if($users->logdel == 0){
                $result .= '<center><span class="badge badge-success">Active</span></center>';
            }
            else{
                $result .= '<center><span class="badge badge-danger">Deactivated</span></center>';

            }
            return $result;
        })

        ->addColumn('user_level',function($users){
            $result = "";

            // $result .= '<center><span class="badge badge-success">'.$users.'</span></center>';


            switch($users->access_level){
                case "admin":
                    $result .= '<center>Administrator</center>';
                    break;
                case "user":
                    $result .= '<center>Regular User</center>';
                    break;

                default;

            }

            return $result;

            
        })

        ->addColumn('action', function($users){
            $result = "";

            $result .= "<center>";
            
            if($users->logdel == 0){
                $result .= '<button class="btn btn-secondary btn-xs mr-1 btn-user-edit" " data-toggle="modal" data-target="#modalAddUser" btn-user-id = "'.$users->id.'"><i class="fas fa-edit fa-lg"></i></button>';
                $result .= '<button class="btn btn-danger btn-xs btn-user-delete" " data-toggle="modal" data-target="#modalUserDelete" btn-user-id = "'.$users->id.'"><i class="fas fa-user-slash fa-lg"></i></button>';

            }
            else{
                $result .= '<button class="btn btn-success btn-xs btn-user-enable" " data-toggle="modal" data-target="#modalUserRestore" btn-user-id = "'.$users->id.'"><i class="fas fa-redo fa-lg"></i></button>';

            }
            $result .= "</center>";

            return $result;
        })

        ->rawColumns(['status','user_level','action'])


        ->make(true);
    }

    public function get_user_email(Request $request){
        $email = RapidxUser::where('id',$request->rapidxId)->first();


        // return $email;
        return response()->json(['email' => $email->email]);
    }

    public function get_user_details_for_edit(Request $request){
        $user_info = UserAccess::with([
            'rapidx_user_details'
        ])
        ->where('id', $request->userId)
        ->get();

        return response()->json(['result' => $user_info]);
    }

    public function delete_user(Request $request){
        UserAccess::where('id', $request->userId)
        ->update([
            'logdel' => 1
        ]);

        return response()->json(['result' => 1]);
    }

    public function enable_user(Request $request){
        UserAccess::where('id', $request->userId)
        ->update([
            'logdel' => 0
        ]);

        return response()->json(['result' => 1]);
    }

    public function get_user_for_verify_login(Request $request){
        $get_user_for_verify = UserAccess::where('rapidx_id', $request->loginUserId)
        ->where('logdel', 0)
        ->get();

        $get_user_to_verify_for_admin = UserAccess::where('rapidx_id', $request->loginUserId)
        ->where('access_level', 'admin')
        ->where('logdel', 0)
        ->get();

        if(count($get_user_for_verify) > 0){
            if(count($get_user_to_verify_for_admin) > 0){
                return response()->json(['result' => 1, 'admin' => 1, 'userDetails' => $get_user_for_verify]);

            }else{
                return response()->json(['result' => 1, 'userDetails' => $get_user_for_verify]);
            }
        }
        else{
            return response()->json(['result' => 0]);
        }
    }

    public function get_authorize_by_id(Request $request){
        $test = $request->emp_id;
        // $user_details = UserAccess::with([
        //     'rapidx_user_details'
        // ])
        // ->where('logdel',0)
        // ->get();
        $user_details = UserAccess::with([
            'rapidx_user_details',
        ])
        ->where('authorize',1)
        ->where('logdel',0)
        ->get();
        

        $user_details = collect($user_details)->where('rapidx_user_details.employee_number', $request->emp_id)->flatten(1);

        // return $user_details;
        if(isset($user_details[0]->rapidx_user_details->employee_number)){
            if($user_details[0]->rapidx_user_details->employee_number ==  $request->emp_id){
                return response()->json(['result' => 1]);
            }
        }
        else{
            return response()->json(['result' => 0]);
        }

        // return $user_details;
    }

    public function add_invalid_details(Request $request){
        session_start();
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();

        // return $data;
        InvalidDetails::insert([
            'rapid_preshipment_id' => $request->preshipment_id,
            'authorize_id_no' => strtoupper($request->emp_id),
            'remarks' => $request->remarks,
            'invalid_on' => $request->invalid_module,
            'created_at' => NOW()
        ]);

        return response()->json(['result' => 1]);

    }
}
