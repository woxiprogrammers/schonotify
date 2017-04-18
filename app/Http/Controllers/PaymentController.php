<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\AesForJava;

class PaymentController extends Controller
{
    public function billPayment(){
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
                "CID=3223",
                "RID=121",
                "CRN=21100018",
                "AMT=1.0",
                "VER=1.0",
                "TYP=test",
                "CNY=INR",
                "RTU=https://10.9.0.9/easypay/frontend/index.php/api/output",
                "PPI=test1|asd|test|29/04/2015|8097520469|rajas.vyas@tejora.com|1",
                "RE1=",
                "RE2=",
                "RE3=",
                "RE4=",
                "RE5=",
            );
            /*
             *  1. Corporate Code: 3223
                2. PPI format:
                    Student GRN No.|Student Name|Section|Standard|Academic Year|Fee Type|Parents Name|Email|Contact Number|Amount
*/
        }


        $chksm = "";
        for ($i = 0; $i < 4; $i++) {
            $valarr = explode("=", $paramArr[$i]);
            $chksm .= $valarr[1];
        }

        $paramArr[] = "CKS=" . hash("sha256", $chksm .$checksumkey );
        $i = $aesJava->encrypt(implode("&", $paramArr),$encryption_key , 128);
        $this->render("sampleForm", array('data' => $i, 'action' => 'payment'));
    }
}
