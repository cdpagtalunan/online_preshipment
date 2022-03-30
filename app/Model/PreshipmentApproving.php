<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Preshipment;
use App\Model\UserAccess;

class PreshipmentApproving extends Model
{
    //

    public function Preshipment_for_approval(){
        return $this->hasOne(Preshipment::class, 'id', 'fk_preshipment_id');
    }

    public function from_user_details(){
        return $this->hasOne(UserAccess::class, 'rapidx_id', 'from_whse_noter');
    }
}
