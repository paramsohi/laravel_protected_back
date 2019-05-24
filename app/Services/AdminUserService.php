<?php

namespace App\Services;

use App\Admin;

class AdminUserService 
{

   protected $model;

   public function __construct(Admin $Admin){
      $this->model = $Admin;
    }


   public function show($id){
      $data = $this->model->where('id',$id)->first();
      return $data ;
     }

   public function find($id) {
      $Userid = $this->model->where('id',$id)->first();
      return $Userid;
      }
      
   public function delete($id){ 
      $Userid = $this->model->where('id',$id)->first(); 
                $Userid->delete(); 
      return $Userid;
        }
    
   public function update($id, $data){  
      $Admin = $this->model->findOrFail($id);
      $data['password'] = bcrypt($data['password']);
      $Admin->update($data);
      return $Admin->fresh();
     }

  public function lists() {
    $adminList = Admin::get();
    return $adminList;
    }
}