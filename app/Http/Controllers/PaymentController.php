<?php
/**
 * Developed By Ameya Joshi
 * Date: 2/6/17
 */

namespace App\Http\Controllers;
use App\NetBankingTransaction;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\AesForJava;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(){
        $this->middleware('db');
    }

    public function billPayment(Request $request){
        try{
            $data = $request->all();
            $slug = $request->slug;

            $aesJava = new AesForJava();
            $referenceId = NetBankingTransaction::first();
            if($referenceId == null){
                NetBankingTransaction::create(['transactions_count' => 1]);
                $referenceId = 1;
            }else{
                $count = $referenceId['transactions_count'];
                $referenceId = $count+1;
                NetBankingTransaction::where('id', 1)->update(['transactions_count' => $referenceId]);
            }
            $crn = $referenceId+1;
            if($slug == 'gis'){
                $checksumkey = env('EASY_PAY_CHKSUM_KEY');
                $encryption_key = env('EASY_PAY_ENCRYPTION_KEY');
                $corporateCode = env('EASY_PAY_CORPORATE_CODE');
                $version = env('EASY_PAY_VERSION');
                $type = env('EASY_PAY_TYPE');
                $paymentUrl = env('EASY_PAY_PAYMENT_URL');
                $ppiParameters = $data['student_grn']."|".$data['student_name']."|".$data['section']."|".$data['standard']."|".$data['academic_year']."|".$data['fee_type']."|".$data['parent_name']."|".$data['email']."|".$data['contact']."|".$data['installment_id']."|".$data['amount'];
            }else{
                $checksumkey = env('GEMS_EASY_PAY_CHKSUM_KEY');
                $encryption_key = env('GEMS_EASY_PAY_ENCRYPTION_KEY');
                $corporateCode = env('GEMS_EASY_PAY_CORPORATE_CODE');
                $version = env('GEMS_EASY_PAY_VERSION');
                $type = env('GEMS_EASY_PAY_TYPE');
                $paymentUrl = env('GEMS_EASY_PAY_PAYMENT_URL');
                $ppiParameters = $data['student_grn']."|".$data['student_name']."|".$data['section']."|".$data['standard']."|".$data['academic_year']."|".$data['fee_type']."|".$data['parent_name']."|".$data['installment_id'].'|'.$data['email']."|".$data['contact']."|1.0";//.$data['amount'];
            }
            $paramArr = array(
                "CID=".$corporateCode,
                "RID=".$referenceId,
                "CRN=".$crn,
                "AMT=1.0",//.$request->amount,
                "VER=".$version,
                "TYP=".$type,
                "CNY=INR",
                "RTU=http://".env('DOMAIN_NAME')."/payment/payment-return",
                "PPI=".$ppiParameters,
                "RE1=MN",
                "RE2=custom1",
                "RE3=custom2",
                "RE4=custom3",
                "RE5=custom4",
            );
            $chksm = "";
            for ($i = 0; $i < 4; $i++) {
                $valarr = explode("=", $paramArr[$i]);
                $chksm .= $valarr[1];
            }
            $paramArr[] = "CKS=" . hash("sha256", $chksm .$checksumkey );
            $i = $aesJava->encrypt(implode("&", $paramArr),$encryption_key , 128);
            $data = [
                'i' => $i,
                'amount' => $request->amount,
                'payment_url' => $paymentUrl
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
            $encryption_key = env('EASY_PAY_ENCRYPTION_KEY');
            $aesJava = new AesForJava();
            $responseDataString = $aesJava->decrypt($request->i,$encryption_key, 128);
            $responseData = explode('&',$responseDataString);
            $chksm = "";
            $newResponse = array();
            for ($i = 0; $i < count($responseData); $i++) {
                $valarr = explode("=", $responseData[$i]);
                $newResponse[$valarr[0]] = $valarr[1];
                if($i < 4){
                    $chksm .= $valarr[1];
                }
            }
            $newResponse['chksm'] = $chksm;
            $data = array();
            if($newResponse['RMK'] == 'success' || $newResponse == 'SUCCESS'){
                $data['message_title'] = 'Payment Successful.';
                $data['color'] = 'green';
                $data['message'] = 'Following are details of your transaction. Fees will be updated against the student after admin confirmation.';
            }else{
                $data['message_title'] = 'Payment Failed.';
                $data['color'] = 'red';
                $data['message'] = 'Your transaction has been failed. Following are details of your transaction.';
            }
            $data['transaction_id'] = $newResponse['TRN'];
            $data['reference_id'] = $newResponse['RID'];
            $data['amount'] = $newResponse['AMT'];
            $data['date'] = $newResponse['TET'];
            return view('fee.transaction_success')->with(compact('data'));
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
