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
                            <h1 class="mainTitle">History</h1>
                            <span class="mainDescription">Attendance</span>
                        </div>
                    </div>
                </section>
                <!-- end: DASHBOARD TITLE -->
                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        <div>
                            <div class="panel panel-transparent">

                                <div class="panel-body">

                                    <div class="form-group col-sm-4">
                                        <label for="form-field-select-2">
                                            Select Batch
                                        </label>
                                        <select class="form-control" id="batch-select" style="-webkit-appearance: menulist;">
                                            <option value="1">morning</option>
                                            <option value="2">evening</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4" id="class-select-div">
                                        <label for="form-field-select-2">
                                            Select Class
                                        </label>
                                        <select class="form-control" id="class-select" style="-webkit-appearance: menulist;">
                                            <option value="1">first</option>
                                            <option value="2">second</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4" id="division-select-div">
                                        <label for="form-field-select-2">
                                            Select Division
                                        </label>
                                        <select class="form-control" id="division-select" style="-webkit-appearance: menulist;">
                                            <option value="1">A</option>
                                            <option value="2">B</option>
                                            <option value="3">C</option>
                                            <option value="4">D</option>
                                            <option value="5">E</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">

                            <div id="w">
                                <div id="content">

                                    <div id="searchfield">
                                        <form>
                                            <div class="form-group col-sm-4">

                                                <label>
                                                    Student Name: <span class="symbol required"></span>
                                                </label>
                                                <input type="text" placeholder="Enter Student Name" class="form-control" name="currency" id="autocomplete" autocomplete="off">
                                                <br>
                                                <div class="form-group" id="outputcontent"></div>
                                            </div>
                                        </form>

                                    </div><!-- @end  #searchfield -->

                                </div><!-- @end  #content -->
                            </div><!-- @end  #w -->

                        </div>

                        <div id="attendance-content" class="col-sm-12">
                            <div class="col-sm-4 form-group">
                            <label>Select Year:</label>
                            <select class="form-control" style="-webkit-appearance: menulist;" id="hist-attendance">
                                <option value="2014-15">2014-15</option>
                                <option value="2013-14">2013-14</option>
                                <option value="2012-13">2012-13</option>
                                <option value="2011-12">2011-12</option>
                                <option value="2010-11">2010-11</option>
                            </select>
                            </div>
                            <div class="col-sm-12 def-height" id="container-charts"></div>
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
<script type="text/javascript" src="assets/js/jquery.autocomplete.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="assets/js/custom-project.js"></script>
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="assets/js/form-validation.js"></script>
<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();
        $('#attendance-content').hide();
        getStudents(1);
    });

    function getStudents(div)
    {

        $(function(){

            $.ajax({
                url: '/students/1',
                type:'get',
                dataType:'json',
                success: function (currencies) {
                    $('#autocomplete').autocomplete({
                        lookup: currencies,
                        onSelect: function (suggestion) {
                            var thehtml = '<strong>Showing result for:</strong> ' + suggestion.value;
                            $('#outputcontent').html(thehtml);
                            $('#attendance-content').show();
                            getAttendance('2014-15');
                        }
                    });

                }
            });

        });

    }

    $('#hist-attendance').change(function(){
        var year= this.value;
        getAttendance(year);
        return false;
        e.preventDefault();
    });

    function getAttendance(year)
    {
        $.ajax({
            url: '/get-attendance/'+year,
            type:'get',
            dataType:'json',
            success: function(res){
                console.log(res);
                var months=res[0]['months'];
                var present=res[0]['present'];
                var absent=res[0]['absent'];

                $('#container-charts').highcharts({
                    title: {
                        text: 'Attendance History Chart for Suraj Bande '
                    },
                    yAxis: {
                        title: {
                            text: 'Days'
                        },
                        labels: {
                            format: '{value} '
                        },
                        maxPadding: 1
                    },
                    xAxis: {
                        title: {
                            text: 'Months'
                        },
                        categories: months
                    },
                    labels: {
                        items: [{
                            html: 'Attendance for year '+year,
                            style: {
                                left: '50px',
                                top: '18px',
                                color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'

                            }
                        }]
                    },
                    series: [{
                        type: 'column',
                        name: 'Present',
                        data: present,
                        color:'green'
                    }, {
                        type: 'column',
                        name: 'Absent',
                        data: absent,
                        color:'red'
                    }, {
                        type: 'pie',
                        name: 'Percentage',
                        data: [{
                            name: 'Present',
                            y: 82,
                            color: Highcharts.getOptions().colors[2]
                        }, {
                            name: 'Absent',
                            y: 18,
                            color: Highcharts.getOptions().colors[8]
                        }],
                        center: [300,40],
                        size: 120,
                        showInLegend: false,
                        dataLabels: {
                            enabled: false
                        }
                    }]
                });

            }
        });
    }

</script>

@stop

