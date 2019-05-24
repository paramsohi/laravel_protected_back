<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{
     protected $table = 'product_categories';

  protected $fillable = [
        'name','description', 'safe_url','parent_id','is_show', 'position','is_master','meta_title','meta_tags',
        'is_featured', 'parent_path','image_url', 'new_image',

    ];

    // protected $with = ['TotalProductCategory'];
	public function toArray()
    {
        $data = parent::toArray();
        $data['totalProduct'] = $this->TotalProductCategory;
        return $data;
    }
      public function ProductCategoryExtras()
    {
        return $this->hasOne('App\Model\ProductCategoryExtras' , 'cat_id','id');
    }


    //  public function ProductCategoryLinks()
    // {
    //     return $this->hasMany('App\Model\ProductCategoryLinks', 'cat_id', 'id');
    // }
    public function getTotalProductCategoryAttribute()
 {
     return $this->belongsTo('App\Model\ProductCategoryLinks', 'id', 'cat_id')->count();

 }

 
}
