<?php

namespace App\Http\Controllers\api;

use App\BodyAboutUs;
use App\BodyContactUsUserForm;
use App\BodyDetails;
use App\BodyMarqueeDetails;
use App\BodySliderImages;
use App\BodyTabDetails;
use App\BodyTabNames;
use App\BodyTestimonial;
use App\BodyVisitorCounts;
use App\Event;
use App\EventTypes;
use App\Folder;
use App\GalleryManagement;
use App\SocialPlatform;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Support\Facades\Mail;


class CmsController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('db');
        $this->middleware('authenticate.user',['except'=>['masterDetails','eventDetails','aboutUsDetails','subPagesView','contactUsVie','galleryDetails','contactUsForm','contactUsFormCreate','subPagesDetails','allGalleryImages']]);
    }
    public function masterDetails(Request $request,$body_id){
        try{
            $status = 200;
            $message = "Successfully Listed";
            $data = array();
            $data['headerData'] = array();
            $menuData = array();
            $menus = BodyTabNames::where('body_id',$body_id)->where('is_active',1)->where('body_tab_name_id','=',null)
                    ->orderByRaw('priority asc')
                    ->select('id','display_name','slug','priority','link','body_tab_name_id')
                    ->get()->toArray();
            $count = 0;
            foreach ($menus as $menu){
                $menuData[$count]['display_name'] = $menu['display_name'];
                $menuData[$count]['slug'] = $menu['slug'];
                $menuData[$count]['priority'] = $menu['priority'];
                $menuData[$count]['link'] = $menu['link'];
                $checkSubMenus = BodyTabNames::where('body_tab_name_id',$menu['id'])->get()->toArray();
                if(count($checkSubMenus) > 0){
                    $innerCount = 0;
                    foreach ($checkSubMenus as $checkSubMenu){
                        $menuData[$count]['sub_menu'][$innerCount]['name'] = $checkSubMenu['display_name'];
                        $menuData[$count]['sub_menu'][$innerCount]['slug'] = $checkSubMenu['slug'];
                        $menuData[$count]['sub_menu'][$innerCount]['priority'] = $checkSubMenu['priority'];
                        $menuData[$count]['sub_menu'][$innerCount]['link'] = $checkSubMenu['link'];
                        $menuData[$count]['sub_menu'][$innerCount]['body_tab_name_id'] = $checkSubMenu['id'];
                        $innerCount++;
                    }
                } else {
                    $menuData[$count]['sub_menu'] = null;
                }
                $count++;
            }
            $data['marquee'] = BodyMarqueeDetails::where('body_id',$body_id)->first();
            $data['menuData'] = $menuData;
            $bodyDetails = BodyDetails::where('body_id',$body_id)->first();
            $data['headerData']['logo'] = env('BASE_URL').env('LOGO_FILE_UPLOAD').DIRECTORY_SEPARATOR.sha1($body_id).DIRECTORY_SEPARATOR.$bodyDetails['logo_name'];
            $data['headerData']['message'] = $bodyDetails['header_message'];
            $socialDetails = SocialPlatform::join('body_social_details','body_social_details.social_platform_id','=','social_platform.id')
                                            ->where('body_social_details.body_id',$body_id)
                                            ->where('body_social_details.is_active',1)
                                            ->select('body_social_details.name as social_link','social_platform.slug')->get()->toarray();
            $data['socialMedia']['links'] = $socialDetails;
            $sliderImages =  BodySliderImages::where('body_id',$body_id)->where('is_active',1)->get()->toArray();
            $itrator = 1;
            foreach ($sliderImages as $slider){
                $data['sliderImages']['slider'][$itrator]['image'] = env('BASE_URL').env('SLIDER_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.sha1($slider['id']).DIRECTORY_SEPARATOR.$slider['name'];
                $data['sliderImages']['slider'][$itrator]['message1'] = $slider['message_1'];
                $data['sliderImages']['slider'][$itrator]['message2'] = $slider['message_2'];
                $data['sliderImages']['slider'][$itrator]['hyper_name'] = $slider['hyper_name'];
                $data['sliderImages']['slider'][$itrator]['hyper_link'] = $slider['hyper_link'];
                $data['sliderImages']['slider'][$itrator]['slider_number'] = "slider".$itrator;
                $itrator++;
            }
            $data['footerData']['message'] = $bodyDetails['footer_message'];
            $data['contactUs']['address'] = $bodyDetails['address'];
            $data['contactUs']['contact_number'] = $bodyDetails['contact_number'];
            $data['contactUs']['email'] =  $bodyDetails['email'];
            $data['contactUs']['map'] =  $bodyDetails['map_embed'];
            $aboutUs =  BodyAboutUs::where('body_id',$body_id)->first();
            $data['aboutUs']['details'] = $aboutUs['description'];
            $data['aboutUs']['image'] = env('BASE_URL').env('ABOUT_US_IMAGE_UPLOAD').DIRECTORY_SEPARATOR.sha1($body_id).DIRECTORY_SEPARATOR.$aboutUs['image_name'];
            $folders = Folder::where('body_id',$body_id)->where('is_active',true)->orderBy('created_at','desc')->take(4)->get()->toArray();
            foreach ($folders as $key => $folder){
                $data['gallery'][$key]['folder_name'] =$folder['name'];
                $galleryImages = GalleryManagement::where('folder_id',$folder['id'])->where('type','=','image')->select('name')->get();
                foreach ($galleryImages as $key1 => $galleryImage){
                    $data['gallery'][$key]['images'][$key1]['image'] = env('BASE_URL').DIRECTORY_SEPARATOR.env('GALLERY_FOLDER_FILE_UPLOAD').DIRECTORY_SEPARATOR.sha1($folder['id']).DIRECTORY_SEPARATOR.$galleryImage['name'];
                }
            }
            $achievementsId = EventTypes::where('slug','achievement')->pluck('id');
            $announcementId = EventTypes::where('slug','announcement')->pluck('id');
            $eventId = EventTypes::where('slug','event')->pluck('id');
            $data['achievements'] = Event::where('event_type_id',$achievementsId)->where('body_id',$body_id)->orderBy('created_at','desc')->take(15)->skip(0)->get()->toArray();
            $data['announcement'] = Event::where('event_type_id',$announcementId)->where('body_id',$body_id)->orderBy('created_at','desc')->take(15)->skip(0)->get()->toArray();
            $data['events'] = Event::where('event_type_id',$eventId)->where('body_id',$body_id)->orderBy('created_at','desc')->take(15)->skip(0)->get()->toArray();
            $testimonials = BodyTestimonial::where('body_id',$body_id)->where('is_active',1)->get()->toarray();
            $testimonialCOunt = 1;
            foreach ($testimonials as $testimonial){
                $data['testimonial'][$testimonialCOunt]['image'] = env('BASE_URL').env('TESTIMONIAL_IMAGE_UPLOAD').DIRECTORY_SEPARATOR.sha1($testimonial['id']).DIRECTORY_SEPARATOR.$testimonial['image_name'];
                $data['testimonial'][$testimonialCOunt]['details'] = $testimonial['description'];
                $data['testimonial'][$testimonialCOunt]['slug'] = "testimonial".$testimonialCOunt;
                $testimonialCOunt++;
            }

            $visitorCount = 0;
            $alreadyPresent = BodyVisitorCounts::where('body_id',$body_id)->first();
            if (count($alreadyPresent) > 0){
                $vcData['counter'] = $visitorCount = ($alreadyPresent['counter']+1);
                BodyVisitorCounts::where('id',$alreadyPresent['id'])->update($vcData);
            } else {
                $vcData['body_id'] = $body_id;
                BodyVisitorCounts::create($vcData);
            }
            $data['visitor_count'] = $visitorCount;
        }catch(\Exception $e){
            $message = "Something went wrong.";
            $status = 500;
            $data = [
                'action' => ' ',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
        $response = [
            "message" => $message,
            "data" => ($data)
        ];
        return response()->json($response,$status);

    }
    public function eventDetails(Request $request){
            $url = "http://www.veza_cms.com/events";
            return Redirect::to($url);

    }
    public function aboutUsDetails(Request $request){
            $url = "http://www.veza_cms.com/aboutUs";
            return Redirect::to($url);

    }
    public function subPagesView(Request $request,$id){
            $url = "http://www.veza_cms.com/subPage";
            return Redirect::to($url)->with(compact('id'));

    }
    public function contactUsView(){
            $url = "http://www.veza_cms.com/contactUs";
            return Redirect::to($url);

    }
    public function galleryDetails(){
        $url = "http://www.veza_cms.com/gallery";
        return Redirect::to($url);
    }
    public function contactUsForm(Request $request,$body_id){
        try{
            $message = "success";
            $status = 200;
            $data = array();
            $data['contactForm'] = BodyContactUsUserForm::where('body_id',$body_id)->where('is_active',1)->select('name','slug')->get()->toArray();
        }catch(\Exception $exception){
            $message = "Something went wrong.";
            $status = 500;
            $data = [
                'action' => ' ',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
        }
        $response = [
            "message" => $message,
            "data" => ($data)
        ];
        return response()->json($response,$status);
    }
    public function contactUsFormCreate(Request $request,$body_id){
        try{
            $data = $request->all();
            Mail::send('emails.contactUs', $data, function($message) use ($data)
                {
                    $message->from($data['email']);
                    if(array_key_exists('subject',$data)){
                     $message->subject($data['subject']);
                    }
                    if(array_key_exists('message',$data)){
                    $message->body($data['message']);
                    }
                    $message->to('nishank.rathod2010@gmail.com');
                });
          return true;
        }catch(\Exception $e){
            $message = "Something went wrong.";
            $status = 500;
            $data = [
                'action' => 'mail',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }

    }
    public function subPagesDetails($id){
        try{
            $message = "success";
            $status = 200;
            $data = array();
            $data['sub_page_detail'] = BodyTabDetails::join('body_tab_names','body_tab_names.id','=','body_tab_details.body_tab_name_id')
                ->where('body_tab_names.id',$id)
                ->select('body_tab_names.display_name','body_tab_details.description')->get()->toArray();
        }catch(\Exception $exception){
            $message = "Something went wrong.";
            $status = 500;
            $data = [
                'action' => ' ',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
        }
        $response = [
            "message" => $message,
            "data" => ($data)
        ];
        return response()->json($response,$status);
    }
    public function allGalleryImages($body_id){
        try{
            $message = "Successful";
            $status = 200;
            $data = array();
            $folders = Folder::where('body_id',$body_id)->where('is_active',true)->orderBy('created_at','desc')->get()->toArray();
            foreach ($folders as $key => $folder){
                $data['gallery'][$key]['folder_name'] =$folder['name'];
                $galleryImages = GalleryManagement::where('folder_id',$folder['id'])->where('type','=','image')->select('name')->get();
                foreach ($galleryImages as $key1 => $galleryImage){
                    $data['gallery'][$key]['images'][$key1]['image'] = env('BASE_URL').DIRECTORY_SEPARATOR.env('GALLERY_FOLDER_FILE_UPLOAD').DIRECTORY_SEPARATOR.sha1($folder['id']).DIRECTORY_SEPARATOR.$galleryImage['name'];
                }
            }
        }catch(\Exception $exception){
            $message = "Something went wrong.";
            $status = 500;
            $data = [
                'action' => ' ',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
        }
        $response = [
            "message" => $message,
            "data" => ($data)
        ];
        return response()->json($response,$status);
    }

    public function visitorsCount($body_id){
        try{
            $alreadyPresent = BodyVisitorCounts::where('body_id',$body_id)->first();
            if (count($alreadyPresent) > 0){
                $data['counter'] = $alreadyPresent['counter']+1;
                $query = BodyVisitorCounts::where('id',$alreadyPresent['id'])->update($data);
            } else {
                $data['body_id'] = $body_id;
                $query = BodyVisitorCounts::create($data);
            }
            $message = "Counter Updated";
            $status = 200;
        }catch(\Exception $e){
            $message = "Coounter Updated";
            $data = [
                'status' => 500,
                'message' => "edit sub-pages",
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
        $response = [
            "message" => $message,
            "data" => $data
        ];
        return response()->json($response,$status);
    }
}
