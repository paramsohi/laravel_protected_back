<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasMultiAuthApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];
     protected $fillable = [
        'firstname', 'email', 'password','login_name','salt','lastname','last_login_ip',
        'last_login_date','last_password_change_date','permissions','reset_ip','bypass_code',
        'implanter_code','vet_name','charity_number','implanter_trained_with','vet_practice_code',
        'charity_name','council_name','license_number','implanter_certificate','implanter_approved',
        'sign_in_allowed','approve_type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
        public function UserAddresses()
    {
        return $this->hasOne('App\Model\UserAddresses' , 'user_id','id');
    }

     public function UserExtras()
    {
        return $this->hasOne('App\Model\UserExtras','user_id', 'id');
    }


   
    
}
