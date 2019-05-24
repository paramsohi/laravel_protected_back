<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiLinkRequest extends FormRequest
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
           'name' => 'required|string',
            'username' => 'required|string',
            "url" => 'required|url',
            'password' => 'required|between:6,12|alpha_num',
            'page' => 'required',
            // 'url' => 'required|string',
            'phone' => 'required|numeric|regex:/[0-9]{9}/',
        ];
       return $request;
    }
}
