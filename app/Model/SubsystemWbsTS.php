<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubsystemWbsTS extends Model
{
    protected $table = 'tbl_wbs_material_receiving';
    protected $connection = 'mysql_subsystem_wbs_ts';
}
