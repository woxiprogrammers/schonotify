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
                <section id="page-title" class="padding-top-15 padding-bottom-15">
                    <div class="row">
                        <div class="col-sm-7">
                            <h1 class="mainTitle">Timetable</h1>

                        </div>
                        <div class="col-sm-5">
                            <!-- start: MINI STATS WITH SPARKLINE -->

                            <!-- end: MINI STATS WITH SPARKLINE -->
                        </div>
                    </div>
                </section>
                <!-- end: DASHBOARD TITLE -->


                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        @include('selectClassDivisionDropdown')
                        <div class="col-sm-8 center" id="timetable-create-btn">
                            @foreach(session('functionArr') as $row)
                            @if($row == 'create_timetable')
                            <h4><i class="fa fa-meh-o"></i></h4> <p>No timetable has been created for this division...<a href="createTimetable">Create New Timetable</a></p>
                            @else
                            <h4><i class="fa fa-meh-o"></i></h4> <p>No timetable has been created for this division...
                            @endif
                            @endforeach
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
                <form class="form-full-event">
                    <div class="modal-body">
                        @foreach(session('functionArr') as $row)
                        @if($row == 'create_timetable')
                        <div id="createper">
                        <div class="form-group">

                            <h4>Do you want <a id="copyStructure" class="btn btn-primary">Copy Structure</a></h4>
                            <p class="center">OR</p>
                            <h4>Create Period</h4>
                        </div>
                        <div class="form-group">

                            <label>
                                Enter Period Number
                            </label>
                            <input class="form-control" type="number" name="quantity" min="1" max="7">
                        </div>

                        <div class="form-group">
                            <label>
                                Select Subject
                            </label>
                            <select class="form-control" id="division-select" style="-webkit-appearance: menulist;">
                                <option value="1">Marathi</option>
                                <option value="2">History</option>
                                <option value="3">Hindi</option>
                                <option value="4">Maths</option>
                                <option value="5">English</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>
                               Select Teacher
                            </label>
                            <select class="form-control" id="division-select" style="-webkit-appearance: menulist;">
                                <option value="1">Mr. Sharma</option>
                                <option value="2">Mr. Patil</option>
                                <option value="3">Mrs. Sali</option>
                                <option value="4">Mrs. Gupta</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>
                                Start Time
                            </label>

                            <div class="input-group bootstrap-timepicker timepicker">
                                <input id="timepicker1" type="text" class="form-control input-small timepicker1">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            </div>

                        </div>
                        <div class="form-group">
                            <label>
                                End Time
                            </label>

                            <div class="input-group bootstrap-timepicker timepicker">
                                <input id="timepicker2" type="text" class="form-control input-small timepicker1">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                Resses
                            </label>
                            <div class="checkbox clip-check check-primary">
                                <input type="checkbox" id="checkbox8">
                                <label for="checkbox8">
                                    Is A Break
                                </label>

                            </div>
                        </div>
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
                                <select class="form-control" id="day-select" style="-webkit-appearance: menulist;" onchange="confirm('Do you want to create structure same as '+this.value)">
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    @endif
                    @endforeach

                    <div class="modal-footer">
                        <button class="btn btn-danger btn-o delete-event">
                            Cancel
                        </button>
                        @foreach(session('functionArr') as $row)
                        @if($row == 'create_timetable')
                        <button class="btn btn-primary btn-o save-event" type="submit">
                            Create
                        </button>
                        @endif
                        @endforeach
                    </div>

                </form>
            </div>
        </div>
    </div>


    <div class="modal fade modal-aside horizontal right events-modal"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="myModal1" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-sm">
            <div class="modal-content">
                <form class="form-full-event">
                    <div class="modal-body">
                        @foreach(session('functionArr') as $row)
                        @if($row == 'update_timetable')
                        <div class="form-group">
                            <h4>Edit Period</h4>
                        </div>

                        <div class="form-group">
                            <label>
                                Subject Title
                            </label>
                            <select class="form-control" id="division-select" style="-webkit-appearance: menulist;">
                                <option value="1">Marathi</option>
                                <option value="2">History</option>
                                <option value="3">Hindi</option>
                                <option value="4">Maths</option>
                                <option value="5">English</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>
                                Teachers
                            </label>
                            <select class="form-control" id="division-select" style="-webkit-appearance: menulist;">
                                <option value="1">Mr. Sharma</option>
                                <option value="2">Mr. Patil</option>
                                <option value="3">Mrs. Sali</option>
                                <option value="4">Mrs. Gupta</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>
                                Start Time
                            </label>

                            <div class="input-group bootstrap-timepicker timepicker">
                                <input id="timepicker3" type="text" class="form-control input-small" value="12:30">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            </div>

                        </div>
                        <div class="form-group">
                            <label>
                                End Time
                            </label>
                            <div class="input-group bootstrap-timepicker timepicker">
                                <input id="timepicker4" type="text" class="form-control input-small" value="13:30">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            </div>

                        </div>
                        <div class="form-group">
                            <label>
                                Recess
                            </label>
                            <div class="checkbox clip-check check-primary">
                                <input type="checkbox" id="checkbox8">
                                <label for="checkbox8">
                                    Is A Break
                                </label>

                            </div>
                        </div>

                        @endif
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        @foreach(session('functionArr') as $row)
                        @if($row == 'delete_timetable')
                        <button class="btn btn-danger btn-o btn-danger pull-left" data-dismiss="modal" onclick="confirm('Are you sure to delete this period?')">
                            Delete
                        </button>
                        @endif
                        @endforeach
                        <button class="btn btn-danger btn-o " data-dismiss="modal">
                            Cancel
                        </button>
                        @foreach(session('functionArr') as $row)
                        @if($row == 'update_timetable')
                        <button class="btn btn-primary btn-o " data-dismiss="modal" type="button" onclick="confirm('would you like to change this period?')">
                            Save
                        </button>
                        @endif
                        @endforeach
                    </div>
                </form>
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
    <script>
        $(document).ready(function(){
            Main.init();
            FormValidator.init();
            showTimetable(1);
            $('#copystr').hide();
        });

        $('#createPeriod').click(function(){
            $('#createper').show();
            $('#copystr').hide();
        });

        $('#copyStructure').click(function(){
            $('#createper').hide();
            $('#copystr').show();
        });

        function showTimetable(val)
        {
            $('#division-body').html('');

            var route='timetableShow/'+val;
            $.get(route,function(res){

                var obj = $.parseJSON(res);

                var arr = $.map(obj, function(value, index) {
                    return [value]
                });

               if(arr[0]!=="unavailable")
               {
                $('#timetable-div').show();
                $('#timetable-create-btn').hide();
                var maxlength=0;

                for(var i=0; i<arr.length; i++)
                {

                    var len=arr[i].length;

                    if(maxlength < len)
                    {
                        maxlength=len;
                    }

                }

                for(var j=0; j<=maxlength; j++)
                {
                    $(".timetable-div-table").each(function () {

                        var tds = '<tr>';
                        tds+='<td class="center">'+(j+1)+'</td>';


                        if(arr[0].length > j)
                        {
                            if(arr[0][j]["is_break"]==0)
                            {
                                tds+='<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect" ><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[0][j]["subject"] +'</h4><h5 class="center"><small>'+ arr[0][j]["teacher"] +'</small></h5><div class="center"><span class="label label-sm label-info">'+arr[0][j]["start_time"]+ '-' +arr[0][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[0][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[0][j]["start_time"]+ '-' +arr[0][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[0].length==j)
                            {
                                tds+='<td class="center"><a data-target="#myModal" data-toggle="modal" class="btn btn-default btn-plus"><i class="ti-plus"></i></a></td>';
                            }else{
                                tds+='<td></td>';
                            }
                        }
                        if(arr[1].length > j)
                        {
                            if(arr[1][j]["is_break"]==0)
                            {
                                tds+='<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[1][j]["subject"] +'</h4><h5 class="center"><small>'+ arr[1][j]["teacher"] +'</small></h5><div class="center"><span class="label label-sm label-default">'+arr[1][j]["start_time"]+ '-' +arr[1][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[1][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[1][j]["start_time"]+ '-' +arr[1][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[1].length==j)
                            {
                                tds+='<td class="center"><a data-target="#myModal" data-toggle="modal" class="btn btn-default btn-plus"><i class="ti-plus"></i></a></td>';
                            }else{
                                tds+='<td></td>';
                            }
                        }

                        if(arr[2].length > j)
                        {
                            if(arr[2][j]["is_break"]==0)
                            {
                                tds+='<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[2][j]["subject"] +'</h4><h5 class="center"><small>'+ arr[2][j]["teacher"] +'</small></h5><div class="center"><span class="label label-sm label-default">'+arr[2][j]["start_time"]+ '-' +arr[2][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[2][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[2][j]["start_time"]+ '-' +arr[2][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[2].length==j)
                            {
                                tds+='<td class="center"><a data-target="#myModal" data-toggle="modal" class="btn btn-default btn-plus"><i class="ti-plus"></i></a></td>';
                            }else{
                                tds+='<td></td>';
                            }
                        }

                        if(arr[3].length > j)
                        {
                            if(arr[3][j]["is_break"]==0)
                            {
                                tds+='<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[3][j]["subject"] +'</h4><h5 style="text-align: center;"><small>'+ arr[3][j]["teacher"] +'</small></h5><div class="center"><span class="label label-sm label-default">'+arr[3][j]["start_time"]+ '-' +arr[3][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[3][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[3][j]["start_time"]+ '-' +arr[3][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[3].length==j)
                            {
                                tds+='<td class="center"><a data-target="#myModal" data-toggle="modal" class="btn btn-default btn-plus"><i class="ti-plus"></i></a></td>';
                            }else{
                                tds+='<td></td>';
                            }
                        }

                        if(arr[4].length > j)
                        {
                            if(arr[4][j]["is_break"]==0)
                            {
                                tds+='<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[4][j]["subject"] +'</h4><h5 class="center"><small>'+ arr[4][j]["teacher"] +'</small></h5><div class="center"><span class="label label-sm label-default">'+arr[4][j]["start_time"]+ '-' +arr[4][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[4][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[4][j]["start_time"]+ '-' +arr[4][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[4].length==j)
                            {
                                tds+='<td class="center"><a data-target="#myModal" data-toggle="modal" class="btn btn-default btn-plus"><i class="ti-plus"></i></a></td>';
                            }else{
                                tds+='<td></td>';
                            }
                        }
                        if(arr[5].length > j)
                        {

                            if(arr[5][j]["is_break"]==0)
                            {
                                tds+='<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[5][j]["subject"] +'</h4><h5 class="center"><small>'+ arr[5][j]["teacher"] +'</small></h5><div class="center"><span class="label label-sm label-default">'+arr[5][j]["start_time"]+ '-' +arr[5][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[5][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[5][j]["start_time"]+ '-' +arr[5][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[5].length==j)
                            {
                                tds+='<td class="center"><a data-target="#myModal" data-toggle="modal" class="btn btn-default btn-plus"><i class="ti-plus"></i></a></td>';
                            }else{
                                tds+='<td></td>';
                            }
                        }

                        if(arr[6].length > j)
                        {

                            if(arr[6][j]["is_break"]==0)
                            {
                                tds+='<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[6][j]["subject"] +'</h4><h5 class="center"><small>'+ arr[6][j]["teacher"] +'</small></h5><div class="center"><span class="label label-sm label-default">'+arr[6][j]["start_time"]+ '-' +arr[6][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right timetable-sect"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[6][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[6][j]["start_time"]+ '-' +arr[6][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[6].length==j)
                            {
                                tds+='<td class="center"><a data-target="#myModal" data-toggle="modal" class="btn btn-default btn-plus"><i class="ti-plus"></i></a></td>';
                            }else{
                                tds+='<td></td>';
                            }
                        }

                        tds += '</tr>';

                        if ($('tbody', this).length > 0) {
                            $('tbody', this).append(tds);
                        } else {
                            $(this).append(tds);
                        }
                    });

                }
               }else{
                   $('#timetable-create-btn').show();
                   $('#timetable-div').hide();
               }
            });

        }

        $('#division-select').change(function()
        {

            var val1=$(this).val();
            showTimetable(val1);

        });

        $('#timepicker1').timepicker();
        $('#timepicker2').timepicker();
        $('#timepicker3').timepicker();
        $('#timepicker4').timepicker();

    </script>

</div>
@stop

