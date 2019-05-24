<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChipsRequest extends FormRequest
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
             'serial_no' => 'required|string',
             'count' => 'required|string',
             'chipset_type' => 'required|string',
             'first_chip_no' => 'required|string',
             'last_chip_no' => 'required|string',
             'notes' => 'required|string',

             'chip_number' => 'required|string',
             // 'IId' => 'required|string',
             // 'is_free' => 'required|string',
             // 'hide_search' => 'required|string',
             // 'price' => 'required|string',
             // 'pet_name' => 'required|string',
             // 'previous_owner_id' => 'required|string',
        ];
    }
}

