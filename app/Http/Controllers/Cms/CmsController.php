<?php

namespace App\Http\Controllers\Cms;

use App\BodyDetails;
use App\BodyTabNames;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CmsController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }

    public function manageCms()
    {
       try{
           $tabNames = BodyTabNames::get()->toArray();
           $bodyDetails = BodyDetails::get()->toArray();
           return view('cms.manage')->with(compact('tabNames','bodyDetails'));
       }catch(\Exception $e){
           $data=[
               'action' => 'Get Manage Admin cms view',
               'exception' => $e->getMessage()
           ];
           Log::critical(json_encode($data));
       }
    }
    public function generalSettings(Request $request){
        try{
            $user = Auth::User();
            $requestedData = $request->all();
            $menuTabs = array();
            foreach ($requestedData as $key => $value){
                $tabNamePresent = BodyTabNames::where('slug',$value['slug'])->first();
                if($tabNamePresent == null){
                    $menuTabs['body_id'] = $user['body_id'];
                    $menuTabs['display_name'] = $value['menu_tab'];
                    $menuTabs['slug'] = $value['slug'];
                    $menuTabs['priority'] = $value['priority_menu_tab'];
                    if(array_key_exists('status',$value)){
                        $menuTabs['is_active'] = true;
                    }else{
                        $menuTabs['is_active'] = false;
                    }
                    $query = BodyTabNames::create($menuTabs);
                }else{
                    $menuTabs['body_id'] = $user['body_id'];
                    $menuTabs['display_name'] = $value['menu_tab'];
                    $menuTabs['slug'] = $value['slug'];
                    $menuTabs['priority'] = $value['priority_menu_tab'];
                    if(array_key_exists('status',$value)){
                        $menuTabs['is_active'] = true;
                    }else{
                        $menuTabs['is_active'] = false;
                    }
                    $query = BodyTabNames::where('id',$tabNamePresent['id'])->where('slug',$tabNamePresent['slug'])->update($menuTabs);
                }
            }
            if($query){
                Session::flash('message-success','Successfully menu names created');
                return back();
            }else{
                Session::flash('message-error','something went wrong');
            }
        }catch(\Exception $e){
            $data = [
                'status' => 500,
                'message' => "general setting",
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function headerSettings(Request $request){
        try{
            $headerData = $request->all();
            $user = Auth::User();
            $data = array();

            $folderEncName = time();
            $folderPath = public_path().env('LOGO_FILE_UPLOAD').$folderEncName;
            if (! file_exists($folderPath)) {
                File::makeDirectory($folderPath , 0777 ,true,true);
            }
            $imageData = array();
            if($request->has('gallery_images')){
                $imageArray = explode(';',$request->gallery_images);
                $image = explode(',',$imageArray[1])[1];
                $pos  = strpos($request->gallery_images, ';');
                $type = explode(':', substr($request->gallery_images, 0, $pos))[1];
                $extension = explode('/',$type)[1];
                $filename = mt_rand(1,10000000000).sha1(time()).".{$extension}";
                $fileFullPath = DIRECTORY_SEPARATOR.$folderPath.DIRECTORY_SEPARATOR.$filename;
                file_put_contents($fileFullPath,base64_decode($image));
                $imageData['name'] = $filename;
            }
            $headerDataPresent = BodyDetails::where('body_id',$user['body_id'])->first();
            if($headerDataPresent == null){
                $data['body_id'] = $user['body_id'];
                $data['header_message'] = $headerData['description'];
                $data['logo_name'] = $imageData['name'];
                $query = BodyDetails::create($data);
            }else{
                $data['header_message'] = $headerData['description'];
                $query = BodyDetails::where('body_id',$headerDataPresent['body_id'])->update($data);
            }
            if($query){
                Session::flash('message-success','Successfully created');
                return redirect()->back();
            }else{
                Session::flash('message-error','Something went wrong');
            }
        }catch (\Exception $e){
            $data = [
                'status' => 500,
                'message' => "header setting",
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function footerSettings(Request $request)
    {
        try{
            $user = Auth::User();
            $footerDataPresent = BodyDetails::where('body_id',$user['body_id'])->first();
            if($footerDataPresent !=null){
                $data['footer_message'] = $request->footer;
                $query = BodyDetails::where('body_id',$footerDataPresent['body_id'])->update($data);
            }
            if($query){
                Session::flash('message-success','Successfully created');
                return redirect()->back();
            }else{
                Session::flash('message-error','Something went wrong');
            }
        }catch (\Exception $e){
            $data = [
                'status' => 500,
                'message' => "footer setting",
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function sliderImages(Request $request){
        try{
            dd($request->all());
        }catch (\Exception $e){
            $data = [
                'status' => 500,
                'message' => "slider images",
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function socialMediaLinks(Request $request){
        try{
            dd($request->all());
        }catch (\Exception $e){
            $data = [
                'status' => 500,
                'message' => "social media links",
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function contactUsForm(Request $request){
        try{
            dd($request->all());
        }catch (\Exception $e){
            $data = [
                'status' => 500,
                'message' => "Contact us form",
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function tabsSubTabsListing(){
        try{
            $str="<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>";
            $str.="<thead><tr>";
            $str.="<th>Parent Page</th>";
            $str.="<th>Child Page</th>";
            $str.="<th>Created Date</th>";
            $str.="<th>Action</th>";
            $str.="</tr></thead><tbody>";
                $str.="<tr>";
                $str.="<td>".'gallery'."</td>";
                $str.="<td>"."ds"."</td>";
                $str.="<td>"."ghfghfghf"."</td>";
                $str.="<td>"."<a href='' >add</a>" ." / ". "<a href=''>remove</a>"."</td>";
                $str.="</tr>";
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
    public function createPages(){
        try{
            return view('cms.pagesCreate');
        }catch(\Exception $e){
            $data = [
                'action'=>'Pages creation',
                'message' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function createSubPages(Request $request){
        try{
            dd($request->all());
        }catch (\Exception $e){
            $data = [
                'status' => 500,
                'message' => "Sub pages create form",
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
}
