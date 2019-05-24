<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Chips extends Model
{
    protected $table = 'chips';

    protected $fillable = ['chipset_id','chip_number','IId','is_free','hide_search','price',
    'owner_id','pet_name','previous_owner_id'];


   public function User()
        {
            return $this->hasOne('App\User', 'id', 'owner_id');
        }


        public function BreederInfo()
        {
            return $this->hasOne('App\Model\BreederInfo', 'chip_id', 'id');
        }

        public function Pet()
        {
            return $this->hasOne('App\Model\Pet', 'chip_id', 'id');
        }
    
     

   }

