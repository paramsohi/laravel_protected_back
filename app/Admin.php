<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Admin extends Authenticatable
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
    'is_admin','is_account_manager','is_sales_admin','added_by','account_manager','last_login','last_active','can_pay_invoice','can_pay_online','can_pay_credit','credit_limit','account_balance','email','emailNew','password','salt','name','surname', 'phone','address1','address2','town','county','postcode','is_active','is_disabled','hash_create_account','sent_create_account','hash_password_reset','sent_password_reset','hash_change_email','sent_change_email','user_level','account_number','company_name','launch_account',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
