<?php

namespace App\Services;

use App\Model\LostFound;
use App\Model\Chips;
use App\User;


class LostFoundService 
  {

    public $successStatus = 200;
    protected $model;

    public function __construct(LostFound $LostFound) {
      $this->model = $LostFound;
      }

    public function show($id) {
      $data = $this->model->where('id',$id)->first();
       return $data;
      }

    public function delete($id){ 
      $LostFoundDelete = $this->model->findOrFail($id)->first();
      if(!$LostFoundDelete){
       return response()->json(['message' => ' not exist'], 400);
       }
      $LostFoundDelete = $this->model->findOrFail($id)->delete();
      return $LostFoundDelete;
       }

    public function update($id, $data)  { 
      $LostFoundUpdate = $this->model->findOrFail($id);
      $LostFoundUpdate->update($data);
       return $LostFoundUpdate;
      }

        public function lists() {
        $LostFoundList = LostFound::select('id','type','created_at','CNId')->get();
           foreach ($LostFoundList as $key) {
          $pet_name = Chips::select('id','owner_id','chip_number','pet_name')->where('id',$key->CNId)->first();
          $ownerid = $pet_name->owner_id;
          $owner_name = User::select('id','firstname','lastname')->where('id',$ownerid)->first();
          $key->pet_detail =$pet_name;
          $key->owner_detail =$owner_name;

          }
        return $LostFoundList;
      }

      public function approverUsersList(){
        $approverUsersList = User:: select('id','firstname','lastname','email','implanter_trained_with','license_number','approve_type','implanter_code')->where('sign_in_allowed','1')->get();
        return $approverUsersList;
      }

      public function approverUser($id){  
        $approverUsers = User::where('id',$id)->update(['sign_in_allowed' => '1']);        
        return $approverUsers;
      }
    public function declineUsers($id){
      $declineUsers = User::where('id', $id)->delete();
      return $declineUsers;
    }

    public function searchlostfound($data) 
        {

        $user = Chips::where(function($query) use($data){

          if($data->has('chip_number')){
          $query->where('chip_number','LIKE','%'.$data->chip_number.'%');
          }

          if($data->has('pet_name')){
          $query->Where('pet_name','LIKE','%'.$data->pet_name.'%');
          }
      
          if($data->has('firstname')){
          $query->whereHas('User', function($query) use($data){
              $query->where('firstname','LIKE','%'.$data->firstname.'%');
          });
          }
  
      })->get();

          return $user ;

        }

      public function searchapproverusers($data) 
        {

        $user = User::where(function($query) use($data){

          if($data->has('firstname')){
          $query->where('firstname','LIKE','%'.$data->firstname.'%');
          }

          if($data->has('lastname')){
          $query->Where('lastname','LIKE','%'.$data->lastname.'%');
          }

          if($data->has('email')){
          $query->Where('email','LIKE','%'.$data->email.'%');
          }

          if($data->has('approve_type')){
          $query->Where('approve_type','LIKE','%'.$data->approve_type.'%');
          }

          if($data->has('implanter_code')){
          $query->Where('implanter_code','LIKE','%'.$data->implanter_code.'%');
          }

           if($data->has('implanter_trained_with')){
          $query->Where('implanter_trained_with','LIKE','%'.$data->implanter_trained_with.'%');
          }
  
      })->get();

          return $user ;

        }
    }

  
            