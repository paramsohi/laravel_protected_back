<?php

namespace App\Http\Controllers\Api;

use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\User; 
use App\Model\UserAddresses;
use App\Model\UserExtras;
use Illuminate\Support\Facades\Auth; 
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Validator;

class RegisterController extends Controller
{
    public $successStatus = 200;
    private $UserService ;

    public function __construct(UserService $UserService){  
       $this->UserService = $UserService;
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
                'firstname' => 'required|string',
                'lastname' => 'required',
                'email' => 'required|string|email|max:255|unique:users',
                'password'=>'required|between:6,12|',
                'login_name' => 'required',
                'address_type' => 'required',
                'street1' => 'required',
                'street2' => 'required',
                'city' => 'required',
                'county'=> 'required',
                'country' => 'required',
                'postcode' => 'required',
                'phone' => 'required',
                'is_vet' => 'required',
                'pp_response' => 'required',
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
        
        $input['password'] = bcrypt($input['password']);
        $adminUser = User::create($input);
        $admin_user_id = $adminUser->id;

        $input['user_id'] = $admin_user_id;
        $adminUser = UserAddresses::create($input);

        $input['user_id'] = $admin_user_id;
        $adminUser = UserExtras::create($input);
       return new UserResource($adminUser);    
      }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
       $data = $this->UserService->show($id);
       if(empty($data)){
      return response()->json(['message' => "User not exist", 'status' => 400], 400);  
        }  
         return response()->json(['data' => $data, 'status' => 200], 200);
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
    public function update(Request $request, $id) {
       $User = $this->UserService->update($id, $request->all()); 
      return response()->json(['User' => $User ,'message' => "User updated successfully", 'status' => 200],200);
      }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $UserDelete = $this->UserService->show($id);
       if(empty($UserDelete)){
     return response()->json(['message' => 'User not exist', 'status'=>400], 400);
        }
     else{
        $UserDelete =  $this->UserService->delete($id);
       return response()->json(['message' => "User deleted successfully", 'status' => 200], 200);
         }
      }
    public function list(){
       $userList = $this->UserService->lists();
       return response()->json(['userList' => $userList, 'status' => 200], 200);
        }

    public function getAllUsers()
       {
       $userList = $this->UserService->getallusers();
       return response()->json(['userList' => $userList, 'status' => 200], 200);
       }

    public function searchUsers(Request $request)
        {
           $userList = $this->UserService->searchusers($request);
           return response()->json(['userList' => $userList, 'status' => 200], 200);
         }
     


     public function changePassword(Request $request) {
        $current_password = $request->get('current_password');
        $new_password = $request->get('new_password');
       if (!(Hash::check($current_password, Auth::user()->password))) {           
            return response()->json(['status' => 'error','msg'=>'Your current password does not matches with the password you provided. Please try again.'], $this->successStatus);
        }

        if (strcmp($current_password,$new_password) == 0) {            
            return response()->json(['status' => 'error','msg'=>'New Password cannot be same as your current password. Please choose a different password.'], $this->successStatus);
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
        return response()->json(['status' => 'success','msg'=> 'password change successfully'], $this->successStatus);
         }


 
}
