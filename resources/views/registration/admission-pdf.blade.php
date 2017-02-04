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
        <td width="35%"></td>
        <td>(Linguistic Minority Institution)</td>
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
        <td width="35%"></td>
        <td width="60%">(CBSC Affiliation No: 1130632 )</td>
    </tr>
</table>
<table>
    <tr>
        <td width="40%"></td>
        <td><h3>ADMISSION FORM</h3></td>
    </tr>
</table>

<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold">Date</span>:- {{date('d-m-Y')}}</td>
        <td width="35%"></td>
        <td width="37%">&nbsp;&nbsp;&nbsp;<span style="font-weight: bold"> Enquiry No</span>:- {{ucwords($newEnquiry->enquiry_number)}}</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;font-size: 14px;">STUDENT'S INFORMATION</span></td>

    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name:&nbsp;&nbsp;</span>{{ucwords($newEnquiry->user->first_name)}}   {{ucwords($newEnquiry->user->middle_name)}}  {{ucwords($newEnquiry->user->last_name)}}</td>

    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="30%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gender:&nbsp;&nbsp;</span>@if($newEnquiry->user->gender == 'M')MALE @else FEMALE @endif</td>
        <td width="33%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date of Birth:&nbsp;&nbsp;</span>{{Carbon\Carbon::parse($newEnquiry->user->birth_date)->format('d-m-Y')}}</td>
        <td width="37%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Place of Birth:&nbsp;&nbsp;</span>{{ucwords($studentExtraInfo->birth_place)}}</td>
    </tr>
</table>

<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="50%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nationality:&nbsp;&nbsp;</span>{{ucwords($studentExtraInfo->nationality)}}</td>
        <td width="50%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Religion:&nbsp;&nbsp;</span>{{ucwords($studentExtraInfo->religion)}}</td>
   </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="50%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Caste:&nbsp;&nbsp;</span>{{ucwords($studentExtraInfo->caste)}}</td>
        <td width="50%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Category:&nbsp;&nbsp;</span>{{ucwords($studentExtraInfo->category)}}</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="32%" style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Permanent Address:</td>
        <td width="68%">
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
        <td width="32%" style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Communication Address:</td>
        <td width="68%">
            <table>
                <tr>
                    <td>{{ucwords($studentExtraInfo->communication_address)}}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="50%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aadhar card Number:&nbsp;&nbsp;</span>{{ucwords($studentExtraInfo->aadhar_number)}}</td>
        <td width="50%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Blood group:&nbsp;&nbsp;</span>{{ucwords($studentExtraInfo->blood_group)}}</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="50%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mother tongue:&nbsp;&nbsp;</span>{{ucwords($studentExtraInfo->mother_tongue)}}</td>
        <td width="50%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Other languages spoken/written:&nbsp;&nbsp;</span>{{ucwords($studentExtraInfo->other_language)}}</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Highest standard passed:&nbsp;&nbsp;</span>{{ucwords($studentExtraInfo->highest_standard)}}</td>
   </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Academic session applied from:&nbsp;&nbsp;</span>{{ucwords($studentExtraInfo->academic_to)}}&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold"> to:&nbsp;&nbsp;</span>{{ucwords($studentExtraInfo->academic_from)}}</td>
    </tr>
</table>



