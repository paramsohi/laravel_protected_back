<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductCategoryLinks extends Model
{
   protected $table = 'product_category_links';

  protected $fillable = [
        'product_id','cat_id', 'position',

    ];
public function categoryProduct()
    {
        return $this->belongsTo('App\Model\ProductCategories', 'id', 'cat_id');
    }

    public function Product()
    {
        return $this->belongsTo('App\Model\Product', 'id', 'product_id');
    }

    public function ProductCategories()
    {
        return $this->hasOne('App\Model\ProductCategories', 'id', 'cat_id');
    }
}
