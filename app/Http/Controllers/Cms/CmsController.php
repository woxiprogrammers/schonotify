<?php

namespace App\Http\Controllers\Cms;

use App\BodyAboutUs;
use App\BodyContactUsUserForm;
use App\BodyDetails;
use App\BodySliderImages;
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
           $user = Auth::User();
           $socialPlatformNames = SocialPlatform::get()->toArray();
           $socialMediaDetails = BodySocialDetails::where('body_id',$user['body_id'])->get()->toArray();
           $tabNames = BodyTabNames::where('body_id',$user['body_id'])->get()->toArray();
           $bodyDetails = BodyDetails::where('body_id',$user['body_id'])->first();
           $aboutUsDetails = BodyAboutUs::where('body_id',$user['body_id'])->first();
           $sliderImages = BodySliderImages::where('body_id',$user['body_id'])->get()->toArray();
           $contactUsForm = BodyContactUsUserForm::get()->toArray();
           return view('cms.manage')->with(compact('tabNames','bodyDetails','socialPlatformNames','socialMediaDetails','aboutUsDetails','sliderImages','contactUsForm'));
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
                    if(array_key_exists('link',$value)){
                        $menuTabs['link'] = $value['link'];
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
                    if(array_key_exists('link',$value)){
                        $menuTabs['link'] = $value['link'];
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
            $headerDataPresent = BodyDetails::where('body_id',$user['body_id'])->first();
            $folderEncName = sha1($user->body_id);
            $folderPath = public_path().env('LOGO_FILE_UPLOAD').DIRECTORY_SEPARATOR.$folderEncName;
            if($headerDataPresent['logo_name'] != null){
                if (file_exists($folderPath.DIRECTORY_SEPARATOR.$headerDataPresent['logo_name'])) {
                    unlink($folderPath.DIRECTORY_SEPARATOR.$headerDataPresent['logo_name']);
                }
            }
            if (! file_exists($folderPath)) {
                File::makeDirectory($folderPath , 0777 ,true,true);
            }
            if($request->has('gallery_images')){
                $imageArray = explode(';',$request->gallery_images);
                $image = explode(',',$imageArray[1])[1];
                $pos  = strpos($request->gallery_images, ';');
                $type = explode(':', substr($request->gallery_images, 0, $pos))[1];
                $extension = explode('/',$type)[1];
                $filename = mt_rand(1,10000000000).sha1(time()).".{$extension}";
                $fileFullPath = DIRECTORY_SEPARATOR.$folderPath.DIRECTORY_SEPARATOR.$filename;
                file_put_contents($fileFullPath,base64_decode($image));
                $data['logo_name'] = $filename;
            }
            if($headerDataPresent == null){
                $data['body_id'] = $user['body_id'];
                $data['header_message'] = $headerData['description'];
                $query = BodyDetails::create($data);
            }else{
                $data['header_message'] = $headerData['description'];
                $query = BodyDetails::where('body_id',$headerDataPresent['body_id'])->update($data);
            }
            if($query){
                Session::flash('message-success','Successfully created');
                return back();
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
                return back();
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
            $user = Auth::user();
            $imageData = array();
            $imagesData = array();
            foreach ($request->all() as $key => $images){
                if(array_key_exists('is_checked_slider1',$images)){
                    $imageData['body_id'] =  $user->body_id;
                    $imageData['is_active'] = true;
                    $imageData['message_1'] = $images['message_1'];
                    $imageData['message_2'] = $images['message_2'];
                    $imageData['hyper_name'] = $images['link_title'];
                    $imageData['hyper_link'] = $images['link'];
                    if(array_key_exists('id',$images)){
                        $sliderImage1 = BodySliderImages::where('id',$images['id'])->update($imageData);
                    }else{
                        $sliderImage1 = BodySliderImages::create($imageData);
                    }
                    //image 1
                    if(array_key_exists('slider_images_1',$images)){
                        $folderEncName = sha1($sliderImage1['id']);
                        $folderPath = public_path().env('SLIDER_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.$folderEncName;
                        if (! file_exists($folderPath)) {
                            File::makeDirectory($folderPath , 0777 ,true,true);
                        }
                        $imageArray = explode(';',$images['slider_images_1']);
                        $image = explode(',',$imageArray[1])[1];
                        $pos  = strpos($images['slider_images_1'], ';');
                        $type = explode(':', substr($images['slider_images_1'], 0, $pos))[1];
                        $extension = explode('/',$type)[1];
                        $filename = mt_rand(1,10000000000).sha1(time()).".{$extension}";
                        $fileFullPath = DIRECTORY_SEPARATOR.$folderPath.DIRECTORY_SEPARATOR.$filename;
                        file_put_contents($fileFullPath,base64_decode($image));
                        $imagesData['name'] = $filename;
                        $query = BodySliderImages::where('id',$sliderImage1['id'])->update($imagesData);

                    }elseif((array_key_exists('slider_images_1',$images) && (array_key_exists('id',$images)))){
                        $folderEncName = sha1($images['id']);
                        $folderPath = public_path().env('SLIDER_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.$folderEncName;
                        unlink($folderPath.DIRECTORY_SEPARATOR.$images['name']);
                        if (! file_exists($folderPath)) {
                            File::makeDirectory($folderPath , 0777 ,true,true);
                        }
                        $imageArray = explode(';',$images['slider_images_1']);
                        $image = explode(',',$imageArray[1])[1];
                        $pos  = strpos($images['slider_images_1'], ';');
                        $type = explode(':', substr($images['slider_images_1'], 0, $pos))[1];
                        $extension = explode('/',$type)[1];
                        $filename = mt_rand(1,10000000000).sha1(time()).".{$extension}";
                        $fileFullPath = DIRECTORY_SEPARATOR.$folderPath.DIRECTORY_SEPARATOR.$filename;
                        file_put_contents($fileFullPath,base64_decode($image));
                        $imagesData['name'] = $filename;
                        $query = BodySliderImages::where('id',$sliderImage1['id'])->update($imagesData);
                    }


                }if (array_key_exists('is_checked_slider2',$images)){
                    $imageData['body_id'] =  $user->body_id;
                    $imageData['is_active'] = true;
                    $imageData['message_1'] = $images['message_1'];
                    $imageData['message_2'] = $images['message_2'];
                    $imageData['hyper_name'] = $images['link_title'];
                    $imageData['hyper_link'] = $images['link'];
                    if(array_key_exists('id',$images)){
                        $imageData['name'] = $images['image'];
                        $sliderImage2 = BodySliderImages::where('id',$images['id'])->update($imageData);
                    }else{
                        $sliderImage2 = BodySliderImages::create($imageData);
                    }
                    //image 2
                    if(array_key_exists('slider_images_2',$images)){
                        $folderEncName = sha1($sliderImage2['id']);
                        $folderPath = public_path().env('SLIDER_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.$folderEncName;
                        if (! file_exists($folderPath)) {
                            File::makeDirectory($folderPath , 0777 ,true,true);
                        }
                        $imageArray = explode(';',$images['slider_images_2']);
                        $image = explode(',',$imageArray[1])[1];
                        $pos  = strpos($images['slider_images_2'], ';');
                        $type = explode(':', substr($images['slider_images_2'], 0, $pos))[1];
                        $extension = explode('/',$type)[1];
                        $filename = mt_rand(1,10000000000).sha1(time()).".{$extension}";
                        $fileFullPath = DIRECTORY_SEPARATOR.$folderPath.DIRECTORY_SEPARATOR.$filename;
                        file_put_contents($fileFullPath,base64_decode($image));
                        $imagesData['name'] = $filename;
                        $query = BodySliderImages::where('id',$sliderImage2['id'])->update($imagesData);

                    }elseif ((array_key_exists('slider_images_2',$images) && (array_key_exists('id',$images)))){
                        $folderEncName = sha1($images['id']);
                        $folderPath = public_path().env('SLIDER_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.$folderEncName;
                        unlink($folderPath.DIRECTORY_SEPARATOR.$images['name']);
                        if (! file_exists($folderPath)) {
                            File::makeDirectory($folderPath , 0777 ,true,true);
                        }
                        $imageArray = explode(';',$images['slider_images_2']);
                        $image = explode(',',$imageArray[1])[1];
                        $pos  = strpos($images['slider_images_2'], ';');
                        $type = explode(':', substr($images['slider_images_2'], 0, $pos))[1];
                        $extension = explode('/',$type)[1];
                        $filename = mt_rand(1,10000000000).sha1(time()).".{$extension}";
                        $fileFullPath = DIRECTORY_SEPARATOR.$folderPath.DIRECTORY_SEPARATOR.$filename;
                        file_put_contents($fileFullPath,base64_decode($image));
                        $imagesData['name'] = $filename;
                        $query = BodySliderImages::where('id',$sliderImage2['id'])->update($imagesData);
                    }


                }if (array_key_exists('is_checked_slider3',$images)){
                    $imageData['body_id'] =  $user->body_id;
                    $imageData['is_active'] = true;
                    $imageData['message_1'] = $images['message_1'];
                    $imageData['message_2'] = $images['message_2'];
                    $imageData['hyper_name'] = $images['link_title'];
                    $imageData['hyper_link'] = $images['link'];
                    if(array_key_exists('id',$images)){
                        $imageData['name'] = $images['image'];
                        $sliderImage3 = BodySliderImages::where('id',$images['id'])->update($imageData);
                    }else{
                        $sliderImage3 = BodySliderImages::create($imageData);
                    }
                    //image 3
                    if(array_key_exists('slider_images_3',$images)){
                        $folderEncName = sha1($sliderImage3['id']);
                        $folderPath = public_path().env('SLIDER_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.$folderEncName;
                        if (! file_exists($folderPath)) {
                            File::makeDirectory($folderPath , 0777 ,true,true);
                        }
                        $imageArray = explode(';',$images['slider_images_3']);
                        $image = explode(',',$imageArray[1])[1];
                        $pos  = strpos($images['slider_images_3'], ';');
                        $type = explode(':', substr($images['slider_images_3'], 0, $pos))[1];
                        $extension = explode('/',$type)[1];
                        $filename = mt_rand(1,10000000000).sha1(time()).".{$extension}";
                        $fileFullPath = DIRECTORY_SEPARATOR.$folderPath.DIRECTORY_SEPARATOR.$filename;
                        file_put_contents($fileFullPath,base64_decode($image));
                        $imageData['name'] = $filename;
                        $query = BodySliderImages::where('id',$sliderImage3['id'])->update($imagesData);

                    }elseif ((array_key_exists('slider_images_3',$images)) && (array_key_exists('id',$images))){
                        $folderEncName = sha1($images['id']);
                        $folderPath = public_path().env('SLIDER_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.$folderEncName;
                        unlink($folderPath.DIRECTORY_SEPARATOR.$images['name']);
                        if (! file_exists($folderPath)) {
                            File::makeDirectory($folderPath , 0777 ,true,true);
                        }
                        $imageArray = explode(';',$images['slider_images_3']);
                        $image = explode(',',$imageArray[1])[1];
                        $pos  = strpos($images['slider_images_3'], ';');
                        $type = explode(':', substr($images['slider_images_3'], 0, $pos))[1];
                        $extension = explode('/',$type)[1];
                        $filename = mt_rand(1,10000000000).sha1(time()).".{$extension}";
                        $fileFullPath = DIRECTORY_SEPARATOR.$folderPath.DIRECTORY_SEPARATOR.$filename;
                        file_put_contents($fileFullPath,base64_decode($image));
                        $imageData['name'] = $filename;
                        $query = BodySliderImages::where('id',$sliderImage3['id'])->update($imagesData);
                    }

                }
            }

            if($query){
                Session::flash('message-success','Successfully created');
                return back();
            }else{
                Session::flash('message-error','Something went wrong');
            }
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
                return back();
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
    public function contactUsDetail(Request $request){
        try{
            $bodyDetails = BodyDetails::first();
            $contactDetails['address'] = $request->address;
            $contactDetails['contact_number'] = $request->contact_display;
            $contactDetails['email'] = $request->email_display;
            $contactDetails['map_embed'] = $request->map_embed;
            $query = BodyDetails::where('id',$bodyDetails['id'])->update($contactDetails);
            if($query){
                Session::flash('message-success','Successfully created');
                return back();
            }else{
                Session::flash('message-error','Something went wrong');
            }
        }catch (\Exception $e){
            $data = [
                'status' => 500,
                'message' => "Contact us Details",
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function contactUsForm(Request $request){
        try{
            $user = Auth::User();
            $contactDetails = array();
            $presentData = BodyContactUsUserForm::count();
            foreach ($request->all() as $data){
                if(array_key_exists('checked',$data)){
                    $contactDetails['is_active'] = true;
                }else{
                    $contactDetails['is_active'] = false;
                }
                $contactDetails['body_id'] = $user['body_id'];
                $contactDetails['name'] = $data['name'];
                $contactDetails['slug'] = $data['slug'];
                if($presentData > 0){
                    $query = BodyContactUsUserForm::where('id',$data['id'])->update($contactDetails);
                }else{
                    $query = BodyContactUsUserForm::create($contactDetails);
                }
            }
            if($query){
                Session::flash('message-success','Successfully created');
                return back();
            }else{
                Session::flash('message-error','Something went wrong');
            }
        }catch(\Exception $e){
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
            $tabNames = BodyTabNames::whereIn('slug',['custom-1','custom-2','custom-3'])->where('is_active',1)->get()->toArray();
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
                return back();
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
                return back();
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
                return back();
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
    public function aboutUsForm(Request $request){
        try{
            $presentData = BodyAboutUs::first();
            $user = Auth::User();
            $aboutUsData ['body_id'] = $user->body_id;
            $aboutUsData ['description'] = $request->about_us;

            if($request->has('about_us_image')){
                $folderEncName = sha1($user->body_id);
                $folderPath = public_path().env('ABOUT_US_IMAGE_UPLOAD').DIRECTORY_SEPARATOR.$folderEncName;
                if($presentData['image_name'] != null){
                    unlink($folderPath.DIRECTORY_SEPARATOR.$presentData['image_name']);
                }
                if (! file_exists($folderPath)) {
                    File::makeDirectory($folderPath , 0777 ,true,true);
                }
                $imageArray = explode(';',$request->about_us_image);
                $image = explode(',',$imageArray[1])[1];
                $pos  = strpos($request->about_us_image, ';');
                $type = explode(':', substr($request->about_us_image, 0, $pos))[1];
                $extension = explode('/',$type)[1];
                $filename = mt_rand(1,10000000000).sha1(time()).".{$extension}";
                $fileFullPath = DIRECTORY_SEPARATOR.$folderPath.DIRECTORY_SEPARATOR.$filename;
                file_put_contents($fileFullPath,base64_decode($image));
                $aboutUsData ['image_name'] = $filename;
            }
            if($presentData != null){
                $query = BodyAboutUs::where('id',$presentData['id'])->update($aboutUsData);
            }else{
                $query = BodyAboutUs::create($aboutUsData);
            }
            if($query){
                Session::flash('message-success','Successfully Created');
                return back();
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
    public function testimonialForm(Request $request){
        try{
            dd($request->all());
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
