<?php
/**
 * Created by Ameya Joshi.
 * Date: 7/4/18
 * Time: 12:36 PM
 */
?>

<html>
    <head>
        <style>
            #bonafideTable {
                border-collapse:separate;
                border:solid black 1px;
                border-radius:6px;
                -moz-border-radius:6px;
                height: 50px;
                text-align: center;
            }

            #bonafideTable td,#bonafideTable th {
                /*border-left:solid black 1px;*/
                border-top:solid black 1px;
            }

            #bonafideTable th {
                /*background-color: blue;*/
                border-top: none;
            }

            #bonafideTable td:first-child, #bonafideTable th:first-child {
                border-left: none;
            }
        </style>
    </head>
    <body>
        <div style="width: 100%; border: 1px solid black; padding: 20px; border-radius: 20px;">
            <table style="font-size: 15px">
            <tr style="height: 80px;">
                <td colspan="2" style="font-size: 18px;">
                    @if($data['body_id'] == 1)
                        <b>Name of School : GANESH INTERNATIONAL SCHOOL,CHIKHALI</b>
                    @else
                        <b>Name of School : GANESH ENGLISH MEDIUM SCHOOL,DAPODI</b>
                    @endif
                </td>
            </tr>
            <tr style="height: 80px;">
                <td style="width: 150px"><br>
                    <table id="bonafideTable">
                        <tr>
                            <th>
                                <span>Gen. Reg. No.</span>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <span>{{$data['grn']}}</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style=" width: 600px; padding-left: 110px"><br>
                    <span><h3><b> BONAFIDE CERTIFICATE</b></h3></span>
                </td>
            </tr>
            <tr>
                <td colspan="2" ><br><br>
                    <div style="font-size: 15px; width: 680px !important;line-height: 30px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        This is to certify that Master / Miss &nbsp;<b><i> {{$data['first_name']}} {{$data['last_name']}} </i></b>&nbsp; is / was a bonafide student of this School studying in Std. &nbsp;<b><i> {{$data['class']['class_name']}} </i></b>&nbsp; Div. &nbsp;<b><i> {{$data['class']['division_name']}} </i></b>
                        &nbsp;during the year &nbsp;<b><i>{{date('Y',strtotime($data['from_date']))}} - {{date('Y',strtotime($data['to_date']))}}</i></b>&nbsp;. Mother's name is &nbsp;<b><i> {{$data['parent']['mother_first_name']}} {{$data['parent']['mother_middle_name']}} {{$data['parent']['mother_last_name']}}</i></b>.
                        &nbsp;He / She is <b><i> {{$data['caste']}} </i></b>&nbsp; by caste.
                        &nbsp;His / Her date of Birth according to our Register is &nbsp;<b><i>{{date('d/m/Y',strtotime($data['birth_date'])) }}</i></b>&nbsp;
                        (In words &nbsp;<b><i>{{$data['words']}}</i></b>)&nbsp;
                        His / Her place of Birth is &nbsp;<b><i>{{$data['birth_place']}}</i></b>&nbsp; Tal. <b><i>&nbsp; {{$data['taluka']}} </i></b>&nbsp; Dist. &nbsp;<b><i> {{$data['district']}}</i></b>
                        He / She bears a good moral character.
                    </div>
                </td>
            </tr>
            <tr style="font-size: 15px">
                <td colspan="2">
                    <br><br><br><br><br>
                    <span style="margin-left: 50px">Date : {{date("d/m/Y")}}</span>
                    <span style="margin-left: 300px">H.M. / Principal</span>
                </td>
            </tr>
        </table>
        </div>
    </body>
</html>
