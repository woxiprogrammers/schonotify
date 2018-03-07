<?php

namespace App\Http\Controllers\api;

use App\Folder;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('authenticate.user');
    }
    public function folderDetails(Request $request){
        try{
            $user = Auth::user();
            $message = "Successfully Listed";
            $status = 200;
            $folderName=Folder::where('body_id',$user->body_id)->where('is_active','=','1')->select('id','name')->get()->toArray();
            $folderDetails['folder_list'] = $folderName;
            $iterator=0;
            foreach($folderName as $data){
                $imageName = Folder::join('gallery_management','gallery_management.folder_id','=','folders.id')
                    ->where('gallery_management.folder_id','=',$data['id'])
                    ->select('gallery_management.name as name')->first();
                $ds = DIRECTORY_SEPARATOR;
                $eventUploadConfig = env('GALLERY_FOLDER_FILE_UPLOAD');
                $folderEncName = sha1($data['id']);
                $path = $eventUploadConfig.$ds.$folderEncName.$ds.$imageName['name'];
                $folderDetails['folder_list'][$iterator]['first_photo_url'] = $path;
                $iterator++;
            };
        }catch(\Exception $exception){
            $status = 500;
            $message = $exception->getMessage();
            $folderDetails = array();
        }
        $response = [
            "status" => $status,
            "message" => $message,
            "data" => $folderDetails
            ];
        Log::critical(json_encode($response));
        return response()->json($response,$status);
    }
}

