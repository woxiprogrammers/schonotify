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
                            <span class="mainDescription">Batches</span>
                        </div>
                        <div class="col-sm-5">
                            <!-- start: MINI STATS WITH SPARKLINE -->
                            <ul class="mini-stats pull-right">

                                <li>
                                    <div class="values">
                                        <a href="/create-class" type="button" class="btn btn-wide btn-lg btn-o btn-primary btn-squared">
                                            Create New Class <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>

                            </ul>
                            <!-- end: MINI STATS WITH SPARKLINE -->
                        </div>
                    </div>
                </section>
                <!-- end: DASHBOARD TITLE -->

                @include('selectClassDropdown')

                <div class="container-fluid container-fullw bg-white">
                    <div class="row">

                        <div class="col-md-12" id="tableContent2">

                            <table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>
                                <thead>
                                <tr>
                                    <th>Batch Name</th>
                                    <th>Description</th>
                                    @foreach(session('functionArr') as $row)
                                    @if($row == 'update_class')
                                    <th>Action</th>
                                    @endif
                                    @endforeach
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($results as $rows)
                                <tr>
                                    <td>{!! $rows->name !!}</td>
                                    <td>{!! $rows->batch_description !!}</td>
                                    @if(in_array('update_class',session('functionArr')))
                                    <td><a href="#" class="edit-row">Edit</a></td>
                                    @endif

                                    <td>
                                        <a href="#">
                                            Delete
                                        </a>
                                    </td>

                                </tr>
                                @endforeach
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

    @include('searchBatchJS')

</div>
@stop



