<?php

namespace App\Services;

use App\Model\ApiLink;

class ApiLinkService 
{

    protected $model;

    public function __construct(ApiLink $ApiLink){
    $this->model = $ApiLink;
    }

    public function show($id){
      $data = $this->model->where('id',$id)->first();
      return $data;
      }

    public function delete($id) {
       $vendor = $this->model->findOrFail($id);
      if(!$vendor){
     return response()->jason(['error' => 'vendor not exist']);
        }
       $vendor = $this->model->where('id', $id)->delete();  
       return $vendor;
     }

    public function update($id, $data) { 
        $vendorupdate = $this->model->findOrFail($id);
        $vendorupdate->update($data);
        return $vendorupdate;
        }

}