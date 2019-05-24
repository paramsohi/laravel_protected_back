<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserAddresses extends Model
{
     protected $table = 'user_addresses';

  protected $fillable = ['user_id','address_type','street1','street2','city','county',

      'country', 'postcode',
      ];


          public function UserExtras()
    {
        return $this->hasOne('App\Model\UserExtras','user_id', 'user_id');
    }

}
