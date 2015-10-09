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
                            <h1 class="mainTitle">Search</h1>
                            <span class="mainDescription">Classes</span>
                        </div>
                        <div class="col-sm-5">
                            <!-- start: MINI STATS WITH SPARKLINE -->
                            <ul class="mini-stats pull-right">
                                @foreach(session('functionArr') as $row)
                                @if($row == 'create_class')
                                <li>
                                    <div class="values">
                                        <button type="button" class="btn btn-wide btn-lg btn-o btn-primary btn-squared">
                                            Create New Class <i class="fa fa-angle-right"></i>
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



