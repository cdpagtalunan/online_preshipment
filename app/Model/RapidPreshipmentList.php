<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RapidPreshipmentList extends Model
{
    protected $table = "tbl_PreShipmentTransaction";
    protected $connection = "mysql_rapid";
}
