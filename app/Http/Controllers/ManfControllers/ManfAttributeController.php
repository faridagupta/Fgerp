<?php

namespace App\Http\Controllers\ManfControllers;
use Illuminate\Http\Request;
use App\Model\ManfAttributeMaster;
use App\Model\ManfStyleAttrValues;
use App\Model\ManfStyleAttrMapping;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Classes\Helpers\Utility;


class ManfAttributeController extends Controller
{
   public function __construct()
	{
	   
	}
	public function saveAttr( Request $request ){
	
		$data = json_decode(json_encode($request->input()), true);

        $requirValidation = Utility::requiredValidation($data, ['attribute_name','attribute_value_name']);
         if($requirValidation)       
            return $requirValidation;
        $data["created_by"] = auth()->user('id')->id;

         try{            
            $manfAttribute =  new ManfAttributeMaster;
            $manfAttribute->attribute_name = $data["attribute_name"];
            $manfAttribute->attribute_type = $data["input_type"];
            //$manfAttribute->attribute_type = $data["attribute_type"];
            $data1 = $manfAttribute->save();
            $attr_id = $manfAttribute->entity_id;
            if( $attr_id != '' ){
                $manfAttributeval =  new ManfStyleAttrValues;
                if(!empty($data["attribute_value_name"])){
                    foreach ($data["attribute_value_name"] as $key => $value) {
                        $resarr[] = array('attribute_name'=>$data['attribute_name'],'attribute_entity_id'=>$attr_id,'attribute_value'=> $value ); 
                       
                    }
                    ManfStyleAttrValues::insert($resarr);
                } 
                
            }
            $successResponse = Utility::successResponse('Attribute Created Succesfully','');
            
            return $successResponse;
         }
        catch(\Exception $e){
              $excResponse = Utility::failureResponse($e->getMessage(), '');
              return $excResponse;
         }








        // try{


        //     $manfAttribute =  new ManfAttributeMaster;
        //     $manfAttribute->attribute_name = $data["attribute_name"];
        //     //$manfAttribute->attribute_type = $data["attribute_type"];
        //     $data1 = $manfAttribute->save();
        //     $attr_id = $manfAttribute->entity_id;
          
        //     if( $attr_id != '' ){
            		
        //     	$manfAttributeval =  new ManfStyleAttrValues;
        //         if(!empty($data["attribute_value_name"])){
        //             foreach ($data["attribute_value_name"] as $key => $value) {
        //                 // $manfAttributeval->attribute_name = $data["attribute_name"];
        //                 // $manfAttributeval->attribute_entity_id = $attr_id;
        //                 // $manfAttributeval->attribute_value = $value;
        //                 $resarr[] = array('attribute_name'=>$data['attribute_name'],'attribute_entity_id'=>$attr_id,'attribute_value'=> $value ); 
                       
        //             }
        //             ManfStyleAttrValues::insert($resarr);
        //         } 
                
        //     }
          
        //  return response()->json([
        //         'status_code'  => 200,
        //         'status'=> 'success',
        //         'result' => [
        //             'message' => 'Attribute Created Succesfully'
        //          ]
        //         //'last_insert_id' =>  manfVendorMaster::getvendorid()
        //      ]);
        //  }
        // catch(\Exception $e){
        //      return response()->json([
        //         'status_code'  => 400,
        //         'status'=> 'failure',
        //         'error' => $e->getMessage()   
        //     ]);
        //  }
	}
	 public function getattrDetails(){
        //$attribute = ManfStyleAttrValues::select('entity_id','attribute_name','attribute_entity_id','attribute_value')->get()->toArray();
        //$attribute = ManfAttributeMaster::with('parent')->get();

        $attribute = ManfAttributeMaster::with('children')->get();
        
        $successResponse = Utility::successResponse('',$attribute);
            
            return $successResponse;
      //  $attr = $attribute->child();
      //  dd($attribute);
    }
    public function updateAttribute( Request $request ){

        $styleattr = $request->input();
        $styleid = $styleattr['style_entity_id'];
        try{
             foreach ($styleattr['attributes'] as $key => $value){ 

            $attrid = $value['attribute_id'];
            $attrvalid = $value['attribute_val_id'];
            $attrval = $value['attribute_val'];

            $updateattr = ManfStyleAttrMapping::where('style_entity_id', $styleid)->where('attribute_id', $attrid)->update(['attribute_val_id' => $attrvalid ,'attribute_val' => $attrval ]);

            }
          $successResponse = Utility::successResponse('Attribute Updated Succesfully','');
            
            return $successResponse;
         }
        catch(\Exception $e){
              $excResponse = Utility::failureResponse($e->getMessage(), '');
              return $excResponse;
        }
       // ManfStyleAttrMapping::where('style_entity_id', $styleid)->update(['attribute_val_id' => $attrid ]);
    }
    public function getAttributeStyle( Request $request ){
        $styleattr = $request->input();
        $styleid = $styleattr['style_entity_id'];
        try{
        $data['style_details'] = ManfStyleAttrMapping::with(array('attributes'=>function($query){$query->select('entity_id','attribute_name');}))->where('style_entity_id', '=', $styleid)->groupBy('attribute_id')->get();

          $successResponse = Utility::successResponse('',$data);
            
            return $successResponse;
         }
        catch(\Exception $e){
              $excResponse = Utility::failureResponse($e->getMessage(), '');
              return $excResponse;
        }
    }
}