<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChnageRequest extends Model
{
    protected $table = 'ownership_change_requests';

    protected $fillable = ['pet_id','user_id','new_user_id','requested_date','paid','pending_payment_new_user'];
}
