<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     protected $table = 'product_live';

  protected $fillable = ['name','description','tags','price','vat','stock','stock_alert','safe_url','meta_title','meta_tags','is_featured','is_active','on_sale','sale_price','group_master','group_value','image_new','is_restricted','price_sale','currency_id','colours','sizes',];


    public function ProductImage()
    {
        return $this->hasOne('App\Model\ProductImage' , 'product_id','id');
    }

     public function ProductCategoryLinks()
    {
        return $this->hasOne('App\Model\ProductCategoryLinks' , 'product_id','id');
    }

    public function Currency()
    {
        return $this->hasOne('App\Model\Currency' , 'id','currency_id');
    }
}
