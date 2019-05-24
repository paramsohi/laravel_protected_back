<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DiscountCodeHistory extends Model
{
   protected $table = 'discount_code_history';
   protected $fillable = ['user_id','discount_code',];
}
