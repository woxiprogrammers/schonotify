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
                            <h1 class="mainTitle">History</h1>
                            <span class="mainDescription">Results</span>
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
                                            <div class="form-group col-sm-4">

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
                                                Exam
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="#myTab2_example2" data-toggle="tab" aria-expanded="false">
                                                Academic
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="#myTab2_example3" data-toggle="tab" aria-expanded="false">
                                                Subjects
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade active in" id="myTab2_example1">


                                        </div>
                                        <div class="tab-pane fade" id="myTab2_example2">



                                        </div>
                                        <div class="tab-pane fade" id="myTab2_example3">



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
                    <h4 class="modal-title" id="myModalLabel">
                        Pie Chart For Exams
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

<script>
jQuery(document).ready(function() {
    Main.init();

    getStudents(1);

    $('#tabTable').hide();

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

</script>

@stop
