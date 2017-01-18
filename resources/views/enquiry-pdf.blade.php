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
        <td>S.S.P. SHIKSHAN SANSTHA'S</td>
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

<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold">Date</span>:- {{date('d-m-Y')}}</td>
        <td width="35%"></td>
        <td width="37%">&nbsp;&nbsp;&nbsp;<span style="font-weight: bold"> Enquiry No</span>:- {{$enquiryId}}</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%"><span style="font-weight: bold">1.&nbsp;&nbsp;Name of the Father/Mother/Guardian:&nbsp;&nbsp;</span>{{ucwords($newEnquiry->guardian_first_name)}}   {{ucwords($newEnquiry->guardian_middle_name)}}  {{ucwords($newEnquiry->guardian_last_name)}}</td>

    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%"><span style="font-weight: bold"> &nbsp;&nbsp;&nbsp;&nbsp;Email:&nbsp;&nbsp;</span>{{ucwords($newEnquiry->email)}}</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%"><span style="font-weight: bold"> 2.&nbsp;&nbsp;Name of the prospective student:&nbsp;&nbsp;</span> {{ucwords($newEnquiry->student_first_name)}}   {{ucwords($newEnquiry->student_middle_name)}}  {{ucwords($newEnquiry->student_last_name)}}</td>

    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="50%"><span style="font-weight: bold"> 3.&nbsp;&nbsp;Presently studying in class:&nbsp;&nbsp;</span> {{ucwords($newEnquiry->current_class)}}</td>
        <td width="50%"><span style="font-weight: bold"> DOB:&nbsp;&nbsp;</span> {{Carbon\Carbon::parse($newEnquiry->dob)->format('d-m-Y') }}</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%"><span style="font-weight: bold"> &nbsp;&nbsp;&nbsp;&nbsp;School:&nbsp;&nbsp;</span> {{ucwords($newEnquiry->school_name)}}</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%"><span style="font-weight: bold"> 4.&nbsp;&nbsp;Seeking Admission to class:&nbsp;&nbsp;</span> {{ucwords($newEnquiry->admission_to_class)}}</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td style="font-weight: bold">5.&nbsp;&nbsp;Contact Details :-</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%"><span style="font-weight: bold"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mobile No.&nbsp;&nbsp;</span> {{ucwords($newEnquiry->mobile_number)}}</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="15%" style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Address:</td>
        <td width="85%">
            <table>
                <tr>
                    <td>{{ucwords($newEnquiry->address)}}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="20%" style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature :</td>
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

</body>
</html>