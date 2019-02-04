<html>
<body>
<table>
    <tr>
        <td width="40%"></td>
        <td><img src="<?php echo url()?>/assets/images/bodyLogo/sspss.jpg" style="width:60px;"></td>
    </tr>
</table>
<table style="text-align:center; width:500px; padding-bottom: 3px">
    <tr>
        <td style="text-align:center; font-size: 80%"><b>S.S.P.Shikshan Sanstha</b></td>
    </tr>
    @if($user['body_id']==1)
    <tr>
        <td style="font-size:120%"><b>Ganesh International School</b></td>
    </tr>
    @else
    <tr>
        <td style="font-size:120%"><b>Ganesh English Medium School</b></td>
    </tr>
    @endif
    <tr>
        <td>Nevale Vasti Gate No. 1157-1160,Chikhali Taluka - Haveli, Dist-Pune.</td>
    </tr>
</table>
<hr>
<table style="text-align:center; width:500px; padding-top: 5px">
    <tr>
        <td style="font-size: 13px"><b>FEE RECEIPT</b></td>
    </tr>
</table>
<table>
    <tr>
        <td style="font-size:110%;" >Receipt No.<span>{{$transaction_details['id']}}</span></td>
        <td style = "text-align:right ">Date: <span>{{date('d-m-Y')}}</span></td>
    </tr>
</table>
<br><br>
<table style="padding-bottom: 5px;padding-top: 2px; height: 10px" border="1px">
    <tr style="height: 1px">
        <td><span>Received with Thanks from Mr./Mrs./Miss</span></td>
        <td>{{$parent_name['first_name']." ".$parent_name['last_name']}}</td>
    </tr>
    <tr>
        <td><span>Student Name</span></td>
        <td>{{$student_name}}</td>
    </tr>
    <tr>
        <td><span>STD</span></td>
        <td> {{$class['class_name']}}</td>
    </tr>
    <tr>
        <td><span>Division</span></td>
        <td> {{$division['division_name']}}</td>
    </tr>
    <tr>
        <td><span>GRN.No</span></td>
        <td>{{$grn['grn']}}</td>
    </tr>
    <tr>
        <td><span>Sum of rupees</span></td>
        <td>Rs. {{$transaction_details['transaction_amount']}}</td>
    </tr>
    <tr>
        <td>Cash/cheque/D.D.No</td>
        <td>{{$transaction_details['transaction_detail']}}</td>
    </tr><tr>
        <td>Dated</td>
        <td>{{date('d-m-y',strtotime($transaction_details['date']))}}</td>
    </tr>
    <tr>
        <td>Bank</td>
        <td></td>
    </tr><tr>
        <td>Branch</td>
        <td></td>
    </tr>
    <tr>
        <td>On account of tuition & other activity fee</td>
        <td></td>
    </tr>
    <tr>
        <td>Rs</td>
        <td>Rs. {{$transaction_details['transaction_amount']}}</td>
    </tr><tr>
        <td>Balance</td>
        <td>Rs. {{$balance}}</td>
    </tr>
</table>
<br>
<table>
    <tr>
        <td>Subject to realization of cheque</td>
    </tr>
</table>
<br><br><br>
<table style="text-align:right; width:500px;">
    <tr>
        <td><b>For Ganesh International School,Chikhali</b></td>
    </tr>
</table>
</body>
</html>