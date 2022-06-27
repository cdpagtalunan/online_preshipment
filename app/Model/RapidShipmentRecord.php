<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RapidShipmentRecord extends Model
{
    //

    protected $table = "vw_shipment_report";
    protected $connection = "mysql_rapid";
    // protected $connection = "mysql_rapid_live";
}
