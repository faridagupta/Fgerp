<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
	echo "hello";
    return $app->version();
});

$app->get('test', function () {
	echo "hello1 ";
    //return 'Hello World';
});

$app->post('postlogin', 'ExampleController@postLogin');
$app->post('/register', 'userController@register');

$app->post('/authenticate', 'userController@authenticate');

$app->group(['middleware' => 'auth:api'], function($app)
{
    $app->post('/test1', function() {
        return response()->json([
            'message' => 'Jai Mata D lets Rock :-)!',
            'status'  => 200
        ]);
    });
    $app->post('/login', 'userController@login');

});



//get_name();

$app->get('/redirect', 'ExampleController@redirectAuthorization');

$app->get('/callback', 'ExampleController@callbackAccess');

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function($api){

	$api->group(['prefix'=>'oauth'], function($api){
		$api->post('token','\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
	});

	$api->group(['namespace'=>'App\Http\Controllers', 'middleware'=>['auth:api']],function($api){
		$api->get('testapi', function () {
			echo "hello1 ";
		    //return 'Hello World';
		});
	});
});