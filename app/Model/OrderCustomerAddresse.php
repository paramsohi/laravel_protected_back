<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderCustomerAddresse extends Model
{
    protected $table = 'order_customer_addresse';

  protected $fillable = ['user_Id','address_type','firstname','lastname','email_address','address1','address2','address3','city','county','postcode','country','home_telephone','work_telephone','mobile',];
}
