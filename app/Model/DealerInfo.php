<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DealerInfo extends Model
{
    protected $table = 'dealer_info';
     protected $fillable = ['chip_id','kennel','name','email_address','phone','street1','street2','city',
         'county','country','postcode','licence_number','council_name',];
}
