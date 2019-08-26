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
									<h1 class="mainTitle">Dashboard</h1>
								</div>

							</div>
						</section>
                        <div id="message-error-div"></div>
						<!-- end: DASHBOARD TITLE -->
						<!-- start: FEATURED BOX LINKS -->

						<?php $user = \Illuminate\Support\Facades\Auth::user();
						$graphDataPresent = array();
						$graphDataAbsent = array();
                        for($count = 0; $count < 8 ;$count++){
                            $date = \Carbon\Carbon::now();
                            $presentDate = $date->subDays($count);
                            $studentSlugID= \App\UserRoles::where('slug','student')->pluck('id');
                            $totalStudents = \App\User::where('is_active',1)->where('role_id',$studentSlugID)->where('is_lc_generated',0)->where('body_id',$user->body_id)->lists('id');
                            $presentStudent = \App\Attendance::whereIn('student_id',$totalStudents)->where('date', '=',date('y/m/d',strtotime($presentDate)))->count();
                            $graphDataPresent[$count] = array(
							    "label" => date('d M Y, D',strtotime($presentDate)),
								"y" => $presentStudent,
							);
                            $graphDataAbsent[$count] = array(
                             "label" => date('d M y, D',strtotime($presentDate)),
							 "y" => (count($totalStudents) - $presentStudent)
							);
                        }
                       ?>
						@if($user->role_id == 1)
                            <div class="container-fluid container-fullw bg-white">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                                    </div>
                                </div>
                            </div>
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-6">
									<p style="text-align: right">
										<i>Last 15 Records</i>
									</p>
									<div class="tabbable">
										<ul id="myTab4" class="nav nav-tabs tab-padding tab-space-3 tab-blue">
											<li class="active">
												<a href="#panel_tab3_example1" data-toggle="tab">
													Achievements
												</a>
											</li>
											<li class="">
												<a href="#panel_tab3_example2" data-toggle="tab">
													Announcement
												</a>
											</li>
											<li class="">
												<a href="#panel_tab3_example3" data-toggle="tab">
													Events
												</a>
											</li>
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="panel_tab3_example1">
												<div class="card">
													<div class="card-body" style="height: 300px;overflow-y: scroll;" >
													@if($achievementsData != "" && $achievementsData != null)
													@foreach($achievementsData as $key => $achievement)
                                                        <?php $createdBy = \App\User::where('id',$achievement['created_by'])->select('first_name','last_name')->first();
                                                        $publishedBy = \App\User::where('id',$achievement['published_by'])->select('first_name','last_name')->first();?>
															<div class="row" style="border-bottom: 1px solid #b2b2b2; padding: 10px;background-color: #fefefe;">
																<div class="col-md-12" style="text-align: right; color: lightcoral"><i>{!! date('dS M Y',strtotime($achievement['created_at'])) !!}</i></div>
																<div class="col-md-12"><i>Title : </i> <span style="color: #000000">{{$achievement['title']}}</span></div>
																<div class="col-md-12"><i>Details : </i> {{$achievement['detail']}}</div>
																<div class="col-md-12"><i>Created By : </i><span style="color: #007AFF">{{$createdBy['first_name'] ." ".$createdBy['last_name']}}</span> </div>
																<div class="col-md-12"><i>Published By : </i><span style="color: #007AFF">{{$publishedBy['first_name'] ." ".$publishedBy['last_name']}}</span></div>
															</div>
													@endforeach
													@else
														<p style="text-align: center">No data found</p>
													@endif
													</div>
												</div>
											</div>
											<div class="tab-pane" id="panel_tab3_example2">
												<div class="card">
													<div class="card-body" style="height: 300px;overflow-y: scroll">
														@if($announcementData != "" && $announcementData != null)
														@foreach($announcementData as $key => $announcement)
                                                            <?php $createdBy = \App\User::where('id',$announcement['created_by'])->select('first_name','last_name')->first();
                                                            $publishedBy = \App\User::where('id',$announcement['published_by'])->select('first_name','last_name')->first();?>
																<div class="row" style="border-bottom: 1px solid #b2b2b2; padding: 10px;background-color: #fefefe;">
																	<div class="col-md-12" style="text-align: right; color: lightcoral"><i>{!! date('dS M Y',strtotime($announcement['created_at'])) !!}</i></div>
																	<div class="col-md-12"><i>Title : </i> <span style="color: #000000">{{$announcement['title']}}</span></div>
																	<div class="col-md-12"><i>Details : </i> {{$announcement['detail']}}</div>
																	<div class="col-md-12"><i>Created By : </i><span style="color: #007AFF">{{$createdBy['first_name'] ." ".$createdBy['last_name']}}</span> </div>
																	<div class="col-md-12"><i>Published By : </i><span style="color: #007AFF">{{$publishedBy['first_name'] ." ".$publishedBy['last_name']}}</span></div>
																</div>
														@endforeach
														@else
															<p style="text-align: center">No data found</p>
														@endif
													</div>
												</div>
											</div>
											<div class="tab-pane" id="panel_tab3_example3">
												<div class="card">
													<div class="card-body" style="height: 300px;overflow-y: scroll;" >
														@if($eventData != "" && $eventData != null)
														@foreach($eventData as $key => $event)
															<?php $createdBy = \App\User::where('id',$event['created_by'])->select('first_name','last_name')->first();
                                                                  $publishedBy = \App\User::where('id',$event['published_by'])->select('first_name','last_name')->first();?>
														<div class="row" style="border-bottom: 1px solid #b2b2b2; padding: 10px;background-color: #fefefe;">
															<div class="col-md-12" style="text-align: right; color: lightcoral"><i>{!! date('dS M Y',strtotime($event['created_at'])) !!}</i></div>
															<div class="col-md-12"><i>Title : </i> <span style="color: #000000">{{$event['title']}}</span></div>
															<div class="col-md-12"><i>Details : </i> {{$event['detail']}}</div>
															<div class="col-md-12"><i>Created By : </i><span style="color: #007AFF">{{$createdBy['first_name'] ." ".$createdBy['last_name']}}</span> </div>
															<div class="col-md-12"><i>Published By : </i><span style="color: #007AFF">{{$publishedBy['first_name'] ." ".$publishedBy['last_name']}}</span></div>
														</div>
														@endforeach
														@else
															<p style="text-align: center">No data found</p>
														@endif
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6 bg-white" >
									<div class="row">
										<div class="col-md-6">
											<p style="color: #333333;font-size: 26px;">
												Recent Homework
											</p>
										</div>
										<div class="col-md-6">
											<p style="text-align: right">
												<i>Last 2 days Records</i>
											</p>
										</div>
									</div>
									<div style="overflow-y: scroll; height: 350px">
										<div class="card" style="background-color: #fffead">
											@if($homeworkData != "" && $homeworkData != null)
											@foreach($homeworkData as $data)
											<div class="card-body" style="border-bottom: 1px solid #a2a2a2; padding: 10px">
												<div class="row">
													<div class="col-md-4"><i>Class : </i><span style="color: #007AFF">{{$data['class_name']}} </span> </div>
													<div class="col-md-4"><i>Div : </i><span style="color: #007AFF">{{$data['division_name']}}</span></div>
													<div class="col-md-4"><i style="color: lightcoral">{!! date('dS M Y',strtotime($data['created_at'])) !!}</i></div>
												</div>
												<div class="row" >
													<div class="col-md-12"><i>Title : </i><span style="color: #000000">{{$data['title']}}</span></div>
												</div>
												<div class="row" >
													<div class="col-md-12"><i>Details : </i><span style="color: #555555">{{$data['description']}}</span></div>
												</div>
												<div class="row" >
													<div class="col-md-12"><i>Created By : </i><span style="color: #007AFF">{{$data['first_name'] . " ".$data['last_name'] }}</span></div>
												</div>
											</div>
											@endforeach
											@else
												<p style="text-align: center">No data found</p>
											@endif
										</div>
									</div>

								</div>
							</div>
							<div class="row">
							@if($userId->body_id == 1)
							<div class="row">
								<div class="col-md-12 bg-white" >
									<div class="row">
										<div class="col-md-6">
											<p style="color: #333333;font-size: 26px;">
												Fee Year 2019-2020
											</p>
										</div>
									</div>
									<div class="portlet-body">
										<table class="table table-striped table-bordered">
											<thead>
											<tr role="row" class="heading">
												<th width="30%"> Section </th>
												<th width="20%"> Total </th>
												<th width="20%"> Paid </th>
												<th width="20%"> Balance </th>
											</tr>
											</thead>
											<tbody>
											@foreach($feeData as $fee)
													<tr role="row">
														<td class="sorting_1">{{$fee['name']}}</td>
														<td class="sorting_1">{{$fee['total']}}</td>
														<td class="sorting_1">{{$fee['paidFee']}}</td>
														<td class="sorting_1">{{$fee['balance']}}</td>
													</tr>
											@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
							</div>
							@endif
						</div>
						@endif
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
            <script>
                window.onload = function () {

                    var chart = new CanvasJS.Chart("chartContainer", {
                        title: {
                            text: "Attendance Reports"
                        },
                        theme: "light2",
                        animationEnabled: true,
                        toolTip:{
                            shared: true,
                            reversed: true
                        },
                        legend: {
                            cursor: "pointer",
                            itemclick: toggleDataSeries
                        },
                        data: [
                            {
                                type: "stackedColumn",
                                name: "Present",
								color :"#18c272",
                                showInLegend: true,
                                yValueFormatString: "#,##0",
                                dataPoints: <?php echo json_encode($graphDataPresent, JSON_NUMERIC_CHECK); ?>
                            },{
                                type: "stackedColumn",
                                name: "Absent",
                                color :"#ff9c99",
                                showInLegend: true,
                                yValueFormatString: "#,##0",
                                dataPoints: <?php echo json_encode($graphDataAbsent, JSON_NUMERIC_CHECK); ?>
                            },
                        ]
                    });

                    chart.render();

                    function toggleDataSeries(e) {
                        if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                            e.dataSeries.visible = false;
                        } else {
                            e.dataSeries.visible = true;
                        }
                        e.chart.render();
                    }

                }
            </script>
            <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
			<!-- start: FOOTER -->
			@include('footer')
			<!-- end: FOOTER -->


		</div>

        @include('dashboardJS')

@stop



