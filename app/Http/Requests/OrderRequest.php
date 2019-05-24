<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'company_name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:orders',
            'telephone'=> 'required',
            'address1' => 'required|string',
            'address2' => 'required',
            'city' => 'required',
            'postcode' => 'required',
            'country' => 'required',
            'total_paid' => 'required',
            'status' => 'required',
            // 'shipped_date' => 'required',
            // 'payment_method' => 'required|string',
            // 'special_instructions' => 'required|string',
            // 'ip_address'=> 'required|string',
            // 'parcel_tracking_no' => 'required|string',
            // 'how_did_you_find_us' => 'required',
            // 'admin_notes' => 'required|numeric',
            // 'dispatched' => 'required',
            // 'customer_id' => 'required|numeric',
            // 'billing_address1' => 'required|string'
            // 'billing_address2' => 'required',
            // 'billing_city' => 'required|numeric',
            // 'billing_country' => 'required|string',
            // 'billing_postcode' => 'required|string',
            // 'shipping_id' => 'required|string',
            // 'discount_id' => 'required|string',
            // 'saved' => 'required|string',
            // 'vat_rate'=> 'required|string',
            // 'assigned_to' => 'required|string',
            // 'b2b' => 'required|regex:/\b\d{5}\b/',
            // 'shipping_item_id' => 'required|numeric',
            // 'shipping_title' => 'required',
            // 'shipping_cost' => 'required|numeric',
            // 'shipping_duration' => 'required|string'
            // 'in_progress' => 'required|string',
            // 'payment_gateway_ref' => 'required|string',
            // 'pet_upgrade_id'=> 'required|string',
            // 'owner_change_request_id' => 'required|string',
            'price' => 'required',
            'vat_rate' => 'required',
            'qty' => 'required',
            // 'framing_options_id' => 'required',
            'colour' => 'required',
            'size' => 'required',

            'address_type' => 'required|string',
            'telephone' => 'required',
            'email_address' => 'required|string|email|max:255|unique:order_customer_addresse',
            'county' => 'required',
            'home_telephone' => 'required',
            'work_telephone' => 'required',
            'mobile' => 'required',
            

        ];
        return $request;
    }
}
