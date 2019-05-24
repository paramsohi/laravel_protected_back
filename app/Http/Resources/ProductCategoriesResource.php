<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoriesResource extends JsonResource
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
         'description'=> $request->description,
         'safe_url'=> $request->safe_url,
         'parent_id'=> $request->parent_id,
         'is_show'=> $request->is_show,
         'position'=> $request->position,
         'is_master'=> $request->is_master,
         'meta_title'=> $request->meta_title,
         'meta_tags'=> $request->meta_tags,
         'is_featured'=> $request->is_featured,
         'parent_path'=> $request->parent_path,
         'image_url'=> $request->image_url,
         'new_image'=> $request->new_image,
         'vet_only'=> $request->vet_only,
         


        ];
    }
}
