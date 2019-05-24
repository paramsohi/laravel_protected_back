<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends BaseResource
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
        // dd($request);
      
        return [
        // 'id'=>$request->id,
        // 'id' => $request['id'],
         'firstname' => $request->firstname,
           'email' => $request->email_address,
            'password' => $request->password,
            'login_name' => $request->login_name,
            // 'salt'=> 'required',
            'lastname' => $request->lastname,
            // 'last_login_ip' => 'required',
            // 'chip_id' => 'required',
            // 'last_login_date' => 'required',
           // 'last_password_change_date' => 'required',
            // 'permissions' => 'required',
            // 'reset_ip' => 'required',
            // 'bypass_code'=> 'required',
            // 'implanter_code' => 'required',
            // 'vet_name' => 'required',
            'charity_number' => $request->charity_number,
             'implanter_trained_with' => $request->implanter_trained_with,
            'vet_practice_code' => $request->vet_practice_code,
            'charity_name'=> $request->charity_name,
            // 'council_name' => 'required',
            // 'license_number' => 'required',
            // 'implanter_certificate' => 'required',
            // 'implanter_approved' => 'required',
            // 'sign_in_allowed' => 'required',
            // 'approve_type' => 'required',

            'address_type' => $request->address_type,
           'street1' => $request->street1,
            'street2' => $request->street2,
            'city' => $request->city,
            'county'=> $request->county,
            'country' => $request->country,
            'postcode' => $request->postcode,

            'phone' => $request->phone,
           // 'level' => 'required',
            'is_vet' => $request->is_vet,
            'pp_response' => $request->pp_response,
             'is_active'=> $request->is_active,
            // 'secret_question' => 'required',
            // 'secret_answer' => 'required',
            // 'admin_notes' => 'required',
         ];
    }
}
