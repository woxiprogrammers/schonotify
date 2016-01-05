
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

<section id="page-title">
    <div class="row">
        <div class="col-sm-8">
            <h1 class="mainTitle">Edit {!! $user->first_name !!} {!! $user->last_name !!}  Profile</h1>
            @include('alerts.errors')
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <div id="error-div"></div>
        </div>
    </div>
</section>
<!-- end: PAGE TITLE -->
<!-- start: USER PROFILE -->
<div class="container-fluid container-fullw bg-white">
    <div class="row">
        <div class="col-md-12">


            <div class="tabbable">
                <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">

                    <li class="active">
                        <a data-toggle="tab" href="#panel_edit_account">
                            Edit Account
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#panel_module_assigned">
                            Assigned Modules
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#panel_my_child">
                            My Children
                        </a>
                    </li>


                </ul>
                <div class="tab-content">
                    <div id="panel_edit_account" class="tab-pane fade in active ">
                        <form id="form4" method="post" action="/edit-teacher/{!! $user->id !!}"  enctype="multipart/form-data">
                            <input name="_method" type="hidden" value="PUT">
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Username
                                            </label>
                                            <input type="text" value="{!! $user->username !!}" readonly class="form-control" id="username" name="username">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">
                                                First name
                                            </label>
                                            <input type="text" value="{!! $user->first_name !!}" class="form-control" id="firstname" name="firstname">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">
                                                Last name
                                            </label>
                                            <input type="text" value="{!! $user->last_name !!}" class="form-control" id="lastname" name="lastname">
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                Email Address
                                            </label>
                                            <input type="email" placeholder="{!! $user->email !!}" value="{!! $user->email !!}" class="form-control" id="email" name="email">
                                            <div class="" id="emailfeedback" ></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">
                                                Phone
                                            </label>
                                            <input type="text" placeholder="{!! $user->mobile !!}" value="{!! $user->mobile !!}" class="form-control" id="mobile" name="mobile">

                                        </div>


                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Gender
                                            </label>
                                            <div class="clip-radio radio-primary">
                                                <input type="radio" value="F" name="gender" id="us-female" @if($user->gender=='F') checked @endif>
                                                <label for="us-female">
                                                    Female
                                                </label>

                                                <input type="radio" value="M" name="gender" id="us-male" @if($user->gender=='M') checked @endif>

                                                <label for="us-male">
                                                    Male
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">
                                                Address
                                            </label>
                                            <textarea maxlength="250"  id="address" name="address"  class="form-control limited">{!! $user->address !!}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Date of Birth </label>
                                            <div class="input-group input-append datepicker date col-sm-6">
                                                <input type="text" class="form-control" name="DOB" value="{!! $user->birth_date !!}"/>
								<span class="input-group-btn">
									<button type="button" class="btn btn-default">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                    </button> </span>
                                            </div>

                                            <!--                            <input class="form-control format-datepicker" type="text">-->
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">
                                                Alternate number
                                            </label>
                                            <input type="text" placeholder="{!! $user->alternate_number !!}" value="{!! $user->alternate_number !!}" class="form-control" id="Alternate_number" name="Alternate_number">

                                        </div>


                                    <div class="form-group">
                                        <label>
                                            Image Upload
                                        </label>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail  col-sm-4">

                                                <img src="/uploads/profile-picture/{!! $user->avatar !!}" alt="">

                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail  col-sm-6 pull-right"></div>
                                            <div class="user-edit-image-buttons pull-right col-sm-6">
																			<span class="btn btn-azure btn-file"><span class="fileinput-new"><i class="fa fa-picture"></i>Browse Image</span><span class="fileinput-exists"><i class="fa fa-picture"></i></span>
																				<input type="file" name="avatar" >
																			</span>
                                                <a href="#" class="btn fileinput-exists btn-red" data-dismiss="fileinput">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </fieldset>

                            <div class="row">

                                <div class="col-md-4">
                                    <button class="btn btn-primary pull-right" type="submit" id="updateUserInfo" >
                                        Update <i class="fa fa-arrow-circle-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="panel_module_assigned" class="tab-pane fade" id="aclMod">
                        <div class="panel-body">
                            <div class="col-sm-10">
                                <form id="form4" method="post" action="/edit-teacher/{!! $user->id !!}"  enctype="multipart/form-data">
                                    <table class="table table-responsive" id="aclMod">
                                    </table>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <button class="btn btn-primary pull-right" type="submit" >
                                                Update <i class="fa fa-arrow-circle-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div id="panel_my_child" class="tab-pane fade" id="aclMod">
                        <div class="panel-body">
                            <div class="col-sm-10"></div></div></div>


                </div>

            </div>
        </div>
    </div>
