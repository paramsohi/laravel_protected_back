<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'discount_codes';

    protected $fillable = ['code','value','type','expiry_date','single_use','is_deleted',
    'currency',];
}
