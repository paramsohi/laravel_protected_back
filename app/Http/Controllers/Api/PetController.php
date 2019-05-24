<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PetRequest;
use App\Http\Requests\PetKindRequest;
use Illuminate\Support\Facades\Auth;
use App\Model\Pet;
use App\Model\PetKind;
use App\Services\PetKindService;
use App\Services\PetService;
use App\Http\Resources\PetKindResource;
use App\Http\Resources\PetResource;
use App\Model\PetLogs;
use Validator;




class PetController extends Controller
  {
		public $successStatus = 200;
		private $PetKindService ;
		private $PetService ;

		public function __construct(PetKindService $PetKindService, PetService $PetService){
			$this->PetKindService = $PetKindService;
			$this->PetService = $PetService;
			 }
		/**
		* Display a listing of the resource.
		*
		* @return \Illuminate\Http\Response
		*/
		public function index()
		{
		//
		}

		/**
		* Show the form for creating a new resource.
		*
		* @return \Illuminate\Http\Response
		*/
		public function create()
		{
		//
		}

		/**
		* Store a newly created resource in storage.
		*
		* @param  \Illuminate\Http\Request  $request
		* @return \Illuminate\Http\Response
		*/
		public function store(Request $request){ 
		   $input = $request->all();
		   $validator = Validator::make($request->all(), [
                    'name' => 'required',
		            'description' => 'required',
		            'breed' => 'required',
		            'colour' => 'required',
		            'dob'=> 'required',
		            'sex' => 'required',
		            'medical_info' => 'required',
		            // 'chip_id' => 'required',
		            'pet_type'=>'required',
		            'user_id'=>'required',
		            'chip_no'=>'required',
		            'for_breeding'=>'required',
		            'got_from'=>'required',
		            'neutered'=>'required',
		            // 'chip_id'=> 'required',
	        ]);
	        if ($validator->fails()) {
	            $errors = $validator->errors();
	            $msg = '';
	            foreach ($errors->all() as $key => $value) {
	                $msg = $value;
	                break;
	            }
	            return response()->json(['msg' => $msg, 'status' => 400], 400);
	        }
			$petadd = Pet::create($input);

			$input1 = json_encode($input);
			
			$pet_id = $petadd->id;
			$pet_name = $petadd->name;
			$input['pet_id'] = $pet_id;
			$input['pet_name'] = $pet_name;
			$input['action'] = 'add';
			$input['action_data'] = $input1;
	        $petlogs = PetLogs::create($input);
			return new PetResource($petadd);
			}

		/**
		* Display the specified resource.
		*
		* @param  int  $id
		* @return \Illuminate\Http\Response
		*/
		public function show($id)
		{

		$data = $this->PetService->show($id);  
		 return response()->json(['data' => $data, 'status'=>200], 200);
		// return new PetResource($data);
		}

		/**
		* Show the form for editing the specified resource.
		*
		* @param  int  $id
		* @return \Illuminate\Http\Response
		*/
		public function edit($id)
		{
		//
		}

		/**
		* Update the specified resource in storage.
		*
		* @param  \Illuminate\Http\Request  $request
		* @param  int  $id
		* @return \Illuminate\Http\Response
		*/
		public function update(Request $request, $id){
           $petUpdate = $this->PetService->show($id);
           	if(empty($petUpdate)){
           	return response()->json(['message' => 'pet not exist', 'status'=>400], 400);
           	 }
			$petUpdate = $this->PetService->update($id, $request->all());
	          return response()->json(['petUpdate' => $petUpdate,
	                 'message'=>'pet updated successfully',
	                 'status'=>200], 200);
			}

		public function updatePetOwner(Request $request, $id){
			$updatePetOwner = $this->PetService->updatepetowner($id, $request->all());
	          return response()->json(['updatePetOwner' => $updatePetOwner,
	                 'message'=>'updated successfully',
	                 'status'=>200], 200);
			}

		 public function updateChipOwner(Request $request, $id){
			$updateChipOwner = $this->PetService->updatechipowner($id, $request->all());
	          return response()->json(['updateChipOwner' => $updateChipOwner,
	                 'message'=>'updated successfully',
	                 'status'=>200], 200);
			}

		 public function updateOwnerHolidayAddress(Request $request, $id){
			$updateOwnerHolidayAddress = $this->PetService->updateownerholidayaddress($id, $request->all());
	          return response()->json(['updateOwnerHolidayAddress' => $updateOwnerHolidayAddress,
	                 'message'=>'updated successfully',
	                 'status'=>200], 200);
			}

		 public function updateBreeder(Request $request, $id){
			$updateBreeder = $this->PetService->updatebreeder($id, $request->all());
	          return response()->json(['updateBreeder' => $updateBreeder,
	                 'message'=>'updated successfully',
	                 'status'=>200], 200);
			}

		 public function updateDealer(Request $request, $id){
			$updateDealer = $this->PetService->updatedealer($id, $request->all());
	          return response()->json(['updateDealer' => $updateDealer,
	                 'message'=>'updated successfully',
	                 'status'=>200], 200);
			}

         public function petHistory(Request $request, $id){
			$petHistory = $this->PetService->pethistory($id, $request->all());
	        return response()->json(['petHistory' => $petHistory,
	                 'message'=>'updated successfully',
	                 'status'=>200], 200);
	         }	

		/**
		* Remove the specified resource from storage.
		*
		* @param  int  $id
		* @return \Illuminate\Http\Response
		*/
		public function destroy($id){ 
		$petDelete = $this->PetService->show($id);
		if(empty($petDelete)){
		return response()->json(['message' => 'pet not exist', 'status'=>400], 400);
		 }
		else{
		$petDelete =  $this->PetService->delete($id);
		return response()->json(['message' => 'pet deleted successfully', 'ststus'=>200], 200);
		  }
		}

	 public function petList(){
        $petList = $this->PetService->lists();
        return response()->json(['petList' => $petList, 'status'=>200], 200);
		}
        
		//pet type//

	 public function petType(PetKindRequest $request) {
		$input = $request->all();
		$petkind = PetKind::create($input);
		return new PetKindResource($petkind);
		}

	 public function petTypeShow($id) {
		  $data = $this->PetService->pettypeshow($id);		    
		     return response()->json(['data' => $data, 'status'=>200], 200);
		    }

	 public function petTypeDelete($id) {
		$petKindDelete = $this->PetService->pettypeshow($id);
		if(empty($petKindDelete)){
       return response()->json(['message' => 'pet not exist', 'status'=>400], 400);
		}
		else{
	   $petKindDelete =  $this->PetService->pettypedelete($id);
       return response()->json(['message' => 'pet deleted successfully','status'=>200], 200);
            }
		}

	 public function petTypeUpdate(Request $request ,$id){
        $data = $this->PetService->pettypeshow($id); 
		if(empty($data)){
		 return response()->json(['message' => 'pet not exist','status'=>400], 400);  
		  }
        $data = $this->PetService->pettypeupdate($id, $request->all());
        return new PetKindResource(['data' => $data ,'message'=>'pet update successfully','status'=>200],200);
		}

	 public function petTypeList(){
		$petTypeList = $this->PetService->pettypelist();
		return response()->json(['petTypeList'=>$petTypeList,'status'=>200],200);
		}

	 public function getAllPetTypes()
	    {
		 $petTypeList = $this->PetService->getallpettypes();
		return response()->json(['petTypeList'=>$petTypeList,'status'=>200],200);
		 }	 


	 public function requestOwnerList(){
        $requestOwnerList = $this->PetService->requestownerlist();
        return response()->json(['requestOwnerList'=>$requestOwnerList,'status'=>200],200);
        }

     public function requestOwnerApprove($id){
         $requestOwnerApprove = $this->PetService->requestownerapprove($id);
       if(empty($requestOwnerApprove)){
      return response()->json(['message'=>'requester not exist','status'=>400,],400);
         }
      return response()->json(['requestOwnerApprove'=>$requestOwnerApprove,'status'=>200],200);
       }

     public function requestOwnerDecline($id){
        $requestOwnerDecline = $this->PetService->requestownerdecline($id);
       if(empty($requestOwnerDecline)){
  	  return response()->json(['message'=>'requester not exist','status'=>400,],400);
        }
      return response()->json(['message'=>' requester decline','status'=>200,],200);
      }

	 public function petStat(){
		$data = $this->PetService->petStat(); 
	  return response()->json(['data'=>$data,'status'=>200],200);
		}	

}
