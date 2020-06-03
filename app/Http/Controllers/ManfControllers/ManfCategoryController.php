<?php

namespace App\Http\Controllers\ManfControllers;
use Illuminate\Http\Request;
use App\Model\ManfCategoryMaster;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Classes\Helpers\Utility;

class ManfCategoryController extends Controller
{
   public function __construct()
	{
	   
	}
	public function createCategory( Request $request ){
        $data = json_decode(json_encode($request->input()), true);
         $requirValidation = Utility::requiredValidation($data, ['name','parent_id','is_active']);
         if($requirValidation)       
            return $requirValidation;

         // $uniqueValidation = Utility::uniqueValidation($data, ['name'=>'unique:name']);
         // if($uniqueValidation)       
         //    return $uniqueValidation;

		
        $data["created_by"] = auth()->user('id')->id;

        try{

            $manfCategory =  new ManfCategoryMaster;
            $manfCategory->name = $data["name"];
            $manfCategory->parent_id = $data["parent_id"];
            $manfCategory->is_approve = $data["is_active"]; //status
            $manfCategory->created_by = $data["created_by"];
           // $manfCategory->path = $data["path"];
           // $manfCategory->level = $data["level"];
            $manfCategory->save();
          
          $successResponse = Utility::successResponse('Category Created Succesfully','');
            
            return $successResponse;
         }
        catch(\Exception $e){
              $excResponse = Utility::failureResponse($e->getMessage(), '');
              return $excResponse;
         }


	}

	public function getDetails(){
	//	$categories = ManfCategoryMaster::where('parent_id',0)->get();
		//$categories = ManfCategoryMaster::with('subcategory')->get()->toArray();

	//	$categories = ManfCategoryMaster::where('parent_id',0)->with('childrenCategories')->get();
          try{
            $categories = ManfCategoryMaster::with('children')->select('id','parent_id','name')->get()->toArray();
            $response = Utility::successResponse('',$categories);
            foreach($categories as $category){
            if(count(array_filter($category['children'])) != 0){
                $subcat = $category['children'];
            }

         }
          
       // return $categories;

          return $response;
         }
        catch(\Exception $e){
              $excResponse = Utility::failureResponse($e->getMessage(), '');
              return $excResponse;
         }





		
		//dd($categories);

	}

  public function updateCategory(Request $request){
        $data = $request->input();
        $catData = ManfCategoryMaster::where('id',$data['id'])->update($data);
        if($catData ==1){
        $response = Utility::successResponse('Category Updated');

        }
        else 
            $response = Utility::failureResponse("Category Not Updated");
        return $response;
  }


  public function deleteCategory($id){
   if($id==""){
         $response = Utility::failureResponse("Please Pass Style ID");
         return $response;
        }
        $res = ManfCategoryMaster::where('id',$id)->delete();
         if($res ==1){
            $response = Utility::successResponse('Category Deleted');
        }
        else 
            $response = Utility::failureResponse("Category Not Deleted");
        return $response;
     }
      
    public function getRatio($size){
       if($size==""){
         $response = Utility::failureResponse("Please Pass Style ID");
         return $response;
        }
          $data = array('XXS'=>12,'XS'=>12,'M'=>13,'L'=>12,'XL'=>13,'XXL'=>14);       
          $response = Utility::successResponse('',$data);
          return $response;
     }
      
    

}
?>