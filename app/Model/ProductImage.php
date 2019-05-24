<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';

  protected $fillable = ['product_id','image_url','position','meta_title','gallery_img',
  ];
}
