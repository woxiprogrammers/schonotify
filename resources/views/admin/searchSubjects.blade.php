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
                            <h1 class="mainTitle">Search</h1>
                            <span class="mainDescription">Subjects</span>
                        </div>
                        <div class="col-sm-5">
                            <!-- start: MINI STATS WITH SPARKLINE -->
                            <ul class="mini-stats pull-right">
                                @foreach(session('functionArr') as $row)
                                @if($row == 'create_subject')
                                <li>
                                    <div class="values">
                                        <button type="button" class="btn btn-wide btn-lg btn-o btn-primary btn-squared">
                                            Create New Subject <i class="fa fa-angle-right"></i>
                                        </button>
                                    </div>
                                </li>
                                @endif
                                @endforeach
                            </ul>
                            <!-- end: MINI STATS WITH SPARKLINE -->
                        </div>
                    </div>
                </section>
                <!-- end: DASHBOARD TITLE -->
                <div class="container-fluid container-fullw bg-white">
                    <div class="row">

                        <div class="col-md-12" id="tableContent2">

                            <table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>
                                <thead>
                                <tr>
                                    <th>Subject Title</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                   <tr>
                                       <td>Marathi</td>
                                       <td><a class="btn btn-default"> View More </a></td>
                                   </tr>
                                   <tr>
                                       <td>Maths</td>
                                       <td><a class="btn btn-default"> View More </a></td>
                                   </tr>
                                   <tr>
                                       <td>Hindi</td>
                                       <td><a class="btn btn-default"> View More </a></td>
                                   </tr>
                                   <tr>
                                       <td>History</td>
                                       <td><a class="btn btn-default"> View More </a></td>
                                   </tr>
                                   <tr>
                                       <td>Biology</td>
                                       <td><a class="btn btn-default"> View More </a></td>
                                   </tr>
                                   <tr>
                                       <td>English</td>
                                       <td><a class="btn btn-default"> View More </a></td>
                                   </tr>
                                   <tr>
                                       <td>Sanskrit</td>
                                       <td><a class="btn btn-default"> View More </a></td>
                                   </tr>
                                   <tr>
                                       <td>Geography</td>
                                       <td><a class="btn btn-default"> View More </a></td>
                                   </tr>
                                   <tr>
                                       <td>Science</td>
                                       <td><a class="btn btn-default"> View More </a></td>
                                   </tr>
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

    @include('searchJS')

</div>
@stop



