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
            <h1 class="mainTitle">Results</h1>
        </div>

    </div>
</section>
<!-- end: DASHBOARD TITLE -->
<div class="container-fluid container-fullw bg-white">
    <div class="row">
    <div class="col-md-12">
    <div class="col-lg-10">

    <div class="tabbable">
    <ul id="myTab2" class="nav nav-tabs nav-justified panel-title">
        <li class="active">
            <a href="#myTab2_example1" data-toggle="tab" aria-expanded="true">
                 Exams
            </a>
        </li>
        <li class="">
            <a href="#myTab2_example2" data-toggle="tab" aria-expanded="false">
                 Subjects
            </a>
        </li>
    </ul>
    <div class="tab-content">
    <div class="tab-pane fade active in" id="myTab2_example1">



        <div id="slider">
            <a href="#" class="control_next">></a>
            <a href="#" class="control_prev"><</a>
            <div id="result_table">

            </div>
        </div>




    </div>
    <div class="tab-pane fade" id="myTab2_example2">

    </div>

    </div>
    </div>
    </div>
    </div>
    </div>
</div>

</div>
</div>

</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Create New Batch</h4>
            </div>
            <div class="modal-body" style="background: #fff">
                <div id="container_1" style="width:570px;">

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


<script src="vendor/bootstrap-rating/bootstrap-rating.min.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<script src="vendor/Chart.js/Chart.min.js"></script>

<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>

<script>
    jQuery(document).ready(function() {
        Main.init();

        $.ajax({
            url: '/exams/1',
            type:'get',
            dataType:'json',

            success: function (res) {

                //var obj = $.parseJSON(res);

                var arr = $.map(res, function(value, index) {
                    var rObj = {};
                    rObj[index]=[value]
                    return rObj;
                });

                var str1;
                str1='<ul>';

                for(var i=0; i<arr.length; i++)
                {
                    var arr1=$.map(arr[i],function(value,index){
                        return index
                    });

                    var arr2=$.map(arr[i],function(value,index){
                        return value
                    });

                    //console.log(arr2[0]);

                    str1+='<li><h2>'+arr1+'</h2>' +
                            '<div id="exam">' +
                            '<table class="table table-hover">'+
                                '<tr>'+
                                '<th class="center">Subjects</th>'+
                                '<th class="center">Marks</th>'+
                                '</tr>';

                            for(var j=0; j<arr2[0].length; j++)
                            {
                                //console.log(arr2[0][j]);
                                var key=$.map(arr2[0][j],function(value,index){
                                    return index
                                });

                                var val=$.map(arr2[0][j],function(value,index){
                                    return value
                                });

                                for(var k=0;k<key.length; k++)
                                {
                                    str1+='<tr>'+
                                            '<td>'+ key[k] +'</td>'+
                                            '<td>'+ val[k] +'</td>'+
                                        '</tr>';
                                }
                            }

                    str1+=        '</table>' +
                                '<h3><a class="btn btn-wide btn-primary " data-toggle="modal" data-target=".bs-example-modal-lg" onclick="return chart()"><i class="fa fa-bar-chart"></i> View on graph</a></h3>'+
                            '</div>' +
                          '</li>';


                }

                str1+='</ul>';

                $('#result_table').html(str1);

                sliding();
            }
        });



    });



    function chart() {
        // Create the chart


        $('#container_1').highcharts({
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Chart for Unit Test'
            },

            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },
            series: [{
                name: 'Subjects',
                colorByPoint: true,
                data: [{
                    name: 'Marathi',
                    y: 50.00

                }, {
                    name: 'English',
                    y: 70.00,
                    drilldown: 'Chrome'
                }, {
                    name: 'Maths',
                    y: 80.00,
                    drilldown: 'Firefox'
                }, {
                    name: 'History',
                    y: 60.00,
                    drilldown: 'Safari'
                },{
                    name: 'Geography',
                    y: 60.00,
                    drilldown: 'Safari'
                }]
            }]

        });
    }


    function sliding()
    {

        var slideCount = $('#slider ul li').length;
        var slideWidth = $('#slider ul li').width();
        var slideHeight = $('#slider ul li').height();
        var sliderUlWidth = slideCount * slideWidth;

        $('#slider').css({ width: slideWidth, height: slideHeight });

        $('#slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });

        $('#slider ul li:last-child').prependTo('#slider ul');

        function moveLeft() {
            $('#slider ul').animate({
                left: + slideWidth,
                opacity:0.5
            }, 200, function () {
                $('#slider ul li:last-child').prependTo('#slider ul');
                $('#slider ul').css('left', '');
                $('#slider ul').animate({opacity:1},700);
            });
        };

        function moveRight() {
            $('#slider ul').animate({
                left: - slideWidth,
                opacity:0.4
            }, 200, function () {
                $('#slider ul li:first-child').appendTo('#slider ul');
                $('#slider ul').css('left', '');
                $('#slider ul').animate({opacity:1},700);
            });
        };

        $('a.control_prev').click(function () {
            moveLeft();
        });

        $('a.control_next').click(function () {
            moveRight();
        });

    }




</script>


@stop
















