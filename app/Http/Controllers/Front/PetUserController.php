<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\User; 
use App\Model\UserAddresses;
use App\Model\SiteSetting;
use App\Model\UserExtras;
use App\Model\Pet;
use App\Model\Chips;
use App\Http\Resources\UserResource;
use Mail;
use Illuminate\Support\Facades\Storage;
use App\Services\PetUserService;
use App\Services\PetService;
use Hash;
use Validator;
use Auth;
use PDF;

class PetUserController extends Controller
{ 
    public $successStatus = 200;
    private $PetUserService;

    public function __construct(PetUserService $PetUserService, PetService $PetService){
        $this->PetUserService = $PetUserService;
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
    public function store(UserRequest $request)
    {
       $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $User = User::create($input);
        $user_id = $User->id;

        $input['user_id'] = $user_id;
        $adminUser = UserAddresses::create($input);

        $input['user_id'] = $user_id;
        $adminUser = UserExtras::create($input);
        $data = [
         'name' => $input['firstname'],
         'email' => $input['email'],
         ];

      $name = $input['firstname'];
      $email = $input['email'];

    Mail::send('mail', $data, function($message) use ($email, $name){ 
        $message->from('Info@ProtectedPet.com', 'ProtectedPet');
        $message->to($email, $name)->cc('hashneha65@gmail.com');
        $message->subject('welcome!!');
     });
    return new UserResource($adminUser);
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
      $data = $this->PetUserService->show($id);
      return response()->json(['data'=>$data, 'status'=>200],200);
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
       $updateUser = $this->PetUserService->update($id, $request->all());
       return response()->json(['updateUser'=>$updateUser, 
         'message'=>'user update successfully', 'status'=>200],200);
      }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $UserDelete = $this->PetUserService->show($id);
       if(empty($UserDelete)){
     return response()->json(['message' => 'User not exist', 'status'=>400], 400);
        }
        else{
        $UserDelete =  $this->PetUserService->delete($id);
        return response()->json(['message' => "User deleted successfully", 'status' => 200], 200);
       }
    }

    public function userHistory(){
       $user = Auth::user();
       $pet_user_id = $user->id;
       $userHistory = $this->PetUserService->userhistory($pet_user_id);
     return response()->json(['data'=>$userHistory, 'message' => 'success', 'status' => 200],200);
       }

    public function changePassword(Request $request) {
      $current_password = $request->get('current_password');
      $new_password = $request->get('new_password');
        if (!(Hash::check($current_password, Auth::user()->password))) {           
            return response()->json(['status' => 400,'msg'=>'Your current password does not matches with the password you provided. Please try again.'], $this->successStatus);
        }
        if (strcmp($current_password,$new_password) == 0) {            
            return response()->json(['status' => 400,'msg'=>'New Password cannot be same as your current password. Please choose a different password.'], $this->successStatus);
        }
        $validator = Validator::make($request->all(),[
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
            // 'new_password_confirmation' 
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
        $user = Auth::user();
        $user->password = bcrypt($new_password);
        $user->save();
        return response()->json(['status' => 200,'msg'=> 'password change successfully'], $this->successStatus);
       
    }

    public function petOwnerDetailGeneratePDF($id){
       $user_detail = User::select('firstname','lastname','email','id')->with(['UserAddresses','UserExtras'])->where('id',$id)->first();
       $pet_detail = Pet::select('name','breed','chip_no_string','colour','sex','user_id')->where('user_id',$id)->first(); 
       // print_r($pet_detail);  dd();
      $pdf = PDF::loadView('RegisteredDetail',['user_detail'=>$user_detail, 'pet_detail'=>$pet_detail]);
      return $pdf->download('RegisteredDetail.pdf');
        }

    public function changeOwner(Request $request, $pet_id){
       $user = Auth::user();
       $pet_user_id = $user->id;
       $pet_id = $pet_id;
       $input = $request->all();
       $changeOwner = $this->PetUserService->changeowner($pet_user_id,$pet_id,$request->all());
       return response()->json(['changeOwner'=>$changeOwner, 'message' => 'success', 'status' => 200],200);
      }
    public function ownerHistory(){
      $user = Auth::user();
      $pet_user_id = $user->id;
      $ownerHistory = $this->PetUserService->ownerhistory($pet_user_id);
     return response()->json(['ownerHistory'=>$ownerHistory, 'message' => 'success', 'status' => 200],200);
      }

     public function changeOwnerGenratePDF()
     {
       
       $path = public_path('OwnerChange.pdf'); 
       return response()->json(['pdf'=>$path, 'message' => 'success', 'status' => 200],200);
       
     }

      public function missingPosterGenratePDF()
        { 
      $pdf = PDF::loadView('MissingDog');
      return $pdf->download('MissingDog.pdf');
      
       }
}
