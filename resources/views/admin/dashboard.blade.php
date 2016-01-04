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
									<h1 class="mainTitle">Dashboard</h1>
									<span class="mainDescription">overview &amp; stats </span>
								</div>

							</div>
						</section>
                        <div id="message-error-div"></div>
						<!-- end: DASHBOARD TITLE -->
						<!-- start: FEATURED BOX LINKS -->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-smile-o fa-stack-1x fa-inverse"></i> </span>
											<h2 class="StepTitle">Manage Users</h2>
											<p class="text-small">
												You can add users if you have user management rights
											</p>
											<p class="links cl-effect-1">
												<a href="searchUsers">
													view more
												</a>
											</p>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-clock-o fa-stack-1x fa-inverse"></i> </span>
											<h2 class="StepTitle">Manage Timetable</h2>
											<p class="text-small">
												You can manage timetable by selecting respective divisions ..
											</p>
											<p class="cl-effect-1">
												<a href="timetable">
													view more
												</a>
											</p>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-calendar-o fa-stack-1x fa-inverse"></i> </span>
											<h2 class="StepTitle">Manage Events</h2>
											<p class="text-small">
												Create and manage events on calender and send invitation to related users ...
											</p>
											<p class="links cl-effect-1">
												<a href="event">
													view more
												</a>
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- end: FEATURED BOX LINKS -->

						<!-- start: FOURTH SECTION -->
						@include('rightSidebar')
						<!-- end: FOURTH SECTION -->
					</div>
				</div>
			</div>
			<!-- start: FOOTER -->
			@include('footer')
			<!-- end: FOOTER -->


		</div>

        @include('dashboardJS')

@stop



