<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Preshipment;


class PreshipmentList extends Model
{
    //

    // protected $table = 'preshipment_lists';

    public function Preshipment(){
        return $this->hasOne(Preshipment::class, 'id', 'fkControlNo');
    }

}
