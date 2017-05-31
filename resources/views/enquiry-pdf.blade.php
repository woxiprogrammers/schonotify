<html>
<body style="font:Calibri 16px #000;">
<table>
    <tr>
        <td width="15%"></td>
        <td width="80%"><h1> Ness Wadia College of Commerce, Pune 411001</h1></td>
    </tr>
</table>
<table>
    <tr>
        <td width="35%"></td>
        <td width="60%">F.Y.B.COM. Waiting List Form</td>
    </tr>
</table>
<table>
  <tr>
    <td>
      <h3>Medium to be offered : {{ucwords($newEnquiry->medium)}}</h3>
      <div>
        <h4>To,</h4>
        <h4>The principal ,</h4>
        <h4>Ness Wadia College Of Commerce ,</h4>
        <h4>Pune-411001</h4>
      </div>
    </td>
    <td>
      <br><br><br>
      <table border="1" style="padding:2px">
       <tr>
          <th>Form No.</th>
          <td>{{ucwords($newEnquiry->form_no)}}</td>
       </tr>
       <tr>
          <th>Marks Obtained</th>
          <td>{{ucwords($newEnquiry->marks_obtained)}} Out Of {{ucwords($newEnquiry->outOf_marks)}}</td>
       </tr>
       <tr>
          <th>% of Marks</th>
          <td>{{ucwords($newEnquiry->percentage)}}</td>
       </tr>
       <tr>
          <th>Board</th>
          <td>{{ucwords($newEnquiry->board)}}</td>
       </tr>
       <tr>
          <th>State</th>
          <td>{{ucwords($newEnquiry->state)}}</td>
       </tr>
       <tr>
          <th>Country</th>
          <td>{{ucwords($newEnquiry->country)}}</td>
       </tr>
       <tr>
          <th>Caste</th>
          <td>{{ucwords($newEnquiry->caste)}}</td>
       </tr>
       <tr>
         <th>Category</th>
          <td>{{ucwords($newEnquiry->category)}}</td>
       </tr>
       <tr>
         <th>Date</th>
          <td>{{ucwords($newEnquiry->date)}}</td>
       </tr>
       </table>
     </td>
</tr>
</table>
<h4>Madam ,</h4>
<p style="font-size:11px;padding:5px">I Mr./Miss.<u style="display:inline-block;"><b>{{ucwords($newEnquiry->first_name)}}  {{ucwords($newEnquiry->middle_name)}} {{ucwords($newEnquiry->last_name)}} </b></u>  have
   passed HSC/ICSE/CBSE/NIOS/Other state Board Examination held in  {{ucwords($newEnquiry->examination_year)}}.</p>
<p style="font-size:11px">I have secured<u style="display:inline-block;"> {{ucwords($newEnquiry->marks_obtained)}}</u> marks out of <u style="display:inline-block;">{{ucwords($newEnquiry->outOf_marks)}} </u>marks.I belong to<u style="display:inline-block;"> {{ucwords($newEnquiry->caste)}}</u>
   caste hence is under <u style="display:inline-block;">{{ucwords($newEnquiry->category)}}</u> category.</p>
<p style="font-size:11px"> I am under DEFENCE/Differently abled Category also.(If so , attach photo copy of the
   concerned category) (Once category offered can not be changed lateron).
   I have passed the examination from {{ucwords($newEnquiry->state)}} state.
   My address is <u style="display:inline-block;">{{ucwords($newEnquiry->address)}}</u> Mobile no <u style="display:inline-block;">{{ucwords($newEnquiry->mobile)}}</u>.</p>
        <p style="font-size:11px">   I know that this is a waitinglist form and not admission form.I will not claim over
   admission if I do not fulfill the terms and conditions.
           I hereby enclose the attested photo copy of the marklist of XII and X , Leaving
   Certificate and Caste Certificate.</p>
<h5>Kindly note that the Reserved Category students from other than Maharashtra State will not be considered for
   admission under Reserved Category students. Such student will be considered as OPEN CATEGORY STUDENT.</h5>
<h5>Thanking You ,</h5>
<h5>Your's faithfully</h5>
<p></p>
<h5>SIGNATURE OF THE STUDENT</h5>
<hr>
<hr>
<h2 style="text-align:center">Receipt</h2>
<div style="text-align:right">Form No : {{ucwords($newEnquiry->form_no)}}</div>
<p>Received from Mr. /Miss___________________________________________________________
   the waiting list form for Class.</p>
Date : ____________<div style="text-align:right">Signature Of Clerk</div>


</body>
</html>
