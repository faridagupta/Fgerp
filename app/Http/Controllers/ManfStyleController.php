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
             "style_number" => "required",
			 "qty_to_produce" =>  "required|numeric",
			 "bom_id" =>  "required",
			 "story_id" => "required"
        ]);
         if ($validator->fails()) {
            return $validator->errors();
        }
        $data["created_by"] = auth()->user('id')->id;

        try{

            $ManfProductStylerObj =  new ManfProductStyle;
            $ManfProductStylerObj -> style_number = $data["style_number"];
            $ManfProductStylerObj -> qty_to_produce = $data["qty_to_produce"];
            $ManfProductStylerObj -> bom_id = $data["bom_id"];
            $ManfProductStylerObj -> story_id = $data["story_id"];
            $ManfProductStylerObj -> created_by = $data["created_by"];
            $ManfProductStylerObj -> save();
          
         return response()->json([
                'message' => 'Style Created Succesfully',
                'status'  => 200,
                //'last_insert_id' =>  manfVendorMaster::getvendorid()
             ]);
         }
        catch(\Exception $e){
             return response()->json([
                'message' => 'Style Not Created',
                'status'  => -1,
                 
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
            return $validator->errors();
        }
        $data["created_by"] = auth()->user('id')->id;

        try{

            $ManfStoryObj =  new ManfStoryMaster;
            $ManfStoryObj -> vendor_id = $data["vendor_id"];
            $ManfStoryObj -> story_name = $data["story_name"];
            $ManfStoryObj -> created_by = $data["created_by"];
            $ManfStoryObj -> save();
          
	         return response()->json([
	                'message' => 'Story Created Succesfully',
	                'status'  => 200,
	                //'last_insert_id' =>  manfVendorMaster::getvendorid()
	            ]);
         }
        catch(\Exception $e){
             return response()->json([
                'message' => 'Story Not Created',
                'status'  => -1,
                 
             ]);
         }


    }
 
}