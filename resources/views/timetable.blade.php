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
                                tds+='<td><div class="outer-div-tm"><h4 class="center">'+ arr[0][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-info">'+arr[0][j]["start_time"]+ '-' +arr[0][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><h4 class="center">'+ arr[0][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[0][j]["start_time"]+ '-' +arr[0][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[0].length==j)
                            {
                                tds+='<td style="text-align: center;"><a href="" class="btn btn-default" style="border-radius: 24px; width: 40px;height: 40px;padding: 7px;font-size: 20px;"><i class="ti-plus"></i></a></td>';
                            }else{
                                tds+='<td></td>';
                            }
                        }
                        if(arr[1].length > j)
                        {
                            if(arr[1][j]["is_break"]==0)
                            {
                                tds+='<td><div class="outer-div-tm"><h4 class="center">'+ arr[1][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-default">'+arr[1][j]["start_time"]+ '-' +arr[1][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><h4 class="center">'+ arr[1][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[1][j]["start_time"]+ '-' +arr[1][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[1].length==j)
                            {
                                tds+='<td style="text-align: center;"><a href="" class="btn btn-default" style="border-radius: 24px; width: 40px;height: 40px;padding: 7px;font-size: 20px;"><i class="ti-plus"></i></a></td>';
                            }else{
                                tds+='<td></td>';
                            }
                        }

                        if(arr[2].length > j)
                        {
                            if(arr[2][j]["is_break"]==0)
                            {
                                tds+='<td><div class="outer-div-tm"><h4 class="center">'+ arr[2][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-default">'+arr[2][j]["start_time"]+ '-' +arr[2][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><h4 class="center">'+ arr[2][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[2][j]["start_time"]+ '-' +arr[2][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[2].length==j)
                            {
                                tds+='<td style="text-align: center;"><a href="" class="btn btn-default" style="border-radius: 24px; width: 40px;height: 40px;padding: 7px;font-size: 20px;"><i class="ti-plus"></i></a></td>';
                            }else{
                                tds+='<td></td>';
                            }
                        }

                        if(arr[3].length > j)
                        {
                            if(arr[3][j]["is_break"]==0)
                            {
                                tds+='<td><div class="outer-div-tm"><h4 class="center">'+ arr[3][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-default">'+arr[3][j]["start_time"]+ '-' +arr[3][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><h4 class="center">'+ arr[3][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[3][j]["start_time"]+ '-' +arr[3][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[3].length==j)
                            {
                                tds+='<td style="text-align: center;"><a href="" class="btn btn-default" style="border-radius: 24px; width: 40px;height: 40px;padding: 7px;font-size: 20px;"><i class="ti-plus"></i></a></td>';
                            }else{
                                tds+='<td></td>';
                            }
                        }

                        if(arr[4].length > j)
                        {
                            if(arr[4][j]["is_break"]==0)
                            {
                                tds+='<td><div class="outer-div-tm"><h4 class="center">'+ arr[4][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-default">'+arr[4][j]["start_time"]+ '-' +arr[4][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><h4 class="center">'+ arr[4][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[4][j]["start_time"]+ '-' +arr[4][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[4].length==j)
                            {
                                tds+='<td style="text-align: center;"><a href="" class="btn btn-default" style="border-radius: 24px; width: 40px;height: 40px;padding: 7px;font-size: 20px;"><i class="ti-plus"></i></a></td>';
                            }else{
                                tds+='<td></td>';
                            }
                        }
                        if(arr[5].length > j)
                        {

                            if(arr[5][j]["is_break"]==0)
                            {
                                tds+='<td><div class="outer-div-tm"><h4 class="center">'+ arr[5][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-default">'+arr[5][j]["start_time"]+ '-' +arr[5][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><h4 class="center">'+ arr[5][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[5][j]["start_time"]+ '-' +arr[5][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[5].length==j)
                            {
                                tds+='<td style="text-align: center;"><a href="" class="btn btn-default" style="border-radius: 24px; width: 40px;height: 40px;padding: 7px;font-size: 20px;"><i class="ti-plus"></i></a></td>';
                            }else{
                                tds+='<td></td>';
                            }
                        }

                        if(arr[6].length > j)
                        {

                            if(arr[6][j]["is_break"]==0)
                            {
                                tds+='<td><div class="outer-div-tm"><h4 class="center">'+ arr[6][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-default">'+arr[6][j]["start_time"]+ '-' +arr[6][j]["end_time"]+'</span></div></td>';
                            }else{
                                tds+='<td><div class="outer-div-tm lunch"><h4 class="center">'+ arr[6][j]["subject"] +'</h4><div class="center"><span class="label label-sm label-danger">'+arr[6][j]["start_time"]+ '-' +arr[6][j]["end_time"]+'</span></div></td>';
                            }
                        }else{
                            if(arr[6].length==j)
                            {
                                tds+='<td style="text-align: center;"><a href="" class="btn btn-default" style="border-radius: 24px; width: 40px;height: 40px;padding: 7px;font-size: 20px;"><i class="ti-plus"></i></a></td>';
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

