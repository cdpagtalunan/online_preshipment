<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\PreshipmentApproving;

class RapidPreshipment extends Model
{
    protected $table = "tbl_PreShipment";
    protected $connection = "mysql_rapid";
    public $timestamps = false;


    public function rapidx_preshipment_app_details(){
        return $this->hasOne(PreshipmentApproving::class, 'fk_preshipment_id', 'id');
    }
}
