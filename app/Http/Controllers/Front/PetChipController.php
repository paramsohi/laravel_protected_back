<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PetChipService;
use Auth;
use App\Model\ApiLink;
use App\Model\Pet;
use App\User;
use PDF;
use App\Model\UserAddresses;
use App\Model\UserExtras;



class PetChipController extends Controller
{
  public $successfulstatus;
  private $PetChipService;

    public function __construct(PetChipService $PetChipService){
    $this->PetChipService = $PetChipService;
    }

  public function oldChipList()
    {
    $oldChipList = $this->PetChipService->oldchiplist(); 
    return response()->json(['oldChipList'=>$oldChipList,'status'=>200],200);
    }

  public function petFrontChipList()
    {
    $PetFrontChipList = $this->PetChipService->petfrontchiplist(); 
    return response()->json(['PetFrontChipList'=>$PetFrontChipList,'status'=>200],200);
    }

  public function petFrontChipListView($id)
    {
    $petFrontChipListView = $this->PetChipService->petfrontchiplistview($id); 
    return response()->json(['petFrontChipListView'=>$petFrontChipListView,'status'=>200],200);
    }

  public function petFrontChipListViewUpdate(Request $request,$chip_number)
    {
    $user = Auth::user();
    $pet_user_id = $user->id;
    $input = $request->all();
    $petFrontChipListViewUpdate = $this->PetChipService->petfrontchiplistviewupdate($chip_number,$request->all()); 
    return response()->json(['petFrontChipListViewUpdate'=>$petFrontChipListViewUpdate,
    'message'=>'update successfully', 'status'=>200],200);
    }

  public function chipListViewReport(Request $request, $chip_number)
    {
    $user = Auth::user();
    $pet_user_id = $user->id;
    $input = $request->all();
    $petFrontChipListViewUpdate = $this->PetChipService->chiplistviewreport($chip_number,$request->all());
    return response()->json(['petFrontChipListViewUpdate'=>$petFrontChipListViewUpdate,'status'=>200],200);
    }

  public function chipListViewDeceased(Request $request,$id)
    {
    $user = Auth::user();
    $pet_user_id = $user->id;
    $input = $request->all();
    $chipListViewDeceased = $this->PetChipService->chiplistviewdeceased($id,$request->all());
    return response()->json(['chipListViewDeceased'=>$chipListViewDeceased,'status'=>200],200);
    }

  //** register another pet 
  public function registerAnotherPet(Request $request)
    {
    $user = Auth::user();
    $pet_user_id = $user->id; 
    $chip = $this->PetChipService->show($pet_user_id);
      if(empty($chip)){
      return response()->json(['message'=>'user not found','status'=>400],400);
      }
    $registerAnotherPet = $this->PetChipService->registeranotherpet($pet_user_id, $request->all());
    return response()->json(['registerAnotherPet'=>$registerAnotherPet,
    'message'=>'success','status'=>200],200);
    }

  public function reportLost(Request $request)
    {  
    $input = $request->all();
    $chip_number = $request->chip_number;
    $chip = $this->PetChipService->ChipNo($chip_number);
      if(!$chip){
      return response()->json(['message'=>'chip number not found','status'=>400],400);
      }
    $reportLost = $this->PetChipService->reportlost($chip_number, $request->all());
    return response()->json(['reportLost'=>$reportLost,'status'=>200],200);
    }

  public function documentList()
    {
    $user = Auth::user();
    $user_id = $user->id;
    $documentList = $this->PetChipService->documentlist($user_id);
    return response()->json(['documentList'=>$documentList,'status'=>200],200);
    }

  public function chipNumber($id)
    {  
    $chip_number = $id;
    $chip = $this->PetChipService->ChipNo($chip_number);
      if(!$chip){
      $data  = $this->checkchipfromApis($chip_number);
      if($data == 1){

      return response()->json(['message'=>'found in another link','foundChip'=>$foundChip,'status'=>200],200);
      }else{
      return response()->json(['message'=>'chip number not found','status'=>400],400);            
      }  

      }else{
        $reportLost = $this->PetChipService->checkChip($chip_number);
        return response()->json(['message'=>'chip exist','status'=>200],200);            
        }

    }

  public function checkChipNumber($id, $bypasscode)
    { 
    $chip_number = $id;
    $bypass_code = $bypasscode;
    $checkChipNumber = $this->PetChipService->checkChipNumber($chip_number,$bypass_code); 
      if(!$checkChipNumber){
      return response()->json(['message'=>'chip number and bypass code not match','status'=>400],400);
      }
    return response()->json(['Chpis'=> $checkChipNumber,'status'=>200],200);
    }

  public function reportFound($id,$LFdetails)
    {
    $chip_number = $id;
    $LFdetails = $LFdetails;
    $reportFound = $this->PetChipService->reportfound($chip_number,$LFdetails);
    return response()->json(['reportFound'=>$reportFound,'status'=>200],200);
    }

private function checkchipfromApis($chip_number)
  {
  $api = ApiLink::get(); 
    if(!empty($api)){  
    $foundChip = 0;
      foreach ($api as $link ) {
      $url = $link->page.'?username='.$link->username.'&password='.$link->password.'&chip_number='.$chip_number;
        $contents = curl_init($url);
        curl_setopt($contents, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($contents, CURLOPT_BINARYTRANSFER, true);
        $detail = curl_exec($contents);
        curl_close($contents);
        if($contents === "TRUE") {
        $foundChip = 1;
        }         
      }
    return $foundChip;
    }
  }

        public function petFrontChipMicrochips()
      {
         $user = Auth::user();
        $user_id = $user->id; 
        $PetFrontChipList = $this->PetChipService->petfrontchipmicrochips($user_id); 
        return response()->json(['PetFrontChipList'=>$PetFrontChipList,'status'=>200],200);

      }


      public function petDocumentPdf($pet_id)
       {
        
         $pet = Pet::where('id',$pet_id)->update([
          'gold'=>'1',
         ]);
         $pet = Pet::where('id',$pet_id)->first();
        $user = User::select('firstname','lastname','email','id')->with(['UserAddresses','UserExtras'])->where('id',$pet->user_id)->first();
        $pdf = PDF::loadView('document',['data'=>$pet,'user'=>$user]);
       return $pdf->download('document.pdf');

       }
  

}
