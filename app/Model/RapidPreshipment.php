<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RapidPreshipment extends Model
{
    protected $table = "tbl_PreShipment";
    protected $connection = "mysql_rapid";
    public $timestamps = false;
}
