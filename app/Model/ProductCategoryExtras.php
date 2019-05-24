<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductCategoryExtras extends Model
{
    protected $table = 'product_category_extras';

  protected $fillable = [
        'cat_id','vet_only', 

    ];

}
