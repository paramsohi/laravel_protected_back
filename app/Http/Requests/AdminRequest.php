<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return false;
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
            'surname' => 'required|string',
            'phone' => 'required|numeric|regex:/[0-9]{9}/',
            'address1' => 'required|string',
            'address2' => 'required|string',
            'town' => 'required|string',
            'county' => 'required|string',
            'postcode' => 'required|regex:/\b\d{5}\b/',
            'company_name' => 'required|string',
            'email' =>'required|string|email|max:255|unique:admins',
            // 'password' => 'required',

            'password'=>'required|between:6,12|alpha_num',
        // 'password_confirmation'=>'required|between:8,12|alpha_num'
            // 'is_account_manager' => 'required',
            // 'is_sales_admin' => 'required',
            // 'account_manager' => 'required',
            // 'last_login' => 'required',
            // 'last_active' => 'required',
            // 'can_pay_invoice' => 'required',
            // 'can_pay_online' => 'required',
            // 'can_pay_credit' => 'required',
            // 'credit_limit' => 'required',
            // 'account_balance' => 'required',
            // 'emailNew' => 'required',
            // 'salt' => 'required',
            'is_active' => 'required',
            // 'is_disabled' => 'required',
            // 'hash_create_account' => 'required',
            // 'sent_create_account' => 'required',
            // 'hash_password_reset' => 'required',
            // 'sent_password_reset' => 'required',
            // 'hash_change_email' => 'required',
            // 'sent_change_email' => 'required',
            // 'user_level' => 'required',
            // 'account_number' => 'required',
            // 'company_name' => 'required',
            // 'launch_account' => 'required',

        ];

        return $request ;
    }
}
 