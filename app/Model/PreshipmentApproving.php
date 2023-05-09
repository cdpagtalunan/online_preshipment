<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// use App\Model\Preshipment;
use App\Model\UserAccess;
use App\Model\RapidxUser;
use App\Model\RapidPreshipment;

class PreshipmentApproving extends Model
{
    //

    // public function Preshipment_for_approval(){
    //     return $this->hasOne(Preshipment::class, 'id', 'fk_preshipment_id');
    // }
    protected $table = "preshipment_approvings";
    protected $connection = "mysql";

    public function preshipment(){
        return $this->hasOne(RapidPreshipment::class, 'id', 'fk_preshipment_id');
    }
    
    public function checked_by_details(){
        return $this->hasOne(UserAccess::class, 'rapidx_id', 'checked_by');
    }

    public function checked_by_details_from_rapidx_user(){
        return $this->hasOne(RapidxUser::class, 'id', 'checked_by');
    }


    public function qc_approver_details(){
        return $this->hasOne(UserAccess::class, 'rapidx_id', 'qc_checker');
    }

    public function from_user_details(){
        return $this->hasOne(UserAccess::class, 'rapidx_id', 'from_whse_noter');
    }

    public function to_whse_noter_details(){
        return $this->hasOne(UserAccess::class, 'rapidx_id', 'to_whse_noter');
    }

    public function whse_uploader_details(){
        return $this->hasOne(UserAccess::class, 'rapidx_id', 'whse_uploader');
    }

    public function whse_superior_details(){
        return $this->hasOne(UserAccess::class, 'rapidx_id', 'whse_superior_noter');
    }
}
