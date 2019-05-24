<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource;

class ApiLink extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [

            'name' => $this->name,
            'username' => $this->username,
            'password' => $this->password,
            'page' => $this->page,
            'url' => $this->url,
            'phone' => $this->phone,

        ];
    }
}
