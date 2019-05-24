<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'firstname' => 'required|string',
           'email' => 'required|string|email|max:255|unique:users',
            // 'password' => 'required',
            'password'=>'required|between:6,12|',
            'login_name' => 'required',
            // 'salt'=> 'required',
            'lastname' => 'required',
            // 'last_login_ip' => 'required',
            // 'chip_id' => 'required',
            // 'last_login_date' => 'required',
           // 'last_password_change_date' => 'required',
            // 'permissions' => 'required',
            // 'reset_ip' => 'required',
            // 'bypass_code'=> 'required',
            // 'implanter_code' => 'required',
            // 'vet_name' => 'required',
            // 'charity_number' => 'required',
            //  'implanter_trained_with' => 'required',
            // 'vet_practice_code' => 'required',
            // 'charity_name'=> 'required',
            // 'council_name' => 'required',
            // 'license_number' => 'required',
            // 'implanter_certificate' => 'required',
            // 'implanter_approved' => 'required',
            // 'sign_in_allowed' => 'required',
            // 'approve_type' => 'required',

            'address_type' => 'required',
           'street1' => 'required',
            'street2' => 'required',
            'city' => 'required',
            'county'=> 'required',
            'country' => 'required',
            'postcode' => 'required',

            'phone' => 'required',
           // 'level' => 'required',
            'is_vet' => 'required',
            'pp_response' => 'required',
            // 'is_active'=> 'required',
            // 'secret_question' => 'required',
            // 'secret_answer' => 'required',
            // 'admin_notes' => 'required',
        ];
    }
}
 
 