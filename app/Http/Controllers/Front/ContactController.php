<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Contact;
use Mail;
class ContactController extends Controller
{
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
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
       $input = $request->all();
       $validator = Validator::make($input, [
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required',
                'phone' => 'required',
            ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = '';
          foreach ($errors->all() as $key => $value) {
             $msg = $value;
             break;
                }
          return response()->json(['msg' => $msg, 'status' => 'error']);
             }
        $contact = Contact::create($input);
        $data = [
            'name' => $input['name'],
            'email' => $input['email'],
            'msg' => $input['message'],
            ];
           $name = $input['name'];
           $email = $input['email'];
           $msg = $input['message'];
        Mail::send('contactmail', $data, function($message) use ($email, $name ,$msg){ 
            $message->from($email, $name, $msg);
            $message->to('hashneha65@gmail.com');
            // $message->to('niara.k@hashsoftware.com');
            $message->subject('welcome!!');
              });
         return Response()->json(['contact'=>$contact, 'message'=> 'Submit Successfully', 'status'=>200], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
