<?php

namespace App\Model;

use App\Model\PreshipmentApproving;
use App\Model\RapidShipmentInvoice;
use Illuminate\Database\Eloquent\Model;

class RapidPreshipment extends Model
{
    protected $table = "tbl_PreShipment";
    protected $connection = "mysql_rapid";
    public $timestamps = false;


    public function rapidx_preshipment_app_details(){
        return $this->hasOne(PreshipmentApproving::class, 'fk_preshipment_id', 'id');
    }
    public function rapid_shipment_invoice_details(){
        return $this->hasOne(RapidShipmentInvoice::class, 'id_tbl_PreShipment', 'id');
    }
}
