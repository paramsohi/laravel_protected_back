<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource;

class ProductResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
           'name' => $request->name,
            'description' => $request->description,
            'tags' => $request->tags,
            'price'=> $request->price,
            // 'vat'=> 'required',
            // 'stock' => 'required',
            // 'stock_alert' => 'required',
            // 'safe_url' => 'required',
            // 'meta_title' => 'required',
            // 'meta_tags' => 'required',
            // 'is_featured' => 'required',
            // 'on_sale'=> 'required',
             'sale_price' => $request->sale_price,
            // 'group_master' => 'required',
            // 'group_value' => 'required',
            // 'image_new' => 'required',
            // 'is_restricted' => 'required',
            // 'price_sale' => 'required',
            // 'colours'=> 'required',
            // 'sizes' => 'required',

             
             // 'image_url' => 'required',
             'position' => $request->position,
             'meta_title' => $request->meta_title,
             // 'gallery_img' => 'required',
             

        ];
    }
}
