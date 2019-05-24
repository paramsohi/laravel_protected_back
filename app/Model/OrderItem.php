<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
   protected $table = 'order_items';

  protected $fillable = ['order_id','product_id','price','vat_rate','qty','framing_options_id','colour','size',];


   public function Product()
    {
        return $this->hasMany('App\Model\Product', 'id', 'product_id');
    }

     public function Order()
    {
        return $this->hasMany('App\Model\Order' , 'id','order_id');
    }

}
