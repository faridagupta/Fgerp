<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use GuzzleHttp;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class userController extends Controller
{
    //
    public function register(Request $request){
    	//$access_token= $this->get_access_token();
       return User::create([
        'username' => $request->input('username'),
        'email' => $request->input('email'),
        'password' => Crypt::encrypt($request->input('password')),
        'api_token' => ''

       ]);
     }
     public function authenticate(Request $request)

	   {

	        //Log::info("hiiidsfoiasjdfisa");
	        $this->validate($request, [

	            'email' => 'required',

	            'password' => 'required'

	        ]);

	        $user = User::where('email', $request->input('email'))->first();

	        /*Log::info($user->password);
	        Log::info($user->email); */   

	        if( Crypt::decrypt($user->password)==$request->input('password')){
              
	           $apikey = $this->get_access_token();

	           User::where('email', $request->input('email'))->update(['api_token' => "$apikey"]);

	          return response()->json(['status' => 'success','api_token' => $apikey]);

	      }else{

	          return response()->json(['status' => 'fail'],401);

	      }

	   }

    public static function get_access_token()
	{
        
			$client = new GuzzleHttp\Client;
			$response = $client->request('POST', 'http://fgerp.faridagupta.com/oauth/token', [
	        'form_params' => [
						'grant_type' => 'client_credentials',
						'client_id'  => '3',
						'scope' => '*',
						'client_secret' => 'hLojgh5504zSpvrGOPeqJ43JIxSL3LTHcRgnPht4',
						],
	         ]);

	       $result= json_decode((string) $response->getBody(), true);
	        

       return $result['access_token'];
	}
     public function login(){
      return "logged in Success";
     }
}
