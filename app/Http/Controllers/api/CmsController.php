<?php

namespace App\Http\Controllers\api;

use App\BodyAboutUs;
use App\BodyDetails;
use App\BodySliderImages;
use App\BodyTabNames;
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
    public function masterDetails(Request $request,$body_id = 1){
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
            $itrator = 0;
            foreach ($sliderImages as $slider){
                $data['sliderImages']['slider']['image'][$itrator] = env('BASE_URL').env('SLIDER_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.sha1($body_id).DIRECTORY_SEPARATOR.$slider['name'];
                $data['sliderImages']['slider']['message1'][$itrator] = $slider['message_1'];
                $data['sliderImages']['slider']['message_2'][$itrator] = $slider['message_2'];
                $data['sliderImages']['slider']['hyper_name'][$itrator] = $slider['hyper_name'];
                $data['sliderImages']['slider']['hyper_link'][$itrator] = $slider['hyper_link'];
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
           /* foreach ($galleryImages as $galleryImage){
                $data['gallery']['folderName'] = $galleryImage;
            }*/

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
