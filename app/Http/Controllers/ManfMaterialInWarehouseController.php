<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Model\ManfMaterialInWarehouse;
use App\Model\ManfMaterialEnter;
use Illuminate\Support\Facades\Validator;

class ManfMaterialInWarehouseController extends Controller
{
   public function __construct()
	{
	   
	}
    
    public function MaterialInWarehouse(Request $request)
    { 
    	$data = json_decode(json_encode($request->input()), true);
     	 $validator = Validator::make($data, [
            'po_id' => 'required',
            "material_entries" => 'required',
            "invoice_no" => 'required',
            "challan_no" => 'required',
            "received_date" => 'required',
            "attach_invoce" => 'required',
            "other" => 'required'
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
		    $warehouseMaterialObj =  new ManfMaterialInWarehouse;
			$warehouseMaterialObj -> po_id = $data["po_id"];
			$warehouseMaterialObj -> invoice_no = $data["invoice_no"];
			$warehouseMaterialObj -> challan_no = $data["challan_no"];
			$warehouseMaterialObj -> received_date = $data["received_date"];
			$warehouseMaterialObj -> attach_invoce = $data["attach_invoce"];
			$warehouseMaterialObj -> other = $data["other"];
			$warehouseMaterialObj -> created_by = $data["created_by"];
	        $warehouseMaterialObj -> save();

	        if(!empty($data['material_entries']))
             {
             	foreach ($data['material_entries'] as $key => $value) {

                     $ManfMaterialEnterObj =  new ManfMaterialEnter;
            	 	 $ManfMaterialEnterObj -> po_id = $data["po_id"];
            	 	 $ManfMaterialEnterObj -> material_code = $value["material_code"];
            	 	 $ManfMaterialEnterObj -> qty_order = $value["qty_order"];
            	 	 $ManfMaterialEnterObj -> qty_recived = $value["qty_recived"];
            	 	 $ManfMaterialEnterObj -> created_by = $data["created_by"];
            	 	 $ManfMaterialEnterObj -> save(); 
             	 }
             }        

	 	     return response()->json([
    	        'status_code'  => 200,
                'status'=> 'success',
                'result' => [
                    'message' => 'Material In WareHouse Created Succesfully'
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