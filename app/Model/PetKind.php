<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PetKind extends Model
{
    protected $table = 'pet_kinds';

  protected $fillable = ['name'];
}
