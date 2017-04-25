<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\AesForJava;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function billPayment(Request $request){
        try{
            $data = $request->all();
            $checksumkey = 'axis';
            $encryption_key = 'axisbank12345678';
            $aesJava = new AesForJava();
            $customerUniqueId = ($request->student_grn."".$request->student_body_id);  // For CRN
            $date = date('YmdHis');
            $referenceId = ($request->student_grn."".$request->student_body_id.''.$date);
            /*
                Student GRN No.|Student Name|Section|Standard|Academic Year|Fee Type|Parents Name|Email|Contact Number|Amount
            */
            $ppiParameters = $data['student_grn']."|".$data['student_name']."|".$data['section']."|".$data['standard']."|".$data['academic_year']."|".$data['fee_type']."|".$data['parent_name']."|".$data['email']."|".$data['contact']."|1.0";//.$data['amount'];
            $paramArr = array(
                "CID=".env('EASY_PAY_CORPORATE_CODE'),
                "RID=13",
                "CRN=128",
                "AMT=1.0",
                "VER=".env('EASY_PAY_VERSION'),
                "TYP=".env('EASY_PAY_TYPE'),
                "CNY=INR",
                "RTU=http://".env('DOMAIN_NAME')."/payment/payment-return",
                "PPI=".$ppiParameters,//411|Ameya Joshi|B|8|2017-2018|1|Sanjay Joshi|ameya.woxi@gmail.com|9158898159|1.0",
                "RE1=MN",
                "RE2=custom1",
                "RE3=custom2",
                "RE4=custom3",
                "RE5=custom4",
            );
                /*
                 *  1. Corporate Code: 3223
                    2. PPI format:
                        Student GRN No.|Student Name|Section|Standard|Academic Year|Fee Type|Parents Name|Email|Contact Number|Amount

                CRN =>  Customer Reference Number
                        which will be unique for the
                        customer for doing payment.

                RID => This Reference ID is used by
                        payment gateway to identify the
                        order. Ensure that you send a
                        unique reference id with each
                        request. Payment Gateway will
                        check the uniqueness of this
                        reference id as it generates a
                        unique payment reference
                        number for each order which is
                        sent by the payment gateway.

                RTU => Payment Gateway will post the
                        status of the order along with
                        the parameters to this URL.

                CKS => Concatenation of ( CID + RID +
                       CRN + AMT + key) and need to
                       be hashed by SHA256 hashed.
                */
            $chksm = "";
            for ($i = 0; $i < 4; $i++) {
                $valarr = explode("=", $paramArr[$i]);
                $chksm .= $valarr[1];
            }
            $paramArr[] = "CKS=" . hash("sha256", $chksm .$checksumkey );
            $i = $aesJava->encrypt(implode("&", $paramArr),$encryption_key , 128);
            $data = [
                'i' => $i
            ];
            return response()->json($data);
        }catch(\Exception $e){
            $data = [
                'action' => 'Make bill payment',
                'data' => $request->all(),
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }

    }

    public function billReturnUrl(Request $request){
        try{
            Log::info('in return Url');
            $encryption_key = 'axisbank12345678';
            $aesJava = new AesForJava();
            $responseDataString = $aesJava->decrypt($request->i,$encryption_key, 128);
            $responseData = explode('&',$responseDataString);
            dd($responseData);
            $chksm = "";
            for ($i = 0; $i < 4; $i++) {
                $valarr = explode("=", $responseData[$i]);
                $chksm .= $valarr[1];
            }
            dd($chksm);
        }catch(\Exception $e){
            $data = [
                'action' => 'Bill return Url',
                'data' => $request->all(),
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
}
