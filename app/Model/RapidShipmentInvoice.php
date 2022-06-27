<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RapidShipmentInvoice extends Model
{
    protected $table = "tbl_ShipmentInvoice";
    // protected $connection = "mysql_rapid_live";
    protected $connection = "mysql_rapid";

}
