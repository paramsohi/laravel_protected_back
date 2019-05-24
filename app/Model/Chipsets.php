<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Chipsets extends Model
{
   protected $table = 'chipsets';

    protected $fillable = ['user_id','serial_no','count','chipset_type','first_chip_no',
    'last_chip_no','notes'];


     public function Chips()
        {

        return $this->hasOne('App\Model\Chips' , 'chipset_id','id');

        }

       

         public function User()
        {
            return $this->hasOne('App\User', 'id', 'user_id');
        }

}
