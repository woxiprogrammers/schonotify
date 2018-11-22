<?php

namespace App\Http\Controllers\api;

use App\BodyAboutUs;
use App\BodyDetails;
use App\BodySliderImages;
use App\BodyTabNames;
use App\BodyTestimonial;
use App\Event;
use App\EventTypes;
use App\Folder;
use App\GalleryManagement;
use App\SocialPlatform;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Null_;

class CmsController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('db');
        $this->middleware('authenticate.user',['except'=>['masterDetails']]);
    }
    public function masterDetails(Request $request,$body_id){
        try{
            $status = 200;
            $message = "Successfully Listed";
            $data = array();
            $data['headerData'] = array();
            $data['menuData'] = array();
            $data['menuData'] = BodyTabNames::where('body_id',$body_id)->where('is_active',1)->where('body_tab_name_id','=',Null)->select('id','display_name','slug','priority','link')->get()->toArray();
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
            $galleryImages = Folder::join('gallery_management','gallery_management.folder_id','=','folders.id')
                                ->where('folders.is_active',1)
                                ->where('folders.body_id',$body_id)
                                ->where('gallery_management.type','=','image')
                                ->select('folders.id','folders.name','gallery_management.name as images')->get()->groupBy('id')->toArray();
            /*jitrator = 1;
            foreach ($galleryImages as $key => $galleryImage){
                $data['gallery']['data']['folderName'] = $galleryImage['name'];
                foreach ($galleryImage as $keys => $value){
                     $data['gallery']['data'][$jitrator]['images'] = env('BASE_URL').env('GALLERY_FOLDER_FILE_UPLOAD').DIRECTORY_SEPARATOR.sha1($value['id']).DIRECTORY_SEPARATOR.$value['images'];
                     $jitrator++;
                 }
            }*/
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
}
