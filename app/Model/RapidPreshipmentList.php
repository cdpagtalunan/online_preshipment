<?php

namespace App\Model;

use App\Model\RapidDieset;
use Illuminate\Database\Eloquent\Model;

class RapidPreshipmentList extends Model
{
    protected $table = "tbl_PreShipmentTransaction";
    protected $connection = "mysql_rapid";

    public function dieset_info(){
        return $this->hasOne(RapidDieset::class, 'R3Code', 'Partscode');
    }
}
