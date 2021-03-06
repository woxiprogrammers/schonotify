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
            @include('alerts.errors')
            <div id="message-error-div"></div>
            <section id="page-title" class="padding-top-15 padding-bottom-15">
                <div class="row">
                    <div class="col-sm-7">
                        <h1 class="mainTitle">Timetable</h1>
                    </div>
                    <div class="col-sm-5">
                    </div>
                </div>
            </section>
            <div class="container-fluid container-fullw bg-white">
                <div class="row">
                    <div class="panel panel-transparent">
                        <div class="panel-body">
                            <div class="form-group col-sm-4">
                                <label for="form-field-select-2">
                                    Select Batch
                                </label>
                                <select class="form-control" id="batch-select" style="-webkit-appearance: menulist;">
                                    @foreach($batches as $batch)
                                    <option value="{!! $batch->id !!}">{!! $batch->name !!}</option>
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
                    </div>
                    <div class="col-sm-8 center" id="timetable-create-btn">
                        <center><img src="assets/images/loader1.gif" /></center>
                    </div>
                    <div class="row" id="timetable-div">
                        <table class="table table-hover timetable-div-table" id="sample-table-2">
                            <thead>
                            <tr>
                                <th class="center">Periods</th>
                                <th class="center">Monday</th>
                                <th class="center">Tuesday</th>
                                <th class="center">Wednesday</th>
                                <th class="center">Thursday</th>
                                <th class="center">Friday</th>
                                <th class="center">Saturday</th>
                                <th class="center">Sunday</th>
                            </tr>
                            </thead>
                            <tbody id="division-body">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- start: FOURTH SECTION -->
            @include('rightSidebar')
            <!-- end: FOURTH SECTION -->
        </div>
    </div>
