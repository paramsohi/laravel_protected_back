<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource;

class PetResource extends BaseResource
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
           'description' => $request->description,
            'breed' => $request->breed,
            'colour' => $request->colour,
            'dob'=> $request->dob,
            'sex' =>$request->sex,
            'medical_info' => $request->medical_info,
           //  'chip_id' => $request->chip_id,
 
           //  'status' => $request->status,
           // 'level' => $request->level,
           //  'result' => $request->result,
           //  'for_breeding' => $request->for_breeding,
           //  'council_name'=> $request->council_name,
           //  'got_from' => $request->got_from,
            
           //  'breeder' => $request->breeder,
           // 're_homing' => $request->re_homing,
           //  'house_sale' => $request->house_sale,
           //  'activation_key_id' => $request->activation_key_id,
           //  'admin_notes'=> $request->admin_notes,
           //  'info_preset' => $request->info_preset,
           //  'pay_token' => $request->pay_token,
           //  'paid_upgrade' => $request->paid_upgrade,
           // 'paid_late' => $request->paid_late,
           //  'neutered' => $request->neutered,
           //  'date_injected' => $request->date_injected,
           //  'gold'=> $request->gold,
           //  'chip_no_string' => $request->chip_no_string,
           //  'got_from_name' => $request->got_from_name,
           //   'got_from_address' => $request->got_from_address,
           //  'unregistered' => $request->unregistered,
           //  'pet_force_upgrade' => $request->pet_force_upgrade,
           //  'upgrade_notified'=> $request->upgrade_notified,
           //  'payment_reminder_count' => $request->payment_reminder_count,
           //  'owner_email' => $request->owner_email,
           //  'pet_safe' => $request->pet_safe,
        
        ];

    }
}




