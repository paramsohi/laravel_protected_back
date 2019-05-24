<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LostFoundRequest;
use App\Http\Resources\LostFoundResource;
use  App\Model\LostFound;
use App\Services\LostFoundService;

class LostFoundController extends Controller
{  
    public $successStaus = 200;
    private $LostFoundService ;

    public function __construct(LostFoundService $LostFoundService){
        $this->LostFoundService = $LostFoundService;
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
                 'type'=>'required',
                // 'CNID'=>'required',
                 'details'=>'required',
                // 'safe'=>'required',
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
        
        $Pet = Pet::select('chip_no')->where("id", $request->id)->first();
        $chip = Chips::where("chip_number", $Pet->chip_no)->first();

        $Lost = LostFound::where("CNId",$chip->id)->first();

         if(!empty($Lost)){
           return response()->json(['message'=>'already exist', 'status'=>400],400);
         }
        
        $input['CNId'] = $chip->id;
        $LostFound = LostFound::create($input);

        
        $PetStatus = Pet::where('chip_no', $Pet->chip_no)->update([
        'status' => '2',
        ]);
        return new LostFoundResource($LostFound);

      }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
       $LostFound = $this->LostFoundService->show($id);
       return response()->json(['LostFound'=>$LostFound, 'status'=>200],200);
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
       $LostFoundUpdate = $this->LostFoundService->update($id, $request->all());
       return response()->json(['LostFoundUpdate'=>$LostFoundUpdate,
                   'message'=>'updated successfully','status'=>200],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){   
       $LostFoundDelete = $this->LostFoundService->show($id);
        if(empty($LostFoundDelete)){
            return response()->json(['message'=>'not exist', 'status'=>400],400);
         }
       $LostFoundDelete = $this->LostFoundService->delete($id);
        return response()->json(['message'=>'deleted successfully','status'=>200],200);
      }

    public function lostFoundList(){
       $LostFoundList = $this->LostFoundService->lists();
        return response()->json(['LostFoundList'=>$LostFoundList, 'status'=>200],200);
     }

    public function approveruserslist(){
       $approverUsersList =$this->LostFoundService->approverUsersList();
       return response()->json(['approverUsersList'=>$approverUsersList, 'status'=>200],200);
       }

    public function approverUsers($id){
        $approverUsers =$this->LostFoundService->approverUser($id);
        return response()->json(['approverUsers'=>$approverUsers, 
            'message'=>'approve successfully', 'status'=>200],200);
       }
       
    public function declineUsers($id){
       $declineUsers =$this->LostFoundService->declineUsers($id);
        return response()->json(['declineUsers'=>'deleted successfully', 'status'=>200],200); 
      }

    public function searchLostFound(Request $request)
     {
       $userList = $this->LostFoundService->searchlostfound($request);
       return response()->json(['userList' => $userList, 'status' => 200], 200);
     }

      public function searchApproverUsers(Request $request)
     {
       $userList = $this->LostFoundService->searchapproverusers($request);
       return response()->json(['userList' => $userList, 'status' => 200], 200);
     }


       public function getLostFound($pet_id){ 
       
 
        $Pet = Pet::select('chip_no')->where("id", $pet_id)->first();
        $chip = Chips::where("chip_number", $Pet->chip_no)->first();
        // $pet = Pet::where("chip_no", $request->chip_number)->first();
        //$user = User::where("user_id", $pet->user_id);
        //$userExtra = UserExtras::where("user_id", $pet->user_id)->first();
        

        $Lost = LostFound::where("CNId",$chip->id)->first();

         if(!empty($Lost)){
           return response()->json(['message'=>'already exist', 'status'=>400],400);
         }
        $input['type'] = 'lost';
        $input['CNId'] = $chip->id;
        $LostFound = LostFound::create($input);

        
        $PetStatus = Pet::where('chip_no', $Pet->chip_no)->update([
        'status' => '2',
        ]);
        return new LostFoundResource($LostFound);

      }
    
}