</div>
<div class="modal fade modal-aside horizontal right events-modal"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="myModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-sm">
        <div class="modal-content">
                <div class="modal-body">
                    <div id="createper">
                        @if(in_array('create_timetable',array_values(session('functionArr'))))
                        <div class="form-group" id="copyStructureDiv">
                            <h4>Do you want <a id="copyStructure" class="btn btn-primary">Copy Structure</a></h4>
                            <p class="center">OR</p>
                        </div>
                        <input type="hidden" id="hiddenSelectedDayAddPeriod" />
                            <div class="form-group">
                                <h4>Create Period</h4>
                            </div>
                            <div class="form-group">
                                <label>
                                    Select Subject
                                </label>
                                <select class="form-control" id="subject-add-copy-structure" style="-webkit-appearance: menulist;">
                                </select>
                            </div>
                            <div id="subjectErrorAdd" style="display:none; color:#a94442;"></div>
                            <div class="align-loader timetable-dropdown-load">
                                <center><img width="50" class="img-responsive" src="assets/images/loader1.gif" /></center>
                            </div>
                            <div class="form-group">
                                <label>
                                    Start Time
                                </label>
                                <div class="input-group bootstrap-timepicker timepicker">
                                    <input  id="startTimeAddPeriod" type="text" class="form-control input-small timepicker1">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                            <div id="timeErrorAdd" style="display:none; color:#a94442;"></div>
                            <div class="align-loader timetable-dropdown-load">
                                <center><img width="50" class="img-responsive" src="assets/images/loader1.gif" /></center>
                            </div>
                            <div class="form-group">
                                <label>
                                    End Time
                                </label>
                                <div class="input-group bootstrap-timepicker timepicker">
                                    <input id="endTimeAddPeriod" type="text" class="form-control input-small timepicker1">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                            <div class="align-loader timetable-dropdown-load">
                                <center><img width="50" class="img-responsive" src="assets/images/loader1.gif" /></center>
                            </div>
                            <div class="form-group">
                                <label>
                                    Resses
                                </label>
                                <div class="checkbox clip-check check-primary">
                                    <input type="checkbox" id="isBreakCheck">
                                    <label for="isBreakCheck">
                                        Is A Break
                                    </label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger btn-o delete-event" data-dismiss="modal">
                                    Cancel
                                </button>
                                @foreach(session('functionArr') as $row)
                                @if($row == 'create_timetable')
                                <button class="btn btn-primary btn-o save-event" type="button" id="addPeriodBtn">
                                    Create
                                </button>
                                @endif
                                @endforeach
                            </div>
                        @else
                        <p class="text-danger">
                            <i class="fa fa-warning"></i>
                            Currently you do not have permission to access this functionality. Please contact administrator to grant you access !
                        </p>
                        @endif
                    </div>
                    <div id="copystr">
                        <div class="form-group">
                            <h4>Do you want <a id="createPeriod" class="btn btn-primary">Create Period</a></h4>
                            <p class="center">OR</p>
                            <h4>Copy Structure</h4>
                        </div>
                        <div class="form-group">
                            <label>
                                Select Available Day Structure
                            </label>
                            <select class="form-control" name="day" id="day-select" style="-webkit-appearance: menulist;" >
                            </select>
                        </div>
                        <input type="hidden" id="hiddenSelectedDay" name="selectedDay"/>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-o delete-event" data-dismiss="modal">
                                Cancel
                            </button>
                            @foreach(session('functionArr') as $row)
                            @if($row == 'create_timetable')
                            <button class="btn btn-primary btn-o save-event" type="button" id="copyStructureBtn">
                                Create
                            </button>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<div class="modal fade modal-aside horizontal right events-modal"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="myModal1" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-sm">
        <div class="modal-content">
                <div class="modal-body">
                    @if(!in_array('update_timetable',array_values(session('functionArr'))))
                    <p class="text-danger">
                        <i class="fa fa-warning"></i>
                        Currently you do not have permission to update timetable functionality. Please contact administrator to grant you access !
                    </p>
                    @endif
                    @if(!in_array('delete_timetable',array_values(session('functionArr'))))
                    <p class="text-danger">
                        <i class="fa fa-warning"></i>
                        Currently you do not have permission to delete timetable functionality. Please contact administrator to grant you access !
                    </p>
                    @endif
                    <div class="form-group">
                        <h4>Edit Period</h4>
                    </div>
                    <input type="hidden" id="hiddenDay">
                    <input type="hidden" id="hiddenPeriodId">
                    <div class="form-group">
                        <label>
                            Subject Title
                        </label>
                        <select class="form-control loading" id="subject-select-edit" style="-webkit-appearance: menulist;">
                        </select>
                    </div>
                    <div id="subjectErrorEdit" style="display:none; color:#a94442;"></div>
                    <div class="align-loader timetable-dropdown-load">
                        <center><img width="50" class="img-responsive" src="assets/images/loader1.gif" /></center>
                    </div>
                    <div class="form-group">
                        <label>
                            Start Time
                        </label>
                        <div class="input-group bootstrap-timepicker timepicker" >
                            <input id="startTimeEdit" type="text" class="form-control input-small timepicker1 loading" name="startTime">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                        </div>
                        <div id="timeErrorEdit" style="display:none; color:#a94442;"></div>
                    </div>
                    <div class="align-loader timetable-dropdown-load">
                        <center><img width="50" class="img-responsive" src="assets/images/loader1.gif" /></center>
                    </div>
                    <div class="form-group">
                        <label>
                            End Time
                        </label>
                        <div class="input-group bootstrap-timepicker timepicker" >
                            <input id="endTimeEdit" type="text" class="form-control input-small timepicker1 loading" name="endTime">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                        </div>
                    </div>
                    <div class="align-loader timetable-dropdown-load">
                        <center><img width="50" class="img-responsive" src="assets/images/loader1.gif" /></center>
                    </div>
                    <div class="form-group">
                        <label>
                            Recess
                        </label>
                        <div class="checkbox clip-check check-primary">
                            <input type="checkbox" id="isBreakCheckEdit" name="isBreakCheckEdit">
                            <label for="isBreakCheckEdit">
                                Is A Break
                            </label>
                       </div>
                    </div>
                    <div id="temp"></div>
                </div>
                <div class="modal-footer">
                    @foreach(session('functionArr') as $row)
                    @if($row == 'delete_timetable')
                    <a class="btn btn-danger btn-o btn-danger pull-left" id="del-period-btn">
                        Delete
                    </a>
                    @endif
                    @endforeach
                    <button class="btn btn-danger btn-o " data-dismiss="modal">
                        Cancel
                    </button>
                    @foreach(session('functionArr') as $row)
                    @if($row == 'update_timetable')
                    <button class="btn btn-primary btn-o " data-dismiss="modal" type="button" id="editPeriodSaveBtn">
                        Save
                    </button>
                    @endif
                    @endforeach
                </div>
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

    $('.timepicker1').timepicker({
      minuteStep: 5
    });
    var sessionBatchVal = sessionStorage.getItem('batch');
    if (sessionStorage.getItem('flagToReload') == 1)
    {
        $('#batch-select').val(sessionBatchVal);
    }
    var batchSelected=$('#batch-select').val();

    if(batchSelected != "") {
        getClasses(batchSelected);
    }
});

$('#batch-select').change(function(){
    var batch = $(this).val();
    getClasses(batch);
});
$('#class-select').change(function(){
    var classId = $(this).val();
    getDivisions(classId);
});
/*
 +   * Function Name: getDivisions
 +   * Param: classId
 +   * Return: it will returns divisions respect to class id
 +   * Desc: it will returns divisions respect to class id and on this basis we will get timetable view.
 +   * Developed By: Suraj Bande
 +   * Date: 15/2/2016
 +   */
