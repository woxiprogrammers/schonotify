<?php

namespace App\Http\Controllers\Cms;

use App\BodyDetails;
use App\BodySocialDetails;
use App\BodyTabDetails;
use App\BodyTabNames;
use App\SocialPlatform;
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
           $socialPlatformNames = SocialPlatform::get()->toArray();
           $socialMediaDetails = BodySocialDetails::get()->toArray();
           $tabNames = BodyTabNames::get()->toArray();
           $bodyDetails = BodyDetails::get()->toArray();
           return view('cms.manage')->with(compact('tabNames','bodyDetails','socialPlatformNames','socialMediaDetails'));
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
            $user = Auth::User();
            $socialMediaData =array();
            $ifDataPresent = BodySocialDetails::get()->first();
            foreach ($request->all() as $data){
                $socialMediaData['name'] = $data['link'];
                $socialMediaData['social_platform_id'] = $data['social_platform_id'];
                if (array_key_exists('is_check',$data)){
                    $socialMediaData['is_active'] = true;
                }else{
                    $socialMediaData['is_active'] = false;
                }
                if($ifDataPresent == null){
                    $socialMediaData['body_id'] = $user['body_id'];
                    $query = BodySocialDetails::create($socialMediaData);
                }else{
                    $query = BodySocialDetails::where('social_platform_id',$data['social_platform_id'])->update($socialMediaData);
                }
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
            $subPagesNameDetail = BodyTabNames::whereNotNull('body_tab_name_id')->where('is_active',1)->get()->toArray();
            $str="<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>";
            $str.="<thead><tr>";
            $str.="<th>Parent Page</th>";
            $str.="<th>Child Page</th>";
            $str.="<th>Created Date</th>";
            $str.="<th>Action</th>";
            $str.="</tr></thead><tbody>";
            foreach($subPagesNameDetail as $details){
                $menuName = BodyTabNames::where('id',$details['body_tab_name_id'])->pluck('display_name');
                $str.="<tr>";
                $str.="<td>"."$menuName"."</td>";
                $str.="<td>".$details['display_name']."</td>";
                $str.="<td>".$details['created_at']."</td>";
                $str.="<td>"."<a href='/cms/pagesEdit/".$details['id']."' >edit</a>" ." / ". "<a href='/cms/pageRemove/".$details['id']."'>remove</a>"."</td>";
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
    public function createPages(){
        try{
            $tabNames = BodyTabNames::where('body_tab_name_id','=',null)->where('is_active',1)->get()->toArray();
            return view('cms.pagesCreate')->with(compact('tabNames'));
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
            $bodyTabName = BodyTabNames::where('slug',$request->main_pages)->first();
            $subPageData['display_name'] = $request->sub_tab_name;
            $subPageData['slug']  = preg_replace('/\s+/', '-',  strtolower($request->sub_tab_name));
            $subPageData['body_tab_name_id'] = $bodyTabName['id'];
            $subPageData['body_id'] = $bodyTabName['body_id'];
            $subPageData['is_active'] = true;
            $query = BodyTabNames::create($subPageData);
            $subPageDescription['body_tab_name_id'] = $query->id;
            $subPageDescription['description'] = $request->page_description;
            BodyTabDetails::create($subPageDescription);
            if($query){
                Session::flash('message-success','Successfully created');
                return view('cms.manage');
            }else{
                Session::flash('message-error','Something went wrong');
            }
        }catch (\Exception $e){
            $data = [
                'status' => 500,
                'message' => "Sub pages create form",
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function editPages(Request $request,$id){
        try{
            $tabNames = BodyTabNames::where('body_tab_name_id','=',null)->where('is_active',1)->get()->toArray();
            $pagesDetail = BodyTabNames::join('body_tab_details','body_tab_details.body_tab_name_id','=','body_tab_names.id')
                                        ->where('body_tab_names.id',$id)->select('body_tab_names.id','body_tab_names.display_name','body_tab_names.slug','body_tab_details.description')
                                        ->first();
            return view('cms.pagesEdit')->with(compact('pagesDetail','tabNames'));
        }catch(\Exception $e){
            $data = [
                'status' => 500,
                'message' => "Sub pages edit",
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function removePages(Request $request,$id){
        try{
           $query = BodyTabNames::where('id',$id)->delete();
            BodyTabDetails::where('body_tab_name_id',$id)->delete();
            if($query){
                Session::flash('message-success','Successfully removed');
                return redirect()->back();
            }else{
                Session::flash('message-error','Something went wrong');
            }
        }catch(\Exception $e){
            $data = [
                'status' => 500,
                'message' => "remove pages",
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function editSubPages(Request $request,$id){
        try{
            $bodyTabName = BodyTabNames::where('slug',$request->main_pages)->first();
            $subPageData['display_name'] = $request->sub_tab_name;
            $subPageData['slug']  = preg_replace('/\s+/', '-',  strtolower($request->sub_tab_name));
            $subPageData['body_tab_name_id'] = $bodyTabName['id'];
            $query = BodyTabNames::where('id',$id)->update($subPageData);
            $subPageDescription['description'] = $request->page_description;
            BodyTabDetails::where('body_tab_name_id',$id)->update($subPageDescription);
            if($query){
                Session::flash('message-success','Successfully Edited');
                return redirect()->back();
            }else{
                Session::flash('message-error','Something went wrong');
            }
        }catch(\Exception $e){
            $data = [
                'status' => 500,
                'message' => "edit sub-pages",
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
}
