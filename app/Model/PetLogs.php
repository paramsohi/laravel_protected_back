<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PetLogs extends Model
{
    protected $table = 'pet_logs';
    protected $fillable =['pet_id','user_id','pet_name','action','action_data',];
}
