<?php

namespace App\Http\Controllers\api;

use App\Folder;
use App\GalleryManagement;
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
    }
    public function folderDetails(Request $request,$id){
        try{
            $message = "Successfully Listed";
            $status = 200;
            $folderName=Folder::where('body_id',$id)->where('is_active','=','1')->select('id','name')->get()->toArray();
            $folderDetails['folder_list'] = array();
            if(!empty($folderName)){
                $folderDetails['folder_list'] = $folderName;
                $iterator=0;
                foreach($folderName as $data){
                    $imageName = Folder::join('gallery_management','gallery_management.folder_id','=','folders.id')
                        ->where('gallery_management.folder_id','=',$data['id'])
                        ->where('gallery_management.type','image')
                        ->select('gallery_management.name as name')->first();
                    if($imageName != null){
                        $ds = DIRECTORY_SEPARATOR;
                        $eventUploadConfig = env('GALLERY_FOLDER_FILE_UPLOAD');
                        $folderEncName = sha1($data['id']);
                        $path = $eventUploadConfig.$ds.$folderEncName.$ds.$imageName['name'];
                        $folderDetails['folder_list'][$iterator]['first_photo_url'] = $path;
                    }else{
                        $folderDetails['folder_list'][$iterator]['first_photo_url'] = "";
                    };
                    $iterator++;
                }
            }
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
    public function galleryImages(Request $request,$id)
    {
        try {
            $message = "Successfully Listed";
            $status = 200;
            $folderName = Folder::where('id', $id)->where('is_active', '=', '1')->select('id', 'name')->get()->toArray();
            $jIterator = 0;
            foreach ($folderName as $data) {
                $folderDetails[$jIterator]['id'] = $data['id'];
                $folderDetails[$jIterator]['name'] = $data['name'];
                $imageName = Folder::join('gallery_management', 'gallery_management.folder_id', '=', 'folders.id')
                    ->where('gallery_management.folder_id', '=', $data['id'])
                    ->where('type','image')
                    ->select('gallery_management.id as id','gallery_management.name as name')->get()->toArray();
                $folderDetails[$jIterator]['photos'] = array();
                $iterator = 0;
                if(!empty($imageName)){
                    foreach ($imageName as $name){
                        $ds = DIRECTORY_SEPARATOR;
                        $eventUploadConfig = env('GALLERY_FOLDER_FILE_UPLOAD');
                        $folderEncName = sha1($data['id']);
                        $path = $eventUploadConfig . $ds . $folderEncName . $ds . $name['name'];
                        $folderDetails[$jIterator]['photos'][$iterator]['id'] = $name['id'];
                        $folderDetails[$jIterator]['photos'][$iterator]['url'] = $path;
                        $iterator++;
                    }
                }
               $videoName = Folder::join('gallery_management', 'gallery_management.folder_id', '=', 'folders.id')
                   ->where('gallery_management.folder_id', '=', $data['id'])
                   ->where('type','video')
                   ->select('gallery_management.name as name','gallery_management.id as id')->get()->toArray();
                $folderDetails[$jIterator]['videos'] = array();
                if(!empty($videoName)){
                    foreach ($videoName as $value){
                        $ds = DIRECTORY_SEPARATOR;
                        $eventUploadConfig = env('GALLERY_FOLDER_FILE_UPLOAD');
                        $folderEncName = sha1($data['id']);
                        $path = $eventUploadConfig . $ds . $folderEncName . $ds . $value['name'];
                        $folderDetails[$jIterator]['videos'][$iterator]['thumbnail']="";
                        $folderDetails[$jIterator]['videos'][$iterator]['url'] = $path;
                        $folderDetails[$jIterator]['videos'] =array_values($folderDetails[$jIterator]['videos']);
                        $jIterator++;
                    }
                }
            }
        } catch (\Exception $exception) {
            $status = 500;
            $message = $exception->getMessage();
            $folderDetails = array();
        }
        $response = [
            "status" => $status,
            "message" => $message,
            "data" => array_values($folderDetails)
        ];
        Log::critical(json_encode($response));
        return response()->json($response, $status);
    }
}

