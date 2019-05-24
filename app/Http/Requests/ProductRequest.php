<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
    
        $request = [
           'name' => 'required',
            'description' => 'required',
            'tags' => 'required',
            'price'=> 'required',
            // 'vat'=> 'required',
            // 'stock' => 'required',
            // 'stock_alert' => 'required',
            // 'safe_url' => 'required',
            // 'meta_title' => 'required',
            // 'meta_tags' => 'required',
            // 'is_featured' => 'required',
            // 'on_sale'=> 'required',
             'sale_price' => 'required',
            // 'group_master' => 'required',
            // 'group_value' => 'required',
            // 'image_new' => 'required',
            // 'is_restricted' => 'required',
            // 'price_sale' => 'required',
            // 'colours'=> 'required',
            // 'sizes' => 'required',

             
             // 'image_url' => 'required',
             'position' => 'required',
             'meta_title' => 'required',
             'gallery_img' => 'required|image|mimes:jpg,png,jpeg',
             'position' => 'required',
        ];
       // dd($request);
        return $request;
    }
}
