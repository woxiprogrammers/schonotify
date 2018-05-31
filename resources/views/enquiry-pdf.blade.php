<html>
<body style="font:Calibri 16px #000;">
<table width="100%" style="border-bottom:2px solid black">
    <tr>
        <td  width="10%">
          <img class="img-responsive" src="/assets/images/bodyLogo/wadia.jpg" style="height:50px"/>
        </td>
        <td width="90%" style="text-align:center;padding:0px;font-size:16px;font-weight:bold">
            <span> Ness Wadia College of Commerce, Pune</span><br>
            <span>Waiting / Merit List Form - 2018-2019</span>
        </td>
    </tr>
</table>

<br><br>
<table style="margin-top:15px;text-align:center;font-size:13px">
  <tr style="font-weight:bolder">
    <td style="border-bottom:1px solid black;width:20%">{{ucwords($newEnquiry->class_applied)}}</td><td  style="width:6%"></td>
    <td style="border-bottom:1px solid black;width:20%">{{ucwords($newEnquiry->medium)}}</td><td  style="width:6%"></td>
    <td style="border-bottom:1px solid black;width:20%">{{ucwords($newEnquiry->date)}}</td><td  style="width:6%"></td>
    <td style="border-bottom:1px solid black;width:20%">{{ucwords($newEnquiry->form_no)}}</td>
  </tr>
  <tr style="font-size:10px">
    <td style="width:20%">CLASS</td><td  style="width:6%"></td>
    <td style="width:20%">MEDIUM</td><td  style="width:6%"></td>
    <td style="width:20%">DATE</td><td  style="width:6%"></td>
    <td style="width:20%">Form No</td>
  </tr>
</table>
<br><br>
<table style="text-align:center;font-size:13px">
  <tr style="font-weight:bolder">
    <td style="border-bottom:1px solid black;width:20%">{{ucwords($newEnquiry->last_name)}}</td><td  style="width:6%"></td>
    <td style="border-bottom:1px solid black;width:20%">{{ucwords($newEnquiry->first_name)}}</td><td  style="width:6%"></td>
    <td style="border-bottom:1px solid black;width:20%">{{ucwords($newEnquiry->middle_name)}}</td><td  style="width:6%"></td>
    <td style="border-bottom:1px solid black;width:20%">{{ucwords($newEnquiry->examination_year)}}</td>
  </tr>
  <tr style="font-size:10px">
    <td style="width:20%">SURNAME</td><td  style="width:6%"></td>
    <td style="width:20%">FIRST NAME</td><td  style="width:6%"></td>
    <td style="width:20%">MIDDLE NAME</td><td  style="width:6%"></td>
    <td style="width:20%">YEAR OF PASSING</td>
  </tr>
</table>
<br><br>
<table style="text-align:center;font-size:13px">
  <tr style="font-weight:bolder">
    <td style="border-bottom:1px solid black;width:20%">{{ucwords($newEnquiry->marks_obtained)}}</td><td  style="width:6%"></td>
    <td style="border-bottom:1px solid black;width:20%">{{ucwords($newEnquiry->outOf_marks)}}</td><td  style="width:6%"></td>
    <td style="border-bottom:1px solid black;width:20%">{{number_format($newEnquiry->percentage,2)}}</td><td  style="width:6%"></td>
    <td style="border-bottom:1px solid black;width:20%">{{ucwords($newEnquiry->board)}}</td>
  </tr>
  <tr style="font-size:10px">
    <td style="width:20%">Total Marks Obtained</td><td  style="width:6%"></td>
    <td style="width:20%">Total Marks Out Of</td><td  style="width:6%"></td>
    <td style="width:20%">% Of Marks</td><td  style="width:6%"></td>
    <td style="width:20%">Examination Board</td>
  </tr>
