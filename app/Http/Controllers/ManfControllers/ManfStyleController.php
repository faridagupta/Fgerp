<?php

namespace App\Http\Controllers\ManfControllers;
use Illuminate\Http\Request;
use App\Model\ManfProductStyle;
use App\Model\ManfProductStyleBom;
use App\Model\ManfStoryMaster;
use App\Model\ManfSizeMapping;
use App\Model\ProductionPlaning;
use App\Model\ManfStyleAttrMapping;
use App\Model\ManfStyleMaster;
use App\Model\ManfBomMaterial;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Classes\Helpers\Utility;
 
class ManfStyleController extends Controller
{
    private $activeUser;

   public function __construct()
	{
          $this->activeUser = auth()->user('id')->id;
	    
	}
    
    public function createStyle(Request $request)
    {
       $data = json_decode(json_encode($request->input()), true);
         
        $validator = Validator::make($data, [
             "style_no" => "required|unique:manf_style_master,style_no",
             "style_type"   => "required"
        ]);

        if ($validator->fails()) {
            $res = Utility::alreadyExistsResponse($validator->errors());
            return $res;  
        }

         try{
            $requestedData = $request->all();
            $requestedData['created_by'] = $this->activeUser;
            //$style_id = 55;
           // $data['created_by'] = 1;
             // $article = ManfStyleMaster::findOrFail($style_id);
             //  dd(ManfStyleMaster::select(['entity_id'])->get()->toArray());
                $response = ManfStyleMaster::create($requestedData);
               
                $responseData['style_no'] = $response->style_no;
                $responseData['style_entity_id'] = $response->entity_id;

                $response = Utility::successResponse('Style Created Successfully',$responseData);
                
                return $response;
    
         }
        catch(\Exception $e){
                $response = Utility::failureResponse($e->getMessage());
                 return $response;
         }

    }

    public function manufacturingStyle(Request $request)
    { 
    	$data = $request->input();//json_decode(json_encode($request->input()), true);

         $requirValidation = Utility::requiredValidation($data, ['style_entity_id','style_no','style_name','bom_id','bom_no','story_id','story_no']);
         if($requirValidation)       
            return $requirValidation;

         $uniqueValidation = Utility::uniqueValidation($data, ['style_no'=>'unique:manf_product_style,style_no']);
         if($uniqueValidation)       
            return $uniqueValidation;

        $customValidation = Utility::customValidation($data, ['style_entity_id'=>'numeric']);
         if($customValidation)       
            return $customValidation;


        $data["created_by"] = auth()->user('id')->id;

        try{            
            $data['created_by'] = $this->activeUser;
            $response = ManfProductStyle::create($data);

            $successResponse = Utility::successResponse('Style Details Created Successfully','');
            
            return $successResponse;
         }
        catch(\Exception $e){
              $excResponse = Utility::failureResponse($e->getMessage(), '');
              return $excResponse;
         }

    }

    public function createProductionPlan(Request $request){
        $data = $request->input();
        $requirValidation = Utility::requiredValidation($data, ['style_no','style_entity_id']);
         if($requirValidation)       
            return $requirValidation;           
        try{    

           $style_entity_id = $data['style_entity_id'];      
           $style_no = $data['style_no'];
           $data['created_by'] = $this->activeUser;
            foreach ($data["production_plan"] as $key => $value) {

            
            $resarr[] = array(
                'style_entity_id' => $style_entity_id,
                'style_no' => $style_no,
                'planned_qty'=>$value['planned_qty'],
                'launched_date'=>$value['launched_date'],
                'production_month'=> $value['production_month']
                );     
            }
            //return $resarr;
            $response = ProductionPlaning::insert($resarr);

            
            if($response)
             $this->styleSizeMapping($data);

            $successResponse = Utility::successResponse('Production Planned Scheduled Successfully','');
            
            return $successResponse;
         }

        catch(\Exception $e){
              $excResponse = Utility::failureResponse($e->getMessage(), '');
              return $excResponse;
         }
        
        
    }

