<?php

namespace App\Services;

use App\Model\PetKind;

class PetKindService 
{

protected $model;


 public function __construct(PetKind $PetKind) {
    $this->model = $PetKind;
     }

 public function show($id){
    return $this->model->findOrFail($id);       
     }

 public function delete($id){ 
    return $this->model
        ->findOrFail($id)
        ->delete();          
    }

 public function update($data, $id){
    $pet = $this->model->findOrFail($id);
    $pet->update($data);
    return $pet->fresh();
    }
}