<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;font-size: 14px;">STUDENT'S FAMILY INFORMATION</span></td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Father’s/Guardian’s name:&nbsp;&nbsp;</span>{{ucwords($studentFamilyInfo->father_first_name)}}   {{ucwords($studentFamilyInfo->father_middle_name)}}  {{ucwords($studentFamilyInfo->father_last_name)}}</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Father’s/Guardian’s occupation:&nbsp;&nbsp;</span>{{ucwords($studentFamilyInfo->father_occupation)}}</td>

    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>

        <td width="100%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Father’s/Guardian’s income (P.A.):&nbsp;&nbsp;</span>{{ucwords($studentFamilyInfo->father_income)}}</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Father’s/Guardian’s contact number:&nbsp;&nbsp;</span>{{ucwords($studentFamilyInfo->father_contact)}}</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mother’s/Guardian’s name:&nbsp;&nbsp;</span>{{ucwords($studentFamilyInfo->mother_first_name)}}   {{ucwords($studentFamilyInfo->mother_middle_name)}}  {{ucwords($studentFamilyInfo->mother_last_name)}}</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mother’s/Guardian’s occupation:&nbsp;&nbsp;</span>{{ucwords($studentFamilyInfo->mother_occupation)}}</td>

    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>

        <td width="100%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mother’s/Guardian’s income (P.A.):&nbsp;&nbsp;</span>{{ucwords($studentFamilyInfo->mother_income)}}</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mother’s/Guardian’s contact number:&nbsp;&nbsp;</span>{{ucwords($studentFamilyInfo->mother_contact)}}</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email address:&nbsp;&nbsp;</span>{{ucwords($studentFamilyInfo->parent_email)}}</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="32%" style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Permanent Address:</td>
        <td width="68%">
            <table>
                <tr>
                    <td>{{ucwords($studentFamilyInfo->permanent_address)}}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="32%" style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Communication Address:</td>
        <td width="68%">
            <table>
                <tr>
                    <td>{{ucwords($studentFamilyInfo->communication_address)}}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;font-size: 14px;">SIBLINGS:</span></td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    @if($studentSiblings->count() > 0)
        @foreach($studentSiblings as $studentSibling)
        <tr>
            <td width="50%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name:&nbsp;&nbsp;</span>{{ucwords($studentSibling->name)}}</td>
            <td width="50%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Age:&nbsp;&nbsp;</span>{{ucwords($studentSibling->age)}}</td>
        </tr>
        @endforeach
    @else
        <tr>
            <td width="50%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name:&nbsp;&nbsp;</span></td>
            <td width="50%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Age:&nbsp;&nbsp;</span></td>
        </tr>

    @endif
</table>

<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;font-size: 14px;">DETAILS OF PREVIOUS SCHOOL ATTENDED</span></td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;School name:&nbsp;&nbsp;</span>{{ucwords($previousSchool->school_name)}}</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="30%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;UDISE No:&nbsp;&nbsp;</span>{{ucwords($previousSchool->udise_no)}}</td>
        <td width="33%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;City:&nbsp;&nbsp;</span>{{ucwords($previousSchool->city)}}</td>
        <td width="37%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Medium of instruction:&nbsp;&nbsp;</span>{{ucwords($previousSchool->medium_of_instruction)}}</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="50%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name of board/examination:&nbsp;&nbsp;</span>{{ucwords($previousSchool->board_examination)}}</td>
        <td width="50%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Grades / %:&nbsp;&nbsp;</span>{{ucwords($previousSchool->grades)}}</td>
    </tr>
</table>


<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;font-size: 14px;">SPECIAL APTITUDE:</span></td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    @if($studentSpecialAptitudes->count() > 0)
        @foreach($studentSpecialAptitudes as $studentSpecialAptitude)
        <tr>
            <td width="50%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Test:&nbsp;&nbsp;</span>{{ucwords($studentSpecialAptitude->special_aptitude)}}</td>
            <td width="50%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Score:&nbsp;&nbsp;</span>{{ucwords($studentSpecialAptitude->score)}}</td>
        </tr>
        @endforeach
    @else
        <tr>
            <td width="50%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Test:&nbsp;&nbsp;</span></td>
            <td width="50%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Score:&nbsp;&nbsp;</span></td>
        </tr>
    @endif
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;font-size: 14px;">INTEREST / HOBBIES:</span></td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    @if($studentHobbies->count() > 0)
        @foreach($studentHobbies as $studentHobby)
        <tr>
            <td width="100%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name:&nbsp;&nbsp;</span>{{ucwords($studentHobby->hobby)}}</td>
        </tr>
        @endforeach
    @else
        <tr>
            <td width="100%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name:&nbsp;&nbsp;</span></td>
        </tr>
    @endif
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;font-size: 14px;">DOCUMENTS SUBMITTED:</span></td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" style="padding-top:10px;padding-bottom:10px;">
    <tr><td width="70%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. Birth certificate:</span></td><td width="30%">YES/NO</td></tr>
    <tr><td width="70%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. Leaving certificate:</span></td><td width="30%">YES/NO</td></tr>
    <tr><td width="70%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. Report card of previous school:</span></td><td width="30%">YES/NO</td></tr>
    <tr><td width="70%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4. Aadhar card of child:</span></td><td width="30%">YES/NO</td></tr>
    <tr><td width="70%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5. Caste certificate if applicable:</span></td><td width="30%">YES/NO</td></tr>
    <tr><td width="70%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;6. ID card size photo:</span></td><td width="30%">YES/NO</td></tr>