    public function styleSizeMapping($data){
            foreach ($data['production_plan'] as $size_wise_qty) {
                foreach ($size_wise_qty['size_wise_qty'] as $key => $value) {
                $plannedRatio = round($value['qty']/$size_wise_qty['planned_qty']*100,2);
                $sizesData[] = array('style_no'=>$data['style_no'],'style_entity_id'=>$data['style_entity_id'],'size_id'=> $value['size_id'],'size'=>$value['size'],'planned_qty'=>$value['qty'],'planned_ratio'=>$plannedRatio ,'created_by'=>$data['created_by']);
                }
            }
            ManfSizeMapping::insert($sizesData);
             $response = Utility::successResponse('Size Assign Successfully');
            
            return $response;
    }
    public function getStyleProductionPlan( $style_entity_id = '' ){
        $data = ProductionPlaning::where('style_entity_id','=', $data['style_entity_id'])->get();
        if(!empty($data)){
            $response = Utility::successResponse('',$data);
            return $response;
        }
        else
        {
             $response = Utility::failureResponse('Style not found');
                 return $response;
        }
    }
    public function updateProductionPlan( Request $request ){
        $data = $request->input();
        $requirValidation = Utility::requiredValidation($data, ['style_no','style_entity_id']);
       if($requirValidation)       
           return $requirValidation;           
        try{    
            //$res = ProductionPlaning::where('style_entity_id','=', $data['style_entity_id'])->where('style_no','=', $data['style_no'])->get();
           
            $style_entity_id = $data['style_entity_id'];      
            $style_no = $data['style_no'];
            $data['created_by'] = $this->activeUser;
            foreach ($data["production_plan"] as $key => $value) {
                $resarr[] = array(
                    'planned_qty'=>$value['plannedRationned_qty'],
                    'launched_date'=>$value['launched_date'],
                    'production_month'=> $value['production_month']
                    );     
                }
            $updateattr = ProductionPlaning::where('style_entity_id', '=',$style_entity_id)->update($resarr);
            
            if($response)
                $this->styleSizeMapping($data);
            $successResponse = Utility::successResponse('Production Planned Updated Successfully','');
            
            return $successResponse;
         }
        catch(\Exception $e){
              $excResponse = Utility::failureResponse($e->getMessage(), '');
              return $excResponse;
         }
    }


   public function assignAttributes(Request $request){
        $data = $request->input();
        
        $requirValidation = Utility::requiredValidation($data, ['style_no','style_entity_id','attributes']);

         if($requirValidation)       
            return $requirValidation;
         try{
            $data['created_by'] = $this->activeUser;
            
            foreach ($data['attributes'] as $key => $value) {
              $attributesValues[] = array('style_no'=>$data['style_no'],'style_entity_id'=>$data['style_entity_id'],'attribute_id'=>$value['attribute_id'],'attribute_val'=>$value['attribute_val'],'attribute_val_id'=>$value['attribute_val_id']);
            }
            $response = ManfStyleAttrMapping::insert($attributesValues);
            $response = Utility::successResponse('Attributes Assign Successfully');
            
            return $response;
    
         }
        catch(\Exception $e){
                $response = Utility::failureResponse($e->getMessage());
                 return $response;
         }
   }

//Add Story

