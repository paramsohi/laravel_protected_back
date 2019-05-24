<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource;

class ApiLinkResource extends BaseResource
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

            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
            'page' => $request->page,
            'url' => $request->url,
            'phone' => $request->phone,

        ];
    }
}
