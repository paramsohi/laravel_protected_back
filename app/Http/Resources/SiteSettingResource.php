<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource;

class SiteSettingResource extends BaseResource
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
             
             'name' => $request->name,
             'value' => $request->value,
           ];
    }
}
