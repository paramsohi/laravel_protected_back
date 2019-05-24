<?php

namespace App\Services;

use App\Model\Pet;
use App\Model\PetKind;
use App\Model\Chips;
use App\User;
use App\Model\ProvisionalInfo;
use App\Model\UserAddresses;
use App\Model\UserExtras;
use App\Model\BreederInfo;
use App\Model\DealerInfo;
use App\Model\PetLogs;
use App\Model\OwnerHistory;
use App\Model\ChnageRequest;




class PetService 
{
public $successStatus = 200;
protected $model;
protected $PetChip;
protected $PetKind;
protected $User;
protected $UserAddresses;
protected $UserExtras;
protected $PetLogs;

public function __construct(Pet $Pet, PetKind $PetKind, User $User, ProvisionalInfo $ProvisionalInfo, UserAddresses $UserAddresses, UserExtras $UserExtras, PetLogs $PetLogs)
	{
		$this->model = $Pet;
		$this->PetKind = $PetKind;
		$this->User = $User;
		$this->ProvisionalInfo = $ProvisionalInfo;
		$this->UserAddresses = $UserAddresses;
		$this->UserExtras = $UserExtras;
    $this->PetLogs = $PetLogs;
		
    }


 public function show($id){   
		$data = $this->model->where('id',$id)->first();        
		return $data;
   }

 public function delete($id){
		$petid = $this->model->where('id', $id)->delete();
    $PetLogs = $this->PetLogs->where('pet_id', $id)->delete();
		return $petid;
	 }

 public function update($id, $data){  
    $User = $this->model->findOrFail($id);
		$User->update($data);  
    $data1 = json_encode($data);
    $PetLogs = $this->PetLogs->where('pet_id', $id)->update([
         'pet_name' => $data['name'],
         'action' => 'update',
         'action_data' => $data1,
        ]);
		    return $User;
	   }

	 public function updatepetowner($id, $data){
      $User_chip_id = $this->model->select('chip_id')->where('id',$id)->value('chip_id');
      $User = ProvisionalInfo::where('chip_id',$User_chip_id);
      $User->update($data);
      $Userdata = ProvisionalInfo::where('chip_id',$User_chip_id)->get();
		 return $Userdata;
	  }

   public function updatechipowner($id, $data){
      $User_id = $this->model->select('user_id')->where('id',$id)->value('user_id');
       $User = UserAddresses::Where('user_id', $User_id)->update([
        'address_type' => $data['address_type'],
        'street1' => $data['street1'],
        'street2' => $data['street2'],
        'city' => $data['city'],
        'county' => $data['county'],
        'country' => $data['country'],
        'postcode' => $data['postcode'],
        ]);
       $User = $this->UserExtras->Where('User_id', $User_id)->update([
        'phone' => $data['phone'],
        // 'level' => $data['level'],
        'is_vet' => $data['is_vet'],
        'pp_response' => $data['pp_response'],
        'is_active' => $data['is_active'],
        // 'secret_question' => $data['secret_question'],
        // 'secret_answer' => $data['secret_answer'],
        // 'admin_notes' => $data['admin_notes'],
        ]);

      $User = User::where('id',$User_id)->update([
        'firstname' => $data['firstname'],
        'lastname' => $data['lastname'],
        'email' => $data['email'],
      ]);

        return $User;
    }

	 public function updateownerholidayaddress($id, $data){
      $User_id = $this->model->select('user_id')->where('id',$id)->value('user_id');
      $User = UserAddresses::Where('user_id', $User_id)->where("address_type", "away")->update([
        'address_type' => $data['address_type'],
        'street1' => $data['street1'],
        'street2' => $data['street2'],
        'city' => $data['city'],
        'county' => $data['county'],
        'country' => $data['country'],
        'postcode' => $data['postcode'],
        ]);
		  return $User;
	  }

	 public function updatebreeder($id, $data){
      $chip_id = $this->model->select('chip_id')->where('id',$id)->value('chip_id');
      $User = BreederInfo::Where('chip_id', $chip_id)->update([
        'kennel' => $data['kennel'],
        'name' => $data['name'],
        'email_address' => $data['email_address'],
        'street1' => $data['street1'],
        'street2' => $data['street2'],
        'city' => $data['city'],
        'county' => $data['county'],
        'country' => $data['country'],
        'postcode' => $data['postcode'],
        'licence_number' => $data['licence_number'],
        'council_name' => $data['council_name'],
        ]);
		 return $User;
     }

    public function updatedealer($id, $data){
       $chip_id = $this->model->select('chip_id')->where('id',$id)->value('chip_id');
       $User = DealerInfo::Where('chip_id', $chip_id)->update([
        'kennel' => $data['kennel'],
        'name' => $data['name'],
        'email_address' => $data['email_address'],
        'street1' => $data['street1'],
        'street2' => $data['street2'],
        'city' => $data['city'],
        'county' => $data['county'],
        'country' => $data['country'],
        'postcode' => $data['postcode'],
        'licence_number' => $data['licence_number'],
        'council_name' => $data['council_name'],
        ]);
      return $User;
     }

   public function pethistory($id){
      $user_id = $this->model->select('user_id')->where('id',$id)->value('user_id');
      $User1 = UserAddresses::select('street1','street2','country','county','city','postcode','user_id')->with('UserExtras')->Where('user_id', $user_id)->get();
      $User2 = User::select('firstname','lastname')->Where('id', $user_id)->first();
      $firstname = $User2->firstname;
      $lastname = $User2->lastname;
      $User1[0]['firstname'] = $firstname;
      $User1[0]['lastname'] = $lastname;
      return $User1;
     }

