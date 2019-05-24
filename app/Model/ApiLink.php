<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApiLink extends Model
{
     protected $table = 'api_links';

  protected $fillable = [
        'name', 'username','password', 'page','url','phone', 
        

    ];
}
