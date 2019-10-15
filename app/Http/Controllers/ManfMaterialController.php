<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Model\ManfMaterialDetail;
use App\Model\ManfMaterialType;
use App\Model\ManfVendorMaterial;
use Illuminate\Support\Facades\Validator;

class ManfMaterialController extends Controller
{
   public function __construct()
	{
	   
	}
    
    public function createMaterial(Request $request)
    { 
    	$data = json_decode(json_encode($request->input()), true);
        $validator = Validator::make($data, [
             "material_code" => "required",
			 "material_type" =>  "required",
			 "composition" =>  "required",
             "color" => "required",
             "test_report" => "required",
             "material_img" => "required",
			 "material_name" => "required",
        ]);
         if ($validator->fails()) {
            return response()->json([
                'status_code'=> 400,
                'status'=> 'faluire',
                'error'=>$validator->errors()
             ]);
        }
        $data["created_by"] = auth()->user('id')->id;

        try{

            $ManfMaterialDetailObj =  new ManfMaterialDetail;
            $ManfMaterialDetailObj -> material_code = $data["material_code"];
            $ManfMaterialDetailObj -> material_type = $data["material_type"];
            $ManfMaterialDetailObj -> composition = $data["composition"];
            $ManfMaterialDetailObj -> color = $data["color"];
            $ManfMaterialDetailObj -> test_report = $data["test_report"];
            $ManfMaterialDetailObj -> material_img = $data["material_img"];
            $ManfMaterialDetailObj -> material_name = $data["material_name"];
            $ManfMaterialDetailObj -> created_by = $data["created_by"];
            $ManfMaterialDetailObj -> save();
          
         return response()->json([
                'status_code'  => 200,
                 'status'=> 'success',
                 'result' => [
                    'message' => 'Material Component Created Succesfully'
                 ]
                //'last_insert_id' =>  manfVendorMaster::getvendorid()
             ]);
         }
        catch(\Exception $e){
              return response()->json([
                'status_code'  => 400,
                'status'=> 'faluire',
                'error' => $e->getMessage()   
            ]);
         }

    }

    public function vendorMaterial(Request $request)
    { 

        $data = json_decode(json_encode($request->input()), true);
        print_r($data); 
        $validator = Validator::make($data, [
             "vendor_id" => "required",
             "material_type_id" =>  "required",
            ]);
         if ($validator->fails()) {
           return response()->json([
                'status_code'=> 400,
                'status'=> 'faluire',
                'error'=>$validator->errors()
             ]);
        }
 
        try{

            $ManfVendorMaterialObj =  new ManfVendorMaterial;
            $ManfVendorMaterialObj -> vendor_id = $data["vendor_id"];
            $ManfVendorMaterialObj -> material_type_id = $data["material_type_id"];
            $ManfVendorMaterialObj -> save();
          
         return response()->json([
                 'status_code'  => 200,
                 'status'=> 'success',
                 'result' => [
                    'message' => 'Vendor Component Created Succesfully'
                 ]
              ]);
         }
        catch(\Exception $e){
              return response()->json([
                'status_code'  => 400,
                'status'=> 'faluire',
                'error' => $e->getMessage()   
            ]);
         }

    }
    
     public function materialType(Request $request)
    { 
        $data = json_decode(json_encode($request->input()), true);
        $validator = Validator::make($data, [
             "bom_number" => "required",
             "measuring_type" =>  "required",
            ]);
         if ($validator->fails()) {
            return response()->json([
                'status_code'=> 400,
                'status'=> 'faluire',
                'error'=>$validator->errors()
             ]);
        }
        $data["created_by"] = auth()->user('id')->id;

        try{

            $ManfMaterialTypeObj =  new ManfMaterialType;
            $ManfMaterialTypeObj -> bom_number = $data["bom_number"];
            $ManfMaterialTypeObj -> measuring_type = $data["measuring_type"];
            $ManfMaterialTypeObj -> created_by = $data["created_by"];
            $ManfMaterialTypeObj -> save();
          
         return response()->json([
                'status_code'  => 200,
                'status'=> 'success',
                'result' => [
                    'message' => 'Material Type Created Succesfully'
                 ]
                //'last_insert_id' =>  manfVendorMaster::getvendorid()
             ]);
         }
        catch(\Exception $e){
             return response()->json([
                'status_code'  => 400,
                'status'=> 'faluire',
                'error' => $e->getMessage()   
            ]);
         }

    }
}