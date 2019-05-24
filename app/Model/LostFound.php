<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LostFound extends Model
{
    protected $table ='lost_and_found_info';

    protected $fillable =['type','CNId','details','safe',];


      public function Chips()
        {
            return $this->hasOne('App\Model\Chips', 'id', 'CNId');
        }

}