function getDivisions(classId)
{
    var route="/get-divisions/"+classId;
    $.get(route,function(res){
        var str = "";
        if (res.length != 0) {
            for(var i = 0; i < res.length; i++)
            {
                var sessionDivisionVal = sessionStorage.getItem('division');
                if (sessionStorage.getItem('flagToReload') == 1 && res[i]['id']==sessionDivisionVal)
                {
                    str += "<option value='"+res[i]['id']+"' selected>"+res[i]['division_name']+"</option>";
                    sessionStorage.setItem('flagToReload', 0);
                }else{
                    str += "<option value='"+res[i]['id']+"'>"+res[i]['division_name']+"</option>";
                }
            }
        } else {
            str += "<option value='0'>No divisions found</option>"
        }
        $('#division-select').html(str);
        var divisionSelected=$('#division-select').val();
        showTimetable(divisionSelected);
        $('#copystr').hide();
    });
}
/*
 +   * Function Name: getDivisions
 +   * Param: batchId
 +   * Return: it will returns classes respect to batch id selected
 +   * Desc: it will returns classes respect to batch id and on this basis we will get divisions.
 +   * Developed By: Suraj Bande
 +   * Date: 15/2/2016
 +   */
function getClasses(batchId)
{
    var route="/get-classes/"+batchId;
    $.get(route,function(res){
          var str = "";
          if (res.length != 0)
          {
              for( var i = 0; i < res.length; i++ )
              {
                  var sessionClassVal = sessionStorage.getItem('class');
                  if (sessionStorage.getItem('flagToReload') == 1 && res[i]['id'] == sessionClassVal)
                  {
                      str += "<option value='"+res[i]['id']+"' selected>"+res[i]['class_name']+"</option>";
                  }else{
                      str += "<option value='"+res[i]['id']+"'>"+res[i]['class_name']+"</option>";
                  }
              }
          } else {
                  str += "<option>No classes found</option>";
                 }
        $('#class-select').html(str);
        var classSelected=$('#class-select').val();
        if( classSelected != "" ) {
            getDivisions(classSelected);
        }
    });
}
$('#createPeriod').click(function(){
    $('#createper').show();
    $('#copystr').hide();
});
$('#copyStructure').click(function(){
    $('#createper').hide();
    $('#copystr').show();
});
/*
 +   * Function Name: showTimetable
 +   * Param: val
 +   * Return: this returns the table view of timetable.
 +   * Desc: This is the main logic of timetable where on the basis of days and periods (time) we append cells to table.
 +   * Developed By: Suraj Bande
 +   * Date: 15/2/2016
 +   */
