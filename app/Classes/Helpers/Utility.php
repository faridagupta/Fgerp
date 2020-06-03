<?php

namespace App\Classes\Helpers;
use Illuminate\Support\Facades\Validator;

use GuzzleHttp;

class Utility {

	//put your code here
	public static $success_code = 200;
	public static $failure_code = 400;
	public static $exist_code   = 601;


	public static function get_access_token() {
return 34;
			$client = new GuzzleHttp\Client;
			$response = $client->request('POST', 'http://fgerp.faridadev.com/oauth/token', [
	        'form_params' => [
						'grant_type' => 'client_credentials',
						'client_id'  => '9',
						'scope' => '*',
						'client_secret' => 'lkm9eQqv4bTFWSDlVig8qx5L7oQanKjuywg4FMzf',
						],
	         ]);
	       $result= json_decode((string) $response->getBody(), true);
	        

       return $result['access_token'];
		//return true;
	}

	public static function successResponse($message= '',$data=''){
		
	         return response()->json([
                 'status_code'  => self::$success_code,
                 'error_code' => 0,
                 'status'=> 'success',
                 'result' => [
                    'message'    => $message,
                    'data'       => $data
                 ]
	            ]);
	}

	public static function failureResponse($message= '',$data=''){
		
	         return response()->json([
                 'status_code'  => self::$failure_code,
                 'error_code' => 0,
                 'status'=> 'failure',
                 'error'=> $message,
                 // 'result' => [
                 //    'message'    => $message,
                 //    'data'       => $data
                 // ]
	            ]);
	}

	public static function alreadyExistsResponse($message= '',$data=''){
		
	         return response()->json([
                 'status_code'  => self::$success_code,
                 'error_code' => 1,
                 'status'=> 'exist',
                 'result' => [
                    'message'    => $message,
                    'data'       => $data
                 ]
	            ]);
	}

	public static function requiredValidation($data, $request,$customRule = array()){
		$requiredRequest = array_fill_keys($request,'required');
         
    	 $validator = Validator::make($data,$requiredRequest);
		 
 		  if ($validator->fails()) {
            return response()->json([
                 'status_code'  => self::$success_code,
                 'error_code' => 2,
                 'status'=> 'required',
                 'result' => [
                    'message'    => $validator->errors(),
                    'data'       => ''
                 ]
	            ]);
        }
        else 
        	return false;
	}

	public static function uniqueValidation($data, $uniqueDatainfo){
		 
    	 $validator = Validator::make($data,$uniqueDatainfo);
		 
 		  if ($validator->fails()) {
            $res = self::alreadyExistsResponse($validator->errors());
            return $res; 
        }
        else 
        	return false;
	}

	public static function customValidation($data, $customData){
		 
    	 $validator = Validator::make($data,$customData);
		 
 		  if ($validator->fails()) {
            return response()->json([
                 'status_code'  => self::$success_code,
                 'error_code' => 3,
                 'status'=> 'customerror',
                 'result' => [
                    'message'    => $validator->errors(),
                    'data'       => ''
                 ]
	            ]);
        }
        else 
        	return false;
	}


}