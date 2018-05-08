<?php
/**
 * Created by PhpStorm.
 * User: Nishank Rathod
 * Date: 4/19/18
 * Time: 5:09 PM
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
                    <section id="page-title" class="padding-top-15 padding-bottom-15">
                        <div class="row">
                            <div class="col-sm-7">
                                <h1 class="mainTitle">Edit Living Certificate</h1>
                            </div>
                        </div>
                    </section>
                    <div id="message-error-div"></div>
                    <!-- end: DASHBOARD TITLE -->
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" action="/certificates/livingCertificate/editForm/{{$livingCertificateData['id']}}/{{$livingCertificateData['grn']}}" role="form" id="livingCertificateEdit">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Aadhar Card No. <span class="symbol required"></span>
                                                </label>
                                                    <input type="text" class="form-control" name="aadharCard" id="aadharCard" value="{{$livingCertificateData['aadhar_number']}}" required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Last School Attended  <span class="symbol required"></span>
                                                </label>
                                                <input type="text" class="form-control" name="lastSchool" id="lastSchool" value="{{$livingCertificateData['last_school_attented']}}"  required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Date of Admission <span class="symbol required"></span>
                                                </label>
                                                <input type="date" class="form-control" name="admissionDate" id="admissionDate" value="{{$livingCertificateData['date_of_admission']}}"  required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Progress <span class="symbol required"></span>
                                                </label>
                                                <input type="text" class="form-control" name="progress" id="progress" value="{{$livingCertificateData['progress']}}"  required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Conduct <span class="symbol required"></span>
                                                </label>
                                                <input type="text" class="form-control" name="conduct" id="conduct" value="{{$livingCertificateData['conduct']}}"  required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Date of living School <span class="symbol required"></span>
                                                </label>
                                                <input type="date" class="form-control" name="livingSchoolDate" id="livingSchoolDate" value="{{$livingCertificateData['date_of_leaving']}}"  required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Std. in which studying from when <span class="symbol required"></span>
                                                </label>
                                                <input type="text" class="form-control" name="standard_studying_from_when" id="standard_studying_from_when" value="{{$livingCertificateData['standard_in_which_studying']}}"  required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Reason of leaving School <span class="symbol required"></span>
                                                </label>
                                                <input type="text" class="form-control" name="reason" id="reason" value="{{$livingCertificateData['reason']}}"  required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Remarks <span class="symbol required"></span>
                                                </label>
                                                <input type="text" class="form-control" name="remark" id="remark" value="{{$livingCertificateData['remark']}}"  required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label">&nbsp;
                                            </label>
                                            <div class="form-group">
                                                <button class="btn btn-primary btn-wide" id="create" type="submit">
                                                    Update <i class="fa fa-arrow-circle-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('footer')

        @include('rightSidebar')

    </div>
    {{--<div id="loadmoreajaxloader" class="loader-position-event" ><center><img src="/assets/images/loader1.gif" /></center></div>--}}
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/vendor/modernizr/modernizr.js"></script>
    <script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/vendor/switchery/switchery.min.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <script src="/vendor/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
    <script src="/vendor/moment/moment.min.js"></script>
    <script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <script src="/assets/js/certificates/livingcertificate.js"></script>
@stop