function showTimetable(val)
{
    $('#division-body').html('');
    var route = 'timetableShow/'+val;
    $.get(route,function(res){
        var obj = $.parseJSON(res);
        var arr = $.map(obj, function(value, index) {
            return [value];
        });
        $('#timetable-create-btn').show();
        $('tbody .timetable-div-table').html('');
        if( arr[0] !== "unavailable" ) {
            $('#timetable-div').show();
            var divId = $('#division-select').val();
            var getSubjectPath = "/get-timetable-subjects/"+divId;
            $.get(getSubjectPath,function(res){
                var subjects = "";
                for( var i = 0; i < res.length; i++ )
                {
                    subjects += "<option value='"+res[i]['id']+"'>"+res[i]['subject_name']+" ("+res[i]['username']+")</option>";
                }
                $('#subject-edit-copy-structure').html(subjects);
                $('#subject-select-edit').html(subjects);
            });
            var maxlength = 0;
            for( var i = 0; i < arr.length; i++ )
            {
                var len = arr[i].length;
                if(maxlength < len) {
                    maxlength = len;
                }
            }
            for(var j = 0; j <= maxlength; j++)
            {
                $(".timetable-div-table").each(function () {
                    var tds = '<tr>';
                    tds += '<td class="center">'+(j+1)+'</td>';
                    if ( arr[0].length > j ) {
                        if( arr[0][j]["is_break"] == 0 ) {
                            if(arr[0][j]['teacher_is_active'] == 1) {
                                tds += '<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[0][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[0][j]["subject"] +'</h4><h5 class="center"><small>'+ arr[0][j]["teacher"] + " "+arr[0][j]["teacher_last_name"] +'</small></h5><div class="center"><span class="label label-sm label-info">'+arr[0][j]["start_time"]+ '-' +arr[0][j]["end_time"]+'</span></div></td>';
                            } else {
                                tds += '<td><div class="outer-div-tm" style="background: rgba(204, 204, 204, 0.11); opacity: 0.5;"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[0][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[0][j]["subject"] +'</h4><h5 class="center"><small>disabled</small></h5><div class="center"><span class="label label-sm label-info">'+arr[0][j]["start_time"]+ '-' +arr[0][j]["end_time"]+'</span></div></td>';
                            }
                        } else {
                            tds += '<td><div class="outer-div-tm lunch"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[0][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">Break</h4><div class="center"><span class="label label-sm label-danger">'+arr[0][j]["start_time"]+ '-' +arr[0][j]["end_time"]+'</span></div></td>';
                        }
                    } else {
                        if ( arr[0].length == j ) {
                            tds += '<td class="center"><a data-target="#myModal" data-toggle="modal" class="btn btn-default btn-plus" id="modal'+arr[0].length+'"><i class="ti-plus"></i></a><input type="hidden" value="'+1+'" /></td>';
                        } else {
                            tds += '<td></td>';
                        }
                    }
                    if ( arr[1].length > j ) {
                        if ( arr[1][j]["is_break"] == 0 ) {
                            if(arr[1][j]['teacher_is_active'] == 1) {
                                tds += '<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[1][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[1][j]["subject"] +'</h4><h5 class="center"><small>'+arr[1][j]["teacher"] + " "+arr[1][j]["teacher_last_name"]+'</small></h5><div class="center"><span class="label label-sm label-info">'+arr[1][j]["start_time"]+ '-' +arr[1][j]["end_time"]+'</span></div></td>';
                            } else {
                                tds += '<td><div class="outer-div-tm" style="background: rgba(204, 204, 204, 0.11); opacity: 0.5;"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[1][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[1][j]["subject"] +'</h4><h5 class="center"><small>disabled</small></h5><div class="center"><span class="label label-sm label-info">'+arr[1][j]["start_time"]+ '-' +arr[1][j]["end_time"]+'</span></div></td>';
                            }
                        } else {
                            tds += '<td><div class="outer-div-tm lunch"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[1][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">Break</h4><div class="center"><span class="label label-sm label-danger">'+arr[1][j]["start_time"]+ '-' +arr[1][j]["end_time"]+'</span></div></td>';
                        }
                    } else {
                        if ( arr[1].length == j ) {
                           tds += '<td class="center"><a data-target="#myModal" data-toggle="modal" class="btn btn-default btn-plus" id="modal'+arr[1].length+'"><i class="ti-plus"></i></a><input type="hidden" value="'+2+'" /></td>';
                        } else {
                            tds += '<td></td>';
                        }
                    }
                    if( arr[2].length > j ) {
                        if( arr[2][j]["is_break"] == 0 ) {
                            if(arr[2][j]['teacher_is_active'] == 1) {
                                tds += '<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[2][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[2][j]["subject"] +'</h4><h5 class="center"><small>'+ arr[2][j]["teacher"] + " "+arr[2][j]["teacher_last_name"] +'</small></h5><div class="center"><span class="label label-sm label-info">'+arr[2][j]["start_time"]+ '-' +arr[2][j]["end_time"]+'</span></div></td>';
                            } else {
                                tds += '<td><div class="outer-div-tm" style="background: rgba(204, 204, 204, 0.11); opacity: 0.5;"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[2][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[2][j]["subject"] +'</h4><h5 class="center"><small>disabled</small></h5><div class="center"><span class="label label-sm label-info">'+arr[2][j]["start_time"]+ '-' +arr[2][j]["end_time"]+'</span></div></td>';
                            }
                        } else {
                            tds += '<td><div class="outer-div-tm lunch"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[2][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">Break</h4><div class="center"><span class="label label-sm label-danger">'+arr[2][j]["start_time"]+ '-' +arr[2][j]["end_time"]+'</span></div></td>';
                        }
                    }else {
                        if( arr[2].length == j ) {
                            tds += '<td class="center"><a data-target="#myModal" data-toggle="modal" class="btn btn-default btn-plus" id="modal'+arr[2].length+'"><i class="ti-plus"></i></a><input type="hidden" value="'+3+'" /></td>';
                        } else {
                            tds += '<td></td>';
                        }
                    }
                    if ( arr[3].length > j ) {
                        if ( arr[3][j]["is_break"] == 0 ) {
                            if(arr[3][j]['teacher_is_active'] == 1) {
                                tds += '<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[3][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[3][j]["subject"] +'</h4><h5 class="center"><small>'+ arr[3][j]["teacher"] + " "+arr[3][j]["teacher_last_name"] +'</small></h5><div class="center"><span class="label label-sm label-info">'+arr[3][j]["start_time"]+ '-' +arr[3][j]["end_time"]+'</span></div></td>';
                            } else {
                                tds += '<td><div class="outer-div-tm" style="background: rgba(204, 204, 204, 0.11); opacity: 0.5;"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[3][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[3][j]["subject"] +'</h4><h5 class="center"><small>disabled</small></h5><div class="center"><span class="label label-sm label-info">'+arr[3][j]["start_time"]+ '-' +arr[3][j]["end_time"]+'</span></div></td>';
                            }
                        } else {
                            tds += '<td><div class="outer-div-tm lunch"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[3][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">Break</h4><div class="center"><span class="label label-sm label-danger">'+arr[3][j]["start_time"]+ '-' +arr[3][j]["end_time"]+'</span></div></td>';
                        }
                    } else {
                        if( arr[3].length == j ) {
                            tds += '<td class="center"><a data-target="#myModal" data-toggle="modal" class="btn btn-default btn-plus" id="modal'+arr[3].length+'"><i class="ti-plus"></i></a><input type="hidden" value="'+4+'" /></td>';
                        } else {
                            tds += '<td></td>';
                        }
                    }
                    if ( arr[4].length > j ) {
                        if( arr[4][j]["is_break"] == 0 ) {
                            if(arr[4][j]['teacher_is_active'] == 1) {
                                tds += '<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[4][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[4][j]["subject"] +'</h4><h5 class="center"><small>'+ arr[4][j]["teacher"]+ " "+arr[4][j]["teacher_last_name"] +'</small></h5><div class="center"><span class="label label-sm label-info">'+arr[4][j]["start_time"]+ '-' +arr[4][j]["end_time"]+'</span></div></td>';
                            } else {
                                tds += '<td><div class="outer-div-tm" style="background: rgba(204, 204, 204, 0.11); opacity: 0.5;"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[4][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[4][j]["subject"] +'</h4><h5 class="center"><small>disabled</small></h5><div class="center"><span class="label label-sm label-info">'+arr[4][j]["start_time"]+ '-' +arr[4][j]["end_time"]+'</span></div></td>';
                            }
                        } else {
                            tds += '<td><div class="outer-div-tm lunch"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[4][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">Break</h4><div class="center"><span class="label label-sm label-danger">'+arr[4][j]["start_time"]+ '-' +arr[4][j]["end_time"]+'</span></div></td>';
                        }
                    } else {
                        if ( arr[4].length== j ) {
                            tds += '<td class="center"><a data-target="#myModal" data-toggle="modal" class="btn btn-default btn-plus" id="modal'+arr[4].length+'"><i class="ti-plus"></i></a><input type="hidden" value="'+5+'" /></td>';
                        } else {
                            tds += '<td></td>';
                        }
                    }
                    if ( arr[5].length > j ) {
                        if( arr[5][j]["is_break"] == 0 ) {
                            if(arr[5][j]['teacher_is_active'] == 1) {
                                tds += '<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[5][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[5][j]["subject"] +'</h4><h5 class="center"><small>'+ arr[5][j]["teacher"] + " "+arr[5][j]["teacher_last_name"] +'</small></h5><div class="center"><span class="label label-sm label-info">'+arr[5][j]["start_time"]+ '-' +arr[5][j]["end_time"]+'</span></div></td>';
                            } else {
                                tds += '<td><div class="outer-div-tm" style="background: rgba(204, 204, 204, 0.11); opacity: 0.5;"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[5][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[5][j]["subject"] +'</h4><h5 class="center"><small>disabled</small></h5><div class="center"><span class="label label-sm label-info">'+arr[5][j]["start_time"]+ '-' +arr[5][j]["end_time"]+'</span></div></td>';
                            }
                        } else {
                            tds += '<td><div class="outer-div-tm lunch"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[5][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">Break</h4><div class="center"><span class="label label-sm label-danger">'+arr[5][j]["start_time"]+ '-' +arr[5][j]["end_time"]+'</span></div></td>';
                        }
                    } else {
                        if ( arr[5].length == j ) {
                            tds += '<td class="center"><a data-target="#myModal" data-toggle="modal" class="btn btn-default btn-plus" id="modal'+arr[5].length+'"><i class="ti-plus"></i></a><input type="hidden" value="'+6+'" /></td>';
                        } else {
                            tds += '<td></td>';
                        }
                    }
                    if ( arr[6].length > j ) {
                        if ( arr[6][j]["is_break"] == 0 ) {

                            if(arr[6][j]['teacher_is_active'] == 1) {
                                tds += '<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[6][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[6][j]["subject"] +'</h4><h5 class="center"><small>'+ arr[6][j]["teacher"] + " "+arr[6][j]["teacher_last_name"] +'</small></h5><div class="center"><span class="label label-sm label-info">'+arr[6][j]["start_time"]+ '-' +arr[6][j]["end_time"]+'</span></div></td>';
                            } else {
                                tds += '<td><div class="outer-div-tm" style="background: rgba(204, 204, 204, 0.11); opacity: 0.5;"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[6][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[6][j]["subject"] +'</h4><h5 class="center"><small>disabled</small></h5><div class="center"><span class="label label-sm label-info">'+arr[6][j]["start_time"]+ '-' +arr[6][j]["end_time"]+'</span></div></td>';
                            }
                        } else {
                            tds += '<td><div class="outer-div-tm lunch"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" onclick="editPeriod('+arr[6][j]['id']+')"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">Break</h4><div class="center"><span class="label label-sm label-danger">'+arr[6][j]["start_time"]+ '-' +arr[6][j]["end_time"]+'</span></div></td>';
                        }
                    } else {
                        if ( arr[6].length == j ) {
                            tds += '<td class="center"><a data-target="#myModal" data-toggle="modal" class="btn btn-default btn-plus" id="modal'+arr[6].length+'"><i class="ti-plus"></i></a><input type="hidden" value="'+7+'" /></td>';
                        } else {
                            tds += '<td></td>';
                        }
                    }
                    tds += '</tr>';
                    if ( $('tbody', this).length > 0 ) {
                        $('tbody', this).append(tds);
                        $('#timetable-create-btn').hide();
                    } else {
                        $(this).append(tds);
                        $('#timetable-create-btn').hide();
                    }
                });
            }
            var divisionSelectedId = $('#division-select').val();
            if(divisionSelectedId != 0) {
                $.get('/check-subject-teacher',function(res)
                {
                    if(res != 1) {
                        if(res == 0) {
                            $('.btn-plus').remove();
                            $('.timetable-sect').remove();
                        } else if(res['division_id'] != $('#division-select').val()) {
                            $('.btn-plus').remove();
                            $('.timetable-sect').remove();
                        }
                    }
                });
            }
        } else {
            var val1 = $('#division-select').val();
            if(val1 != 0) {
                $.get('/check-subject-teacher',function(res)
                {
                    if(res == 0) {
                        $('#timetable-create-btn').show();
                        $('#timetable-create-btn').html(' <p>No timetable has been created for this division...</p>');

                    } else if(res == 1) {

                        $('#timetable-create-btn').show();

                        $('#timetable-create-btn').html(' <p>No timetable has been created for this division...<a href="createTimetable">Create New Timetable</a></p>');

                    } else if(res['division_id'] == $('#division-select').val()) {

                            $('#timetable-create-btn').show();

                            $('#timetable-create-btn').html(' <p>No timetable has been created for this division...<a href="createTimetable">Create New Timetable</a></p>');

                        } else {

                            $('#timetable-create-btn').show();

                            $('#timetable-create-btn').html(' <p>No timetable has been created for this division...</p>');

                        }

                });

            } else {

             $('#timetable-create-btn').hide();

            }

            $('#timetable-div').hide();

        }

        $('.btn-plus').click(function(){

            $('#createper').show();

            $('#copystr').hide();

            var dom = $(this).next();

            $('#hiddenSelectedDayAddPeriod').val(dom.val());

            if( this.id == "modal0" ) {

                var dom = $(this).next();

                $('#hiddenSelectedDay').val(dom.val());

                $('#copyStructureDiv').show();

                var divisionSelected = $('#division-select').val();

                var route = "/copy-structure-day/"+divisionSelected;

                $.get(route,function(res){

                    var str = "";

                    var days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

                    if(res.length != 0) {
                        for(var i = 0; i < res.length; i++)
                        {
                            str += "<option value='"+res[i]['day_id']+"'>"+days[(res[i]['day_id']-1)]+"</option>"
                        }
                        $('#day-select').html(str);
                    }

                });

            } else {

                $('#copyStructureDiv').hide();

            }

            addPeriod();

        });

    });

}

