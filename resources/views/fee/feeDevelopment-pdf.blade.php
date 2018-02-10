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
    <tr>
        <td>Nevale Vasti Gate No. 1157-1160,Chikhali Taluka - Haveli, Dist-Pune.</td>
    </tr>
</table>
<br>
<hr>
<table style="text-align:center; width:500px; padding-top: 10px">
    <tr>
        <td style="font-size: 20px"><b>FEE RECEIPT</b></td>
    </tr>
</table>
<br><br>
<table>
    <tr>
        <td style="font-size:120%;" >Receipt No.<span>{{$userData['id']}}</span></td>
        <td style = "text-align:right ">Date: <span>{{date('d-m-Y')}}</span></td>
    </tr>
</table>
<br><br>
<table >

</table>
<br><br>
<table>
    <tr>
        <td>Subject of realization of cheque</td>
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