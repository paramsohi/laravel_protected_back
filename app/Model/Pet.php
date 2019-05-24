<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
   protected $table = 'pets';

  protected $fillable = [
        'name', 'pet_type','description', 'breed','colour','dob', 'sex','medical_info','chip_id','user_id','status', 'chip_id','level', 'result','for_breeding','breed_no', 'council_name','got_from','breeder','re_homing','house_sale', 'activation_key_id','admin_notes', 'info_preset','pay_token','paid_upgrade', 'paid_late','neutered','date_injected','gold','chip_no', 'stat_country','got_from_name','got_from_address','unregistered','pet_force_upgrade','upgrade_notified','payment_reminder_count','owner_email','pet_safe',

    ];

        
          public function Chips()
            {
                return $this->hasOne('App\Model\Chips', 'chip_number', 'chip_no');
            }

          public function User()
            {
                return $this->hasOne('App\User', 'id', 'user_id');
            }
          public function UserAddresses()
            {
            return $this->hasOne('App\Model\UserAddresses' , 'user_id','user_id');
            }

          public function UserExtras()
            {
            return $this->hasOne('App\Model\UserExtras','user_id', 'user_id');
             }

          
        
    }
