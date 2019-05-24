<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource;

class OrederResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
     return [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'company_name' => $request->company_name,
            'email' => $request->email,
            'telephone'=> $request->telephone,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'city' => $request->city,
            'postcode' => $request->postcode,
            'country' => $request->country,
            'total_paid' => $request->total_paid,
            'status' => $request->status,
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
            'price' => $request->price,
            'vat_rate' => $request->vat_rate,
            'qty' => $request->qty,
            // 'framing_options_id' => 'required',
            'colour' => $request->colour,
            'size' => $request->size,

             'address_type' => $request->address_type,
            'telephone' => $request->telephone,
            'email_address' => $request->email_address,
            'county' => $request->county,
            'home_telephone' => $request->home_telephone,
            'work_telephone' => $request->work_telephone,
            'mobile' => $request->mobile,
            
        
        ];
    }
}
