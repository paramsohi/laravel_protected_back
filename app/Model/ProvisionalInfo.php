<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProvisionalInfo extends Model
{
    protected $table = 'provisional_info';

    protected $fillable = ['chip_id','name','email_address','phone_number','street1','street2',

                'city','county','country','postcode','hidden_as_owner',];
}
