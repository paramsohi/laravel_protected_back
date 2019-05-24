<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoriesRequest extends FormRequest
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
        return [
                
         'name'=>'required',
         'description'=>'required',
         // 'safe_url'=>'required',
         'parent_id'=>'required',
         'is_show'=>'required',
         'position'=>'required',
         'is_master'=>'required',
         'meta_title'=>'required',
         'meta_tags'=>'required',
         'is_featured'=>'required',
         'parent_path'=>'required',
         // 'image_url'=>'required',
         'image_url'=>'required|image|mimes:jpg,png,jpeg',
         'is_featured'=>'required',
         'vet_only'=>'required',
         'position'=>'required',
         
         
            
        ];
    }
}

