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
                            <fieldset>
                                    <div style="margin-left: 30%">S.S.P Shikshan Sanstha's</div>
                                    <div><span style="margin-left: 25%;font-size: 150%"><b>Ganesh International School</b></span></div>
                                    <div><span style="margin-left: 15%;"><b>Gat No. 1158, Newale Wasti, Chikhali, Pune-411062. Tel.No.:020-65290055</b></span></div>
                                    <div><span style="margin-left: 30%;">E- Mail :hr.gispune@gmail.com</span></div>
                                    <div><span style="margin-left: 30%;">www.ganeshinternationalschool.com</span></div>
                                    <div style="margin-left: 20%"><span>UDISE No-27252001510<span style="padding-left: 7%">CBSE Affiliation No.1130632</span></span></div>
                                    <div style="margin-left: 30%;font-size: 150%"><span><b>Living Certificate</b></span></div>
                                    <div>Certificate No.1<span style="padding-left: 55%">Register No. of the pupil</span></div>
                            </fieldset>
                            <table border="1" style="width: 85%; text-align: left;">
                                <tr>
                                    <td style="padding: 1%">
                                       1. Name of the pupil in full
                                    </td>
                                    <td width="70%;" style="padding: 1%">
                                        Nishank Rathod
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 1%">
                                       2. Name of the pupil in full
                                    </td>
                                    <td style="padding: 1%">
                                        Nishank Rathod
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 1%">
                                      3. Name of the pupil in full
                                    </td>
                                    <td style="padding: 1%">
                                        Nishank Rathod
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 1%">
                                       4. Name of the pupil in full
                                    </td>
                                    <td style="padding: 1%">
                                        Nishank Rathod
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 1%">
                                       5. Name of the pupil in full
                                    </td>
                                    <td style="padding: 1%">
                                        Nishank Rathod
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 1%">
                                      6.  Name of the pupil in full
                                    </td>
                                    <td style="padding: 1%">
                                        Nishank Rathod
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 1%">
                                      7.  Name of the pupil in full
                                    </td>
                                    <td style="padding: 1%">
                                        Nishank Rathod
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 1%">
                                      8.  Name of the pupil in full
                                    </td>
                                    <td style="padding: 1%">
                                        Nishank Rathod
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 1%">
                                       9. Name of the pupil in full
                                    </td>
                                    <td style="padding: 1%">
                                        Nishank Rathod
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 1%">
                                      10.  Name of the pupil in full
                                    </td>
                                    <td style="padding: 1%">
                                        Nishank Rathod
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 1%">
                                       11. Name of the pupil in full
                                    </td>
                                    <td style="padding: 1%">
                                        Nishank Rathod
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 1%">
                                      12.  Name of the pupil in full
                                    </td>
                                    <td style="padding: 1%">
                                        Nishank Rathod
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 1%">
                                      13.  Name of the pupil in full
                                    </td>
                                    <td style="padding: 1%">
                                        Nishank Rathod
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 1%">
                                      14.  Name of the pupil in full
                                    </td>
                                    <td style="padding: 1%">
                                        Nishank Rathod
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 1%">
                                       15. Name of the pupil in full
                                    </td>
                                    <td style="padding: 1%">
                                        Nishank Rathod
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 1%">
                                      16.  Name of the pupil in full
                                    </td>
                                    <td style="padding: 1%">
                                        Nishank Rathod
                                    </td>
                                </tr>
                            </table>
                    <div style="padding-left: 20%">Certified that the above information is in according with the school Register.</div>
                    <div>Date: {{date('d/m/Y')}}</div>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
@stop
