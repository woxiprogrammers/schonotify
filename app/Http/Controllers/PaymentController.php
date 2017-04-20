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
            $checksumkey = 'axis';
            $encryption_key = 'axisbank12345678';
            $aesJava = new AesForJava();
            if (!empty($_POST['CID']) && !empty($_POST['RID']) && !empty($_POST['CRN']) && !empty($_POST['AMT']) && !empty($_POST['VER']) && !empty($_POST['TYP']) && !empty($_POST['CNY']) && !empty($_POST['RTU']) && !empty($_POST['PPI'])) {
                $paramArr = array();
                foreach ($_POST as $key => $val) {
                    if ($key != "easyTkn") {
                        $paramArr[] = $key . "=" . $val;
                    }
                }
            } else {
                $paramArr = array(
                    "CID=".env('EASY_PAY_CORPORATE_CODE'),
                    "RID=120",
                    "CRN=211000190",
                    "AMT=1.0",
                    "VER=".env('EASY_PAY_VERSION'),
                    "TYP=".env('EASY_PAY_TYPE'),
                    "CNY=INR",
                    "RTU=http://".env('DOMAIN_NAME')."/payment/payment-return",
                    "PPI=test1|asd|test|29/04/2015|8097520469|rajas.vyas@tejora.com|1",
                    "RE1=MN",
                    "RE2=",
                    "RE3=",
                    "RE4=",
                    "RE5=",
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
            }


            $chksm = "";
            for ($i = 0; $i < 4; $i++) {
                $valarr = explode("=", $paramArr[$i]);
                $chksm .= $valarr[1];
            }

            $paramArr[] = "CKS=" . hash("sha256", $chksm .$checksumkey );
            $i = $aesJava->encrypt(implode("&", $paramArr),$encryption_key , 128);
            $paymentUrl = "https://uat-etendering.axisbank.co.in/index.php/api/payment";
            return view('paymentTest')->with(compact('paymentUrl','i'));
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
            Log::info($request->all());
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
