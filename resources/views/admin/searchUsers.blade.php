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
									<span class="mainDescription">Users</span>
								</div>
								<div class="col-sm-5">
									<!-- start: MINI STATS WITH SPARKLINE -->
									<ul class="mini-stats pull-right">
                                        @foreach(session('functionArr') as $row)
                                        @if($row == 'create_user')
                                        <li>
											<div class="values">
                                                <a href="/createUsers/1" type="button" class="btn btn-wide btn-lg btn-o btn-primary btn-squared">
                                                    Create New User <i class="fa fa-angle-right"></i>
                                                </a>
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

                        @include('admin.userRoleDropdown')



                        <!-- start: DYNAMIC TABLE -->
                        <div class="container-fluid container-fullw bg-white">
                        <div class="row">

                        <div class="col-md-12" id="tableContent">

                        </div>

                        </div>

                        </div>



                        <!-- end: DYNAMIC TABLE -->

						<!-- start: FOURTH SECTION -->
						@include('rightSidebar')
						<!-- end: FOURTH SECTION -->
					</div>
				</div>
			</div>

            @include('footer')
		</div>

        @include('searchJS')

<script>

    function statusUser(status,id)
    {

        if(status==false)
        {

            swal({
                title: "Are you sure? Do you want to deactive this user.",
                text: "this user will not get access to his account!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: false

            }, function(isConfirm) {
                if(isConfirm) {

                    var route='deactive/'+id;

                    $.get(route,function(res){

                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    });

                } else {


                    $('status'+id).load('#statusDiv');

                }
            });

        }else
        {
            swal({
                title: "Are you sure? Do you want to active this user.",
                text: "this user will get access to his account!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Active it!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if(isConfirm) {
                    var route='active/'+id;

                    $.get(route,function(res){
                        console.log(res);
                        swal("Activated!", "User has been activated.", "success");
                    });

                } else {
                    swal("Cancelled", "Your imaginary file is safe :)", "error");
                    $('#status'+id).prop('checked', false);
                }
            });
        }

    }

</script>



@stop