   public function lists() {
      $petList = Pet::select('name','pet_type','for_breeding','gold','breed','colour','dob','sex','status','user_id')->with(['Chips'])->orderBy('id', 'DESC')->paginate(10);
       return $petList;
      }
     
//pet type
  public function pettypeshow($id){
	   $pettypedata = $this->PetKind->where('id',$id)->first();
	  return $pettypedata;   
	  }
  public function pettypedelete($id){
		$pettypeid = $this->PetKind->where('id',$id)->first();
		if(!$pettypeid){
		return response()->json(['error' => 'pet  not exist'], 400);
		 }
		$pettypeid = $this->PetKind->where('id', $id)->delete();
		return $pettypeid;
	  }

  public function pettypeupdate($id, $data){
    $pettypeupdate = $this->PetKind->findOrFail($id);
    $pettypeupdate->update($data);
    return $pettypeupdate; 
    }

  public function pettypelist(){
  	 $pettypelist = PetKind::orderBy('id', 'DESC')->paginate(10);
  	 return $pettypelist;
    }

  public function getallpettypes()
    {
  $pettypelist = PetKind::orderBy('id', 'DESC')->get();
  return $pettypelist;
   }
  public function requestownerlist(){
     $requestownerlist =ChnageRequest::select('id','new_user_id','user_id','pet_id','updated_at')->orderBy('id', 'DESC')->paginate(10);
         foreach ($requestownerlist as $key) {
        $PetName = Pet::select('name')->where('id',$key->pet_id)->value('name');   
        $UserName = User::select('firstname','lastname')->where('id',$key->user_id)->first();
        $NewUserName = User::select('firstname','lastname')->where('id',$key->new_user_id)->first();
         $key->Pet = $PetName;
         $key->User = $UserName;
         $key->NewUser = $NewUserName; 
          }
           return $requestownerlist;
        }

 public function requestownerapprove($id){     
  $user = ChnageRequest::select('new_user_id','user_id','pet_id')->where('id', $id)->get()->toArray();
   $user_id = $user[0]['user_id']; 
   $new_user_id = $user[0]['new_user_id'];
   $pet_id = $user[0]['pet_id'];     
  Pet::where('id',$pet_id)->update(['user_id'=>$new_user_id]);

   $Owner = new OwnerHistory();
   $Owner->current_user_id = $new_user_id;
   $Owner->old_user_id = $user_id;
   $Owner->pet_id = $pet_id;
   $Owner->save();
   
  ChnageRequest::where('id', $id)->delete();

   return $user;
    }


  public function requestownerdecline($id){
     $requestownerdecline = ChnageRequest::where('id', $id)->delete();
      return $requestownerdecline;
     }
  public function petStat(){      
    $data = array();   
    $data['TOTAL:_Dogs_(Total)'] =Pet::where('pet_type','Dog')->count();
    $data['TOTAL:_Dogs_(Alive)'] =Pet::where('pet_type','Dog')->where('status','1')->count();
    $data['TOTAL:_Dogs_(Age Unknown)'] =Pet::where('pet_type','Dog')->where("dob", "0000-00-00")->count();
    $data['TOTAL:_Dogs_(Age under 12)'] =Pet::where('pet_type','Dog')->whereRaw('DATEDIFF(created_at, dob) >= (0 * 365.25)')->whereRaw('DATEDIFF(created_at, dob) <= (12 * 365.25)')->count();

    $data['ENGLAND:_Dogs_(Total)'] =Pet::where('pet_type','Dog')->where("stat_country", "England")->count();
    $data['ENGLAND:_Dogs_(Alive)'] =Pet::where('pet_type','Dog')->where("stat_country", "England")->where('status','1')->count();
    $data['ENGLAND:_Dogs_(Age Unknown)'] =Pet::where('pet_type','Dog')->where("stat_country", "England")->where("dob", "0000-00-00")->count();
    $data['ENGLAND:_Dogs_(Age under 12)'] =Pet::where('pet_type','Dog')->where("stat_country", "England")->whereRaw('DATEDIFF(created_at, dob) >= (0 * 365.25)')->whereRaw('DATEDIFF(created_at, dob) <= (12 * 365.25)')->count();

    $data['SCOTLAND:_Dogs_(Total) '] =Pet::where('pet_type','Dog')->where("stat_country", "Scotland")->count();
    $data['SCOTLAND:_Dogs_(Alive)'] =Pet::where('pet_type','Dog')->where("stat_country", "Scotland")->where('status','1')->count();
    $data['SCOTLAND:_Dogs_(Age Unknown) '] =Pet::where('pet_type','Dog')->where("stat_country", "Scotland")->where("dob", "0000-00-00")->count();
    $data['SCOTLAND:_Dogs_(Age under 12) '] =Pet::where('pet_type','Dog')->where("stat_country", "Scotland")->whereRaw('DATEDIFF(created_at, dob) >= (0 * 365.25)')->whereRaw('DATEDIFF(created_at, dob) <= (12 * 365.25)')->count();

    $data['WALES:_Dogs_(Total)'] =Pet::where('pet_type','Dog')->where("stat_country", "Wales")->count();
    $data['WALES:_Dogs_(Alive)'] =Pet::where('pet_type','Dog')->where("stat_country", "Wales")->where('status','1')->count();
    $data['WALES:_Dogs_(Age Unknown)'] =Pet::where('pet_type','Dog')->where("stat_country", "Wales")->where("dob", "0000-00-00")->count();
    $data['WALES:_Dogs_(Age under 12)'] =Pet::where('pet_type','Dog')->where("stat_country", "Wales")->whereRaw('DATEDIFF(created_at, dob) >= (0 * 365.25)')->whereRaw('DATEDIFF(created_at, dob) <= (12 * 365.25)')->count();
        return $data;
      }  
}