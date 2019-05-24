<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminRequest;
use App\Http\Resources\AdminResource;
use App\Services\AdminUserService;
use Validator;

class AdminRegisterController extends Controller
{
     public $successStatus = 200;
     private $AdminUserService;
    public function __construct(AdminUserService $AdminUserService)
    {
        $this->AdminUserService = $AdminUserService;
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
    public function store(AdminRequest $request)
    {  
        // dd('kl');
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $adminUser = Admin::create($input);
       return new AdminResource($adminUser);  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->AdminUserService->show($id);
        if(empty($data)){
           return response()->json(['error' => "User not exist"], 200);  
        }  
        return response()->json(['data' => $data], 200);
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
    public function update(Request $request, $id)
    {  
         // dd($request->all());
        $adminResource = $this->AdminUserService->update($id, $request->all());
          
         return new AdminResource($adminResource);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
     { 
        $AdminDelete = $this->AdminUserService->show($id);
          if(empty($AdminDelete)){
           return response()->json(['error' => 'User not exist'], 200);
            }
           else{
         $AdminDelete =  $this->AdminUserService->delete($id);
             return response()->json(['AdminDelete' => 'Delete'], 200);
             }
      }

    public function adminlist()
        {
           $adminList = $this->AdminUserService->lists();
            return response()->json(['adminList' => $adminList], 200);
        }

     public function changePasswordAdmin(Request $request) {

        //dd('mn');
      // $current_password = base64_decode($request->get('current_password'));
      //  print_r($current_password); dd('kl');
      // $new_password = base64_decode($request->get('new_password'));
      //  print_r($new_password); dd('lk');
      $current_password = $request->get('current_password');
     
      $new_password = $request->get('new_password');
       // $user= Auth::user();
       // dd($user);
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
            return response()->json(['msg' => $msg, 'status' => 'error'], 200);
        }
       
        $user = Auth::user();
        // dd($user);
        $user->password = bcrypt($new_password);
        $user->save();
        
        return response()->json(['status' => 'success','msg'=> 'password change successfully'], $this->successStatus);
       
}
}