</table>
<br><br>
<table style="text-align:center;font-size:13px">
  <tr style="font-weight:bolder">
    <td style="border-bottom:1px solid black;width:20%">{{ucwords($newEnquiry->state)}}</td><td  style="width:6%"></td>
    {{--<td style="border-bottom:1px solid black;width:20%">{{$newEnquiry->diff_category}}</td><td  style="width:6%"></td>--}}
    <td style="border-bottom:1px solid black;width:20%">{{$newEnquiry->category}}</td><td  style="width:6%"></td>
    <td style="border-bottom:1px solid black;width:20%">{{ucwords($newEnquiry->caste)}}</td>
    <td></td>
  </tr>
  <tr style="font-size:10px">
    <td style="width:20%">State From Which XII Std Passed</td><td  style="width:6%"></td>
    {{--<td style="width:20%">Defence / Differently Abled Category</td><td  style="width:6%"></td>--}}
    <td style="width:20%">Caste / Special Category</td><td  style="width:6%"></td>
    <td style="width:20%">Name Of The Caste / Sub Caste</td>
    <td></td>
  </tr>
</table>
<br><br>
<table style="text-align:center;font-size:11px">
  <tr>
  <td>My Address</td><td style="border-bottom:1px solid black;font-weight:bolder;font-size:13px" colspan="3">{{ucwords($newEnquiry->address)}}</td>
  </tr>
  <tr><td>Mobile No</td><td colspan="3" style="border-bottom:1px solid black;font-weight:bolder;font-size:13px">{{ucwords($newEnquiry->mobile)}}</td>
  </tr>
  <tr>
    <td>Email Id</td><td colspan="3" style="border-bottom:1px solid black;font-weight:bolder;font-size:13px">{{ucwords($newEnquiry->email)}}</td>
  </tr>
</table>
<br>
<br>
<!--<span  style="font-weight:bolder;font-size:10px">Attachments:</span><br>
<span style="font-size:9px;padding:5px">Photocopy of 1) XII MarkList 2) XII Leaving Certificate 3) Caste Certificate(if applicable)
                                       4) Differently abled certificate(if applicable) 5) Defence Certificate issued by Zilla Sainik Board ,Pune(if applicable)
</span>--><br/><br/><br/>
<span  style="font-weight:bolder;font-size:10px">Important Notes:</span><br>
<span style="font-size:9px;padding:5px">1. Once offered Category / Medium can not be changed.&nbsp;&nbsp;&nbsp;&nbsp;Student can offer one category at a time.
<br>2. I know that this is a waitinglist form and not admission form.I will not have claim over
admission if I do not fulfill the terms and conditions.
<br>3. Student has to mention all subject marks and not Best Four/Five marks.
<br><span style="font-weight:bolder;">4. Kindly note that the Reserved Category students from other than Maharashtra State will not be considered for
   admission under Reserved Category students. Such student will be considered as OPEN CATEGORY STUDENT.</span>
<br/><span style="font-weight:bold;font-size:13px;">5. Hard Copy of Waiting/Merit List form NEED NOT be submitted at the college office.</span>
<br/><br/>
<br/><br/>
<h5>Thanking You</h5>
<!--<h5>Your's faithfully</h5>
<p></p>
<h5>SIGNATURE OF THE STUDENT</h5>
<hr>
<hr>
<h2 style="text-align:center">Receipt</h2>
<div style="text-align:right">Form No : <b>{{ucwords($newEnquiry->form_no)}}</b></div>
<p>Received from Mr. /Miss <u><b>  {{ucwords($newEnquiry->last_name)}}  {{ucwords($newEnquiry->first_name)}}  {{ucwords($newEnquiry->middle_name)}} </b></u>
   the<u> Waiting/Merit List </u> form for  <u><b>{{ucwords($newEnquiry->class_applied)}}</b></u>  Class for 2018-2019.</p>
Date : <b>{{ucwords($newEnquiry->date)}}</b><div style="text-align:right">Signature Of Clerk</div>

-->
</body>
</html>
