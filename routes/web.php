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
$app->post('/register', 'ManfControllers\userController@register');

$app->post('/authenticate', 'ManfControllers\userController@authenticate');

$app->group(['middleware' => 'auth:api'], function($app)
{
    $app->post('/createrole', 'ManfControllers\userController@createRole');
    $app->post('/createpermission', 'ManfControllers\userController@createPermission');
    $app->post('/assignrole', 'ManfControllers\userController@assignRole');
    $app->post('/assignpermission', 'ManfControllers\userController@assignPermission');
    $app->post('/assignrolepermission', 'ManfControllers\userController@roleHasPermmision');
    $app->post('/create-component', 'ManfControllers\userController@createComponent');
    //$app->post('/createvendor', 'ManufacturingController@createVendor');
    $app->post('/add-delivery-address', 'ManfControllers\ManfPoController@addDeliveryAddress');
    $app->post('/manufacturing-style', 'ManfControllers\ManfStyleController@manufacturingStyle');
    $app->post('/create-story', 'ManfControllers\ManfStyleController@createStory');
    $app->post('/create-bom', 'ManfControllers\ManfBomController@createBom');
    $app->post('/create-product-style-bom', 'ManfControllers\ManfBomController@productStyleBom');
    $app->post('/create-material', 'ManfControllers\ManfMaterialController@createMaterial');
    $app->post('/material-type', 'ManfControllers\ManfMaterialController@materialType');
    $app->post('/vendor-material', 'ManfControllers\ManfMaterialController@vendorMaterial');
    $app->post('/generate-po', 'ManfControllers\ManfPoController@generatePo');
    $app->post('/material-in-warehouse', 'ManfControllers\ManfMaterialInWarehouseController@MaterialInWarehouse');
    $app->post('/get-material-detail', 'ManfControllers\ManfMaterialController@getmaterialDetails');
    $app->post('/get-material-qty', 'ManfControllers\ManfMaterialController@getMaterialQty');
    $app->post('/create-style', 'ManfControllers\ManfStyleController@createStyle');
    $app->post('/po-details', 'ManfControllers\ManfPoController@poDetails');
    $app->post('/material-code-bytype', 'ManfControllers\ManfMaterialController@materialCodeByType');
    $app->post('/material-test', 'ManfControllers\ManfMaterialController@materialTest');
    $app->post('/create-material-type', 'ManfControllers\ManfMaterialController@createMaterialType');
    $app->post('/create-admin-rule', 'ManfControllers\userController@createAdminRule');



    $app->group(['middleware' => ['role:Admin']], function ($app) {

      //$app->post('/createrole', 'userController@createRole');
      $app->post('/createvendor', 'ManfControllers\ManufacturingController@createVendor');

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

    // Get Api For Manufacturing ERP

    $app->get('/get-style', 'ManfControllers\ManfStyleController@getStyles');
    $app->get('/get-bom', 'ManfControllers\ManfStyleController@getBom');
    $app->get('/get-story', 'ManfControllers\ManfStyleController@getStory');
    $app->get('/get-material-name-type', 'ManfControllers\ManfMaterialController@getMaterialNameType');
    $app->get('/get-material-name', 'ManfControllers\ManfMaterialController@getMaterialName');
    $app->get('/get-material-composition', 'ManfControllers\ManfMaterialController@getMaterialComposition');
    $app->get('/get-vendor-name', 'ManfControllers\ManufacturingController@getVendorName');
    $app->get('/po-list', 'ManfControllers\ManfPoController@poLists');
    $app->get('/get-material-code', 'ManfControllers\ManfMaterialController@getMaterialCode');
    $app->get('/get-material-type', 'ManfControllers\ManfMaterialController@getMaterialType');
    $app->get('/get-state-code', 'ManfControllers\ManufacturingController@getStateCode');
    $app->get('/get-bank-name', 'ManfControllers\ManufacturingController@getBankName');
    
     //Api for view in ERP
    $app->get('/get-style-list[/{style}]','ManfControllers\ManfStyleController@getStylesList');
$app->get('/example','ManfControllers\ExampleController@index');
    
});



//get_name();

$app->get('/redirect', 'ExampleController@redirectAuthorization');

$app->get('/callback', 'ExampleController@callbackAccess');

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function($api){

	// $api->group(['prefix'=>'oauth'], function($api){
	// 	$api->post('token','\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
	// });

	$api->group(['namespace'=>'App\Http\Controllers', 'middleware'=>['auth:api']],function($api){
		$api->get('testapi', function () {
			echo "hello1 ";
		    //return 'Hello World';
		});
	});
});


