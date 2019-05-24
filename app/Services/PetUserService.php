<?php

namespace App\Services;

use App\User;
use App\Model\UserAddresses;
use App\Model\UserExtras;
use App\Model\Pet;
use App\Model\Chips;
use App\Model\ChnageRequest;
use Carbon;
use App\Model\OwnerHistory;


class PetUserService 
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

    public function show($id)
     {
        $data = $this->model->where('id',$id)->with(['UserAddresses','UserExtras'])->first();
        return $data;
      }


    public function delete($id)
      { 
      $Userid = $this->model->where('id',$id)->first();
      if(!$Userid){

      return response()->json(['error' => 'User not exist'], 200);
      }

      $Userid = $this->model->where('id', $id)->delete();
      $Userid = $this->UserAddresses->where('User_id', $id)->delete();
      $Userid = $this->UserExtras->where('User_id', $id)->delete();

      return $Userid;
      }



    public function update($id, $data) {
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

    public function lists() {
        $userList = User::get();
        return $userList;
      }

    public function userhistory($pet_user_id){
        $Pet = Pet::select('id','chip_no','chip_id')->where('user_id', $pet_user_id)->get();
        foreach ($Pet as $key => $value) {
        $Chips = Chips::select('owner_id','previous_owner_id')->where('chip_number', $value->chip_number)->get();
          $value->Chips = $Chips;
           }
        return $Pet;
         }

       public function changeowner($pet_user_id, $pet_id, $data){

          $main_user_id = User::select('id')->where('id', $pet_user_id)->value('id');

           $user = new User();
           $user->firstname = $data['firstname'];
           $user->lastname = $data['lastname'];
           $user->email = $data['email'];
           $user->password = bcrypt($data['password']);
           $user->save();
           $neww_user_id = $user->id ;
            

           $userAddress = new UserAddresses();
           $userAddress->user_id = $neww_user_id;
           $userAddress->address_type = $data['address_type'];
           $userAddress->street1 = $data['street1'];
           $userAddress->street2 = $data['street2'];
           $userAddress->city = $data['city'];
           $userAddress->county = $data['county'];
           $userAddress->country = $data['country'];
           $userAddress->postcode = $data['postcode'];
           $userAddress->save();

           $userExtras = new UserExtras();
           $userExtras->user_id = $neww_user_id;
           $userExtras->phone = $data['phone'];
           $userExtras->save();

           $Chnage = new ChnageRequest();
           $Chnage->pet_id = $pet_id;
           $Chnage->user_id = $main_user_id;
           $Chnage->new_user_id = $neww_user_id;
            $Chnage->requested_date = Carbon\Carbon::now();
           $Chnage->save();

          return $Chnage;
       }
    public function ownerhistory($pet_user_id){
       $pet_detail = Pet::where('user_id',$pet_user_id)->get();
       $Owner_detail = OwnerHistory::with(['User','User1'])->get();
       $data['pet_detail'] = $pet_detail;
       $data['Owner_detail'] = $Owner_detail;
      return $data;
     }

    }