<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RapidxUser extends Model
{
    //
    protected $table = "users";
    protected $connection = "mysql_rapidx_user";

}
