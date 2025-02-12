<?php

namespace App\Http\Controllers;

use DataTables;
use App\Model\Destination;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\DestinationRequest;

class DestinationController extends Controller
{
    public function dt_destination(Request $request){
        $destinations = Destination::whereNull('deleted_at')->get();

        return DataTables::of($destinations)
        ->addColumn('action', function($destinations){
            $result = "";
            $result .= '<button type="button" class="btn btn-primary btn-sm btnEditCategory"
                data-id="'.$destinations->id.'" 
                data-destination-name="'.$destinations->destination_name.'" 
                data-destination-whse-section="'.$destinations->destination_whse_section.'">
            <i class="fas fa-edit"></i> 
            </button>';
            $result .= "<button class='btn btn-sm btn-danger ml-1 btnDeleteCategory' data-id='$destinations->id'><i class='fas fa-trash'></i></button>";
            return $result;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function store_destination(DestinationRequest $request){
        session_start();
        date_default_timezone_set('Asia/Manila');
        $data = $request->validated();

        DB::beginTransaction();
        
        try{
            $destination = new Destination();
            if(isset($request->id)){ //update
                $destination = Destination::find($request->id);
                $destination->destination_name = $data['destination_name'];
                $destination->destination_whse_section = $data['destination_whse_section'];
                $destination->updated_at = NOW();
                $destination->updated_by = $_SESSION['rapidx_username'];
                $destination->save();
                $msg = 'Destination successfully updated!';

            }
            else{ //create
                $destination->destination_name = $data['destination_name'];
                $destination->destination_whse_section = $data['destination_whse_section'];
                $destination->created_at = NOW();
                $destination->created_by = $_SESSION['rapidx_username'];
                $destination->save();
                $msg = 'Destination successfully added!';
               
            }
            DB::commit();

            return response()->json([
                'result' => true,
                'msg' => $msg
            ]);
        }catch(Exemption $e){
            DB::rollback();
            return $e;
        }
        
    }

    public function delete_destination(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        DB::beginTransaction();
        
        try{
            $destination = Destination::find($request->id);
            $destination->deleted_at = NOW();
            $destination->updated_by = $_SESSION['rapidx_username'];
            $destination->save();
        
            DB::commit();

            return response()->json([
                'result' => true,
                'msg' => 'Destination deleted!'
            ]);
        }catch(Exemption $e){
            DB::rollback();
            return $e;
        }
    }
}
