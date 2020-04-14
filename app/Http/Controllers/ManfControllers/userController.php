<?php

namespace App\Http\Controllers\ManfControllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use GuzzleHttp;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Model\AdminRule;
use Dashboard\Classes\Helpers\Utility;


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

           //echo  "===".Crypt::decrypt($user->password)  ."---". $request->input('password');exit;
	        if( Crypt::decrypt($user->password)==$request->input('password')){
              
	            echo $apikey = self::get_access_token();
               
              return 98;
	          // User::where('email', $request->input('email'))->update(['api_token' => "$apikey"]);
            // $role =  DB::table('user_has_roles')->select('role_id')->where('user_id',$user->id)->first();
              
             // if(!empty($role))
             // $details =  DB::table('admin_rule')->select('role_id','component','module','resource','permission')->where('role_id',$role->role_id)->get();
             // else
             // {
              return response()->json([
                'status_code'=> 201,
                'status'=> 'success',
                'result'=> 'Login Successfully, Please assign a role'
             ]);
            // }

 	          return response()->json([
               'status_code'  => 200,
               'status'=> 'success',
               'result' => [
                    'api_token' => env('api_token'),
                    'access_details'      => $details//[{"name": "style","resource" : "manfacturing/style", "permission":"1"}],
                 ]
               ]);

	      }else{

	          return response()->json([
                'status_code'=> 201,
                'status'=> 'failure',
                'error'=> 'password incorrect'
             ]);

	      }

	   }

    public static function get_access_token()
	{
    return 23;
			$client = new GuzzleHttp\Client;
			$response = $client->request('POST', env('APP_URL').'/oauth/token', [
	        'form_params' => [
						'grant_type' => 'client_credentials',
						'client_id'  => '9',
						'scope' => '*',
						'client_secret' => 'lkm9eQqv4bTFWSDlVig8qx5L7oQanKjuywg4FMzf',
						],
	         ]);
       
	       $result= json_decode((string) $response->getBody(), true);
	        

       return $result['access_token'];
	}
     public function login()
     {
     	// A permission can be assigned to a role 
         /*$role = Role::find(1);
         $permission = Permission::find(1);
         $role->givePermissionTo($permission);*/
          

	    /*$role = Role::create(['name' => 'Production2']);
		$permission = Permission::create(['name' => 'edit']);
		$role->givePermissionTo($permission);
		$permission->assignRole($role);
	     $role = Role::where('id',1)->first();
	     $permission = Permission::where('id',1)->first();
	     //print_r ($permission->name);exit;
	     $role=$role->id;*/
	     //$role->givePermissionTo($permission->id);
	     //$permission->assignRole($role);

	     // Revoke Permission 
	   /*  $role = Role::find(1);
	     $permission = Permission::find(1);
	     dd($permission);
	     $permission->removeRole($role);*/
          $user = auth()->user();
          //$user ->givePermissionTo('view');
          //$user ->assignRole('writer');
          /*return User::permission('writer')->get();
	      return auth()->user()->permissions;
	      */return "logged in Success"; exit;
     }


     public function createRole(Request $request){

     	if($request->input('role')){
     	  $role = Role::create(['name' => $request->input('role')]);
     	  return  response()->json([
            'status_code'  => 200,
            'status'=> 'success',
            'result' => [
               'message' => $request->input('role') .'Role Created Succesfully',
             ]
          ]);
         }
         else
         {
         	return  response()->json([
            'status_code'  => 400,
            'status'=> 'failure',
            'result' => [
            'message' => $request->input('role') .'Role Not Created',]
          ]);
         }
     	 
     }

     public function createPermission(Request $request){

     	if($request->input('permission')){
     	  $role = Permission::create(['name' => $request->input('permission')]);
     	  return  response()->json([
            'status_code'  => 200,
            'status'=> 'success',
            'result' => [
            'message' => $request->input('role') .'Permission Created Succesfully',]
          ]);
         }
         else
         {
         	return  response()->json([
            'status_code'  => 400,
            'status'=> 'failure',
            'result' => [
            'message' => $request->input('role') .'Permission Not Created',
             ]
          ]);
         }
     }

     public function roleHasPermmision(Request $request){
     	  $rl= $request->input('role');
         
     	  $role = Role::findByName("$rl");
      	$per = $request->input('permissions');
     	  $perArray = explode(',', $per);
     	  $role->syncPermissions($perArray);
          return  response()->json([
            'status_code'  => 200,
            'status'=> 'success',
            'result' => [
            'message' =>  "Permission assign to role".$request->input('role')
          ]
        ]); 
     }
      public function assignRole(Request $request){

          /*$email = $request->input('email');
          $results = DB::select("SELECT * FROM users where email='".$email."' ");*/
          // $results->assignRole($request->input('assignrole'));
          /*$role = Role::findByName('writer');
          $permissions = array('Designing','edit','view');
          $role->syncPermissions($permissions);

        
         dd(auth()->user());*/
          
        
         //exit; 
     	if($request->input('role_id')){
          
            DB::table('user_has_roles')->insert([
            'role_id' => $request->input('role_id'),
            'user_id' => $request->input('user_id')
           ]);
            
	     	  return  response()->json([
	          'status_code'  => 200,
            'status'=> 'success',
            'result' => [
            'message' => $request->input('role_id') .'Role Assign Succesfully',
	           ]
	          ]);
         }
         else
         {
         	return  response()->json([
            'status_code'  => 400,
            'status'=> 'faluire',
            'result' => [
              'message' => $request->input('role_id') .'Role Not Assign',
            ]
          ]);
         }
     }
     
     public function assignPermission(Request $request){
         
      	if($request->input('permission_id')){
          
            DB::table('user_has_permissions')->insert([
            'permission_id' => $request->input('permission_id'),
            'user_id' => $request->input('user_id')
           ]);
            
	     	  return  response()->json([
            'status_code'  => 200,
            'status'=> 'success',
            'result' => [
	            'message' => $request->input('permission_id') .'Permission Assign Succesfully',
	            ]
	          ]);
         }
         else
         {
         	return  response()->json([
            'status_code'  => 400,
            'status'=> 'failure',
            'result' => [
            'message' => $request->input('permission_id') .'Permission Not Assign',
            ]
          ]);
         }
     }
     
     public function createAdminRule(Request $request){
      $data = json_decode(json_encode($request->input()), true);
//return $data;
       $validator = Validator::make($data, [
              'role_id'   => 'required',
              'role_name' => 'required',
              'component' => 'required',
              'module'    => 'required',
              //'resource'  => 'required'
          ]);
 
        if ($validator->fails()) {
             return response()->json([
                'status_code'=> 400,
                'status'=> 'failure',
                'error'=>$validator->errors()
             ]);
        }
         
        try{
            

            foreach ($data['component'] as $key => $value) {
              $adminRuleObj =  new AdminRule;
              $adminRuleObj -> role_id    = $data["role_id"];
              $adminRuleObj -> role_name  = $data["role_name"];
              $adminRuleObj -> module     = $data["module"];
              $adminRuleObj -> component  = $value["name"];
              $adminRuleObj -> resource   = $value["resource"]; 
              $adminRuleObj -> permission = $value["permission"];
              $adminRuleObj -> save();
            }
             
           return response()->json([
                    'status_code'  => 200,
                    'status'=> 'success',
                    'result' => [
                                'message' => 'Admin Rule Created Succesfully'
                     ]
             ]);
         }
        catch(\Exception $e){
             return response()->json([
                    'status_code'  => 400,
                    'status'=> 'success',
                    'result' => [
                                 'message' => 'Admin Rule Not Created Succesfully'
                    ]
             ]);
         }
      
     }


    public function createComponent(Request $request){
      $data = json_decode(json_encode($request->input()), true);
       $validator = Validator::make($data, [
              'component'   => 'required',
              'module' => 'required',
          ]);
        
        if ($validator->fails()) {
             return response()->json([
                'status_code'=> 400,
                'status'=> 'failure',
                'error'=>$validator->errors()
             ]);
        }
        try{
            
          DB::table('erp_component')->insert([
            'component' => $data['component'],
            'module' => $data['module']
           ]);
          return response()->json([
                    'status_code'  => 200,
                    'status'=> 'success',
                    'result' => [
                    'message' => 'component Created Succesfully'
                     ]
             ]);
        }
        catch(\Exception $e){
             return response()->json([
                    'status_code'  => 400,
                    'status'=> 'success',
                    'result' => [
                                 'message' => 'component Not Created Succesfully'
                    ]
             ]);
         }
       
    }
     
}
