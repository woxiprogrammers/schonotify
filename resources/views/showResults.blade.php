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
            @include('selectClassDivisionDropdown')
    <div class="col-md-12">

        <div id="w">
            <div id="content">

                <div id="searchfield">
                    <form>
                    <div class="form-group col-sm-5">

                        <label>
                            Student Name: <span class="symbol required"></span>
                        </label>
                        <input type="text" placeholder="Enter Student Name" class="form-control" name="currency" id="autocomplete">
                        <br>
                        <div class="form-group" id="outputcontent"></div>
                    </div>
                    </form>

                </div><!-- @end #searchfield -->

            </div><!-- @end #content -->
        </div><!-- @end #w -->

    </div>
    <div class="col-md-12">

    <div class="col-lg-10">

    <div class="tabbable" id="tabTable">
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

        <div id="slider1">
            <a href="#" class="control_next">></a>
            <a href="#" class="control_prev"><</a>
            <div id="result_table1">

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
</div>

</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title chart-title" id="myModalLabel">

                </h4>
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
<script src="vendor/Chart.js/Chart.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.autocomplete.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="assets/js/custom-project.js"></script>
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="assets/js/form-validation.js"></script>

<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();
        getStudents(1);

        $('#tabTable').hide();

        $.ajax({
            url: '/exams/1',
            type:'get',
            dataType:'json',

            success: function (res) {

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

                    str1+='<li><h2>'+arr1+'</h2>' +
                            '<div id="exam">' +
                            '<table class="table table-hover">'+
                                '<tr>'+
                                '<th class="center">Subjects</th>'+
                                '<th class="center">Marks</th>'+
                                '<th class="center">Out of Marks</th>'+
                                '</tr>';

                            for(var j=0; j<arr2[0].length; j++)
                            {

                                var key=$.map(arr2[0][j],function(value,index){
                                    return index
                                });

                                var val=$.map(arr2[0][j],function(value,index){
                                    var arrKey={};
                                    arrKey=[value];
                                    return arrKey;
                                });

                                for(var k=0;k<key.length; k++)
                                {
                                    str1+='<tr>'+
                                            '<td>'+ key[k] +'</td>'+
                                            '<td>'+ val[k][0] +'</td>'+
                                            '<td>'+ val[k][1] +'</td>'+
                                        '</tr>';
                                }
                            }

                    str1+=        '</table>' +
                                '<h3><a class="btn btn-wide btn-primary " data-toggle="modal" data-target=".bs-example-modal-lg" onclick="return chart('+i+')"><i class="fa fa-bar-chart"></i> View on graph</a></h3>'+
                            '</div>' +
                          '</li>';
                }

                str1+='</ul>';

                $('#result_table').html(str1);

                sliding();
            }
        });

        $.ajax({
            url: '/subjects/1',
            type:'get',
            dataType:'json',

            success: function (res) {

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

                    str1+='<li><h2>'+arr1+'</h2>' +
                        '<div id="subject">' +
                        '<table class="table table-hover">'+
                        '<tr>'+
                        '<th class="center">Exams</th>'+
                        '<th class="center">Marks</th>'+
                        '<th class="center">Out of Marks</th>'+
                        '</tr>';

                    for(var j=0; j<arr2[0].length; j++)
                    {

                        var key=$.map(arr2[0][j],function(value,index){
                            return index
                        });

                        var val=$.map(arr2[0][j],function(value,index){
                            var arrKey={};
                            arrKey=[value];
                            return arrKey;
                        });

                        for(var k=0;k<key.length; k++)
                        {
                            str1+='<tr>'+
                                '<td>'+ key[k] +'</td>'+
                                '<td>'+ val[k][0] +'</td>'+
                                '<td>'+ val[k][1] +'</td>'+
                                '</tr>';
                        }
                    }

                    str1+=        '</table>' +
                        '</div>' +
                        '</li>';

                }

                str1+='</ul>';

                $('#result_table1').html(str1);

                sliding1();
            }
        });

    });

    function getStudents(div)
    {

        $(function(){

            $.ajax({
                url: '/getStudents/1',
                type:'get',
                dataType:'json',
                success: function (currencies) {
                    $('#autocomplete').autocomplete({
                        lookup: currencies,
                        onSelect: function (suggestion) {
                                var thehtml = '<strong>Showing result for:</strong> ' + suggestion.value;
                                $('#outputcontent').html(thehtml);
                                $('#tabTable').show();
                            }
                        });

                }
            });

        });

    }

    function chart(key) {

        $.ajax({
            url: '/exams/1',
            type:'get',
            dataType:'json',

            success: function (res) {

                var arr = $.map(res, function(value, index) {
                    var rObj = {};
                    rObj[index]=[value]
                    return rObj;
                });

                var arr1=$.map(arr[key],function(value,index){
                    return index
                });

                var arr2=$.map(arr[key],function(value,index){
                    return value
                });

                var arr3=$.map(arr2[0],function(value,index){
                    return value
                });

                var i=0;

                var subjects=$.map(arr3[0],function(value,index){return index});

                var arrLength=subjects.length;

                var dataStr="[";

                var marks=$.map(arr3[0],function(value,index){
                    i++;

                    if(i<arrLength)
                    {
                    dataStr+= '{"name":"'+index+'",'+
                        '"y":' +value[0]+'},';
                    }else{
                    dataStr+= '{"name":"'+index+'",'+
                            '"y":' +value[0]+'}';
                    }
                });

                dataStr+="]";

                $('.chart-title').text('Chart for '+arr1);

                $('#container_1').highcharts({
                    chart: {
                        type: 'pie'
                    },
                    title: {
                        text: ''
                    },

                    plotOptions: {
                        series: {
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}: {point.y:.1f}%'
                            }
                        }
                    },
                    series: [{
                        name: 'Subjects',
                        colorByPoint: true,
                        data: jQuery.parseJSON(dataStr)
                    }],
                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                    }


                });
            }

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

    function sliding1()
    {

        var slideCount = $('#slider1 ul li').length;
        var slideWidth = $('#slider1 ul li').width();
        var slideHeight = $('#slider1 ul li').height();
        var sliderUlWidth = slideCount * slideWidth;

        $('#slider1').css({ width: slideWidth, height: slideHeight });

        $('#slider1 ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });

        $('#slider1 ul li:last-child').prependTo('#slider1 ul');

        function moveLeft() {
            $('#slider1 ul').animate({
                left: + slideWidth,
                opacity:0.5
            }, 200, function () {
                $('#slider1 ul li:last-child').prependTo('#slider1 ul');
                $('#slider1 ul').css('left', '');
                $('#slider1 ul').animate({opacity:1},700);
            });
        };

        function moveRight() {
            $('#slider1 ul').animate({
                left: - slideWidth,
                opacity:0.4
            }, 200, function () {
                $('#slider1 ul li:first-child').appendTo('#slider1 ul');
                $('#slider1 ul').css('left', '');
                $('#slider1 ul').animate({opacity:1},700);
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






