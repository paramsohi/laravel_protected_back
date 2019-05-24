<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BasketProduct extends Model
{
    protected $table = 'basket_products';
    protected $fillable =['user_id','product_id','extra','category_id','quantity'];
}
