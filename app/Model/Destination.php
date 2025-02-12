<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $table      = 'destinations';
    protected $connection = 'mysql';

    protected $fillable = [
        'destination_name',
        'destination_whse_section',
        'deleted_at',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];
}
