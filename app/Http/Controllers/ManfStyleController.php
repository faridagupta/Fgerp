<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Model\ManfProductStyle;
use App\Model\ManfStoryMaster;
use Illuminate\Support\Facades\Validator;

class ManfStyleController extends Controller
{
   public function __construct()
	{
	   
	}
    
    public function createStyle(Request $request)
    { 
    	$data = json_decode(json_encode($request->input()), true);
    	 
        $validator = Validator::make($data, [
             "style_number" => "required|unique:manf_product_style,style_number",
             "qty_to_produce" =>  "required|numeric",
			 "started_at" =>  "required",
			 "bom_id" =>  "required",
			 "story_id" => "required"
        ]);
         if ($validator->fails()) {

            return response()->json([
                "status_code"=>400,
                'status'=> 'faluire',
                 'error'=>$validator->errors()
             ]);

        }
        $data["created_by"] = auth()->user('id')->id;

        try{

            $ManfProductStylerObj =  new ManfProductStyle;
            $ManfProductStylerObj -> style_number = $data["style_number"];
            $ManfProductStylerObj -> qty_to_produce = $data["qty_to_produce"];
            $ManfProductStylerObj -> started_at = $data["started_at"];
            $ManfProductStylerObj -> bom_id = $data["bom_id"];
            $ManfProductStylerObj -> story_id = $data["story_id"];
            $ManfProductStylerObj -> created_by = $data["created_by"];
            $ManfProductStylerObj -> save();
          
         return response()->json([
                'status_code'  => 200,
                'status'=> 'success',
                'result' => [
                    'message' => 'Style Created Succesfully'
                ],
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

    public function createStory(Request $request){

    	$data = json_decode(json_encode($request->input()), true);
    	 
        $validator = Validator::make($data, [
             "vendor_id" => "required|numeric",
			 "story_name" =>  "required",
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

            $ManfStoryObj =  new ManfStoryMaster;
            $ManfStoryObj -> vendor_id = $data["vendor_id"];
            $ManfStoryObj -> story_name = $data["story_name"];
            $ManfStoryObj -> created_by = $data["created_by"];
            $ManfStoryObj -> save();
          
	         return response()->json([
                 'status_code'  => 200,
                 'status'=> 'success',
                 'result' => [
                    'message' => 'Story Created Succesfully'
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