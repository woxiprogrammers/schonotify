<?php
/**
 * Created by Ameya Joshi.
 * Date: 7/4/18
 * Time: 12:14 PM
 */?>
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
                    <!-- start: DASHBOARD TITLE --><br><br><br>
                    @include('alerts.errors')
                    <div id="message-error-div"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <fieldset>
                                <legend style="margin-left: 40%">Bonafide Certificate</legend>
                                <div style="width: 100%; border: 1px solid black; padding: 20px; border-radius: 20px;">
                                    <table style="font-size: 15px">
                                        <tr style="height: 80px;">
                                            <td colspan="2" style="font-size: 18px;">
                                                 <b>Name of School : {{$data['name']}}</b>
                                            </td>
                                        </tr>
                                        <tr style="height: 80px;">
                                            <td style="width: 260px">
                                                <table id="bonafideTable">
                                                    <tr>
                                                        <th>
                                                            <span style="margin-left: 19px">Gen. Reg. No.</span>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span style="margin-left: 30%"> {{$data['grn']}}</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td style=" width: 600px; padding-left: 150px">
                                                <span><h3><b> BONAFIDE CERTIFICATE</b></h3></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" >
                                                <div style="font-size: 18px">
                                                    <p style="margin-top: 30px">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        This is to certify that Master / Miss &nbsp;<b><i> {{$data['first_name']}} {{$data['last_name']}} </i></b>&nbsp;&nbsp; is / was a bonafide student of this School studying in Std. <b><i> {{$data['class']['class_name']}} </i></b> Div. <b><i> {{$data['class']['division_name']}} </i></b>
                                                        during the year &nbsp;<b><i>{{date('Y',strtotime($data['from_date']))}} - {{date('Y',strtotime($data['to_date']))}}</i></b>. Mother's name is <b><i> {{$data['parent']['mother_first_name']}} {{$data['parent']['mother_middle_name']}} {{$data['parent']['mother_last_name']}}</i></b>.
                                                        He / She is <b><i> {{$data['caste']}} </i></b> by caste.
                                                        His / Her date of Birth according to our Register is <b><i>{{date('d/m/Y',strtotime($data['birth_date'])) }}</i></b>
                                                        (In words <b><i>  {{$data['words']}}  </i></b>)
                                                        His / Her place of Birth is <b><i>{{$data['birth_place']}}</i></b> Tal. <b><i> {{$data['taluka']}} </i></b> Dist. <b><i> {{$data['district']}}</i></b>
                                                        He / She bears a good moral character.
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="font-size: 18px">
                                            <td colspan="2">
                                                <br><br><br><br><br>
                                                <span style="margin-left: 100px">Date : {{date("d/m/Y")}}</span>
                                                <span style="margin-left: 300px">H.M. / Principal</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop
