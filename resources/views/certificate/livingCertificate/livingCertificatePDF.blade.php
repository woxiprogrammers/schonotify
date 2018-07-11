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
@if($studentData['body_id'] == 1)
    <div style="margin-left: 32%;font-size: 120%"><span><b>Ganesh International School</b></span></div>
@else
    <div style="margin-left: 32%;font-size: 120%"><span><b>Ganesh English Medium School</b></span></div>
@endif
@if($studentData['body_id'] == 1)
    <div style="margin-left: 15%;"><span ><b>Gat No. 1158, Newale Wasti, Chikhali, Pune-411062. Tel.No.:020-65290055</b></span></div>
@else
    <div style="margin-left: 25%;"><span ><b>Ganesh Nagar, Dapodi, Pune-411012.</b></span></div>
@endif
<div><span style="margin-left: 35%;">E- Mail :hr.gispune@gmail.com</span></div>
<div><span style="margin-left: 35%;">www.ganeshinternationalschool.com</span></div>
<div style="margin-left: 20%"><span>UDISE No - 27252001510<span style="padding-left: 7%">CBSE Affiliation No. 1130632</span></span></div>
<div style="margin-left: 35%;font-size: 120%"><span><b>LEAVING CERTIFICATE</b></span></div>
<div style="border: 1px black solid;margin-left: 10px ; padding: 1%">
    <div style="padding-left: 5%">(No Changes in any entry in this certificate shall be made except by the authority issuing it and any infringement this requirement is liable to involve the imposition of penalty such as that of rustication)</div>
    <div style="padding-left: 20%">(Prescribed by rule 17 chapter II of Grant - in - aid code)</div>
</div>
<div style="margin-left: 5%">Certificate No. <span>{{$studentData['id']}}</span><span style="padding-left: 50%">Register No. of the pupil : <span>{{$studentData['grn']}}</span></span></div>
    <table border="1" style="border-collapse: collapse; width: 100%; text-align: left; padding-left: 1%;padding-top: 1%">
        <tr>
        <td style="padding: 1%">
        1. Name of the pupil in full
        </td>
        <td width="70%;" style="padding: 0.5%">
        <span>{{strtoupper($studentData['first_name'])}} &nbsp;&nbsp;{{strtoupper($studentData['father_first_name'])}}&nbsp;&nbsp; {{strtoupper($studentData['last_name'])}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        2. Name of the mother in full
        </td>
        <td style="padding: 0.5%">
        <span>{{strtoupper($studentData['mother_first_name'])}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        3. Religion Caste Sub-caste
        </td>
        <td style="padding: 0.5%">
        <span>{{strtoupper($studentData['religion'])}}&nbsp;&nbsp; {{strtoupper($studentData['caste'])}}&nbsp;&nbsp; {{strtoupper($studentData['category'])}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        4. Nationality
        </td>
        <td style="padding: 0.5%">
        <span>{{strtoupper($studentData['nationality'])}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        5. Birth of place
        </td>
        <td style="padding: 0.5%">
        <span>{{strtoupper($studentData['birth_place'])}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        6.  Mother Tongue
        </td>
        <td style="padding: 0.5%">
        <span>{{strtoupper($studentData['mother_tongue'])}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        7.  Adhar Card Number
        </td>
        <td style="padding: 0.5%">
        <span>{{strtoupper($studentData['aadhar_number'])}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        8.  Date of birth
        </td>
        <td style="padding: 0.5%">
        <span>{{date('d/m/Y',strtotime($studentData['birth_date']))}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        9. Last school attended
        </td>
        <td style="padding: 0.5%">
        <span>{{strtoupper($studentData['last_school_attented'])}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        10.  Date of Admission
        </td>
        <td style="padding: 0.5%">
        <span>{{date('d/m/Y',strtotime($studentData['date_of_admission']))}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        11. Progress
        </td>
        <td style="padding: 0.5%">
        <span>{{strtoupper($studentData['progress'])}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        12.  Conduct
        </td>
        <td style="padding: 0.5%">
        <span>{{strtoupper($studentData['conduct'])}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        13.  Date of Living School
        </td>
        <td style="padding: 0.5%">
        <span>{{date('d/m/Y',strtotime($studentData['date_of_leaving']))}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        14.  Standard in which studing and since when
        </td>
        <td style="padding: 0.5%">
        <span>{{strtoupper($studentData['standard_in_which_studying'])}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        15. Reason of living School
        </td>
        <td style="padding: 0.5%">
        <span>{{strtoupper($studentData['reason'])}}</span>
        </td>
        </tr>
                <tr>
        <td style="padding: 0.5%">
        16.  Remark
        </td>
        <td style="padding: 0.5%">
        <span>{{strtoupper($studentData['remark'])}}</span>
        </td>
        </tr>
    </table>
    <div style="padding-left: 18%">Certified that the above information is in accordance with the school Register.</div>
    <br>
    <div style="margin-left: 5%">Date: {{date('d/m/Y')}}</div>
    <div style="margin-left: 5%; margin-top: 2%"><span><b>CLASS TEACHER<span style="margin-left: 25%">CLERK</span><span style="padding-left: 25%">H.M./PRINCIPAL</span></b></span></div>
</body>
</html>