function addPeriod(){

    $('.timetable-dropdown-load').show();

    $('.loading').addClass('loading-css');

    $('.loading').prop('disabled',true);

    $('#addPeriodBtn').prop('disabled','true');

    $('#subjectErrorAdd').html('');

    $('#timeErrorAdd').html('');

    var div_id=$('#division-select').val();

    var route="/get-timetable-subjects/"+div_id;

    $.get(route,function(res){

        if(res.length != 0) {

            var str="";

            for(var i=0; i<res.length; i++)
            {
                str+="<option value='"+res[i]['id']+"'>"+res[i]['subject_name']+"</option>";
            }

            $('#subject-add-copy-structure').html(str);

            $('.timetable-dropdown-load').hide();

            $('.loading').removeClass('loading-css');

            $('.loading').prop('disabled',false);

            $('#addPeriodBtn').prop('disabled',false);

        }else{
            var str="<option>No subjects available</option>";

            $('#subject-add-copy-structure').html(str);

            $('.timetable-dropdown-load').hide();

            $('.loading').removeClass('loading-css');

            $('.loading').prop('disabled',false);
        }

        if($('#isBreakCheck').checked == true) {
            $('#isBreakCheck').val('1');
        }else{
            $('#isBreakCheck').val('0');
        }

    });

}

    $('#addPeriodBtn').click(function(){
        var subject = $('#subject-add-copy-structure').val();
        var startTime = $('#startTimeAddPeriod').val();
        var endTime = $('#endTimeAddPeriod').val();
        var checkValue = $('#isBreakCheck').val();
        var day = $('#hiddenSelectedDayAddPeriod').val();

        var division = $('#division-select').val();

        var flag = 1;

        var route = "/teacher-check-add";

        $.ajax({
            url:route,
            async:false,
            type:"post",
            data:{id:subject,day:day,startTime:startTime,endTime:endTime,checkValue:checkValue,division:division},
            success:function(res){

                if ( res == 0 ) {
                    if (checkValue == 0) {
                        flag = 0;
                    } else if ( res == 2 ) {
                        flag = 2;
                    } else {
                        flag = 1;
                    }

                } else if ( res == 2 ) {
                    flag = 2;
                } else {
                    flag = 1;
                }

            }

        });

        if(flag == 2) {
            $('#subjectErrorAdd').hide();
            $('#subjectErrorAdd').html('');
            $('#timeErrorAdd').show();
            $('#timeErrorAdd').html('This time is not available.');
        } else if(flag == 0) {
            $('#timeErrorAdd').hide();
            $('#timeErrorAdd').html('');
            $('#subjectErrorAdd').show();
            $('#subjectErrorAdd').html('This teacher subject is not available for this time interval.');
        } else {
            $('#timeErrorAdd').hide();
            $('#timeErrorAdd').html('');
            $('#subjectErrorAdd').hide();
            $('#subjectErrorAdd').html('');

            var st = minFromMidnight(startTime);
            var et = minFromMidnight(endTime);

            if(st >= et) {
                $('#timeErrorAdd').show();
                $('#timeErrorAdd').html('End time must be greater than start time.');
                return false;
            } else {

                var route = "/add-period";

                $.ajax({
                    url:route,
                    async:false,
                    type:"post",
                    data:{id:subject,day:day,startTime:startTime,endTime:endTime,check:checkValue,division:division},
                    success:function(res){

                        if(res == 1) {

                            showTimetable(division);

                            $('#myModal').modal('toggle');

                            var str = '<div class="alert alert-success alert-dismissible" role="alert">'+
                                'Timetable period created successfully !'+
                                '<button type="button" class="close" data-dismiss="alert" area-lebel="close">'+
                                '<span area-hidden="true">&times;</span>'+
                                '</button>'+

                                '</div>';

                            $('#message-error-div').html(str);

                        }
                    }

                });
            }

        }

});

