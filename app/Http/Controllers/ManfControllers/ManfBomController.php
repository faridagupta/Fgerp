<?php

namespace App\Http\Controllers\ManfControllers;
use Illuminate\Http\Request;
use App\Model\ManfBomMaterial;
use App\Model\ManfProductStyleBom;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


class ManfBomController extends Controller
{
   public function __construct()
	{
	   
	}
    
    public function createBom(Request $request)
    { 
    	$data = json_decode(json_encode($request->input()), true);
       
    	 $validator = Validator::make($data, [
            'style_id' => 'required',
            "bom_material" => 'required',
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
 
		    $ManfProductStyleBomObj =  new ManfProductStyleBom;
			$ManfProductStyleBomObj -> style_id = $data["style_id"];
			$ManfProductStyleBomObj -> bom = 'BOM - '. $ManfProductStyleBomObj->id;
			$ManfProductStyleBomObj -> created_by = $data["created_by"];
	        $ManfProductStyleBomObj -> save();
  
               $bomId = ManfProductStyleBom::getBomId();
	        
            if(!empty($data['bom_material'])){
               foreach ($data['bom_material'] as $key => $value) {
               	  $ManfBomMaterialObj =  new ManfBomMaterial;
               	  $ManfBomMaterialObj -> bom_number = $bomId;
				  $ManfBomMaterialObj -> material_id = $value["material_id"];
			   	  $ManfBomMaterialObj -> material_type = $value["material_type"];
				  $ManfBomMaterialObj -> material_qty = $value["material_qty"];
				  $ManfBomMaterialObj -> created_by = $data["created_by"];
		          $ManfBomMaterialObj -> save();
               }
            }
		     
	 	     return response()->json([
	             'status_code'  => 200,
                 'status'=> 'success',
                 'result' => [
                    'message' => 'Bom Created Succesfully'
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
   /* public function productStyleBom(Request $request){

       $data = json_decode(json_encode($request->input()), true);
       
    	 $validator = Validator::make($data, [
            'bom_number' => 'required',
             ]);

	    if ($validator->fails()) {
            return $validator->errors();
        }
        $data["created_by"] = auth()->user('id')->id;
	    try{
		    $ManfProductStyleBomObj =  new ManfProductStyleBom;
			$ManfProductStyleBomObj -> bom_number = $data["bom_number"];
			$ManfProductStyleBomObj -> created_by = $data["created_by"];
	        $ManfProductStyleBomObj -> save();
	 	     return response()->json([
	        'message' => 'Product Style Bom Created Succesfully',
	        'status'  => 200
	         ]);
	 	 }
	    catch(\Exception $e){
	 	 	 return response()->json([
	            'message' => 'Product Style Bom  Not Added',
	            'status'  => -1
	        ]);
	 	 }
    }*/
 
}