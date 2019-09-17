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
    $app->post('/createrole', 'userController@createRole');
    $app->post('/createpermission', 'userController@createPermission');
    $app->post('/assignrole', 'userController@assignRole');
    $app->post('/assignpermission', 'userController@assignPermission');
    $app->post('/assignrolepermission', 'userController@roleHasPermmision');
    //$app->post('/createvendor', 'ManufacturingController@createVendor');
    $app->post('/add-delivery-address', 'ManfPoController@addDeliveryAddress');
    $app->post('/create-style', 'ManfStyleController@createStyle');
    $app->post('/create-story', 'ManfStyleController@createStory');
    $app->post('/create-bom', 'ManfBomController@createBom');
    $app->post('/create-product-style-bom', 'ManfBomController@productStyleBom');
    $app->post('/create-material', 'ManfMaterialController@createMaterial');
    $app->post('/material-type', 'ManfMaterialController@materialType');
    $app->post('/vendor-material', 'ManfMaterialController@vendorMaterial');
    $app->post('/generate-po', 'ManfPoController@generatePo');
    $app->post('/material-in-warehouse', 'ManfMaterialInWarehouseController@MaterialInWarehouse');



    $app->group(['middleware' => ['role:Admin']], function ($app) {

      //$app->post('/createrole', 'userController@createRole');
      $app->post('/createvendor', 'ManufacturingController@createVendor');

    });

	$app->group(['middleware' => ['role:writer']], function ($app) {

    $app->post('/write', function() {
       return response()->json([
            'message' => 'writer role define',
            'status'  => 200
        ]);
       }); 
   });
    $app->group(['middleware' => ['permission:view']], function ($app) {

    $app->post('/viewdata', function() {
       return response()->json([
            'message' => 'view permission define',
            'status'  => 200
        ]);
       }); 
   });
    
    $app->group(['middleware' => ['role_or_permission:view']], function ($app) {

    $app->post('/show', function() {
       return response()->json([
            'message' => 'roles and  permission define',
            'status'  => 200
        ]);
       }); 
   });

    $app->post('/test1', function() {
    	//print_r(config('laravel-permission.table_names'))."gkadgjagk";
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