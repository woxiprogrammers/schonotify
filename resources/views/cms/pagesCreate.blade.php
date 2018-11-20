<?php
/**
 * Created by PhpStorm.
 * User: Nishank Rathod
 * Date: 10/1/18
 * Time: 12:01 PM
 */
?>

@extends('master')
@section('content')
    <div id="app">
        @include('sidebar')
        <div class="app-content">
            @include('header')
            <div class="main-content" >
                <div class="wrap-content container" id="container">
                    @include('alerts.errors')
                    <div id="message-error-div"></div>
                    <section id="page-title" class="padding-top-15 padding-bottom-15">
                        <div class="row">
                            <div class="col-sm-7">
                                <h1 class="mainTitle">Pages</h1>
                                <span class="mainDescription">Create</span>
                            </div>
                            <div class="col-sm-5">
                                <!-- start: MINI STATS WITH SPARKLINE -->
                                <!-- end: MINI STATS WITH SPARKLINE -->
                            </div>
                        </div>
                        <div class="row pull-right">
                            <a href="/cms/manage">Back</a>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <form action="/cms/sub-pages" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Main Menu :
                                        </label>
                                        <select class="form-control" name="main_pages" style="-webkit-appearance: menulist;">
                                            <option value="">Select Main Pages</option>
                                            @foreach($tabNames as $tabname)
                                            <option value="{{$tabname['slug']}}">{{$tabname['display_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Title :
                                        </label>
                                        <input type="text" class="form-control" name="sub_tab_name" placeholder="Enter title">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="control-label">
                                    Description :
                                </label>
                                <div class="col-md-12">
                                    <textarea id="" name="page_description" cols="50" rows="4"> </textarea>
                                </div>
                            </div>
                            <br><br>
                            <div class="row">
                                    <div class="form-group col-md-12">
                                        <button class="btn btn-primary btn-wide pull-right" type="submit">
                                            Save <i class="fa fa-arrow-circle-right"></i>
                                        </button>
                                    </div>
                                </div>
                        </form>
                    </div>
                    @include('rightSidebar')
                </div>
            </div>
        </div>
        @include('footer')
    </div>
    <!-- start: MAIN JAVASCRIPTS -->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/vendor/modernizr/modernizr.js"></script>
    <script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/vendor/switchery/switchery.min.js"></script>
    <script src="/vendor/selectFx/classie.js"></script>
    <script src="/vendor/selectFx/selectFx.js"></script>
    <script src="/vendor/ckeditor/ckeditor.js"></script>
    <script src="/vendor/ckeditor/adapters/jquery.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="/vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
    <script src="/vendor/maskedinput/jquery.maskedinput.min.js"></script>
    <script src="/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="/vendor/autosize/autosize.min.js"></script>
    <script src="/vendor/selectFx/classie.js"></script>
    <script src="/vendor/selectFx/selectFx.js"></script>
    <script src="/vendor/select2/select2.min.js"></script>
    <script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="/vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <!-- start: CLIP-TWO JAVASCRIPTS -->
    <script src="/assets/js/form-validation-edit.js"></script>
    <script src="/vendor/DataTables/jquery.dataTables.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/form-elements.js"></script>
    <script src="/assets/js/custom-project.js"></script>
    <script src="/assets/js/table-data.js"></script>
    <script src="/assets/js/form-validation.js"></script>
    <script>
        $(document).ready(function (){
            $("textarea").ckeditor();
        });
    </script>
@stop

