<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WbsIqcMatrix extends Model
{
    protected $table = "tbl_iqc_matrix";
    protected $connection = "mysql_subsystem_pmi_ts";
}
