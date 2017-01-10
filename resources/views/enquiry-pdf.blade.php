<!doctype html>
<html>
<body style="font:Calibri 16px #000;">
<table>
    <tr>
        <td width="45%"></td>
        <td><img src="<?php echo url()?>/assets/images/bodyLogo/sspss.jpg" style="width:60px;"></td>
    </tr>
</table>
<table>
    <tr>
        <td width="35%"></td>
        <td>S.S.P. SHIKSHAN SANSTHAN'S</td>
    </tr>
</table>
<table>

    <tr>
        <td width="20%"></td>
        <td width="70%"><h3>GANESH INTERNATIONAL SCHOOL,CHIKHALI</h3></td>
    </tr>
</table>
<table>
    <tr>
        <td width="40%"></td>
        <td><h3>ENQUIRY FORM</h3></td>
    </tr>
</table>
<!--<table style="padding-top:10px;padding-bottom:10px;">-->
<!--    <tr>-->
<!--        <td width="35%">2.Name of prospective student:</td>-->
<!--        <td width="65%">fc gvghvghvv gyffytfytfytfrtdestfytfty</td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td width="35%"></td>-->
<!--        <td width="65%;padding-top:-15px;">____________________________________________________________________</td>-->
<!--    </tr>-->
<!--</table>-->
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="35%">Date:- {{date('Y-m-d')}}</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="35%">1.Name of Father/Mother/Guardian:</td>
        <td width="65%">
            <table>
                <tr>
                    <td>{{ucwords($newEnquiry->guardian_first_name)}}   {{ucwords($newEnquiry->guardian_middle_name)}}  {{ucwords($newEnquiry->guardian_last_name)}}</td>
                </tr>
                <tr>
                    <td style="padding-top:-15px;">_______________________________________________</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="35%">2.Name of prospective student:</td>
        <td width="65%">
            <table>
                <tr>
                    <td>{{ucwords($newEnquiry->student_first_name)}}   {{ucwords($newEnquiry->student_middle_name)}}  {{ucwords($newEnquiry->student_last_name)}}</td>
                </tr>
                <tr>
                    <td style="padding-top:-15px;">_______________________________________________</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="30%">3.Presently studying in class:</td>
        <td width="20%">
            <table>
                <tr>
                    <td>{{ucwords($newEnquiry->current_class)}}</td>
                </tr>
                <tr>
                    <td style="padding-top:-15px;">_____________</td>
                </tr>
            </table>
        </td>
        <td width="10%">DOB:</td>
        <td width="40%">
            <table>
                <tr>
                    <td>{{ucwords($newEnquiry->dob)}}</td>
                </tr>
                <tr>
                    <td style="padding-top:-15px;">___________________________</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="10%">School:</td>
        <td style="width:90%;">
            <table>
                <tr>
                    <td>{{ucwords($newEnquiry->school_name)}}</td>
                </tr>
                <tr>
                    <td style="padding-top:-15px;">__________________________________________________________________</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="35%">4.Seeking admission to class :</td>
        <td width="65%">
            <table>
                <tr>
                    <td>{{ucwords($newEnquiry->admission_to_class)}}</td>
                </tr>
                <tr>
                    <td style="padding-top:-15px;">_______________________________________________</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td>5.Contact Details :-</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="15%">Mobile No.</td>
        <td width="65%">
            <table>
                <tr>
                    <td>{{ucwords($newEnquiry->mobile_number)}}</td>
                </tr>
                <tr>
                    <td style="padding-top:-15px;">_______________________________________________</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="15%">Address:</td>
        <td width="85%">
            <table>
                <tr>
                    <td>{{ucwords($newEnquiry->address)}}</td>
                </tr>
                <tr>
                    <td style="padding-top:-15px;">______________________________________________________________</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table>
    <tr>
        <td width="15%"></td>
        <td style="padding-top:-15px;width:85%;">&nbsp;_______________________________________________________________</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="15%">Signature :</td>
        <td width="65%">
            <table>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td style="padding-top:-45px;">_______________________________________</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!--<table style="padding-top:10px;padding-bottom:10px;">-->
<!--    <tr>-->
<!--        <td>_____________________________________________________________________________</td>-->
<!--    </tr>-->
<!--</table>-->
<!--<table>-->
<!--    <tr>-->
<!--        <td>First Name</td>-->
<!--        <td>Last Name</td>-->
<!--        <td>Middle Name</td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td style="padding-top: 10px;">__________________________</td>-->
<!--        <td style="padding-top: 10px;">__________________________</td>-->
<!--        <td style="padding-top: 10px;">__________________________</td>-->
<!--    </tr>-->
<!--</table>-->
<!---->
<!--<table style="padding-top:10px;padding-bottom:10px;">-->
<!---->
<!--    <tr>-->
<!--        <td><h5>Name of prospective student</h5></td>-->
<!--    </tr>-->
<!--</table>-->
<!--<table>-->
<!--    <tr>-->
<!--        <td>First Name</td>-->
<!--        <td>Last Name</td>-->
<!--        <td>Middle Name</td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td>__________________________</td>-->
<!--        <td>__________________________</td>-->
<!--        <td>__________________________</td>-->
<!--    </tr>-->
<!--</table>-->
<!---->
<!--<table style="padding-top:10px;padding-bottom:10px;">-->
<!---->
<!--    <tr>-->
<!--        <td>-->
<!--            <table>-->
<!--                <tr>-->
<!--                    <td>Date Of Birth</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td style="margin-top: 10px;">__________________________</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td style="padding-top: 10px;">Presently studying in class</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td style="margin-top: 10px;">__________________________</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td style="margin-top: 10px;">Seeking admission to class</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td style="margin-top: 10px;">__________________________</td>-->
<!--                </tr>-->
<!--            </table>-->
<!--        </td>-->
<!--        <td>-->
<!--            <table>-->
<!--                <tr>-->
<!--                    <td style="margin-top: 70px;">School Name</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td style="margin-top: 10px;">__________________________</td>-->
<!--                </tr>-->
<!--            </table>-->
<!--        </td>-->
<!--    </tr>-->
<!--</table>-->
<!---->
<!--<table>-->
<!--    <tr>-->
<!--        <td></td>-->
<!--        <td></td>-->
<!--    </tr>-->
<!--</table>-->

</body>
</html>