<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource;


class AdminResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

           return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'phone' => $this->phone,
            'address1' => $this->address1,
            'address2' => $this->address2,
            'town' => $this->town,
            'county' => $this->county,
            'postcode' => $this->postcode,
            'company_name' => $this->company_name,
            'email' =>$this->email,
            'password' => $this->password,
            'is_admin' => $this->is_admin,
        ];
        //dd($request);
    }
}
