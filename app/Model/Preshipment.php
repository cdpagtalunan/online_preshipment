<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\UserAccess;


class Preshipment extends Model
{
    //

    public function qc_approver_details(){
        return $this->hasOne(UserAccess::class, 'rapidx_id', 'qc_approver');
    }

}
