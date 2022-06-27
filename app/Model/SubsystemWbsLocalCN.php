<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubsystemWbsLocalCN extends Model
{
    //
    protected $table = 'tbl_wbs_local_receiving';
    protected $connection = 'mysql_subsystem_wbs_cn';
}