</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="25%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;</span></td>
        <td width="30%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Place:&nbsp;&nbsp;</span></td>
        <td width="45%"><span style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Parent’s/Guardian’s Signature:&nbsp;&nbsp;</span></td>
    </tr>
</table>

<br pagebreak="true">
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
        <td width="35%"></td>
        <td>(Linguistic Minority Institution)</td>
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
        <td width="35%"></td>
        <td width="60%">(CBSC Affiliation No:1130632)</td>
    </tr>
</table>
<table>
    <tr>
        <td width="37%"></td>
        <td><h3><u>MEDICAL CERTIFICATE</u></h3></td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">

</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="80%"><span >&nbsp;&nbsp;I.&nbsp;&nbsp;&nbsp;Whether the pupil has undergone any surgical procedure:</span></td><td width="20%">YES/NO</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="100%"><span >&nbsp;&nbsp;II.&nbsp;&nbsp;&nbsp;Please mention the details whether the pupil has a history of&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" style="padding-top:10px;padding-bottom:10px;">
    <tr><td width="5%"></td><td width="75%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A. Congenital abnormality</span></td><td width="20%">YES/NO</td></tr>
    <tr><td width="5%"></td><td width="75%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B. Rheumatic heart disease</span></td><td width="20%">YES/NO</td></tr>
    <tr><td width="5%"></td><td width="75%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C. Bronchial asthma</span></td><td width="20%">YES/NO</td></tr>
    <tr><td width="5%"></td><td width="75%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;D. Epilepsy</span></td><td width="20%">YES/NO</td></tr>
    <tr><td width="5%"></td><td width="75%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E. Diabetes</span></td><td width="20%">YES/NO</td></tr>
    <tr><td width="5%"></td><td width="75%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;F. Hyper tension</span></td><td width="20%">YES/NO</td></tr>
    <tr><td width="5%"></td><td width="75%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G. Tuberculosis</span></td><td width="20%">YES/NO</td></tr>
    <tr><td width="5%"></td><td width="75%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;H. Congenital heart disease</span></td><td width="20%">YES/NO</td></tr>
    <tr><td width="5%"></td><td width="75%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I. Any other disease(Please give details if necessary):</span></td></tr>

</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="80%"><span >&nbsp;&nbsp;III.&nbsp;&nbsp;&nbsp;Please mention whether the student has any eye sight related problems</span></td><td width="20%">YES/NO</td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="80%"><span >&nbsp;&nbsp;IV.&nbsp;&nbsp;&nbsp;Please mention whether the student has been vaccinated regularly</span></td><td width="20%">YES/NO</td>
    </tr>
</table>

<table style="padding-top:10px;padding-bottom:10px;">
    <tr>
        <td width="50%"></td><td><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature of the Doctor:</span></td>
    </tr>
</table>

<table style="padding-top:10px;padding-bottom:10px;">
    <tr><td width="100%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Full name of the doctor:</span></td></tr>
    <tr><td width="100%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Address & contact no.:</span></td></tr>
    <tr><td width="100%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registration number:</span></td></tr>
</table>
<table>
    <tr>
        <td width="10%"></td>
        <td width="90%"><h3><u>DECLARATION BY THE PARENTS/GUARDIANS</u></h3></td>
    </tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr><td width="100%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;In case of any medical emergency which may require surgical procedure, anaesthesia, invasive investigations, administration of drugs where the written permission is obligatory I hereby authorize the principal to give it on behalf provided is not possible to obtain from me in time. Medical treatment may be availed from any competent medical authority or institute.</span></td></tr>