$('#division-select').change(function()
{
    var divisionId = $(this).val();

    showTimetable(divisionId);

});

/*
 +   * Function Name: editPeriod
 +   * Param: id
 +   * Return: it will returns data to edit
 +   * Desc: it will returns timetable period data with respect to period id.
 +   * Developed By: Suraj Bande
 +   * Date: 23/2/2016
 +   */

function editPeriod(id)
{

    $('.timetable-dropdown-load').show();

    $('.loading').addClass('loading-css');

    $('.loading').prop('disabled',true);

    $('#del-period-btn').prop('href','javascript:void(0)');

    $('#subjectErrorEdit').html('');

    $('#timeErrorEdit').html('');

    var route="/edit-period/"+id;

    $.get(route,function(res){

        if(res.length != 0) {

            $('.timetable-dropdown-load').hide();

            $('.loading').removeClass('loading-css');

            $('.loading').prop('disabled',false);

            $('#del-period-btn').attr('onclick','deletePeriod('+id+')');

            $('#hiddenPeriodId').val(id);

            $('#hiddenDay').val(res[0]['day_id']);

            $('#subject-select-edit option').each(function(){

                var subjectDivId=res[0]['division_subject_id'];

                var selectedSubjectId=$(this).val();

                if(subjectDivId == selectedSubjectId) {

                    $('#subject-select-edit').val(selectedSubjectId);

                }

            });

            $('#startTimeEdit').val(res[0]['start_time']);

            $('#endTimeEdit').val(res[0]['end_time']);

            if(res[0]['is_break'] == 1) {

                $('#isBreakCheckEdit').prop('checked',true);

                $('#subject-select-edit').prop('disabled',true);

                $('#isBreakCheckEdit').prop('value','1');

            } else {

                $('#isBreakCheckEdit').prop('checked',false);

                $('#subject-select-edit').prop('disabled',false);

                $('#isBreakCheckEdit').prop('value','0');

            }

        }

    });

}


