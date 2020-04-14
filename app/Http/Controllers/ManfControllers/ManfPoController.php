<?php

namespace App\Http\Controllers\ManfControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\ManfGeneratePo; 
use App\Model\ManfPoDetail;
use Illuminate\Support\Facades\Validator;

class ManfPoController extends Controller
{
   public function __construct()
	{
	   
	}
    
     
	public function generatePo(Request $request)
    { 
	    $data = json_decode(json_encode($request->input()), true);
	    
	    $validator = Validator::make($data, [
            "order_date"        => 'required',
            "payment_term"      => 'required',
            "delivery_date"     => 'required',
            "delivery_address"  => 'required',
            "vendor_name"       => 'required',
            "material_detail"   => 'required',
            //"purchase_material" => 'required',
            //"item_description" => 'required',
            "contact_person"    => 'required',
            "account_person"    => 'required'
             ]);

	    if ($validator->fails()) {
            return response()->json([
                'status_code'=> 400,
                'status'     => 'failure',
                'error'      =>$validator->errors()
             ]);
        }
        $data["created_by"] = auth()->user('id')->id;
         
	    try{
            $lastPoId          = ManfGeneratePo::getlatestPoID();

		    $ManfGeneratePoObj =  new ManfGeneratePo;
            $ManfGeneratePoObj -> order_date   = $data["order_date"];
			$ManfGeneratePoObj -> po_id        = ++$lastPoId;
			$ManfGeneratePoObj -> payment_term = $data["payment_term"];
			$ManfGeneratePoObj -> delivery_date = $data["delivery_date"];
			$ManfGeneratePoObj -> delivery_address = $data["delivery_address"];
			$ManfGeneratePoObj -> vendor_name = $data["vendor_name"];
			//$ManfGeneratePoObj -> material_type = $data["material_type"];
			//$ManfGeneratePoObj -> purchase_material = $data["purchase_material"];
			//$ManfGeneratePoObj -> item_description = $data["item_description"];
			$ManfGeneratePoObj -> contact_person = $data["contact_person"];
            $ManfGeneratePoObj -> account_person = $data["account_person"]; 
            $ManfGeneratePoObj -> is_active      = 1; 
			$ManfGeneratePoObj -> is_deleted     = 0; 
			$ManfGeneratePoObj -> created_by = $data["created_by"];
	        $ManfGeneratePoObj -> save();
            $po_id = ManfGeneratePo::getPoId();

            if(!empty($data['material_detail']))
            {
             	 foreach ($data['material_detail'] as $key => $value) {

                     $ManfPoDetailObj =  new ManfPoDetail;
                     $ManfPoDetailObj -> po_id      = $po_id;
            	 	 $ManfPoDetailObj -> po_master  =  $lastPoId;
            	 	 $ManfPoDetailObj -> material_name = $value["material_name"];
            	 	 $ManfPoDetailObj -> material_code = $value["material_code"];
                     $ManfPoDetailObj -> material_type = $value["material_type"];
            	 	 $ManfPoDetailObj -> qty = $value["qty"];
            	 	 $ManfPoDetailObj -> unit_price = $value["unit_price"];
            	 	 $ManfPoDetailObj -> created_by = $data["created_by"];
            	 	 $ManfPoDetailObj -> save(); 
             	 }

            }

	 	     return response()->json([
	           'status_code'  => 200,
               'status'       => 'success',
               'result'       => [
                                'message' => 'PO Generated Succesfully'
                 ]
	         ]);
	 	 }
	    catch(\Exception $e){
	 	 	 return response()->json([
	            'status_code'  => 400,
                'status'       => 'failure',
                'error'        => $e->getMessage()   
	        ]);
	 	 }
    }

    public function poLists(){

         $po_id = ManfGeneratePo::getPoLists();

        if(!empty($po_id)){
        return response()->json([
                'status_code'  => 200,
                'status'=> 'success',
                'result' => 
                  [$po_id]                 
             ]);
        }
        else
        {
             return response()->json([
                'status_code'  => 400,
                'status'=> 'faluire',
                'error' => 'PO Not Found'
             ]);
        }
          
    }

    public function poDetails(Request $request){
     
     $data = json_decode(json_encode($request->input()), true);
        
        $validator = Validator::make($data, [
            "po_id"             => 'required',
             ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code'=> 400,
                'status'     => 'failure',
                'error'      =>$validator->errors()
             ]);
        }

        $po_details = ManfPoDetail::getPoDetails($data['po_id']);
        
        if(!empty($po_details)){
        return response()->json([
                'status_code'  => 200,
                'status'=> 'success',
                'result' => 
                  $po_details                 
             ]);
        }
        else
        {
             return response()->json([
                'status_code'  => 400,
                'status'=> 'failure',
                'error' => 'Po Not Found'
             ]);
        }
    }
 
}