</table>
<table style="padding-top:10px;padding-bottom:10px;">
    <tr><td width="100%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name of pupil:</span></td></tr>
    <tr><td width="50%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name of parent: </span></td><td width="50%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Relation with pupil:</span></td></tr>
    <tr><td width="100%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Full address: </span></td></tr>
    <tr><td width="50%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telephone number: </span></td><td width="50%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Place:&nbsp;&nbsp;</span></td></tr>
    <tr><td width="50%"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;</span></td><td width="50%"><span >Parent’s/Guardian’s Signature:</span></td></tr>

</table>
<br pagebreak="true">
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
        <td width="35%"></td>
        <td>(Linguistic Minority Institution)</td>
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
        <td width="35%"></td>
        <td width="60%">(CBSC Affiliation No: 1130632)</td>
    </tr>
</table>
<div></div>
<table>
    <tr>
        <td><h3><u>INSTRUCTIONS FOR SYUDENTS AND GUARDIANS</u></h3></td>
    </tr>
</table>
<div></div>
<table>
    <tr width="100%">
        <td >Please read the following instructions carefully and put a <img src="<?php echo url()?>/assets/images/bodyLogo/tickmark.jpg" style="width:10px;height: 10px"> mark against the instructions in the box. Please sign at the end of the instruction page to indicate that you have read and understood them and agree to them.</td>
    </tr>
</table>
<table>
    <tr width="100%">
        <td ><ul><li>&nbsp;&nbsp;<B>Admissions</B></li></ul></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.</td>
        <td width="80%">The school reserves the right to grant admissions to the students, being a minority institution first preference shall be given to the minority category (kannada speaking linguistic minority) &nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
</table>
<table>
    <tr width="100%">
        <td ><ul><li>&nbsp;&nbsp;<B>School Timings & Punctuality</B></li></ul></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.</td>
        <td width="80%">School Assembly: The morning assembly plays a very important role in the life of a student and sets the tone of work for the day. Students are required to attend the assembly held at the school’s quadrangle from Monday to Saturday at 8:00 a.m.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b.</td>
        <td width="80%">School Timing from Monday to Friday: 8.00a.m. to 2.30p.m. & for Saturday: 8.00a.m. to 12.00 noon.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c.</td>
        <td width="80%">All students must attend the school regularly and punctually. He/she must be present for all the periods in the school.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>

</table>
<table>
    <tr width="100%">
        <td ><ul><li>&nbsp;&nbsp;<B>School Uniform and Hygiene</B></li></ul></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.</td>
        <td width="80%">The School uniform is obligatory on all school days and official functions. It is the duty of the parents to see that the student comes to school neatly dressed in the prescribed uniform. The uniform should be clean and ironed.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b.</td>
        <td width="80%">No jewellery is permitted except small ear studs for girls.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c.</td>
        <td width="80%">New uniform should be purchased by all the students at the beginning of the new academic year.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
</table>
<table>
    <tr width="100%">
        <td ><ul><li>&nbsp;&nbsp;<B>Meetings</B></li></ul></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.</td>
        <td width="80%">Parents must attend the open house meetings to get an update on their child's academic progress and conduct. In case the parent is unable to attend the open house it must be intimated to the class teacher. Parents must collect the report card within that week.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b.</td>
        <td width="80%">Parents/Guardians are not allowed to enter the class rooms. They can meet the teachers only after getting permission from the principal. Any query regarding the academic performance of the child shall be addressed as per the scheduled timings.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c.</td>
        <td width="80%">It is compulsory for both the parents to attend the monthly meetings to discuss the progress of the child regularly.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
</table>
<table>
    <tr width="100%">
        <td ><ul><li>&nbsp;&nbsp;<B>Leave of absence & movement during school hours</B></li></ul></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.</td>
        <td width="80%">The parent/guardian will have to submit a Medical Certificate along with his application if his ward is unable to appear for any Examination or Unit Test on account of illness.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b.</td>
        <td width="80%">If the student is late for school or wishes to leave the school early he must get a note from the parents in the school diary and get it signed from the class teacher. Permission from the Supervisor/Headmistress for the same is mandatory.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c.</td>
        <td width="80%">No leave shall be granted for trivial reasons or functions during the school term.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
