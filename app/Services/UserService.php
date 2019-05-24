<?php

namespace App\Services;

use App\User;
use App\Model\UserAddresses;
use App\Model\UserExtras;
use App\Model\Pet;


class UserService 
    {

    public $successStatus = 200;
    protected $model;
    protected $UserAddresses;
    protected $UserExtras;


    public function __construct(User $User, UserAddresses $UserAddresses, UserExtras $UserExtras){
      $this->model = $User;
      $this->UserAddresses = $UserAddresses;
      $this->UserExtras = $UserExtras;

    }

    public function find($id) {
        $Userid = $this->model->where('id',$id)->first();
        if($Userid == ""){
        return response()->json(['error' => 'User not exist'], 200);     
        }
        return $Userid;
    }

    public function show($id){
        $data = $this->model->where('id',$id)->with(['UserAddresses','UserExtras'])->first();
        return $data;
      }


    public function delete($id){ 
      $Userid = $this->model->where('id',$id)->first();
      if(!$Userid){
      return response()->json(['error' => 'User not exist'], 200);
      }

      $Userid = $this->model->where('id', $id)->delete();
      $Userid = $this->UserAddresses->where('User_id', $id)->delete();
      $Userid = $this->UserExtras->where('User_id', $id)->delete();
      $pet = Pet::where('user_id', $id)->delete();
      return $Userid;
      }


    public function update($id, $data) 
      {
          $User = $this->model->findOrFail($id);
          $User->update($data);

          $User = $this->UserAddresses->Where('User_id', $id);

          $User->update([
          'address_type' => $data['address_type'],
          'street1' => $data['street1'],
          'street2' => $data['street2'],
          'city' => $data['city'],
          'county' => $data['county'],
          'country' => $data['country'],
          'postcode' => $data['postcode'],
          ]);

          $User = $this->UserExtras->Where('User_id', $id);
          $User->update([
          'phone' => $data['phone'],
          // 'level' => $data['level'],
          'is_vet' => $data['is_vet'],
          'pp_response' => $data['pp_response'],
          'is_active' => $data['is_active'],
          // 'secret_question' => $data['secret_question'],
          // 'secret_answer' => $data['secret_answer'],
          // 'admin_notes' => $data['admin_notes'],
          ]);
          $User = $this->model->where('id',$id)->with(['UserAddresses','UserExtras'])->first();
          return $User;
      }

      public function lists() 
        {
          $userList = User::orderBy('id', 'DESC')->paginate(10);
          return $userList;
        }

      public function getallusers() 
        {
          $userList = User::orderBy('id', 'DESC')->get();
          return $userList;
        }

        public function searchusers($data) 
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
          })->get();
            return $user ;
          }
    }