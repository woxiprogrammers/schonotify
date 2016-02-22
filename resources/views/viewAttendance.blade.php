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
                            <h1 class="mainTitle">Attendance</h1>
                        </div>
                    </div>
                </section>
                <!-- end: DASHBOARD TITLE -->
                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        <div>
                            <div class="panel panel-transparent">
                                @if ($dropDownData != null)
                                @if (Auth::User()->role_id == 2)
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="form-field-select-2">
                                            Select Batch
                                        </label>

                                        <select class="form-control" name="batch-select" id="batch-select"  style="-webkit-appearance: menulist;">
                                            @foreach($dropDownData['batch'] as $row)
                                            <option value="{!!$row['batch_id']!!}" >{!!$row['batch_name']!!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4"  id="class-select-div">
                                        <label for="form-field-select-2">
                                            Select Class
                                        </label>
                                        <select class="form-control" name="class-select" id="class-select" style="-webkit-appearance: menulist;">
                                            <option value="{!!$dropDownData['class_id']!!}">{!!$dropDownData['class_name']!!}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4" id="division-select-div">
                                        <label for="form-field-select-2">
                                            Select Division
                                        </label>
                                        <select class="form-control" name="division-select" id="division-select" style="-webkit-appearance: menulist;">
                                            <option value="{!!$dropDownData['division_id']!!}">{!!$dropDownData['division_name']!!}</option>
                                        </select>
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="form-field-select-2">
                                            Select Batch
                                        </label>
                                        <select class="form-control" id="batch-select" style="-webkit-appearance: menulist;">
                                            @foreach($dropDownData['batch'] as $row)
                                            <option value="{!!$row['batch_id']!!}" >{!!$row['batch_name']!!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4" id="class-select-div">
                                        <label for="form-field-select-2">
                                            Select Class
                                        </label>
                                        <select class="form-control" id="class-select" style="-webkit-appearance: menulist;">
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4" id="division-select-div">
                                        <label for="form-field-select-2">
                                            Select Division
                                        </label>
                                        <select class="form-control" id="division-select" style="-webkit-appearance: menulist;">
                                        </select>
                                    </div>
                                </div>
                                @endif
                                @else
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="form-field-select-2">
                                            Select Batch
                                        </label>

                                        <select class="form-control" name="batch-select" id="batch-select"  style="-webkit-appearance: menulist;">

                                            <option value="" >no record found</option>

                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4"  id="class-select-div">
                                        <label for="form-field-select-2">
                                            Select Class
                                        </label>
                                        <select class="form-control" name="class-select" id="class-select" style="-webkit-appearance: menulist;">
                                            <option value="">no record found</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4" id="division-select-div">
                                        <label for="form-field-select-2">
                                            Select Division
                                        </label>
                                        <select class="form-control" name="division-select" id="division-select" style="-webkit-appearance: menulist;">
                                            <option value="">no record found</option>
                                        </select>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-8 col-sm-offset-2">
                            <div id='full-calendar'></div>
                        </div>

                    </div>
                </div>

                <div class="modal fade modal-aside horizontal right events-modal"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog modal-sm">
                        <div class="modal-content">
                            <form class="form-full-event">
                                <div class="modal-body">
                                    <div class="form-group ">
                                        <h4>Attendance</h4>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            <h3><span class="label label-danger" id="today"></span></h3>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-bold" id="listTitle">
                                            Students
                                        </label>
                                        <div id="stud-list"></div>
                                        <div>
                                            <table class="table">
                                                <tr>
                                                    <td><div class="col-sm-10"><label class="padding-left-5">Absent Students</label></div><div class=" absent-tag"></div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="col-sm-10"><label class="padding-left-5">Leave Applied</label></div><div class=" leave-applied-tag"></div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="col-sm-10"><label class="padding-left-5">Leave Approved</label></div><div class=" leave-approved-tag"></div></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-info btn-o pull-left" type="button" data-dismiss="modal">
                                        OK
                                    </button>
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
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/modernizr/modernizr.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<script src="vendor/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
<script src="vendor/moment/moment.min.js"></script>
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="vendor/fullcalendar/fullcalendar.min.js"></script>
<script src="vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/attendance-calender.js"></script>
<script src="assets/js/custom-project.js"></script>
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="assets/js/form-validation.js"></script>
<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();
        Calendar.init();
        $('.fc-agendaWeek-button').hide();
        $('.fc-agendaDay-button ').hide();
            var batchSelected=$('#batch-select').val();
            if (batchSelected != "")
            {
                getClasses(batchSelected);
            }
    });

    $('#batch-select').change(function(){
        var batch=$(this).val();
        getClasses(batch);

    });

    $('#class-select').change(function(){
        var classId=$(this).val();
        getDivisions(classId);
    });
    /**
     * Function Name: getDivisions
     * @param:classId
     * @return retrun all divisions related user
     * Desc:it will return list of divisions of releated user
     * Date: 22/2/2016
     * author manoj chaudahri
     */
    function getDivisions(classId)
    {
        var route="/get-divisions/"+classId;

        $.get(route,function(res){

            var str="";

            if (res.length != 0)
            {

                for(var i=0;i<res.length; i++)
                {
                    str+="<option value='"+res[i]['id']+"'>"+res[i]['division_name']+"</option>"
                }

            } else {

                str+="<option value='0'>No divisions found</option>"

            }

            $('#division-select').html(str);

            var divisionSelected=$('#division-select').val();

        });
    }
    /**
     * Function Name: getClasses
     * @param:batchId
     * @return retrun all classes related user
     * Desc:it will return list of classes of releated user
     * Date: 22/2/2016
     * author manoj chaudahri
     */
    function getClasses(batchId)
    {
        var route="/get-classes/"+batchId;

        $.get(route,function(res){

            var str="";

            if (res.length != 0)
            {

                for(var i=0;i<res.length; i++)
                {
                    str+="<option value='"+res[i]['id']+"'>"+res[i]['class_name']+"</option>"
                }

            } else {

                str+="<option>No classes found</option>"

            }

            $('#class-select').html(str);

            var classSelected=$('#class-select').val();

            if(classSelected!="")
            {
                getDivisions(classSelected);
            }

        });
    }
    $('#batch-select').change(function(){

        $('#class-select').val('');
        $('#division-select').val('');
        $('#tableContent2').html('');

    });
    $('#batch-select').change(function(){
        var id=this.value;
        var route = 'get-attendance-classes/'+id;
        $.get(route,function(res){
            if (res.length == 0)
            {
                $('#class-select').html("no record found");
            } else {
                var str = '<option value="">please select class</option>';
                for(var i=0; i<res.length; i++)
                {
                    str += '<option value="'+res[i]['class_id']+'">'+res[i]['class_name']+'</option>';
                }
                $('#class-select').html(str);
            }
        });
    });

    $("#class-select").change(function() {
        var id = this.value;
        var batch_id = $('#batch-select').val();
        var route='get-attendance-division/'+id +'/'+batch_id;
        $.get(route,function(res) {
            if(res.length == 0)
            {
                $('#division-select').html("no record found");
            } else {
                var str = '<option value="">please select division</option>';
                for(var i=0; i<res.length; i++)
                {
                    str += '<option value="'+res[i]['division_id']+'">'+res[i]['division_name']+'</option>';
                }
                $('#division-select').html(str);
            }
        });
    });


</script>

@stop

