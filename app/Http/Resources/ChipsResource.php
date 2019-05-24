<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource;

class ChipsResource extends BaseResource
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
            return  [
              
              'serial_no' => $request->serial_no,
              'count' => $request->count,
              'chipset_type' => $request->chipset_type,
              'first_chip_no' => $request->first_chip_no,
              'last_chip_no' => $request->last_chip_no,
              'notes' => $request->notes,
              'chip_number' => $request->chip_number,
              // 'IId' => $request->IId,
              // 'is_free' => $request->is_free,
              // 'hide_search' => $request->hide_search,
              // 'price' => $request->price,
              // 'pet_name' => $request->pet_name,
              // 'previous_owner_id' => $request->previous_owner_id,

            ];
    
    }
}

        