$('#isBreakCheck').change(function(){
    if(this.checked == true){
        $(this).val('1');
        $('#subject-add-copy-structure').prop('disabled',true);
    }else{
        $(this).val('0');
        $('#subject-add-copy-structure').prop('disabled',false);
    }
});

$('#isBreakCheckEdit').change(function(){
    if(this.checked == true){
        $(this).val('1');
        $('#subject-select-edit').prop('disabled',true);
    }else{
        $(this).val('0');
        $('#subject-select-edit').prop('disabled',false);
    }
});
/*
 +   * Function Name: deletePeriod
 +   * Param: id
 +   * Return: it will returns delete period
 +   * Desc: it will delete timetable period with respect to period id.
 +   * Developed By: Suraj Bande
 +   * Date: 23/2/2016
 +   */

function deletePeriod(id)
{

    var route = "/delete-period/"+id;

    $.get(route,function(res){

        var div_id = $('#division-select').val();

        showTimetable(div_id);

        var str = '<div class="alert alert-success alert-dismissible" role="alert">'+
            'Period deleted successfully !'+
            '<button type="button" class="close" data-dismiss="alert" area-lebel="close">'+
            '<span area-hidden="true">&times;</span>'+
            '</button>'+

            '</div>';

        $('#message-error-div').html(str);

        $('#myModal1').modal('toggle');

    });

}

