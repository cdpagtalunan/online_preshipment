<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RapidDieset extends Model
{
    protected $table = "tbl_dieset";
    protected $connection = "mysql_rapid";
    public $timestamps = false;
}
