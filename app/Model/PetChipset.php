<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PetChipset extends Model
{
    protected $table = 'chipsets';

  protected $fillable = [
        'user_id', 'serial_no', 'count','chipset_type','first_chip_no', 'last_chip_no','notes',
    ];



         public function PetChip()
        {

        return $this->hasOne('App\Model\PetChip' , 'chipset_id','id');

        }
}
