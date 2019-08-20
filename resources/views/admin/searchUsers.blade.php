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
                        {{--<div class=" col-md-2" id="Student_without_division" style="display: none">
                            <label for="checkbox">Show students without Semester.</label>
                            <input type="checkbox" class="checkbox" id="checkbox">
                            <br>
                            <br><br>
                        </div>--}}
                        <div class="col-md-3" id="EnableDisableTeacher">
                        </div>
                        <div class="col-md-2" id="UserSearch">
                        </div>
                        <div class="col-md-2" id="ClassSearch">
                        </div>
                        <div class="col-md-3" id="DivSearch">
                        </div>
                        <div class="col-md-3" id="EnableDisableSearch">
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <hr>
                        <div class="row" id="shuffle_row" hidden>
                            <h3 style="margin-left: 45%">Shuffle Students</h3>
                            <form id="shuffle_student" method="post" action="/student/student-multiple-shuffle">
                                    <div class="col-md-2">
                                        <label class="control-label">
                                            Select All Students <span class="symbol required"></span>
                                        </label>
                                        <input type="checkbox" class="select-all">
                                    </div>
                                    <div class="col-md-2 ">
                                        <label class="control-label">
                                            Program <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" name="batch" id="batchDrpdn" style="-webkit-appearance: menulist;">
                                            <option>Select Program</option>
                                            @foreach($batches as $batch)
                                                <option value="{!! $batch['id'] !!}">{!! $batch['name'] !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2" id="class-select-div" >
                                        <label class="control-label">
                                            Select Department <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="class-select" name="class_select" style="-webkit-appearance: menulist;">
                                        </select>
                                    </div>
                                    <div class="col-md-2" id="select-div" >
                                        <label class="control-label">
                                            Select Semester <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="div-select" name="div_select" style="-webkit-appearance: menulist;">
                                        </select>
                                    </div>
                                    <div hidden>
                                        <input type="text" name="students_id" id="students_ids" value="">
                                    </div>
                                    <div style="margin-top: 20px" class="col-md-2" id="shuffle" hidden>
                                        <button type="button" class="btn btn-info btn-md" id="modal-call">Shuffle Student</button>
                                    </div>
                                </form>
                            </div>
                        {{--model for shuffle students--}}
                        <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Shuffle Student</h4>
                                    </div>
                                    <div class="modal-body" id="modal-body">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" id="final_shuffle" class="btn btn-default" value="submit">Shuffle</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    {{--end--}}
                        <!-- start: DYNAMIC TABLE -->
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div id="loadmoreajaxloader" style="display:none;"><center><img src="/assets/images/loader1.gif" /></center></div>
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
    function statusUserIsDisplayed(status,id){
        if(status==false){
            var route='/enableDisableFunctionality/enable/'+id;
            $.get(route,function(res){
                if(res['status']==403)
                {
                    var route= "/searchUsers";
                    window.location.replace(route);
                }else{
                    swal({
                        title: "Disabled!",
                        text: "User has been disabled!",
                        type: "error",
                        confirmButtonColor: "#DD6B55",
                        closeOnCancel: false
                    },function(){
                        location.reload();
                    });
                }
            });
        }else{
            var route='/enableDisableFunctionality/disable/'+id;
            $.get(route,function(res){
                if(res['status']==403)
                {
                    var route= "/searchUsers";
                    window.location.replace(route);
                } else if(res['status'] == 401) {
                    var route= "/searchUsers";

                    window.location.replace(route);
                }else{
                    swal({title:"Enabled!", text:"User has been enabled."},function(){
                        location.reload();
                    });
                }
            });
        }
    }
</script>
    <script>
        function result(element){
          if(element.checked){
             var resultFlag = 'true';
          }else{
              var resultFlag = 'false';
          }
            var studentId = element.value;
            $.ajax({
                url:'/exam/change-show-result-flag',
                type: "POST",
                data: {
                    resultFlag: resultFlag,
                    student_id: studentId
                },
                success:function(data,textStatus,xhr){
                    if(resultFlag == 'true'){
                        swal("Result Will Not been Update For this student!");
                    }else{
                        swal("Result Will be Updated!");
                    }
                },
                error:function(errorData){
                    alert(errorData)
                }
            })
        }
    </script>
        <script>
            $('#batchDrpdn').change(function(){
                var id=this.value;
                var route='/get-all-classes/'+id;
                $('#loadmoreajaxloaderClass').show();
                $.get(route,function(res){
                    if (res.length == 0)
                    {
                        $('#class-select').html("no record found");
                        $('#loadmoreajaxloaderClass').hide();
                    } else {
                        var str='<option value="">Please select Department</option>';
                        for(var i=0; i<res.length; i++)
                        {
                            str+='<option value="'+res[i]['class_id']+'">'+res[i]['class_name']+'</option>';
                        }
                        $('#class-select').html(str);
                        $('#loadmoreajaxloaderClass').hide();
                    }
                });
            });
            $('#class-select').change(function(){
                var id=this.value;
                var route='/get-all-division/'+id;
                $('#loadmoreajaxloaderClass').show();
                $.get(route,function(res){
                    if (res.length == 0)
                    {
                        $('#div-select').html("no record found");
                        $('#loadmoreajaxloaderClass').hide();
                    } else {
                        var str='<option value="">Please select semester</option>';
                        for(var i=0; i<res.length; i++)
                        {
                            str+='<option value="'+res[i]['division_id']+'">'+res[i]['division_name']+'</option>';
                        }
                        $('#div-select').html(str);
                        $('#loadmoreajaxloaderClass').hide();
                    }
                });
            });
            $('#div-select').change(function(){
                $('#shuffle').show();
            });
            var students_id = [];
            $('#shuffle').click(function(){
                if($('#tableContent .multiple_shuffle:checkbox:checked').length > 0){
                    $('#myModal').modal('show');
                    var division_name =  $("#div-select :selected").text();
                    var class_name =  $("#class-select :selected").text();
                  $('#tableContent .multiple_shuffle').each(function(){
                     if($(this).prop("checked")){
                         var ids = this.value;
                         students_id.push(ids);
                     }
                  });
                    $('#modal-body').find('p').remove();
                  $('<p>Are you sure you want to shift the students to Class: <b>'+class_name+' </b> And  Division: <b>'+division_name+'</b></p>').appendTo('#modal-body');
                 $('#students_ids').val(students_id);
                }else{
                    alert("Please select the student for shuffle");
                }

            })
            $('.select-all').on('change',function(){
                if($(this).prop("checked")) {
                    $('.multiple_shuffle').prop('checked',true)
                }else{
                    $('.multiple_shuffle').prop('checked',false)
                }
            })
            $('#final_shuffle').on('click',function(){
                $('#shuffle_student').submit();
            })
        </script>
        <script>
            $(document).ready(function(){
                var id= 1;
                $('div#loadmoreajaxloader').show();
                var EnableDisable = 'enable';
                var route='/selectUser'+'/'+id;
                $.ajax({
                    method: "get",
                    url: route,
                    data: { EnableDisable,id}
                })
                    .done(function(res){
                        $('#tableContent').show();
                        $("#tableContent").html(res);
                        $('div#loadmoreajaxloader').hide();
                        var switcheryHandler = function() {

                            var elements = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

                            elements.forEach(function(html) {
                                var switchery = new Switchery(html);
                            });
                        };
                        switcheryHandler();
                        TableData.init();
                    })
                $('#role-select').change(function(){
                    var id= $(this).val();
                    $('div#loadmoreajaxloader').show();
                    var EnableDisable = 'enable';
                    var route='/selectUser'+'/'+id;
                    $.ajax({
                        method: "get",
                        url: route,
                        data: { EnableDisable,id}
                    })
                        .done(function(res){
                            $('#tableContent').show();
                            $("#tableContent").html(res);
                            $('div#loadmoreajaxloader').hide();
                            var switcheryHandler = function() {

                                var elements = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

                                elements.forEach(function(html) {
                                    var switchery = new Switchery(html);
                                });
                            };
                            switcheryHandler();
                            TableData.init();
                        })
                })

            })
        </script>

@stop
