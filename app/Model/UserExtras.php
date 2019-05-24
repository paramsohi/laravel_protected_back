<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserExtras extends Model
{
    protected $table = 'user_extras';

  protected $fillable = ['user_id','phone','level','is_vet','pp_response','is_active',

      'secret_question','secret_answer','admin_notes',
      ];
}
