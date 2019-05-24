<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CurrenyConversionRate extends Model
{
    protected $table = 'curreny_conversion_rate';
    protected $fillable = ['base_currency','to_currency_id','to_currency_name','rate',];
}
