<?php
/**
 * Created by PhpStorm.
 * User: Nishank Rathod
 * Date: 4/23/18
 * Time: 2:55 PM
 */
?>
<html>
<body>

<table>
    <tr>
        <td style="padding-left: 220%"><img src="<?php echo url()?>/assets/images/bodyLogo/sspss.jpg" style="width:100px;"></td>
    </tr>
</table>
<div style="margin-left: 38%">S.S.P Shikshan Sanstha's</div>
    <div style="margin-left: 22%;font-size: 120%"><span><b>{{ucwords($studentData['name'])}}</b></span></div>
@if($studentData['body_id'] == 1)
    <div style="margin-left: 15%;"><span ><b>Gat No. 1158, Newale Wasti, Chikhali, Pune-411062. Tel.No.:020-65290055</b></span></div>
@else
    <div style="margin-left: 25%;"><span ><b>Ganesh Nagar, Dapodi, Pune-411012.</b></span></div>
@endif
<div><span style="margin-left: 35%;">E- Mail :hr.gispune@gmail.com</span></div>
<div><span style="margin-left: 35%;">www.ganeshinternationalschool.com</span></div>
<div style="margin-left: 20%"><span>UDISE No - 27252001510<span style="padding-left: 7%">CBSE Affiliation No. 1130632</span></span></div>
<div style="margin-left: 35%;font-size: 120%"><span><b>LEAVING CERTIFICATE</b></span></div>
<br>
<div style="border: 1px black solid; padding: 0.5% ;font-size: 12px">
    <div style="text-align: center">(No Changes in any entry in this certificate shall be made except by the authority issuing it and any infringement this requirement is liable to involve the imposition of penalty such as that of rustication)</div>
    <div style="text-align: center">(Prescribed by rule 17 chapter II of Grant - in - aid code)</div>
</div>
<br>
<div style="margin-left: 0.6%">Certificate No. <span>{{$studentData['id']}}</span><span style="padding-left: 56%">Register No. of the pupil : <span>{{$studentData['grn']}}</span></span></div>
<br>
    <table border="1" style="border-collapse: collapse; width: 100%; text-align: left;font-size: 13px;" cellpadding="4">
        <tr>
        <td>
        1. Name of the pupil in full
        </td>
        <td width="70%;">
            <span><b>{{strtoupper($studentData['first_name'])}} &nbsp;&nbsp;{{strtoupper($studentData['father_first_name'])}}&nbsp;&nbsp; {{strtoupper($studentData['last_name'])}}</b></span>
        </td>
        </tr>
                <tr>
        <td>
        2. Name of the mother in full
        </td>
        <td>
            <span><b>{{strtoupper($studentData['mother_first_name'])}}</b></span>
        </td>
        </tr>
                <tr>
        <td>
        3. Religion Caste Sub-caste
        </td>
        <td>
            <span><b>{{strtoupper($studentData['religion'])}}&nbsp;&nbsp; {{strtoupper($studentData['caste'])}}&nbsp;&nbsp; {{strtoupper($studentData['category'])}}</b></span>
        </td>
        </tr>
                <tr>
        <td>
        4. Nationality
        </td>
        <td>
            <span><b>{{strtoupper($studentData['nationality'])}}</b></span>
        </td>
        </tr>
                <tr>
        <td>
        5. Birth of place
        </td>
        <td>
            <span><b>{{strtoupper($studentData['birth_place'])}}</b></span>
        </td>
        </tr>
                <tr>
        <td>
        6.  Mother Tongue
        </td>
        <td>
            <span><b>{{strtoupper($studentData['mother_tongue'])}}</b></span>
        </td>
        </tr>
                <tr>
        <td>
        7.  Adhar Card Number
        </td>
        <td>
            <span><b>{{strtoupper($studentData['aadhar_number'])}}</b></span>
        </td>
        </tr>
                <tr>
        <td>
        8.  Date of birth
        </td>
        <td>
            <span><b>{{date('d/m/Y',strtotime($studentData['birth_date']))}}&nbsp;&nbsp;<i>( {{ucwords($birthDayInWords)}})</i></b></span>
        </td>
        </tr>
                <tr>
        <td>
        9. Last school attended
        </td>
        <td>
            <span><b>{{strtoupper($studentData['last_school_attented'])}}</b></span>
        </td>
        </tr>
                <tr>
        <td>
        10.  Date of Admission
        </td>
        <td>
            <span><b>{{date('d/m/Y',strtotime($studentData['date_of_admission']))}}</b></span>
        </td>
        </tr>
                <tr>
        <td>
        11. Progress
        </td>
        <td>
            <span><b>{{strtoupper($studentData['progress'])}}</b></span>
        </td>
        </tr>
                <tr>
        <td>
        12.  Conduct
        </td>
        <td>
            <span><b>{{strtoupper($studentData['conduct'])}}</b></span>
        </td>
        </tr>
                <tr>
        <td>
        13.  Date of Living School
        </td>
        <td>
            <span><b>{{date('d/m/Y',strtotime($studentData['date_of_leaving']))}}</b></span>
        </td>
        </tr>
                <tr>
        <td>
        14.  Standard in which studing and since when
        </td>
        <td>
            <span><b>{{strtoupper($studentData['standard_in_which_studying'])}}</b></span>
        </td>
        </tr>
                <tr>
        <td>
        15. Reason of living School
        </td>
        <td>
            <span><b>{{strtoupper($studentData['reason'])}}</b></span>
        </td>
        </tr>
                <tr>
        <td>
        16.  Remark
        </td>
        <td>
            <span><b>{{strtoupper($studentData['remark'])}}</b></span>
        </td>
        </tr>
    </table>
    <div style="padding-left: 18%">Certified that the above information is in accordance with the school Register.</div>
    <br>
    <div style="margin-left: 5%">Date: {{date('d/m/Y')}}</div>
<br><br>
    <div style="margin-left: 5%; margin-top: 2%"><span><b>CLASS TEACHER<span style="margin-left: 25%">CLERK</span><span style="padding-left: 25%">H.M./PRINCIPAL</span></b></span></div>
</body>
</html>