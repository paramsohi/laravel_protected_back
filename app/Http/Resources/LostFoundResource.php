<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource;

class LostFoundResource extends BaseResource
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

         'type'=> $request->type,
            // 'CNID'=>$request->CNID,
            'details'=> $request->details,
            'safe'=> $request->safe,
        ];
    }
}
