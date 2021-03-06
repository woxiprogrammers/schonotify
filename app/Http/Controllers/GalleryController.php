<?php

namespace App\Http\Controllers;

use App\Folder;
use App\GalleryManagement;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }
    public function folderView(Request $request){
        try{
            return view('gallery.folderView');
        }catch(\Exception $e){
            $data = [
                'action' => 'Gallery folder view',
                'message' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function galleryView(Request $request){
        try{
            $user = Auth::user();
            $folderName = Folder::where('is_active','=','1')->where('body_id',$user->body_id)->get()->toArray();
            return view('gallery.galleryManagementView')->with(compact('folderName'));
        }catch(\Exception $e){
            $data = [
                'action' => 'Gallery management view',
                'message' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function createFolder(Request $request){
        try{
            $user = Auth::user()->toArray();
            $folderData['name'] = $request->folder_name;
            $folderData['is_active'] = false;
            $folderData['body_id'] = $user['body_id'];
            $folder = Folder::create($folderData);
            $folderEncName = sha1($folder->id);
            if (! file_exists(public_path()."/uploads/gallery/".$folderEncName)) {
                File::makeDirectory(public_path()."/uploads/gallery/".$folderEncName , 0777 ,true,true);
            }
            Session::flash('message-success','folder created successfully');
            return Redirect::back();
        }catch(\Exception $e){
            $data = [
                'action' => 'Folder Created',
                'message' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function folderListing(Request $request){
        try{
            $user = Auth::user();
            $folderData = Folder::where('body_id',$user->body_id)->get()->toArray();
            $str="<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>";
            $str.="<thead><tr>";
            $str.="<th>Folder Name</th>";
            $str.="<th>Status</th>";
            $str.="<th>Action</th>";
            $str.="</tr></thead><tbody>";
            foreach ($folderData as $data){
                $str.="<tr>";
                $str.="<td>".$data['name']."</td>";
                $str.="<td>";
                if($data['is_active'] == 1)
                {
                    $str.="<input type='checkbox' class='js-switch' onchange='return statusFolder(this.checked,$data[id])' id='status$data[id]' value='$data[id]' checked/>";
                }else{
                    $str.="<input type='checkbox' class='js-switch' onchange='return statusFolder(this.checked,$data[id])' id='status$data[id]' value='$data[id]'/>";
                }
                $str.="</td>";
                $str.="<td>"."<a href='/gallery/edit-folder/".$data['id']."'>Edit </a>"."</td>";
                $str.="</tr>";
            }
            $str.="</tbody></table>";

            return $str;
        }catch(\Exception $e){
            $data = [
                'action'=>'folders listed successfully',
                'message' => $e->getMessage()
     ];
            Log::critical(json_encode($data));
        }
    }
    public function deactivateFolder(Request $request,$id){
        try{
            $query = Folder::where('id',$id)->update(['is_active' => 0]);
            if($query){
                return response()->json(['status'=>'folder has been deactivated.']);
            }else{
                return response()->json(['status'=>403]);
            }
        }catch(\Exception $e){
            $data = [
                'action'=>'folders Deactivated',
                'message' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }

    }
    public function activateFolder(Request $request,$id){
        try{
            $query = Folder::where('id',$id)->update(['is_active' => 1]);
            if($query){
                return response()->json(['status'=>'folder has been active.']);
            }else{
                return response()->json(['status'=>403]);
            }
        }catch(\Exception $e){
            $data = [
                'action'=>'folders Activated',
                'message' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function editFolderView(Request $request,$id){
        try{
            return view('gallery.folderEdit')->with(compact('id'));
        }catch(\Exception $exception){
            $data=[
                'action'=>'Edit Form',
                'message'=>$exception->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function editFolder(Request $request,$id){
        try{
            $data['name'] = $request->folder_name_edit;
            $update = Folder::where('id',$id)->update($data);
            if($update){
                Session::flash('message-success','folder updated successfully');
                return \redirect('gallery/folder-management');
            }else{
                Session::flash('message-error','Something went wrong');
                return Redirect::back();
            }
        }catch(\Exception $e){
            $data=[
                'action'=>'Folder name edited successfully',
                'message'=>$e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function uploadImages(Requests\WebRequests\galleryRequest $request){
        try{
            $folderEncName = sha1($request['folder_id']);
            $folderPath = public_path()."/uploads/gallery/".$folderEncName;
            if (! file_exists($folderPath)) {
                File::makeDirectory($folderPath , 0777 ,true,true);
            }
            $imageData = array();
            $iterator = 0;
            if($request->has('gallery_images')){
               foreach($request->gallery_images as $billImage){
                   $imageArray = explode(';',$billImage);
                   $image = explode(',',$imageArray[1])[1];
                   $pos  = strpos($billImage, ';');
                   $type = explode(':', substr($billImage, 0, $pos))[1];
                   $extension = explode('/',$type)[1];
                   $filename = mt_rand(1,10000000000).sha1(time()).".{$extension}";
                   $fileFullPath = DIRECTORY_SEPARATOR.$folderPath.DIRECTORY_SEPARATOR.$filename;
                    file_put_contents($fileFullPath,base64_decode($image));
                    $imageData[$iterator]['name'] = $filename;
                   if($extension = 'png' || $extension = 'jpeg' || $extension ='jpg'){
                       $imageData[$iterator]['type'] = "image";
                   }
                   $iterator++;
               }
            }
            if($request->has('videos')){
                $videoArray = explode(';',$request->videos);
                $video = explode(',',$videoArray[1])[1];
                $pos  = strpos($request->videos, ';');
                $type = explode(':', substr($request->videos, 0, $pos))[1];
                $extension = explode('/',$type)[1];
                $filename = mt_rand(1,10000000000).sha1(time()).".{$extension}";
                $fileFullPath = DIRECTORY_SEPARATOR.$folderPath.DIRECTORY_SEPARATOR.$filename;
                file_put_contents($fileFullPath,base64_decode($video));
                $imageData[$iterator]['name'] = $filename;
                if($extension = 'mp4'){
                    $imageData[$iterator]['type'] = "video";
                }
            }

            $galleryManagement['folder_id'] = $request['folder_id'];
            foreach ($imageData as $key => $data){
                $galleryManagement['name'] = $data['name'];
                $galleryManagement['type'] = $data['type'];
                GalleryManagement::create($galleryManagement);
            }
            return Redirect::back();
        }catch(\Exception $e){
            $data = [
                'input_params' => $request->all(),
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function checkName(Request $request){
        try{
            $checkFolderName = Folder::where('name',$request->folder_name)->count();
            if($checkFolderName > 0){
                return 'false';
            }else{
                return 'true';
            }
        }catch (\Exception $e){
            $data = [
                'input_params' => $request->all(),
                'action' => 'Check Folder Name ',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function imageValidation(Request $request){
        try{
            $user = Auth::user();
            $count=array();
            $count['image'] = GalleryManagement::where('folder_id',$request['folder_id'])->where('body_id',$user->body_id)->where('type','image')->count();
            $count['video']= GalleryManagement::where('folder_id',$request['folder_id'])->where('body_id',$user->body_id)->where('type','video')->count();
            return $count;
        }catch(\Exception $e){
            $data=[
                'params' => $request->all(),
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function imagesView(Request $request,$id){
        try{
            $user = Auth::user();
            $gallery = array();
            $folderName = Folder::where('id',$id)->where('body_id',$user->body_id)->pluck('name');
            $images = GalleryManagement::where('folder_id',$id)->where('type','image')->select('id','name')->get()->toArray();
            $videos = GalleryManagement::where('folder_id',$id)->where('type','video')->select('id','name')->get()->toArray();
            $folderEncName = sha1($id);
            $folderPath = env('GALLERY_FOLDER_FILE_UPLOAD');
            $ds = DIRECTORY_SEPARATOR;
            $iterator=0;
            $gallery['folder_name'] = $folderName;
            $gallery['folder_id']= $id;
            if($images != null && $images != ""){
                foreach ($images as $image){
                    $gallery['image'][$iterator]['id'] = $image['id'];
                    $gallery['image'][$iterator]['image'] = $ds.$folderPath.$ds.$folderEncName.$ds.$image['name'];
                    $iterator++;
                }
            }
            $jterator = 0;
            if($videos != null || $videos !=""){
                foreach ($videos as $video){
                    $gallery['video'][$jterator]['id'] = $video['id'];
                    $gallery['video'][$jterator]['video'] = $ds.$folderPath.$ds.$folderEncName.$ds.($video['name']);
                    $jterator++;
                }
            }
            return view('gallery.galleryView')->with(compact('gallery'));

        }catch(\Exception $e){
            $data=[
                'params' => $request->all(),
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function removeImages(Request $request,$id)
    {
        try {
            $folderId = GalleryManagement::where('id', $id)->select('folder_id', 'name')->first();
            $ds = DIRECTORY_SEPARATOR;
            $folderEncName = sha1($folderId['folder_id']);
            $webUploadPath = env('GALLERY_FOLDER_FILE_UPLOAD');
            $file_to_be_deleted = public_path().$ds . $webUploadPath . $ds . $folderEncName . $ds . $folderId['name'];
            if (!file_exists($file_to_be_deleted)) {
                Session::flash('message-error','file does not exists');
                return Redirect::back();
            } else {
                unlink($file_to_be_deleted);
                GalleryManagement::where('id',$id)->delete();
                Session::flash('message-success','File has been deleted');
                return Redirect::back();
            }
        } catch (\Exception $e) {
            $data = [
                'params' => $request->all(),
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function editImages(Request $request,$id){
        try{
            $folderEncName = sha1($id);
            $folderPath = public_path()."/uploads/gallery/".$folderEncName;
            if (! file_exists($folderPath)) {
                File::makeDirectory($folderPath , 0777 ,true,true);
            }
            $imageData = array();
            $iterator = 0;
            if($request->has('gallery_images')){
                foreach($request->gallery_images as $billImage){
                    $imageArray = explode(';',$billImage);
                    $image = explode(',',$imageArray[1])[1];
                    $pos  = strpos($billImage, ';');
                    $type = explode(':', substr($billImage, 0, $pos))[1];
                    $extension = explode('/',$type)[1];
                    $filename = mt_rand(1,10000000000).sha1(time()).".{$extension}";
                    $fileFullPath = DIRECTORY_SEPARATOR.$folderPath.DIRECTORY_SEPARATOR.$filename;
                    file_put_contents($fileFullPath,base64_decode($image));
                    $imageData[$iterator]['name'] = $filename;
                    if($extension = 'png' || $extension = 'jpeg' || $extension ='jpg'){
                        $imageData[$iterator]['type'] = "image";
                    }
                    $iterator++;
                }
            }
            if($request->has('videos')){
                $videoArray = explode(';',$request->videos);
                $video = explode(',',$videoArray[1])[1];
                $pos  = strpos($request->videos, ';');
                $type = explode(':', substr($request->videos, 0, $pos))[1];
                $extension = explode('/',$type)[1];
                $filename = mt_rand(1,10000000000).sha1(time()).".{$extension}";
                $fileFullPath = DIRECTORY_SEPARATOR.$folderPath.DIRECTORY_SEPARATOR.$filename;
                file_put_contents($fileFullPath,base64_decode($video));
                $imageData[$iterator]['name'] = $filename;
                if($extension = 'mp4'){
                    $imageData[$iterator]['type'] = "video";
                }
            }
            $galleryManagement['folder_id'] = $id;
            foreach ($imageData as $key => $data){
                $galleryManagement['name'] = $data['name'];
                $galleryManagement['type'] = $data['type'];
                GalleryManagement::create($galleryManagement);
            }
            return Redirect::back();
        }catch(\Exception $e){
            $data = [
                'input_params' => $request->all(),
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
}

