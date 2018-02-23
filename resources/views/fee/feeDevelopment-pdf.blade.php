<html>
<body>
<table>
    <tr>
        <td width="40%"></td>
        <td><img src="<?php echo url()?>/assets/images/bodyLogo/sspss.jpg" style="width:60px;"></td>
    </tr>
</table>
<table style="text-align:center; width:500px">
    @if($userData['body_id'] == 1)
    <tr>
        <td style="text-align:center;"><b>S.S.P.SHIKSHAN SANSTHA'S</b></td>
    </tr>
    @else
    <tr>
        <td>Sr.No. 15/1, Ganesh Nagar,Dapodi,Pune 411012.</td>
    </tr>
    @endif
</table>
<br>
<hr>
<table style="text-align:center; width:500px; padding-top: 10px">
    <tr>
        <td style="font-size: 20px"><b><u>RECEIPT</u></b></td>
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
        <td><u>{{$userData['parent_name']}}</u></td>
    </tr>
    <tr>
        <td style="text-align: center">Student Name</td>
        <td><u>{{$userData['student_name']}}</u></td>
    </tr>
    <tr>
        <td style="text-align: center">Class</td>
        <td><u>{{$userData['class']}}</u></td>
    </tr>
    <tr>
         <td style="text-align: center">Sum Of Rupees</td>
         <td><u>{{$userData['sum_of_rupee']}}</u></td>
     </tr>
    <tr>
        <td style="text-align: center">Cash/Cheque/D.D.No.</td>
        <td><u>{{$userData['transaction_number']}}</u></td>
    </tr>
    <tr>
        <td style="text-align: center">Date</td>
        <td><u>{{date('d/m/Y',strtotime($userData['date']))}}</u></td>
    </tr>
</table>
<table border="1" cellpadding="5">
    <tr>
        <td style="text-align: center">Bank</td>
        <td><u>{{$userData['bank_name']}}</u></td>

    </tr>
    <tr>
        <td style="text-align: center">On Account of</td>
        <td><u>{{$userData['account_holder_name']}}</u></td>
    </tr>
</table>
<br><br><br>
<table>
    <tr>
        <td style="font-size: 110%">Subject to realization of cheque</td>
    </tr>
    <br>
    <tr>
        <td>*Tax deduction exemption under section</td>
    </tr>
    <tr>
        <td>80 G(S)(vi) of the income Tax act,1961</td>
    </tr>
    <tr>
        <td>Vide the commission of Income tax (v) pune's order no.</td>
    </tr>
    <tr>
        <td>PN/CIT-Tech/80 G/ 02/84/ 12/45/2013-14/2177 dated 11.11.2013</td>
    </tr>
</table>
<br><br><br><br>
<table style="text-align:right; width:105%">
    <tr>
        <td><b>For S.S.P.SHISKSHAN SANSTHA'S</b></td>
    </tr>
</table>
</body>
</html>