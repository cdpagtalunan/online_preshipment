<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\RapidxUser;

class UserAccess extends Model
{
    //
    protected $table = 'user_access';
    protected $connection = 'mysql';

    public function rapidx_user_details()
    {
    	return $this->hasOne(RapidxUser::class, 'id', 'rapidx_id');
    }
    
}
