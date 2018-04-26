<?php
/**
 * Created by PhpStorm.
 * User: Nishank Rathod
 * Date: 4/23/18
 * Time: 2:55 PM
 */
?>
<html>
    <head>
        <style>

        </style>
    </head>
<body>
<table>
    <tr>
        <td style="padding-left: 180%"><img src="<?php echo url()?>/assets/images/bodyLogo/sspss.jpg" style="width:120px;"></td>
    </tr>
</table>
<div style="margin-left: 35%">S.S.P Shikshan Sanstha's</div>
@if($studentData['body_id'] == 1)
    <div style="margin-left: 28%;font-size: 150%"><span><b>Ganesh International School</b></span></div>
@else
    <div style="margin-left: 28%;font-size: 150%"><span><b>Ganesh English Medium School</b></span></div>
@endif
@if($studentData['body_id'] == 1)
    <div style="margin-left: 15%;"><span ><b>Gat No. 1158, Newale Wasti, Chikhali, Pune-411062. Tel.No.:020-65290055</b></span></div>
@else
    <div style="margin-left: 25%;"><span ><b>Ganesh Nagar, Dapodi, Pune-411012.</b></span></div>
@endif
<div><span style="margin-left: 35%;">E- Mail :hr.gispune@gmail.com</span></div>
<div><span style="margin-left: 35%;">www.ganeshinternationalschool.com</span></div>
<div style="margin-left: 20%"><span>UDISE No - 27252001510<span style="padding-left: 7%">CBSE Affiliation No. 1130632</span></span></div>
<div style="margin-left: 35%;font-size: 150%"><span><b>Living Certificate</b></span></div>
<div style="margin-left: 5%">Certificate No. <span>{{$studentData['id']}}</span><span style="padding-left: 50%">Register No. of the pupil : <span>{{$studentData['grn']}}</span></span></div>
<br>
    <table border="1" style="border-collapse: collapse; width: 100%; text-align: left; padding-left: 1%">
        <tr>
        <td style="padding: 1%">
        1. Name of the pupil in full
        </td>
        <td width="70%;" style="padding: 0.5%">
        <span>{{$studentData['first_name']}}&nbsp;&nbsp; {{$studentData['last_name']}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        2. Name of the mother in full
        </td>
        <td style="padding: 0.5%">
        <span>{{$studentData['mother_first_name']}}&nbsp;&nbsp; {{$studentData['mother_middle_name']}}&nbsp;&nbsp; {{$studentData['mother_last_name']}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        3. Religion Caste Sub-caste
        </td>
        <td style="padding: 0.5%">
        <span>{{$studentData['religion']}}&nbsp;&nbsp; {{$studentData['caste']}}&nbsp;&nbsp; {{$studentData['category']}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        4. Nationality
        </td>
        <td style="padding: 0.5%">
        <span>{{$studentData['nationality']}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        5. Birth of place
        </td>
        <td style="padding: 0.5%">
        <span>{{$studentData['birth_place']}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        6.  Mother Tongue
        </td>
        <td style="padding: 0.5%">
        <span>{{$studentData['mother_tongue']}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        7.  Adhar Card Number
        </td>
        <td style="padding: 0.5%">
        <span>{{$studentData['aadhar_number']}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        8.  Date of birth
        </td>
        <td style="padding: 0.5%">
        <span>{{$studentData['birth_date']}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        9. Last school attended
        </td>
        <td style="padding: 0.5%">
        <span>{{$studentData['last_school_attented']}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        10.  Date of Admission
        </td>
        <td style="padding: 0.5%">
        <span>{{$studentData['date_of_admission']}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        11. Progress
        </td>
        <td style="padding: 0.5%">
        <span>{{$studentData['progress']}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        12.  Conduct
        </td>
        <td style="padding: 0.5%">
        <span>{{$studentData['conduct']}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        13.  Date of Living School
        </td>
        <td style="padding: 0.5%">
        <span>{{$studentData['date_of_leaving']}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        14.  Standard in which studing and since when
        </td>
        <td style="padding: 0.5%">
        <span>{{$studentData['standard_in_which_studying']}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        15. Reason of living School
        </td>
        <td style="padding: 0.5%">
        <span>{{$studentData['reason']}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        16.  Remark
        </td>
        <td style="padding: 0.5%">
        <span>{{$studentData['date_of_admission']}}</span>
        </td>
        </tr>
    </table>
    <div style="padding-left: 18%">Certified that the above information is in according with the school Register.</div>
    <br>
    <div style="margin-left: 5%">Date: {{date('d/m/Y')}}</div>
    <br><br>
    <div style="margin-left: 5%"><span><b>CLASS TEACHER<span style="margin-left: 20%">CLERK</span><span style="padding-left: 20%">H.M.PRINCIPAL</span></b></span></div>
</body>
</html>