<?php

namespace App\Http\Controllers;

use App\Model\Authenticator;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Model\SiteSetting;
use App\Model\UserCurrency;

class LoginController extends Controller
{
    /**
     * @var Authenticator
     */
    private $authenticator;

    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    /**
     * @param Request $request
     * @return array
     * @throws AuthenticationException
     */
    public function login(Request $request)
    {

        $credentials = array_values($request->only('username', 'password', 'provider'));
       // dd($this->authenticator->attempt(...$credentials));
        if (! $user = $this->authenticator->attempt(...$credentials)) {
            return response()->json(['error' => "Incorrect credentials"], 200);  
        }
        $token = $user->createToken('My Token')->accessToken;
        
        $email = $user->email;
        $id = $user->id;
        $provider = $credentials[2];
       
       $site_dateTime = SiteSetting::select('date_time_format')->value('date_time_format');
       $user_currency = UserCurrency::select('curreny_id')->where('user_id', $user->id)->value('curreny_id');

        return $data = response()->json([
            'status' => 200,
            'access_token' => $token,
            'id' => $id,
            'email'=>$email,
            'user_type'=>$provider,
            'site_dateTime'=>$site_dateTime,
            'user_currency'=>$user_currency,
        ], 200);  
    }
}
