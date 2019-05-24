<?php

namespace App\Services;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Model\Chips;
use App\Model\Chipsets;
use App\Model\BreederInfo;
use App\Model\Pet;
use App\Model\UserExtras;
use App\Model\LostFound;
use App\Model\UserAddresses;
use DB;


class PetChipService 
{

  public $successStatus = 200;
  protected $model;
  protected $Chips;


  public function __construct(Chipsets $Chipsets, Chips $Chips)
    {
    $this->model = $Chipsets;
    $this->Chips = $Chips;
    }

  public function show($pet_user_id)
    {
    $data = $this->model->where('user_id',$pet_user_id)->first();
    return $data;
    }

  public function ChipNo($chip_number)
    {
    $data = $this->Chips->where('chip_number',$chip_number)->first();
    return $data;
    }

  public function oldchiplist()
    {
    $oldchiplist = Chips::select('chip_number','owner_id','id')->with(['User', 'BreederInfo','Pet'])->get();
    return $oldchiplist;  
    }

  public function petfrontchiplist($pet_user_id)
    {
    $petfrontchiplist = Pet::select('name','pet_type','chip_no')->with(['Chips'])->where('user_id', $pet_user_id)->get();
    return $petfrontchiplist;  
    }

  public function petfrontchiplistview($chip_number)
    {
    $petfrontchiplistview = Chips::select('chip_number','owner_id')->with('Pet')->where('chip_number', $chip_number)->get();
    return $petfrontchiplistview;  
    }

  public function petfrontchiplistviewupdate($chip_number,$data)
    {
    $petfrontchiplistviewupdate = Pet::where('chip_no',$chip_number)->update($data);
    $PetLogs = Chips::where('chip_number', $chip_number)->update([
    'pet_name' => $data['name'],
    ]);
    return $petfrontchiplistviewupdate;
    }

  public function chiplistviewreport($chip_number,$data)
    {
    $chip_id = Chips::select('id')->where('chip_number',$chip_number)->value('id');
    $LostFound = new LostFound();
    $LostFound->type = $data['type'];
    $LostFound->details = $data['details'];
    $LostFound->CNId = $chip_id;
    $LostFound->save();
    return $LostFound;
    }

  public function chiplistviewdeceased($id, $data)
    {
    $pet = Pet::where('id',$id)->update(['status' => '4']);
    return $pet;
    }

  public function registeranotherpet($pet_user_id, $data)
    {
    $pet_user = Chips::select('owner_id','chipset_id','created_at')->where('owner_id', $pet_user_id)->first();
    $pet_owner_id = $pet_user['owner_id'];
    $pet_chipset_id = $pet_user['chipset_id'];
    $pet_created_at= $pet_user['created_at'];

    $chips = new Chips;
    $chips->chipset_id = $pet_chipset_id;
    $chips->chip_number = $data['chip_number'];
    $chips->owner_id = $pet_owner_id;
    $chips->pet_name = $data['name'];
    $chips->save();

    $chip_id = $chips->id;
    $chip_no = $chips->chip_number;

    $pet = new Pet;
    $pet->user_id = $pet_owner_id;
    $pet->name = $data['name'];
    $pet->pet_type = $data['pet_type'];
    $pet->name = $data['name'];
    $pet->description = $data['description'];
    $pet->medical_info = $data['medical_info']; 
    $pet->breed = $data['breed'];
    $pet->colour = $data['colour'];
    $pet->dob = $data['dob'];
    $pet->sex = $data['sex'];
    $pet->medical_info = $data['medical_info'];
    $pet->status = $data['status'];
    $pet->chip_id = $chip_id;
    $pet->neutered = $data['neutered'];
    $pet->chip_no = $chip_no;
    $pet->save();
    return $pet;
    }

  public function reportlost($chip_number, $data)
    {
    $chip_id = Chips::select('id')->where('chip_number', $chip_number)->value('id');
    $pet_user_id = Pet::select('user_id')->where("chip_no", $chip_number)->value('user_id');
    $user = User::where('id', $pet_user_id);
    $userExtra = UserExtras::where("user_id", $pet_user_id);
    $data['CNId'] = $chip_id;
    $data['type'] = 'lost';
    $data['details'] = $data['details'];
    $lost_and_found_info =  LostFound::create($data);
    return $lost_and_found_info;
    }

  public function documentlist($user_id)
    {
    $Pet = Pet::where('user_id',$user_id)->get();
      foreach ($Pet as $key => $value) { 
      $documentlist = DB::table('chips')
      ->where('owner_id',$value->user_id)
      ->get();
      }
    return $documentlist;
    }

  public function checkChip($chip_number)
    {
    $checkChip = $this->Chips->where('chip_number', $chip_number)->first();
    return $checkChip;
    } 

  private function checkchipfromApis($chip_number)
    {
    $apis = ApiLink::get();
    // print_r($apis);

    }

  public function checkChipNumber($chip_number,$bypass_code)
    {
    $Chips = $this->Chips->select('chip_number','id','owner_id')->where('chip_number', $chip_number)->get();
        foreach ($Chips as $key => $value) {
        $Pet = Pet::select('pet_type','name','breed','sex','colour')->where('chip_no', $value->chip_number)->first(); 
        $User = User::select('firstname','lastname','email')->where(['bypass_code'=> $bypass_code, 'id'=> $value->owner_id])->first();
        $userAddress = UserAddresses::select('street1','city','county','country','postcode')->where('user_id', $value->owner_id)->first();   
        $UserExtras = UserExtras::select('phone')->where('user_id', $value->owner_id)->first(); 
        $value->User = $User;
        $value->Pet = $Pet;
        $value->userAddress = $userAddress;
        $value->UserExtras = $UserExtras;
            if($User){
            return $Chips; 
            }
        }
    }

  public function reportfound($chip_number,$LFdetails)
    {
    $Chips_id = $this->Chips->select('id')->where('chip_number', $chip_number)->value('id');
    $LostFound = new LostFound();
    $LostFound->type = 'lost';
    $LostFound->details = $LFdetails;
    $LostFound->CNId = $Chips_id;
    $LostFound->save();
    return $LostFound;
    }

  public function petfrontchipmicrochips($user_id)
     {
      
       $chips = Chips::select('chip_number','pet_name','id')->where('owner_id', $user_id)->with('Pet')->get();

       foreach ($chips as $value) {
        $BreederInfo = BreederInfo::where('chip_id' , $value->id)->get()->toArray();
        if(count($BreederInfo) >0){
          $value->BreederInfo = 1;
        }else{
          $value->BreederInfo = 0;
        }
        $DealerInfo = DealerInfo::where('chip_id' , $value->id)->get()->toArray();
        if(count($DealerInfo) >0){
          $value->DealerInfo = 1;
        }else{
          $value->DealerInfo = 0;
        }        
        $PetInfo = Pet::where('chip_no' , $value->chip_number)->get()->toArray();
        if(count($PetInfo) >0){
          $value->PetInfo = 1;
        }else{
          $value->PetInfo = 0;
        } 

       }

       return $chips;

     }

}


