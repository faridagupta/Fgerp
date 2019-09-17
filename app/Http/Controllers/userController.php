<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use GuzzleHttp;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;


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
            'message' => $request->input('role') .'Role Created Succesfully',
            'status'  => 200
          ]);
         }
         else
         {
         	return  response()->json([
            'message' => $request->input('role') .'Role Not Created',
            'status'  => 400
          ]);
         }
     	 
     }

     public function createPermission(Request $request){

     	if($request->input('permission')){
     	  $role = Permission::create(['name' => $request->input('permission')]);
     	  return  response()->json([
            'message' => $request->input('role') .'Permission Created Succesfully',
            'status'  => 200
          ]);
         }
         else
         {
         	return  response()->json([
            'message' => $request->input('role') .'Permission Not Created',
            'status'  => 400
          ]);
         }
     }

     public function roleHasPermmision(Request $request){
     	  $rl= $request->input('role');

     	  $role = Role::findByName("$rl");
      	  $per = $request->input('permissions');
     	  $perArray = explode(',', $per);
     	  $role->syncPermissions($perArray);
          return "Permission assign to role".$request->input('role'); 
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
	            'message' => $request->input('role_id') .'Role Assign Succesfully',
	            'status'  => 200
	          ]);
         }
         else
         {
         	return  response()->json([
            'message' => $request->input('role_id') .'Role Not Assign',
            'status'  => 400
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
	            'message' => $request->input('permission_id') .'Permission Assign Succesfully',
	            'status'  => 200
	          ]);
         }
         else
         {
         	return  response()->json([
            'message' => $request->input('permission_id') .'Permission Not Assign',
            'status'  => 400
          ]);
         }
     }

     
}
