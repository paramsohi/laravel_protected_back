<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserCurrency extends Model
{
    protected $table = 'user_currency';
    protected $fillable = ['user_id','curreny_id'];
}
