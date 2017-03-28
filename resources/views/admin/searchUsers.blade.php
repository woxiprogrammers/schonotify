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
									<span class="mainDescription">Users</span>
								</div>
								<div class="col-sm-5">
									<!-- start: MINI STATS WITH SPARKLINE -->
									<ul class="mini-stats pull-right">

                                        <li>
											<div class="values">
                                                <a href="/createUsers/1" type="button" class="btn btn-wide btn-lg btn-o btn-primary btn-squared">
                                                    Create New User <i class="fa fa-angle-right"></i>
                                                </a>
											</div>
										</li>


									</ul>
									<!-- end: MINI STATS WITH SPARKLINE -->
								</div>
							</div>
						</section>
						<!-- end: DASHBOARD TITLE -->

                        @include('admin.userRoleDropdown')


                        <div class="container-fluid container-fullw bg-white col-md-4" id="UserSearch">

                        </div>
                        <div class="container-fluid container-fullw bg-white col-md-4" id="ClassSearch">

                        </div>
                        <div class="container-fluid container-fullw bg-white col-md-4" id="DivSearch">

                        </div>
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

            var route='deactive/'+id;

            $.get(route,function(res){
                if(res['status']==403)
                {
                    var route= "/searchUsers";

                    window.location.replace(route);

                }else{
                    swal({
                        title: "Deactivated!",
                        text: "User has been deactivated!",
                        type: "error",
                        confirmButtonColor: "#DD6B55",
                        closeOnCancel: false
                    });
                }

            });

        }else
        {

            var route='active/'+id;

            $.get(route,function(res){

                if(res['status']==403)
                {
                    var route= "/searchUsers";

                    window.location.replace(route);

                } else if(res['status'] == 401) {

                    var route= "/searchUsers";

                    window.location.replace(route);

                }else{
                    swal("Activated!", "User has been activated.", "success");
                }

            });

        }

    }

</script>



@stop




