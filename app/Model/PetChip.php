<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PetChip extends Model
{
protected $table = 'chips';

protected $fillable = ['chipset_id','chip_number','IId','is_free','hide_search','price',

'owner_id','pet_name','previous_owner_id',
];
}
