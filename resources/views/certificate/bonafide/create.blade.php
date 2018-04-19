<?php
/**
 * Created by Ameya Joshi.
 * Date: 7/4/18
 * Time: 11:56 AM
 */
?>

@extends('master')

@section('content')
    <style>
        #bonafideTable {
            border-collapse:separate;
            border:solid black 1px;
            border-radius:6px;
            -moz-border-radius:6px;
            width: 150px;
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
                                <h1 class="mainTitle">Create Bonafide Certificate</h1>
                            </div>
                        </div>
                    </section>
                    <div id="message-error-div"></div>
                    <!-- end: DASHBOARD TITLE -->
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" action="" role="form" id="bonafideCreateForm">
                                    {!! csrf_field() !!}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    GRN <span class="symbol required"></span>
                                                </label>
                                                <input type="text" class="form-control" name="grn" id="grn" required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label">&nbsp;
                                            </label>
                                            <div class="form-group">
                                                <button class="btn btn-primary btn-wide" type="submit">
                                                    Create <i class="fa fa-arrow-circle-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="bonafideDiv">

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
    <script src="/assets/js/certificates/bonafide.js"></script>
@stop


