<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class States extends Model
{
      protected $table = 'states';
   protected $fillable = ['name','country_id',];
}
