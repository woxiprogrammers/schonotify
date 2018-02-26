<html>
<body>
<table>
    <tr>
        <td width="40%"></td>
        <td><img src="<?php echo url()?>/assets/images/bodyLogo/sspss.jpg" style="width:60px;"></td>
    </tr>
</table>
<table style="text-align:center; width:500px">
    <tr>
        <td style="text-align:center;"><b>S.S.P.Shikshan Sanstha</b></td>
    </tr>
    @if($userData['body_id']==1)
        <tr>
            <td style="font-size:200%"><b>Ganesh International School</b></td>
        </tr>
    @else
        <tr>
            <td style="font-size:200%"><b>Ganesh English Medium School</b></td>
        </tr>
    @endif
    @if($userData['body_id']==1)
        <tr>
            <td>Nevale Vasti Gate No. 1157-1160,Chikhali Taluka - Haveli, Dist-Pune.</td>
        </tr>
    @else
        <tr>
            <td>Ganesh Nagar, Dapodi, Pune-411012.</td>
        </tr>
    @endif
</table>
<br>
<hr>
<table style="text-align:center; width:500px; padding-top: 10px">
    <tr>
        <td style="font-size: 20px"><b>RECEIPT</b></td>
    </tr>
</table>
<br><br>
<table>
    <tr>
        <td style="font-size:120%;" >Receipt No.: <span style="font-size: 120%">{{$userData['id']}}</span></td>
        <td style = "text-align:right ">Date: <span>{{date('d-m-Y')}}</span></td>
    </tr>
</table>
<br><br>
<table cellpadding="5" border="1px">
    <tr>
        <td style="text-align: center">Recieved with thanks from Mr./Mrs./Miss</td>
        <td>{{$userData['parent_name']}}</td>
    </tr>
    <tr>
        <td style="text-align: center">Student Name</td>
        <td>{{$userData['student_name']}}</td>
    </tr>
    <tr>
        <td style="text-align: center">Class</td>
        <td>{{$userData['class']}}</td>
    </tr>
    <tr>
        <td style="text-align: center">Sum Of Rupees</td>
        <td>{{$userData['sum_of_rupee']}}</td>
    </tr>
    <tr>
        <td style="text-align: center">Cash/Cheque/D.D.No.</td>
        <td>{{$userData['transaction_number']}}</td>
    </tr>
    <tr>
        <td style="text-align: center">Date</td>
        <td>{{date('d/m/Y',strtotime($userData['date']))}}</td>
    </tr>
    <tr>
        <td style="text-align: center">Bank</td>
        <td>{{$userData['bank_name']}}</td>
    </tr>
    <tr>
        <td style="text-align: center">Branch</td>
        <td>{{$userData['branch']}}</td>

    </tr>
</table>
<table border="1" cellpadding="5">
    <tr>
        <td style="text-align: center">On Account of</td>
        <td>{{$userData['account_holder_name']}}</td>
    </tr>
</table>
<table border="1" cellpadding="5">
    <tr>
        <td style="text-align: center">Amount.</td>
        <td>{{$userData['rupees']}}</td>
    </tr>
    <tr>
        <td style="text-align: center">Balance</td>
        <td>{{$userData['balance']}}</td>
    </tr>
</table>
<br><br>
<table>
    <tr>
        <td>Subject to realization of cheque</td>
    </tr>
</table>
<br><br><br><br>
<table style="text-align:right; width:500px;">
    <tr>
        <td><b>For Ganesh International School,Chikhali</b></td>
    </tr>
</table>
</body>
</html>