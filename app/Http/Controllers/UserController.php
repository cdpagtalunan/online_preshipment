<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\RapidxUser;
use App\Model\UserAccess;

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
       $user_id =  $request->rapidx_user;
       $user_email =  $request->rapidx_email;
       $user_level =$request->access_level;
       $user_department = $request->user_department;
    

        if(isset($request->edit_user_id)){
            UserAccess::where('id', $request->edit_user_id)
            ->update([
                'rapidx_id' => $user_id,
                'email' => $user_email,
                'access_level' => $user_level,
                'department' => $user_department,
            ]);
            return response()->json(['result' => 2]);

        }
        else{
            UserAccess::insert([
                'rapidx_id' => $user_id,
                'email' => $user_email,
                'access_level' => $user_level,
                'department' => $user_department,
                 
            ]);

            return response()->json(['result' => 1]);

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
}
