<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    protected $table = 'baskets';
    protected $fillable = ['user_id','ip_address','flat_discount_type','flat_discount_amount','complete'];
}
