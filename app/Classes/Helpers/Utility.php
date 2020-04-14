<?php

namespace Dashboard\Classes\Helpers;
use GuzzleHttp;

class Utility {

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

}