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
                                <h1 class="mainTitle">Timetable</h1>
                                <span class="mainDescription">Create</span>
                            </div>
                            <div class="col-sm-5">
                                <!-- start: MINI STATS WITH SPARKLINE -->

                                <!-- end: MINI STATS WITH SPARKLINE -->
                            </div>
                        </div>
                    </section>

                    <div class="container-fluid container-fullw bg-white">

                        <div class="row">

                            <div class="col-sm-12">
                                <div class="panel panel-transparent">

                                    <div class="panel-body">

                                        <label>Create Timetable For :</label>

                                        @foreach($divisions as $division)
                                            <span class="lato-font">Batch : {!! $division->batch_name !!}   Class : {!! $division->class_name !!}  Division : {!! $division->division_name !!}</span>
                                                <input type="hidden" id="hiddenBatchId" name="hiddenBatchId" value="{!! $division->batch_id !!}">
                                                <input type="hidden" id="hiddenClassId" name="hiddenClassId" value="{!! $division->class_id !!}">
                                                <input type="hidden" id="hiddenDivId" name="hiddenDivId" value="{!! $division->division_id !!}">
                                        @endforeach

                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-sm-12">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="errorHandler alert alert-danger no-display">
                                                    <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                                                </div>
                                                <div class="successHandler alert alert-success no-display">
                                                    <i class="fa fa-ok"></i> Your form validation is successful!
                                                </div>
                                            </div>

                                            <div class="col-md-12">

                                                <form role="form" id="createStructureForm">

                                                    <div class="form-group col-md-4">
                                                        <label class="control-label">
                                                            Day <span class="symbol required"></span>
                                                        </label>
                                                        <select class="form-control" id="dropdown" name="dropdown" style="-webkit-appearance: menulist;">
                                                            <option value="">Select Days</option>
                                                            @foreach($days as $day)
                                                                <option value="{!! $day->id !!}">{!! $day->name !!}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label class="control-label">
                                                            Number of periods: <span class="symbol required"></span>
                                                        </label>
                                                        <input type="number" min="0" max="55" class="form-control" id="periods" name="periods">
                                                    </div>

                                                    <div class="col-md-3">
                                                        <button class="btn" style="margin:22px 0px 0px 0px;" type="submit" id="structure-create">
                                                            Create <i class="fa fa-arrow-circle-right"></i>
                                                        </button>
                                                    </div>

                                                </form>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                        <div class="errorHandler alert alert-danger no-display">
                                                            <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                                                        </div>
                                                        <div class="successHandler alert alert-success no-display">
                                                            <i class="fa fa-ok"></i> Your form validation is successful!
                                                        </div>

                                                        <div class="col-md-12">

                                                            <div class="col-md-12" id="main-div-periods">
                                                               <form action="create-timetable" method="post" role="form" id="timeTableForm">

                                                                   @foreach($divisions as $division)

                                                                   <input type="hidden" id="hiddenFormDivId" name="hiddenFormDivId" value="{!! $division->division_id !!}">

                                                                   @endforeach

                                                                    <div id="periods-rows"></div>
                                                                    <input type="hidden" name="day" id="hiddenDay">
                                                                    <div class="col-md-3" id="periods-structure-save-btn">
                                                                        <button class="btn btn-primary" style="margin:22px 0px 0px 0px;" type="button" id="btnSubmitStructure">
                                                                            Create <i class="fa fa-arrow-circle-right"></i>
                                                                        </button>
                                                                    </div>

                                                                </form>
                                                            </div>

                                                        </div>
                                                </div>

                                            </div>

                                        </div>

                                </div>

                            </div>

                        </div>
                    </div>

                    @include('rightSidebar')

                </div>

            </div>

        </div>

        @include('footer')

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/modernizr/modernizr.js"></script>
    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="vendor/switchery/switchery.min.js"></script>
    <script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
    <script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="vendor/autosize/autosize.min.js"></script>
    <script src="vendor/selectFx/classie.js"></script>
    <script src="vendor/selectFx/selectFx.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="vendor/ckeditor/ckeditor.js"></script>
    <script src="vendor/ckeditor/adapters/jquery.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="assets/js/form-validation.js"></script>
    <script src="assets/js/form-elements.js"></script>
    <script src="assets/js/custom-project.js"></script>

    <script>
        $(document).ready(function(){
            getMsgCount();
            Main.init();
            FormValidator.init();

            $('#periods-structure-save-btn').hide();

            $('#main-div-periods').hide();

            });

        $('#btnSubmitStructure').click(function(){

            var num = 1;

            var flag = 1;

            $('input[name="endTime[]"]').each(function(){

                if($('#subjects_'+num).val() == "unavailable") {
                    $("#subjectError"+num).show();
                    $("#subjectError"+num).html('There are no subjects available for this division.');
                    flag = 0;
                    return false;
                } else {
                    $("#subjectError"+num).hide();
                    $("#subjectError"+num).html('');

                }

                var startTime = $("#startTime"+num).val();

                var endTime = $("#endTime"+num).val();

                var st = minFromMidnight(startTime);

                var et = minFromMidnight(endTime);

                 if ( st >= et ) {

                     $("#startTimeError"+num).show();
                     $("#startTimeError"+num).html('End time must be greater than start time.');
                     flag = 0;
                     return false;

                 } else {
                     $("#startTimeError"+num).show();
                     $("#startTimeError"+num).html('');

                     var startTime = $("#startTime"+num).val();

                     var endTime = $("#endTime"+num).val();

                     var st = minFromMidnight(startTime);

                     var et = minFromMidnight(endTime);

                     var numInner = 1;

                     $('input[name="endTime[]"]').each(function(){

                         if(num != numInner) {
                             var startTime1 = $("#startTime"+numInner).val();

                             var endTime1 = $("#endTime"+numInner).val();

                             var st1 = minFromMidnight(startTime1);

                             var et1 = minFromMidnight(endTime1);

                             if(st1 < st && et1 > st) {
                                 $("#startTimeError"+num).show();
                                 $("#startTimeError"+num).html('Periods never be in same time interval or in between any other time interval. ');

                                 flag = 0;
                                 return false;
                             } else if(st1 < et && et1 > et) {
                                 $("#startTimeError"+num).show();
                                 $("#startTimeError"+num).html('Periods never be in same time interval or in between any other time interval. ');

                                 flag = 0;
                                 return false;
                             } else if (st == st1) {
                                 $("#startTimeError"+num).show();
                                 $("#startTimeError"+num).html('Periods never be in same time interval or in between any other time interval. ');

                                 flag = 0;
                                 return false;
                             }
                         }
                         numInner++;

                     });

                 }

                num++;

            });


            if( flag == 1 ) {

                var num = 1;

                $('input[name="endTime[]"]').each(function(){

                    var startTime = $("#startTime"+num).val();

                    var endTime = $("#endTime"+num).val();

                    var id = $("#subjects_"+num).val();

                    var day = $("#dropdown").val();

                    var checkValue = $('#hiddenCheck'+num).val();

                    if(checkValue == 0) {
                        var route = "/teacher-check";

                        $.ajax({
                            url:route,
                            async:false,
                            type:"post",
                            data:{id:id,day:day,startTime:startTime,endTime:endTime},
                            success:function(res){
                                if( res != 0 ) {

                                    flag = 0;

                                } else {
                                    flag = 1;
                                }
                            }

                        });

                        if( flag == 0 ) {
                            $('#subjectError'+num).show();
                            $('#subjectError'+num).html('This teacher subject is not available for this time interval.');
                            return false;
                        } else {
                            $('#subjectError'+num).hide();
                            $('#subjectError'+num).html('');

                        }
                    }

                    num++;

                });

                if(flag == 1) {
                    sessionStorage.setItem('batch',$('#hiddenBatchId').val());
                    sessionStorage.setItem('class',$('#hiddenClassId').val());
                    sessionStorage.setItem('division',$('#hiddenDivId').val());
                    sessionStorage.setItem('flagToReload',1);

                    $('#timeTableForm').submit();
                }

            }

        });

        /*
         +   * Function Name: minFromMidnight
         +   * Param: tm
         +   * Return: it will returns formatted time in AM PM format (Meridian)
         +   * Desc: this method converts 24 hrs timestamp into meredian timestamp.
         +   * Developed By: Suraj Bande
         +   * Date: 15/2/2016
         +   */

        function minFromMidnight(tm){

            var ampm = tm.substr(-2);

            var time = $.trim(tm).length === 7 ? "0" + tm : tm;

            var clk = time.substr(0, 5);

            var m  = parseInt(clk.match(/\d+$/)[0], 10);

            var h  = parseInt(clk.match(/^\d+/)[0], 10);

            if((ampm.match(/pm/i)) == "PM") {
                if( h == 12 ) {
                    h += 0;
                } else {
                    h += 12;
                }

            } else {

                if( h == 12 ) {
                    h = 0;
                } else {
                    h += 0;
                }

            }

            return (h*60+m);
        }


    </script>


</div>
@stop

