<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

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
           return view('cms.manage');
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
            dd($request->all());
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
            dd($request->all());
        }catch (\Exception $e){
            $data = [
                'status' => 500,
                'message' => "general setting",
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function footerSettings(Request $request)
    {
        try{
            dd($request->all());
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
