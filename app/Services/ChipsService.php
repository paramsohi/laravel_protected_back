<?php

namespace App\Services;
use App\User;
use App\Model\Chips;
use App\Model\Chipsets;


class ChipsService 
    {

    public $successStatus = 200;
    protected $model;
    protected $Chips;


    public function __construct(Chipsets $Chipsets, Chips $Chips){
        $this->model = $Chipsets;
        $this->Chips = $Chips;
      }

    public function show($id){
        $data = $this->model->where('id',$id)->with(['Chips'])->first();
        return $data;
      }

    public function delete($id){ 
        $chipid = $this->model->findOrFail($id)->first();
        if(!$chipid){
        return response()->json(['error' => 'Chips not exist'], 400);
        }
        $chipid = $this->model->findOrFail($id)->delete();
        $chipid = $this->Chips->findOrFail($id)->delete();
        return $chipid;
      }

    public function update($id, $data)  {  
       $chipUpdate = $this->model->findOrFail($id);
       $chipUpdate->update($data);
       $chipUpdate = $this->Chips->findOrFail($id); 
       $chipUpdate->update([
        'chip_number' => $data['chip_number'],
        'owner_id' => $data['owner_id'],
        'is_free' => $data['colour'],
        'hide_search' => $data['size'],
        'price' => $data['price'],
        'pet_name' => $data['pet_name'],
        'previous_owner_id' => $data['previous_owner_id'],
        ]);
      
        $chipUpdate = $this->model->where('id',$id)->with(['Chips'])->first();
        return $chipUpdate;
     }

     public function lists() {
         $chipList = Chipsets::select('serial_no','first_chip_no','last_chip_no','id','user_id','updated_at')->with(['User'])->get();
         return $chipList;
      }

      //here id for get chips data and user_id for userdata
     public function petChipList() {
        $petChipList = Chips::select('chip_number','owner_id','updated_at')->with(['User'])->get();
        return $petChipList;
      }

      public function checkchip($chip_number){
        //die($chip_number);
         $Chips = Chips::where('chip_number', $chip_number)->get()->toArray();
          //print_r($Chips); die;
         if(empty($Chips)){
          return response()->json(['message' => 'This chip does not exist in our database. It may be registered on a different database', 'status'=>400], 400); 
         }else{
            //die($Chips[0]['owner_id']);
            $pet = Pet::select('name','breed','pet_type','colour','dob','sex','chip_no','got_from_name','got_from_address','for_breeding','neutered','medical_info','description','for_breeding')->where('chip_no',$chip_number)->first();
            return $pet;
         }

       }
      
    }