$('#copyStructureBtn').click(function(){

    var day_id = $('#day-select').val();

    var div_id = $('#division-select').val();

    var selected_day_id=$('#hiddenSelectedDay').val();

    var route = "/create-copy-structure/"+div_id+"/"+day_id+"/"+selected_day_id;

    $.get(route,function(res){

        showTimetable(div_id);

        var str = '<div class="alert alert-success alert-dismissible" role="alert">'+
                'Timetable structure copied successfully !'+
                '<button type="button" class="close" data-dismiss="alert" area-lebel="close">'+
                '<span area-hidden="true">&times;</span>'+
            '</button>'+

            '</div>';

        $('#message-error-div').html(str);

        $('#myModal').modal('toggle');

    });

});


$('#editPeriodSaveBtn').click(function(){

    var subject = $('#subject-select-edit').val();
    var startTime = $('#startTimeEdit').val();
    var endTime = $('#endTimeEdit').val();
    var checkValue = $('#isBreakCheckEdit').val();
    var period = $('#hiddenPeriodId').val();
    var day = $('#hiddenDay').val();
    var division = $('#division-select').val();

    var flag = 1;

        var route = "/teacher-check-edit";

        $.ajax({
            url:route,
            async:false,
            type:"post",
            data:{id:subject,day:day,startTime:startTime,endTime:endTime,period:period,checkValue:checkValue,division:division},
            success:function(res){

                if ( res == 0 ) {
                    if (checkValue == 0) {
                        flag = 0;
                    } else if ( res == 2 ) {
                        flag = 2;
                    } else {
                        flag = 1;
                    }

                } else if ( res == 2 ) {
                    flag = 2;
                } else {
                    flag = 1;
                }

            }

        });

        if ( flag == 0 ) {
            $('#subjectErrorEdit').show();
            $('#subjectErrorEdit').html('This teacher subject is not available for this time interval.');
            return false;
        } else if( flag == 2 ) {
            $('#subjectErrorEdit').hide();
            $('#subjectErrorEdit').html('');
            $('#timeErrorEdit').show();
            $('#timeErrorEdit').html('This time is not available.');
            return false;
        } else {
            $('#subjectErrorEdit').hide();
            $('#subjectErrorEdit').html('');
            $('#timeErrorEdit').hide();

            var st = minFromMidnight(startTime);
            var et = minFromMidnight(endTime);

            if(st >= et) {
                $('#timeErrorEdit').show();
                $('#timeErrorEdit').html('End time must be greater than start time.');
                return false;
            } else {
                var route = "/update-period";

                $.ajax({
                    url:route,
                    async:false,
                    type:"post",
                    data:{id:subject,day:day,startTime:startTime,endTime:endTime,period:period,check:checkValue},
                    success:function(res){
                        if(res == 1) {

                            showTimetable(division);

                            var str = '<div class="alert alert-success alert-dismissible" role="alert">'+
                                'Timetable period updated successfully !'+
                                '<button type="button" class="close" data-dismiss="alert" area-lebel="close">'+
                                '<span area-hidden="true">&times;</span>'+
                                '</button>'+

                                '</div>';

                            $('#message-error-div').html(str);

                        }
                    }

                });
            }

        }

});

/*
 +   * Function Name: minFromMidnight
 +   * Param: tm
 +   * Return: it will returns formatted time in AM PM format (Meridian)
 +   * Desc: this method converts 24 hrs timestamp into meredian timestamp.
 +   * Developed By: Suraj Bande
 +   * Date: 25/2/2016
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
