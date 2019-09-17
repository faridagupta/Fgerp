<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Model\manfVendorMaster;
use App\Model\manfVendorDetails;
use App\Model\manfVendorBankDetails;
use App\Model\manfVendorDocs;
use Illuminate\Support\Facades\Validator;

class ManufacturingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    public function createVendor(Request $request)
    { 
        $data = json_decode(json_encode($request->input()), true);
         
        $validator = Validator::make($data, [
            'vendor_name' => 'required',
            "vendor_mobile"=> 'required|digits:10',
            "vendor_email" => 'required|email',//|unique:manf_vendor_master,vendor_email
            "vendor_city_id" => 'required|numeric',
            "contact_person" => 'required',
            "status"=> 'required|boolean',
            "vendor_id" => "required|numeric", 
            "vendor_address" => "required",
            "vendor_landline" => "",
            "vendor_website" => "",
            "ac_person" => "required", 
            "ac_person_mobile" => "required",
            "ac_person_email" => "required|email",
            "gst_number" => "required",
            "pan_number" => "required",
            "vendor_state_code" =>  "required|numeric",
            "payment_type" => "required", 
            "bank_name" => "required",
            "branch_name" => "required",
            "bank_account_no" => "required|numeric",
            "ifsc_code" => "required",
            "branch_code" =>  "required", 
            "swift_code" => "required",
            "iban_code" => "required",
            "aggreement" => "",
            "scanned_cheque" => "",
            "nda" => "",
            "custom1" => "",
            "custom2" => "",
            ]);
        
        if ($validator->fails()) {
            return $validator->errors();
        }

        $data["created_by"] = auth()->user('id')->id;
           
          $vdetail =manfVendorMaster::where('entity_id',2)->first();
         /* echo "<pre>";
          print_r($vdetail->detail->toArray());
          print_r($vdetail->bankdetail->toArray()); 
          print_r($vdetail->docs->toArray());
          dd("da");*/
        try{

            $manfVendorMasterObj =  new manfVendorMaster;
            $manfVendorMasterObj -> vendor_name = $data["vendor_name"];
            $manfVendorMasterObj -> vendor_mobile = $data["vendor_mobile"];
            $manfVendorMasterObj -> vendor_email = $data["vendor_email"];
            $manfVendorMasterObj -> vendor_city_id = $data["vendor_city_id"];
            $manfVendorMasterObj -> contact_person = $data["contact_person"];
            $manfVendorMasterObj -> status = $data["status"];
            $manfVendorMasterObj -> created_by = $data["created_by"];
            $manfVendorMasterObj -> save();
            //latest vendor ID
            $latestvendor = manfVendorMaster::getvendorid();
            
            //Add Vendor Details 
            $manfVendorDetailsObj =  new manfVendorDetails;
            $manfVendorDetailsObj -> vendor_id = $latestvendor;
            $manfVendorDetailsObj -> vendor_address = $data["vendor_address"];
            $manfVendorDetailsObj -> vendor_landline = $data["vendor_landline"];
            $manfVendorDetailsObj -> vendor_website = $data["vendor_website"];
            $manfVendorDetailsObj -> ac_person = $data["ac_person"];
            $manfVendorDetailsObj -> ac_person_mobile = $data["ac_person_mobile"];
            $manfVendorDetailsObj -> ac_person_email = $data["ac_person_email"];
            $manfVendorDetailsObj -> gst_number = $data["gst_number"];
            $manfVendorDetailsObj -> pan_number = $data["pan_number"];
            $manfVendorDetailsObj -> vendor_state_code = $data["vendor_state_code"]; 
            $manfVendorDetailsObj -> created_by = $data["created_by"];
            $manfVendorDetailsObj -> save();

            //Add Bank Details of Vendor
            $bankDetailsObj =  new manfVendorBankDetails;
            $bankDetailsObj -> vendor_id = $latestvendor;
            $bankDetailsObj -> payment_type = $data["payment_type"];
            $bankDetailsObj -> branch_name = $data["branch_name"];
            $bankDetailsObj -> bank_account_no = $data["bank_account_no"];
            $bankDetailsObj -> ifsc_code = $data["ifsc_code"];
            $bankDetailsObj -> branch_code = $data["branch_code"];
            $bankDetailsObj -> swift_code = $data["swift_code"];
            $bankDetailsObj -> save();

            //Add Vendor Document
            $vendorDocsObj =  new manfVendorDocs;
            $vendorDocsObj -> vendor_id = $latestvendor;
            $vendorDocsObj -> vendor_name = $data["vendor_name"];
            $vendorDocsObj -> aggreement = $data["aggreement"];
            $vendorDocsObj -> scanned_cheque = $data["scanned_cheque"];
            $vendorDocsObj -> nda = $data["nda"];
            $vendorDocsObj -> custom1 = $data["custom1"];
            $vendorDocsObj -> custom2 = $data["custom2"];
            $vendorDocsObj -> save();
            
             return response()->json([
                'message' => 'Vendor Added Succesfully',
                'status'  => 200,
                //'last_insert_id' =>  manfVendorMaster::getvendorid()
             ]);
         }
        catch(\Exception $e){
             return response()->json([
                'message' => 'Vendor Not Added',
                'status'  => -1,
                 
             ]);
         }
         /*foreach ($data as $key => $value) {

            if(preg_match("/vendor_name|vendor_mobile|vendor_email|vendor_city_id|contact_person|status|created_by/", $key))
                $vendorMaster[$key] = $value;

            if(preg_match("/vendor_address|vendor_landline|vendor_website|ac_person|ac_person_mobile|ac_person_email|gst_number|pan_number|vendor_state_code|created_by/", $key))
                $vendorDetails[$key] = $value;

            if(preg_match("/payment_type|branch_name|bank_account_no|ifsc_code|branch_code|swift_code/", $key))
                $bankDetails[$key] = $value;

            if(preg_match("/vendor_name|aggreement|scanned_cheque|nda|custom1|custom2/", $key))
                $vendorDoc[$key] = $value;
                                       
        }
        
        $latestvendor = manfVendorMaster::getvendorid();

        $vendorDetails['vendor_id'] = $latestvendor;
        $bankDetails['vendor_id'] = $latestvendor;
        $vendorDoc['vendor_id'] = $latestvendor;

        //manfVendorDetails::addVendorDetails($vendorDetails);
        manfVendorBankDetails::addBankDetails($bankDetails);
        manfVendorDocs::addVendorDocs($vendorDoc);
*/

    }
    //
}