</table>
<table>
    <tr width="100%">
        <td ><ul><li>&nbsp;&nbsp;<B>Code of conduct to be followed by the student</B></li></ul></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.</td>
        <td width="80%">When the teacher is not present in the class, all the instructions given by the Class-Monitor have to be followed by the pupil.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b.</td>
        <td width="80%">A Student should behave properly and be well mannered not only in the classroom and school premises but also while travelling in the bus. Strict action will be taken against those who misbehave in the bus, classroom and in the school premises or bring disrepute to the school in any manner.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c.</td>
        <td width="80%">Students should not leave the school premises without permission during school hours.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;d.</td>
        <td width="80%">Students are not permitted to bring any valuables, mobiles or other electronic gadgets to school. No responsibility for its loss will be taken by the school.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
</table>
<div></div>
<table>
    <tr width="100%">
        <td ><ul><li>&nbsp;&nbsp;<B>Examination</B></li></ul></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.</td>
        <td width="80%">Students must appear for all the Unit Tests, Evaluations and Examinations; Written, oral, theory, practical, drawing, physical education, computer etc......&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b.</td>
        <td width="80%">The guardian will have to submit a Medical Certificate along with his application if his ward is unable to appear for any Examination or Unit Test on account of illness.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c.</td>
        <td width="80%">A Pupil found using any unfair means during the exam will be given zero marks for that paper.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;d.</td>
        <td width="80%">75% attendance is compulsory for all the students.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;e.</td>
        <td width="80%">35% marks in all the subjects are required for promoting the student to the next class.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
</table>
<table>
    <tr width="100%">
        <td ><ul><li>&nbsp;&nbsp;<B>Co-curricular activities, Projects and sports</B></li></ul></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.</td>
        <td width="80%">Students should complete the Assignment & Projects assigned to them from time to time and make the entries regarding their co-curricular activities in the diary.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b.</td>
        <td width="80%">All the students should participate in the school sports, co-curricular activities, project work, annual gathering and other events conducted in the school from time to time.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
</table>
<table>
    <tr width="100%">
        <td ><ul><li>&nbsp;&nbsp;<B>Payment of Fees</B></li></ul></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.</td>
        <td width="80%">All fees: Annual, Computer, Term, Activity etc. Must be paid before the Term End Exam otherwise the student will not be allowed to appear for the exam.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b.</td>
        <td width="80%">The fee structure shall be revised by the management from time to time in consultation with the school managing committee and executive committee. The decisions taken by these committees shall be binding to all the parents.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c.</td>
        <td width="80%">The fees shall be paid online or through bank transactions as instructed on the school website: www.ganeshinternationalschool.com&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
</table>
<table>
    <tr width="100%">
        <td ><ul><li>&nbsp;&nbsp;<B>School diary & Assignments</B></li></ul></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.</td>
        <td width="80%">All the assignments should be noted in the daily diary. Parents are responsible to get the assignment/homework done by the student regularly.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b.</td>
        <td width="80%">The school diary must be brought to the school every day. The diary must be purchased by the students. If it is lost a new diary will be issued at double the cost. Parents should check the diary daily and sign it regularly.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
    <tr width="100%">
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c.</td>
        <td width="80%">A pupil must bring his guardian’s note in the school diary if he comes late to the school or wishes to leave the school early.&nbsp;&nbsp;<img src="<?php echo url()?>/assets/images/bodyLogo/checkbox.jpg" style="width:10px;height: 10px"></td>
    </tr>
</table>
<div></div>
<div></div>
<table>
    <tr width="100%">
        <td >I have read all the rules and I agreed to abide by them.</td>
    </tr>
</table>
<div></div>
<table>
    <tr>
        <td width="10%"></td>
        <td width="40%"><span >Date: </span></td>
        <td width="50%"><span >Parent’s/Guardian’s Signature:</span></td>
    </tr>
</table>
</body>
</html>
