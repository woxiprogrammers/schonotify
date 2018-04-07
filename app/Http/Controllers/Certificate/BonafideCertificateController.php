<?php

namespace App\Http\Controllers\certificate;

use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class BonafideCertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }

    public function getManageView(Request $request){
        try{
            return view('certificate.bonafide.manage');
        }catch (\Exception $e){
            $data = [
                'action' => 'Get Manage bonafide view',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }

    public function getCreateView(Request $request){
        try{
            return view('certificate.bonafide.create');
        }catch (\Exception $e){
            $data = [
                'action' => 'Get Create bonafide view',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function getBonafideView(Request $request){
        try{
            /*Retrieve data*/
            return view('certificate.bonafide.bonafide_partial');
        }catch (\Exception $e){
            $data = [
                'action' => 'Get Bonafide view',
                'GRN' => $request->grn,
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            return response()->json(['message' => 'Something went wrong .'], 500);
        }
    }

    public function downloadBonafide(Request $request){
        try{
            /*Retrieve data*/
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML(view('certificate.bonafide.bonafide_pdf'));
            return $pdf->download('nishank_bonafide.pdf');
        }catch (\Exception $e){
            $data = [
                'action' => 'Download Bonafide Certificate',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }
}
