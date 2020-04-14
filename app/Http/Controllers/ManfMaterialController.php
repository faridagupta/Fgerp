<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Model\ManfMaterialDetail;
use App\Model\ManfMaterialType;
use App\Model\ManfVendorMaterial;
use App\Model\ManfBomMaterial;
use App\Model\ManfMaterialEnter;
use App\Model\ManfMaterialTypeCreate;
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
             "material_code"  => "required",
			 "material_type"  =>  "required",
			 "composition"    =>  "required",
             "color"          => "required",
             "test_report"    => "required",
             "material_img"   => "required",
             "material_name"  => "required",
             "rate"           => "required",
             "measuring_type" => "required",
			 "vendor"         => "required",
        ]);
        
         if ($validator->fails()) {
            return response()->json([
                'status_code' => 400,
                'status'      => 'failure',
                'error'       =>$validator->errors()
             ]);
        }
        $data["created_by"] = auth()->user('id')->id;

        try{

            $ManfMaterialDetailObj =  new ManfMaterialDetail;
            $ManfMaterialDetailObj -> material_code = $data["material_code"];
            $ManfMaterialDetailObj -> material_type = $data["material_type"];
            $ManfMaterialDetailObj -> composition = $data["composition"];
            $ManfMaterialDetailObj -> color = $data["color"];
            $ManfMaterialDetailObj -> test_report = json_encode($data["test_report"]);
            $ManfMaterialDetailObj -> material_img = $data["material_img"];
            $ManfMaterialDetailObj -> material_name = $data["material_name"];
            $ManfMaterialDetailObj -> rate = $data["rate"];
            $ManfMaterialDetailObj -> measuring_type = $data["measuring_type"];
            $ManfMaterialDetailObj -> vendor = $data["vendor"];
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
                'status'=> 'failure',
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
                'status'=> 'failure',
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
                'status'=> 'failure',
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
                'status'=> 'failure',
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
                'status'=> 'failure',
                'error' => $e->getMessage()   
            ]);
         }

    }

    public function getmaterialNameType(){

        $data = ManfMaterialDetail::getMaterialNameType();

        if(!empty($data)){
        return response()->json([
                'status_code'  => 200,
                'status'=> 'success',
                'result' => 
                  [$data]                 
             ]);
        }
        else
        {
             return response()->json([
                'status_code'  => 400,
                'status'=> 'failure',
                'error' => 'Material Not Found'
             ]);
        }
    }

    public function getMaterialName(){
        $data = ManfMaterialDetail::getMaterialNames();

        if(!empty($data)){
        return response()->json([
                'status_code'  => 200,
                'status'=> 'success',
                'result' => 
                  [$data]                 
             ]);
        }
        else
        {
             return response()->json([
                'status_code'  => 400,
                'status'=> 'failure',
                'error' => 'Material Not Found'
             ]);
        }
    }
 
    public function getMaterialType(){
        $data = ManfMaterialDetail::getMaterialType();

        if(!empty($data)){
        return response()->json([
                'status_code'  => 200,
                'status'=> 'success',
                'result' => 
                  [$data]                 
             ]);
        }
        else
        {
             return response()->json([
                'status_code'  => 400,
                'status'=> 'failure',
                'error' => 'Material Type Not Found'
             ]);
        }
    }


    public function getMaterialComposition(){
        $data = ManfMaterialDetail::getMaterialCompositions();

        if(!empty($data)){
        return response()->json([
                'status_code'  => 200,
                'status'=> 'success',
                'result' => 
                  [$data]                 
             ]);
        }
        else
        {
             return response()->json([
                'status_code'  => 400,
                'status'=> 'failure',
                'error' => 'Material Not Found'
             ]);
        }
    }

     public function getMaterialQty(Request $request){
        

        $data = json_decode(json_encode($request->input()), true);

        $validator = Validator::make($data, [
             "material_id"       => "required"
            ]);

         if ($validator->fails()) {
            return response()->json([
                'status_code'   => 400,
                'status'        => 'failure',
                'error'         =>$validator->errors()
             ]);
        }
        $value =array();
        $value['tot_qty']     = ManfMaterialDetail::getMaterialQty($data['material_id']);
        $material_in_qty      = ManfMaterialEnter::getMaterialRecived($data['material_id']);
        if($material_in_qty!="")
        $value['stock_left'] = $material_in_qty['qty_recived'];
        $value['qty_used']    = 0;
        //dd($value);

        if(!empty($value)){
        return response()->json([
                'status_code'   => 200,
                'status'        => 'success',
                'result'        =>  [$value]                 
             ]);
        }
        else
        {
             return response()->json([
                'status_code'   => 400,
                'status'        => 'failure',
                'error'         => 'Material Not Found'
             ]);
        }
    }
    
    public function getmaterialDetails(Request $request){

        $data = json_decode(json_encode($request->input()), true);
        $validator = Validator::make($data, [
             "vendor_id" => "required",
            ]);
         
         if ($validator->fails()) {
            return response()->json([
                'status_code'   => 400,
                'status'        => 'failure',
                'error'         =>$validator->errors()
             ]);
        } 
        
        $vendorData = ManfMaterialDetail::getMaterialDetail($data['vendor_id']);
         
        if(!empty($vendorData)){
        return response()->json([
                'status_code'  => 200,
                'status'       => 'success',
                'result'       => 
                  [$vendorData]                 
             ]);
        } else {
             return response()->json([
                'status_code'  => 400,
                'status'       => 'failure',
                'error'        => 'Material Detail Not Found'
             ]);
        }

        
    }
    
    public function materialCodeByType(Request $request){
      
      $data = json_decode(json_encode($request->input()), true);
        $validator = Validator::make($data, [
             "material_type" => "required",
            ]);
         
         if ($validator->fails()) {
            return response()->json([
                'status_code'   => 400,
                'status'        => 'failure',
                'error'         =>$validator->errors()
             ]);
        } 
       
        $materialCode = ManfMaterialDetail::getMaterialCodebyType($data['material_type']);
          
        if(!empty($materialCode)){
        return response()->json([
                'status_code'  => 200,
                'status'       => 'success',
                'result'       => 
                  [$materialCode]                 
             ]);
        } else {
             return response()->json([
                'status_code'  => 400,
                'status'       => 'failure',
                'error'        => 'Material Detail Not Found'
             ]);
        }

    }

    public function materialTest(Request $request)
    {
        $data = json_decode(json_encode($request->input()), true);
        $validator = Validator::make($data, [
             "material_type" => "required",
             "material_name" => "required",
             "test_report" => "required"
            ]);
         
         if ($validator->fails()) {
            return response()->json([
                'status_code'   => 400,
                'status'        => 'failure',
                'error'         =>$validator->errors()
             ]);
        } 
    
        $updatedtest = ManfMaterialDetail::updateTestReport($data);

        return response()->json([
                'status_code'  => 200,
                'status'       => 'success',
                'result'       => 
                  [$updatedtest]                 
             ]);
    } 

    public function createMaterialType(Request $request){
        $data = json_decode(json_encode($request->input()), true);
        //dd($data);
        $validator = Validator::make($data, [
             "material_type" => "required",
            ]);
         if ($validator->fails()) {
           return response()->json([
                'status_code'=> 400,
                'status'=> 'failure',
                'error'=>$validator->errors()
             ]);
        }
 
        try{

            $ManfVendorMaterialObj =  new ManfMaterialTypeCreate;
            $ManfVendorMaterialObj -> material_type = $data["material_type"];
            $ManfVendorMaterialObj -> save();
          
         return response()->json([
                 'status_code'  => 200,
                 'status'=> 'success',
                 'result' => [
                    'message' => 'Material Type Created Succesfully'
                 ]
              ]);
         }
        catch(\Exception $e){
              return response()->json([
                'status_code'  => 400,
                'status'=> 'failure',
                'error' => $e->getMessage()   
            ]);
         }   
          }
    
}