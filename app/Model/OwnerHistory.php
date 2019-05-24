<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OwnerHistory extends Model
{
    protected $table = 'owner_history';
    protected $fillable = ['pet_id','user_id'];
}
