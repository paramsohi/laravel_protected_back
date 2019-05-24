<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource;

class DiscountResource extends BaseResource
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
          
           'code'=> $request->code,
             'value'=> $request->value,
             'type'=> $request->type,
             'expiry_date'=> $request->expiry_date,
             'single_use'=> $request->single_use,
             'is_deleted'=> $request->is_deleted,
              'currency'=> $request->currency,

        ];
    }
}