    public function createStory(Request $request){

    	$data = json_decode(json_encode($request->input()), true);
    	 
        $validator = Validator::make($data, [
             //"vendor_id" => "required|numeric",
			 "story_name" =>  "required",
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

            $ManfStoryObj =  new ManfStoryMaster;
            //$ManfStoryObj -> vendor_id = $data["vendor_id"];
            $ManfStoryObj -> story_name = $data["story_name"];
            $ManfStoryObj -> created_by = $data["created_by"];
            $ManfStoryObj -> save();
           $response = Utility::successResponse('Style Created Successfully');
            
            return $response;
         }
        catch(\Exception $e){
               $response = Utility::failureResponse($e->getMessage());
                 return $response;
         }

    }


    //Get Story List 
    public function getStoryList(Request $request){
         $data = $request->input();
        if(!empty($data['search']))
            $search = $data['search'];
        
        
        if(!isset($data['skip']))
            $data['skip'] = 0;
        if(!isset($data['limit']))
            $data['limit'] = 10;

        $storyList = ManfStoryMaster::with('styleDetails')
                    ->where(function($query) use ($data)  {
                        if(!empty($data['search'])){
                            $query->where($data['search']);
                        }
                        
                     })->skip($data['skip'])->limit($data['limit'])->orderBy($data['sortcolumn'], $data['sortorder'])->get();


        return $storyList;
    }

    //Delete Story

    public function deleteStory($id ){

         if($id==""){
         $response = Utility::failureResponse("Please Pass Story ID");
         return $response;
        }
        $res = ManfStoryMaster::where('entity_id',$id)->delete();
         if($res ==1){
            $response = Utility::successResponse('Story Deleted');
        }
        else 
            $response = Utility::failureResponse("Story Not Deleted");
        return $response;
    }

    public function getStyles(Request $request){
        $data = ManfStyleMaster::getStyle();
        // $data = ManfStyleMaster::getStyle();
        if(!empty($data)){
            $response = Utility::successResponse('',$data);
            return $response;
        }
        else
        {
             $response = Utility::failureResponse('Style not found');
                 return $response;
        }

     }

     public function getBom(){
        $data = ManfProductStyleBom::getBomName();
        if(!empty($data)){
          $response = Utility::successResponse('',$data);
          return $response;
    
         }
        else{
                $response = Utility::failureResponse('Bom not found');
                 return $response;
         }
     }
     public function getStory(){

        $data = ManfStoryMaster::getStoryName();
        if(!empty($data)){
        $response = Utility::successResponse('',$data);
          return $response;
    
        }
        else
        {
              $response = Utility::failureResponse('Story not found');
                 return $response;
        }
     }
     
     

     public function editStory(Request $request){
        $data = $request->input();
        $storyData = ManfStoryMaster::where('entity_id',$data['entity_id'])->update($data);
        if($storyData ==1){
        $response = Utility::successResponse('Style Description Updated');

        }
        else 
            $response = Utility::failureResponse("Style Not Updated");
        return $response;
     }

     public function getStylesList($style = "",Request $request){

        $data = $request->input();
        if(!empty($data['search']))
            $search = $data['search'];
        
        
        if(!isset($data['skip']))
            $data['skip'] = 0;
        if(!isset($data['limit']))
            $data['limit'] = 10;
 
        $Styledata = ManfStyleMaster::with('children')->with('details')
        ->where('manf_style_master.is_active', '=',1)
        ->where('manf_style_master.is_deleted', '=',0)
        ->where(function($query) use ($style,$data)  {
            if($style !="") {
                $query->where('style_no', $style);}
            if(!empty($data['search'])){
                $query->where($data['search']);
            }
            
         })->skip($data['skip'])->limit($data['limit'])->orderBy($data['sortcolumn'], $data['sortorder'])->get();
       
        // return $style;
        // $data = ManfProductStyle::getStyleLists($style);
        if(!empty($Styledata)){
        $res = Utility::successResponse('',$Styledata);
        return $res;    
        }
     }

  
     public function getManufacturingStyleDetails($styleNo=""){
        if($styleNo=="")
         {
            $response = Utility::failureResponse("Please pass style");
             return $response;
         }
          $data['style_details'] = ManfStyleMaster::with('children')->with('details')
        ->where('manf_style_master.is_active', '=',1)
        ->where('manf_style_master.is_deleted', '=',0)
         ->where(function($query) use ($styleNo)  {
            if($styleNo !="") {
                $query->where('style_no', $styleNo);
            }
         })->get();
        $data['size'] = ManfSizeMapping::getStylesSize($styleNo);

         $bom = "";
       //  dd($data);
         foreach ($data['style_details'] as $key => $value) {
              $bom = $value['bom_no'];
          }
         // $data['style_details'][0]['children']['bom_no'];
        
        if($bom!="")
        $data['bom_material']  = ManfBomMaterial::with('children')->where('bom_no',$bom)
         ->get();

          $data['attributes'] = ManfStyleAttrMapping::with(array('attributes'=>function($query){$query->select('entity_id','attribute_name');}))->where('style_no', '=', $styleNo)->groupBy('attribute_id')->get();
 
          
        if(!empty($data)){
        $res = Utility::successResponse('',$data);
        return $res;    
        }


        return $styleNo;
     }

     public function updateStyleAttribute(Request $request){
        $data = $request->input();
        $styleData = ManfProductStyle::where('style_no',$data['style_no'])->update($data);
        if($styleData ==1){
        $response = Utility::successResponse('Style Description Updated');

        }
        else 
            $response = Utility::failureResponse("Style Not Updated");
        return $response;
     }

     public function deleteStyle($id){
       
        if($id==""){
         $response = Utility::failureResponse("Please Pass Style ID");
         return $response;
        }
        $res = ManfStyleMaster::where('entity_id',$id)->delete();
         if($res ==1){
            $response = Utility::successResponse('Style Deleted');
        }
        else 
            $response = Utility::failureResponse("Style Not Deleted");
        return $response;
     }

}