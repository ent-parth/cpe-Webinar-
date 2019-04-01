<?php
namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use File;
class DropZoneController extends Controller
{
    public function deleteFiles(Request $reuqest)
    {
        File::delete($_SERVER['DOCUMENT_ROOT'].'/'.config('constants.DROPZONE.FILES_STORE_PATH').$reuqest['filename']);
    }

    public function uploadFiles(Request $request)
    {
        if($request->hasfile('file'))
        {
            if (!is_dir(config('constants.DROPZONE.FILES_STORE_PATH'))) 
            {
                mkdir(config('constants.DROPZONE.FILES_STORE_PATH'), 0777, true);
            }
            $fileNames = array();
            $targetPath = config('constants.DROPZONE.FILES_STORE_PATH'); 
            foreach($request->file('file') as $file)
            {
                $newFileName = 'dropzone_tmp_image_'.uniqid().'_'.rand(00000000,99999999).'.'.$file->getClientOriginalExtension();
                $file->move($targetPath, $newFileName);  
                $fileNames[] = $newFileName;
            }
            //return response()->json($fileNames);
            header('Content-Type: application/json');
            echo json_encode($fileNames);
        }
    }

}
