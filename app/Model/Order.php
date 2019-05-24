<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   protected $table = 'orders';

  protected $fillable = ['firstname','lastname','company_name','email','telephone','address1','address2','city','postcode','country','order_amount','status','shipped_date','payment_method','special_instructions','ip_address','parcel_tracking_no','how_did_you_find_us','admin_notes','paid','dispatched','customer_id','billing_address1','billing_address2','billing_city','billing_country','billing_postcode','shipping_id','discount_id','saved','vat_rate','assigned_to','b2b','shipping_item_id','shipping_title','shipping_cost','shipping_duration','in_progress','payment_gateway_ref','pet_upgrade_id','owner_change_request_id',];


 public function OrderItem()
    {
        return $this->hasOne('App\Model\OrderItem' , 'order_id','id');
    }

 public function OrderCustomerAddresse()
    {
        return $this->hasOne('App\Model\OrderCustomerAddresse' , 'user_Id','customer_id');
    }


}
