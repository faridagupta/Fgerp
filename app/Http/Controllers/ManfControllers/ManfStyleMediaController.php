<?php

namespace App\Http\Controllers\ManfControllers;
use Illuminate\Http\Request;
use App\Model\ManfStyleMaster;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Classes\Helpers\Utility;
 
class ManfStyleController extends Controller
{

	public function create()
    {
        return view('fileupload');
    }
    public function fileUpload(Request $request)
    {
        $this->validate($request, ['image' => 'required|image']);
        if($request->hasfile('image'))
         {
            $file = $request->file('image');
            $name=time().$file->getClientOriginalName();
            $filePath = 'images/' . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            return back()->with('success','Image Uploaded successfully');
         }
    }
}
