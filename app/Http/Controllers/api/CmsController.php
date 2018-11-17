<?php

namespace App\Http\Controllers\api;

use App\BodyDetails;
use App\BodySliderImages;
use App\BodyTabNames;
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
            $data['headerData']['socialMedia'] = $socialDetails;
            $data['sliderImages'] = BodySliderImages::where('body_id',$body_id)->where('is_active',1)->get()->toArray();
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