</div>
</div>

@include('rightSidebar')
<!-- end: FOURTH SECTION -->
</div>
</div>
</div>

@include('footer')
</div>


<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/vendor/modernizr/modernizr.js"></script>
<script src="/vendor/jquery-cookie/jquery.cookie.js"></script>4a
<script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/vendor/switchery/switchery.min.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="/vendor/bootstrap-fileinput/jasny-bootstrap.js"></script>
<script src="/vendor/ckeditor/ckeditor.js"></script>
<script src="/vendor/ckeditor/adapters/jquery.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="/vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="/vendor/maskedinput/jquery.maskedinput.min.js"></script>
<script src="/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="/vendor/autosize/autosize.min.js"></script>
<script src="/vendor/selectFx/classie.js"></script>
<script src="/vendor/selectFx/selectFx.js"></script>
<script src="/vendor/select2/select2.min.js"></script>
<script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="/vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>

<!-- start: JavaScript Event Handlers for this page -->
<script src="/assets/js/form-validation.js"></script>

<script src="/assets/js/main.js"></script>
<script src="/assets/js/form-elements.js"></script>
<script src="/assets/js/custom-project.js"></script>
<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();
        FormElements.init();
        userAclModule();

    });
    $('#email').on('keyup',function(){
        var email = $(this).val();
        var route='/check-email';
        $.post(route,{email:email},function(res){
            if(res == 0 ) {
                $('#emailfeedback').removeClass("alert alert-danger alert-dismissible");
                $('#emailfeedback').addClass("alert alert-success alert-dismissible");
                $('#emailfeedback').html("Email Id Can Be Used");
                $('#updateUserInfo').removeAttr('disabled');
            } else {
                document.getElementById("emailfeedback").disabled = true;
                $('#emailfeedback').addClass("alert alert-danger alert-dismissible");
                $('#emailfeedback').html("Email Id Already Exists");
                $('#updateUserInfo').attr('disabled','disabled');
            }
        });
    });
    function userAclModule()
    {
        var route='/user-module-acl';
        $.get(route,function(res){

            var str;

            var arr=res['allModAclArr'];

            var arr1= $.map(arr,function(index,value){
                return [value];
            });

            var arr3=res['allAcls'];
            var arr2= $.map(arr3,function(index,value){
                return [index];
            });

            var arr4=res['userModAclArr'];

            str+='<tr>'+
                '<th><b>Modules</b></th>';
            for(var j=0; j<arr2.length; j++)
            {

                str+='<th><span class="label label-default" >'+arr2[j]['title']+'</span></th>';
            }

            str+='</tr>';


            for(var i=0; i<arr1.length; i++)
            {

                str+="<tr>"+
                    "<td>"+(arr1[i]).toUpperCase()+"</td>";
                for(var j=0; j<arr2.length; j++)
                {
                    str+='<td>'+
                        '<div class="checkbox clip-check check-primary checkbox-inline">';


                    if($.inArray(arr2[j]['slug']+'_'+arr1[i],arr4)!=-1)
                    {

                        str+='<input type="checkbox" id="'+arr2[j]['slug']+'_'+arr1[i]+'" value="1"  checked>'+
                            '<label for="checkbox"></label>';
                    }else{
                        str+='<input type="checkbox" id="'+arr2[j]['slug']+'_'+arr1[i]+'" value="1" >'+
                            '<label for="checkbox"></label>';
                    }
                    str+='</div>'+
                        '</td>';
                }

                str+="</tr>";
            }

            $('#aclMod').html(str);
        });
    }




</script>


@stop














