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
                    <section id="page-title" class="padding-top-15 padding-bottom-15">
                        <div class="row">
                            <div class="col-sm-7">
                                <h1 class="mainTitle">Exam Structure</h1>
                                <span class="mainDescription">Listing</span>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <form method="post" action="structure-create" role="form" id="examStructureForm">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Batch <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="batchDrpdn" style="-webkit-appearance: menulist;">
                                            <option>Select Batch</option>
                                            @foreach($batches as $batch)
                                                <option value="{!! $batch['id'] !!}">{!! $batch['name'] !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4" id="class-select-div" >
                                    <div class="form-group">
                                        <label class="control-label">
                                            Select Class
                                        </label>
                                            <select class="form-control" id="class-select" name="class-select" style="-webkit-appearance: menulist;">
                                            </select>
                                    </div>
                                </div>
                                <div id="loadmoreajaxloaderClass" style="display:none;"></div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Subject <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="subject-select" name="subject_select" style="-webkit-appearance: menulist;">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Sub Subject <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="sub-subject-select" name="sub-subject_select" style="-webkit-appearance: menulist;">
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <table border="1" id="table1" width="100%">

                            </table>
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
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <!-- start: CLIP-TWO JAVASCRIPTS -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/exam-form-validation.js"></script>
    <script src="/assets/js/custom-project.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            $('#batchDrpdn').change(function(){
                var id=this.value;
                var route='get-all-classes/'+id;
                $('div#loadmoreajaxloaderClass').show();
                $.get(route,function(res){
                    if (res.length == 0)
                    {
                        $('#class-select').html("no record found");
                        $('div#loadmoreajaxloaderClass').hide();
                    } else {
                        var str='<option value="">Please select class</option>';
                        for(var i=0; i<res.length; i++)
                        {
                            str+='<option value="'+res[i]['class_id']+'">'+res[i]['class_name']+'</option>';
                        }
                        $('#class-select').html(str);
                        $('div#loadmoreajaxloaderClass').hide();
                    }
                });
            });
            $('#class-select').change(function(){
                var id=this.value;
                var route='get-subjects/'+id;
                $('div#loadmoreajaxloaderClass').show();
                $.get(route,function(res){
                    if (res.length == 0)
                    {
                        $('#subject-select').html("no record found");
                        $('div#loadmoreajaxloaderClass').hide();
                    } else {
                        var str='<option value="">Please select subject</option>';
                        for(var i=0; i<res.length; i++)
                        {
                            str+='<option value="'+res[i]['id']+'">'+res[i]['name']+'</option>';
                        }
                        $('#subject-select').html(str);
                        $('div#loadmoreajaxloaderClass').hide();
                    }
                });
            });
            $('#subject-select').change(function(){
                var id=this.value;
                var route='get-sub-subjects/'+id;
                $('div#loadmoreajaxloaderClass').show();
                $.get(route,function(res){
                    if (res.length == 0)
                    {
                        $('#sub-subject-select').html("no record found");
                        $('div#loadmoreajaxloaderClass').hide();
                    } else {
                        var str='<option value="">Please select sub subject</option>';
                        for(var i=0; i<res.length; i++)
                        {
                            str+='<option value="'+res[i]['id']+'">'+res[i]['sub_subject_name']+'</option>';
                        }
                        $('#sub-subject-select').html(str);
                        $('div#loadmoreajaxloaderClass').hide();
                    }
                });
            });
            $('#sub-subject-select').change(function(){
                var id=this.value;
                $.ajax({
                    method: "get",
                    url: "/exam/get-structure/"+id,
                    success: function(response)
                    {
                        $("#table1").html(response);
                        $("#table1").parent().show();
                    }
                });
            });
        });

    </script>
@stop