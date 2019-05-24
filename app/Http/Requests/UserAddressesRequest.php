<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAddressesRequest extends FormRequest
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
             'name' => 'required|string',
           'description' => 'required|string',
            'breed' => 'required|string',
            'colour' => 'required|string',
            'dob'=> 'required|date',
            'sex'=>'boolean|integer|required',
            'medical_info' => 'required|string',
            'chip_id' => 'required|numeric',
        ];
    }
}
