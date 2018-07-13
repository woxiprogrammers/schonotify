<?php
/**
 * Created by PhpStorm.
 * User: Nishank Rathod
 * Date: 4/23/18
 * Time: 2:54 PM
 */
?>
@extends('master')
@section('content')
    <div id="app">
        @include('sidebar')
        <div class="app-content">
            <!-- start: TOP NAVBAR -->
        @include('header')
        <!-- end: TOP NAVBAR -->
            <div class="main-content" >
                <div class="wrap-content container" id="container">
                    <!-- start: DASHBOARD TITLE -->
                    @include('alerts.errors')
                    <div id="message-error-div"></div>
                    <div style="margin-left: 40%">S.S.P Shikshan Sanstha's</div>
                    <div><span style="margin-left: 35%;font-size: 150%"><b>Ganesh International School</b></span></div>
                    <div><span style="margin-left: 25%;"><b>Gat No. 1158, Newale Wasti, Chikhali, Pune-411062. Tel.No.:020-65290055</b></span></div>
                    <div><span style="margin-left: 40%;">E- Mail :hr.gispune@gmail.com</span></div>
                    <div><span style="margin-left: 40%;">www.ganeshinternationalschool.com</span></div>
                    <div style="margin-left: 30%"><span>UDISE No - 27252001510<span style="padding-left: 7%">CBSE Affiliation No. 1130632</span></span></div>
                    <div style="margin-left: 40%;font-size: 150%"><span><b>LEAVING CERTIFICATE</b></span></div>
                    <div style="margin-left: 5%">Certificate No. <span>{{$studentData['id']}}</span><span style="padding-left: 60%">Register No. of the pupil : <span>{{$studentData['grn']}}</span></span></div>
                    <br>
                    <table border="1" style="width: 85%; text-align: left; margin-left: 05%">
                        <tr>
                            <td style="padding: 1%">
                                1. Name of the pupil in full
                            </td>
                            <td width="70%;" style="padding: 1%">
                                <span><b>{{strtoupper($studentData['first_name'])}}&nbsp;&nbsp;{{strtoupper($studentData['father_first_name'])}}&nbsp; {{strtoupper($studentData['last_name'])}}</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 1%">
                                2. Name of the mother in full
                            </td>
                            <td style="padding: 1%">
                                <span><b>{{strtoupper($studentData['mother_first_name'])}}</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 1%">
                                3. Religion Caste Sub-caste
                            </td>
                            <td style="padding: 1%">
                                <span><b>{{strtoupper($studentData['religion'])}}&nbsp;&nbsp; {{strtoupper($studentData['caste'])}}&nbsp;&nbsp; {{strtoupper($studentData['category'])}}</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 1%">
                                4. Nationality
                            </td>
                            <td style="padding: 1%">
                                <span><b>{{strtoupper($studentData['nationality'])}}</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 1%">
                                5. Birth of place
                            </td>
                            <td style="padding: 1%">
                                <span><b>{{strtoupper($studentData['birth_place'])}}</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 1%">
                                6.  Mother Tongue
                            </td>
                            <td style="padding: 1%">
                                <span><b>{{strtoupper($studentData['mother_tongue'])}}</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 1%">
                                7.  Adhar Card Number
                            </td>
                            <td style="padding: 1%">
                                <span><b>{{strtoupper($studentData['aadhar_number'])}}</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 1%">
                                8.  Date of birth
                            </td>
                            <td style="padding: 1%">
                                <span><b>{{date('d/m/Y',strtotime($studentData['birth_date']))}}&nbsp;&nbsp;<i>( {{ucwords($birthDayInWords)}})</i></b></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 1%">
                                9. Last school attended
                            </td>
                            <td style="padding: 1%">
                                <span><b>{{strtoupper($studentData['last_school_attented'])}}</b>></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 1%">
                                10.  Date of Admission
                            </td>
                            <td style="padding: 1%">
                                <span><b>{{date('d/m/Y',strtotime($studentData['date_of_admission']))}}</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 1%">
                                11. Progress
                            </td>
                            <td style="padding: 1%">
                                <span><b>{{strtoupper($studentData['progress'])}}</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 1%">
                                12.  Conduct
                            </td>
                            <td style="padding: 1%">
                                <span><b>{{strtoupper($studentData['conduct'])}}</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 1%">
                                13.  Date of Living School
                            </td>
                            <td style="padding: 1%">
                                <span><b>{{date('d/m/Y',strtotime($studentData['date_of_leaving']))}}</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 1%">
                                14.  Standard in which studing and since when
                            </td>
                            <td style="padding: 1%">
                                <span><b>{{strtoupper($studentData['standard_in_which_studying'])}}</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 1%">
                                15. Reason of living School
                            </td>
                            <td style="padding: 1%">
                                <span><b>{{strtoupper($studentData['reason'])}}</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 1%">
                                16.  Remark
                            </td>
                            <td style="padding: 1%">
                                <span><b>{{strtoupper($studentData['remark'])}}</b></span>
                            </td>
                        </tr>
                    </table>
                    <div style="padding-left: 25%">Certified that the above information is in according with the school Register.</div>
                    <br>
                    <div style="margin-left: 5%">Date: {{date('d/m/Y')}}</div>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
@stop