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
                           <h4><i class="fa fa-meh-o"></i></h4> <p>No timetable has been created for this division...<a href="createTimetable">Create New Timetable</a></p>
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
                        <div class="form-group hidden">
                            <label>
                                ID
                            </label>
                            <input type="text" id="event-id">
                        </div>
                        <div class="form-group">
                            <label>
                                Event Title
                            </label>
                            <input type="text" id="event-name" placeholder="Enter title" class="form-control underline text-large" name="eventName">
                        </div>
                        <div class="form-group">
                            <label>
                                Start
                            </label>
												<span class="input-icon">
													<input type="text" id="start-date-time" class="form-control underline" name="eventStartDate"/>
													<i class="ti-calendar"></i> </span>
                        </div>
                        <div class="form-group">
                            <label>
                                End
                            </label>
												<span class="input-icon">
													<input type="text" id="end-date-time" class="form-control underline" name="eventEndDate" />
													<i class="ti-calendar"></i> </span>
                        </div>
                        <div class="form-group">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger btn-o delete-event">
                            Delete
                        </button>
                        <button class="btn btn-primary btn-o save-event" type="submit">
                            Save
                        </button>
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

                            <input type="time" class="form-control" value="12:30"/>

                        </div>
                        <div class="form-group">
                            <label>
                                End Time
                            </label>
                            <input type="time" class="form-control" value="13:30"/>
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
                    <div class="modal-footer">
                        <button class="btn btn-danger btn-o " data-dismiss="modal">
                            Cancel
                        </button>
                        <button class="btn btn-primary btn-o " data-dismiss="modal" type="button" onclick="confirm('would you like to change this period?')">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    @include('footer')

    <!-- start: MAIN JAVASCRIPTS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/modernizr/modernizr.js"></script>
    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="vendor/switchery/switchery.min.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->

    <!-- start: CLIP-TWO JAVASCRIPTS -->
    <script src="assets/js/main.js"></script>
    <!-- start: JavaScript Event Handlers for this page -->



    <script>
        $(document).ready(function(){
            Main.init();
            showTimetable(1);
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
                                tds+='<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right" style="margin-right: 5px; color: #666;"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[0][j]["subject"] +'</h4><h5 style="text-align: center;"><small>'+ arr[0][j]["teacher"] +'</small></h5><div class="center"><span class="label label-sm label-info">'+arr[0][j]["start_time"]+ '-' +arr[0][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><h4 class="center">'+ arr[0][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[0][j]["start_time"]+ '-' +arr[0][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[0].length==j)
                            {
                                tds+='<td style="text-align: center;"><a data-target="#myModal" data-toggle="modal" class="btn btn-default" style="border-radius: 24px; width: 40px;height: 40px;padding: 7px;font-size: 20px;"><i class="ti-plus"></i></a></td>';
                            }else{
                                tds+='<td></td>';
                            }
                        }
                        if(arr[1].length > j)
                        {
                            if(arr[1][j]["is_break"]==0)
                            {
                                tds+='<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right" style="margin-right: 5px; color: #666;"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[1][j]["subject"] +'</h4><h5 style="text-align: center;"><small>'+ arr[1][j]["teacher"] +'</small></h5><div class="center"><span class="label label-sm label-default">'+arr[1][j]["start_time"]+ '-' +arr[1][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><h4 class="center">'+ arr[1][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[1][j]["start_time"]+ '-' +arr[1][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[1].length==j)
                            {
                                tds+='<td style="text-align: center;"><a data-target="#myModal" data-toggle="modal" class="btn btn-default" style="border-radius: 24px; width: 40px;height: 40px;padding: 7px;font-size: 20px;"><i class="ti-plus"></i></a></td>';
                            }else{
                                tds+='<td></td>';
                            }
                        }

                        if(arr[2].length > j)
                        {
                            if(arr[2][j]["is_break"]==0)
                            {
                                tds+='<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right" style="margin-right: 5px; color: #666;"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[2][j]["subject"] +'</h4><h5 style="text-align: center;"><small>'+ arr[2][j]["teacher"] +'</small></h5><div class="center"><span class="label label-sm label-default">'+arr[2][j]["start_time"]+ '-' +arr[2][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><h4 class="center">'+ arr[2][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[2][j]["start_time"]+ '-' +arr[2][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[2].length==j)
                            {
                                tds+='<td style="text-align: center;"><a data-target="#myModal" data-toggle="modal" class="btn btn-default" style="border-radius: 24px; width: 40px;height: 40px;padding: 7px;font-size: 20px;"><i class="ti-plus"></i></a></td>';
                            }else{
                                tds+='<td></td>';
                            }
                        }

                        if(arr[3].length > j)
                        {
                            if(arr[3][j]["is_break"]==0)
                            {
                                tds+='<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right" style="margin-right: 5px; color: #666;"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[3][j]["subject"] +'</h4><h5 style="text-align: center;"><small>'+ arr[3][j]["teacher"] +'</small></h5><div class="center"><span class="label label-sm label-default">'+arr[3][j]["start_time"]+ '-' +arr[3][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><h4 class="center">'+ arr[3][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[3][j]["start_time"]+ '-' +arr[3][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[3].length==j)
                            {
                                tds+='<td style="text-align: center;"><a data-target="#myModal" data-toggle="modal" class="btn btn-default" style="border-radius: 24px; width: 40px;height: 40px;padding: 7px;font-size: 20px;"><i class="ti-plus"></i></a></td>';
                            }else{
                                tds+='<td></td>';
                            }
                        }

                        if(arr[4].length > j)
                        {
                            if(arr[4][j]["is_break"]==0)
                            {
                                tds+='<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right" style="margin-right: 5px; color: #666;"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[4][j]["subject"] +'</h4><h5 style="text-align: center;"><small>'+ arr[4][j]["teacher"] +'</small></h5><div class="center"><span class="label label-sm label-default">'+arr[4][j]["start_time"]+ '-' +arr[4][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><h4 class="center">'+ arr[4][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[4][j]["start_time"]+ '-' +arr[4][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[4].length==j)
                            {
                                tds+='<td style="text-align: center;"><a data-target="#myModal" data-toggle="modal" class="btn btn-default" style="border-radius: 24px; width: 40px;height: 40px;padding: 7px;font-size: 20px;"><i class="ti-plus"></i></a></td>';
                            }else{
                                tds+='<td></td>';
                            }
                        }
                        if(arr[5].length > j)
                        {

                            if(arr[5][j]["is_break"]==0)
                            {
                                tds+='<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right" style="margin-right: 5px; color: #666;"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[5][j]["subject"] +'</h4><h5 style="text-align: center;"><small>'+ arr[5][j]["teacher"] +'</small></h5><div class="center"><span class="label label-sm label-default">'+arr[5][j]["start_time"]+ '-' +arr[5][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><h4 class="center">'+ arr[5][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[5][j]["start_time"]+ '-' +arr[5][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[5].length==j)
                            {
                                tds+='<td style="text-align: center;"><a data-target="#myModal" data-toggle="modal" class="btn btn-default" style="border-radius: 24px; width: 40px;height: 40px;padding: 7px;font-size: 20px;"><i class="ti-plus"></i></a></td>';
                            }else{
                                tds+='<td></td>';
                            }
                        }

                        if(arr[6].length > j)
                        {

                            if(arr[6][j]["is_break"]==0)
                            {
                                tds+='<td><div class="outer-div-tm"><a data-target="#myModal1" data-toggle="modal" class="show-tab pull-right" style="margin-right: 5px; color: #666;"><i class="fa fa-pencil edit-user-info"></i></a><h4 class="center">'+ arr[6][j]["subject"] +'</h4><h5 style="text-align: center;"><small>'+ arr[6][j]["teacher"] +'</small></h5><div class="center"><span class="label label-sm label-default">'+arr[6][j]["start_time"]+ '-' +arr[6][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><h4 class="center">'+ arr[6][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[6][j]["start_time"]+ '-' +arr[6][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[6].length==j)
                            {
                                tds+='<td style="text-align: center;"><a data-target="#myModal" data-toggle="modal" class="btn btn-default" style="border-radius: 24px; width: 40px;height: 40px;padding: 7px;font-size: 20px;"><i class="ti-plus"></i></a></td>';
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
    </script>

</div>
@stop

