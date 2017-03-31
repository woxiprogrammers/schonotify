
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
@include('alerts.errors')
<div id="message-error-div"></div>
<section id="page-title" class="padding-top-15 padding-bottom-15">
    <div class="row">
        <div class="col-sm-7">
            <h1 class="mainTitle">Edit</h1>
            <span class="mainDescription">Student</span>
        </div>

    </div>
    <div id="error-div"></div>
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
                        <li >
                            <a data-toggle="tab" href="#panel_edit_Parent">
                                My Parent
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#panel_module_assigned">
                                Parent Assigned Modules
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#panel_module_fee">
                                Assigned Fee
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#fee_transaction">
                                Fee Transactions
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="panel_edit_account" class="tab-pane fade in active ">

                            <form id="formEditStudentAccount" method="post" action="/edit-student/{!! $user->id !!}"  enctype="multipart/form-data">
                                <input name="_method" type="hidden" value="PUT">
                                <input type="hidden" name="userId" id="userId" value="{!! $user->id !!}">
                                <input type="hidden" name="division_id"  value="{!! $division_for_updation !!}">
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Roll Number
                                                </label>
                                                <input type="text" value="{!! $user->roll_number !!}"  class="form-control" id="roll_number" name="roll_number">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    GRN Number
                                                </label>
                                                <input type="text" value="{!! $user['studentExtraInfo']['grn'] !!}"  class="form-control" id="grn" name="grn">
                                            </div>
                                        </div>
                                    </div>
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
                                                <input type="email" placeholder="{!! $user->email !!}" value="{!! $user->email !!}" class="form-control" id="editEmail" name="email">
                                                <div id="emailIdfeedback"><div class="" id="emailfeedback" ></div></div>
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
                                                <input type="text" value="{!! $user->address !!}" class="form-control" id="address" name="address">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Date of Birth </label>
                                                <div class="input-group input-append datepicker date col-sm-6">
                                                    <input type="text" class="form-control" name="DOB" value="{!! $user->birth_date !!}"/>
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default">
                                                                <i class="glyphicon glyphicon-calendar"></i>
                                                            </button>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Alternate number
                                                </label>
                                                <input type="text" placeholder="{!! $user->alternate_number !!}" value="{!! $user->alternate_number !!}" class="form-control" id="alternate_number" name="alternate_number">

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
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                Assign Fee Structure
                                            </label>
                                            <div>
                                                <select name="student_fee">
                                                    @if(!empty($fees))
                                                    @foreach($fees as $fee_details)
                                                     <option id="{{$fee_details['id']}}" class="form-control assign_fee_structure" value="{{$fee_details['id']}}" >{{$fee_details['fee_name']}} &nbsp &nbsp &nbsp {{$fee_details['year']}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <h4 style="color: red">{{$division_status}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Select Concession Types
                                        </label>
                                        <div>
                                            @foreach($concession_types as $concessions)
                                            <div class="checkbox clip-check check-primary checkbox-inline caste-checkbox" id="check">
                                                <input type="checkbox"  id="{{ $concessions['id'] }}_concession_chk" name="concessions[]" value="{{ $concessions['id'] }}">
                                                <label for="{{ $concessions['id'] }}_concession_chk">{{ $concessions['name'] }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    </div>
                                   <div class="col-md-12">
                                        <div class="form-group">
                                            <label>
                                                Assign Fee Concession
                                            </label>
                                            <div id="concession-types">

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

                        <div id="panel_edit_Parent" class="tab-pane fade in  ">
                            <div class="panel-body">
                                 <form id="formEditAccount" method="post" action="/edit-parent/{!! $user->parent_id !!}"  enctype="multipart/form-data">
                                <input name="_method" type="hidden" value="PUT">
                                <input type="hidden" name="userId" id="userPerentId" value="{!! $user->parentUserId !!}">
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Username
                                                </label>
                                                <input type="text" value="{!! $user->parentUserName !!}" readonly class="form-control" id="username" name="username">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    First name
                                                </label>
                                                <input type="text" value="{!! $user->parentFirstName !!}" class="form-control" id="firstname" name="firstname">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Last name
                                                </label>
                                                <input type="text" value="{!! $user->parentLastName !!}" class="form-control" id="lastname" name="lastname">
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label">
                                                    Email Address
                                                </label>
                                                <input type="email" placeholder="{!! $user->parentEmail !!}" value="{!! $user->parentEmail !!}" class="form-control" id="editEmailParent" name="email">
                                                <div id="emailIdfeedback"><div class="" id="emailparentfeedback" ></div></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Phone
                                                </label>
                                                <input type="text" placeholder="{!! $user->parentMobile !!}" value="{!! $user->parentMobile !!}" class="form-control" id="mobile" name="mobile">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Gender
                                                </label>
                                                <div class="clip-radio radio-primary">
                                                    <input type="radio" value="F" name="gender" id="us-female" @if($user->parentGender=='F') checked @endif>
                                                    <label for="us-female">
                                                        Female
                                                    </label>

                                                    <input type="radio" value="M" name="gender" id="us-male" @if($user->parentGender=='M') checked @endif>

                                                    <label for="us-male">
                                                        Male
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Address
                                                </label>
                                                <textarea maxlength="250"  id="address" name="address"  class="form-control limited">{!! $user->parentAddress !!}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Date of Birth </label>
                                                <div class="input-group input-append datepicker date col-sm-6">
                                                    <input type="text" class="form-control" name="DOB" value="{!! $user->parentBirth_date !!}"/>
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default">
                                                                <i class="glyphicon glyphicon-calendar"></i>
                                                            </button>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Alternate number
                                                </label>
                                                <input type="text" placeholder="{!! $user->parentAlternateNumber !!}" value="{!! $user->parentAlternateNumber !!}" class="form-control" id="alternate_number" name="alternate_number">
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    Image Upload
                                                </label>
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail  col-sm-4">
                                                        <img src="/uploads/profile-picture/{!! $user->parentAvatar !!}" alt="">
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
                        </div>

                        <div id="panel_module_assigned" class="tab-pane fade" id="aclMod">
                            <div class="panel-body">
                                <div class="col-sm-10">
                                    <form id="editAcl" method="post" action="/acl-update/{!! $user->parent_id !!}">
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
                            <div id="panel_module_fee" class="tab-pane fade-out">
                                <div class="panel-body">
                                     <div class="container">
                                         <div class="row">
                                             <fieldset>
                                                 <div class="form-group">
                                                     <div class="col-md-12">
                                                         <span class="mainDescription"><h3>Fee particulars :</h3></span>
                                                         <hr>
                                                         <label>
                                                             Installment :&nbsp
                                                         </label>
                                                         <select name="installment_number" style="-webkit-appearance: menulist;">
                                                             <option selected>Please select installment</option>
                                                             <option value="1">1</option>
                                                             <option value="2">2</option>
                                                             <option value="3">3</option>
                                                             <option value="4">4</option>
                                                             <option value="5">5</option>
                                                         </select>
                                                     </div>
                                             </fieldset>
                                             <fieldset>
                                                 <div id="installment_table">
                                                 </div>
                                             </fieldset>
                                         </div>
                                        <fieldset>
                                            <div class="col-md-4">
                                                <span class="mainDescription"><h3>Installment details :</h3></span>
                                                <hr>
                                                <div>
                                                    @if(!empty($fee_due_date))
                                                    @foreach($fee_due_date as  $fee_due_dates)
                                                    <dl class="accordion">
                                                        <dt style="font-size: 20px;-webkit-appearance: menulist;"><a href="">Installment: {{$fee_due_dates['installment_id']}} </a></dt>
                                                        <dd>Due-date:{{$fee_due_dates['due_date']}} <br><br> Amount: {{round($fee_due_dates['discount'],2)}}</dd>
                                                    </dl>
                                                    @endforeach
                                                    @endif
                                                    <input type="hidden" id="user-id" value={{$user->id}}>
                                                </div>
                                            </div>
                                         </fieldset>
                                    </div>
                                    </div>
                                  </div>
                        <div class="tab-pane fade" id="fee_transaction">
                            <div class="panel-body">
                                    <fieldset>
                                               <ul class="mini-stats pull-left">
                                                   <li>
                                                       <div class="values">
                                                           <div type="button" class="btn btn-wide btn-lg btn-o btn-primary btn-squared">
                                                               Total fee for current year  :  {{$total_fee_for_current_year}}
                                                           </div>
                                                       </div>
                                                   </li>
                                               </ul>
                                               <ul class="mini-stats pull-right">
                                               <li>
                                                       <div class="values">
                                                           <div type="button" class="btn btn-wide btn-lg btn-o btn-primary btn-squared">
                                                               Total due fee for current year : {{$total_due_fee_for_current_year}}
                                                           </div>
                                                       </div>
                                                   </li>
                                               </ul>
                                    </fieldset>
                                    <fieldset>
                                        <span class="mainDescription"><h3>Add Fee Transaction </h3></span>
                                        <hr>
                                        <form id="fee_transaction_form" method="post" action="/fees/transactions">
                                            <input type="hidden" name="student_id" id="userId" value="{!! $user->id !!}">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Select Transaction Type :<span class="symbol required"></span>
                                                    </label>
                                                    <div>
                                                        <select name="transaction_type">
                                                            @foreach($transaction_types as $transaction_type)
                                                            <option value="{{$transaction_type['transaction_type']}}">{{$transaction_type['transaction_type']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Voucher No / NEFT  no:<span class="symbol required"></span>
                                                    </label>
                                                    <div>
                                                        <input type="text" name="transaction_detail">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Paid Amount:<span class="symbol required"></span>
                                                    </label>
                                                    <div>
                                                        <input type="number" name="transaction_amount">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        Transaction Date:<span class="symbol required"></span>
                                                    </label>
                                                    <div>
                                                        <input type="text" name="date" placeholder="DD-MM-YYYY">
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary pull-right" type="submit" >
                                                Update <i class="fa fa-arrow-circle-right"></i>
                                            </button>
                                    </form>
                                   </fieldset>
                                   <fieldset>
                                       <span class="mainDescription"><h3>Transaction Details</h3></span>
                                       <hr>
                                       <div class="container">
                                           <div class="col-md-12">
                                           </div>  <div class="col-md-12">
                                           </div>  <div class="col-md-12">
                                           </div>
                                           <div class="col-md-12">

                                               <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                                                   <thead>
                                                   <tr>
                                                       <th width="10%"> No </th>
                                                       <th width="20%"> Transaction Type </th>
                                                       <th width="10%"> Transaction Detail </th>
                                                       <th width="10%"> Transaction Amount </th>
                                                       <th width="10%"> Date </th>
                                                   </tr>
                                                   </thead>
                                                   <tbody>
                                                   @foreach($transactions as $transaction)
                                                   <tr>
                                                       <td>{!! $transaction->id !!}</td>
                                                       <td>{!! $transaction->transaction_type !!}</td>
                                                       <td>{!! $transaction->transaction_detail !!}</td>
                                                       <td>{!! $transaction->transaction_amount !!}</td>
                                                       <td>{!! $transaction->date !!}</td>
                                                   </tr>
                                                   @endforeach
                                                   </tbody>
                                               </table>
                                           </div>
                                       </div>
                                   </fieldset>
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
</div>

@include('rightSidebar')
</div>
</div>
</div>
@include('footer')

<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/vendor/modernizr/modernizr.js"></script>
<script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
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
<script src="/assets/js/form-validation-edit.js"></script>
<script src="/assets/js/form-validation.js"></script>
<script src="/assets/js/main.js"></script>
<script src="/assets/js/form-elements.js"></script>
<script src="/assets/js/custom-project.js"></script>
<script src="/vendor/DataTables/jquery.dataTables.min.js"></script>
<script src="/assets/js/table-data.js"></script>


<script>
    jQuery(document).ready(function() {
        $(".caste-checkbox input[value='{{$caste_concession_type_edit}}']").attr('checked', true);
        $(".assign_fee_structure input[value='{{$assigned_fee}}']").attr('selected', true);
        getMsgCount();
        if($('#2_concession_chk').is(":checked")==true)
        {
            var user={{$user['id']}};
        var dataa=this.value;
        $.ajax({
            url: "/get-concession",
            data:{user},

            success: function(result)
            {
                $("#concession-types").html(result);

            }});
    }
        Main.init();
        FormValidator.init();
        FormElements.init();
        TableData.init();
        userAclModule();


        if($('#checkbox8').is(":checked")==true)
        {
            clsTeacher(true);
        }


        (function($) {

            var allPanels = $('.accordion > dd').hide();

            $('.accordion > dt > a').click(function() {
                allPanels.slideUp();
                $(this).parent().next().slideDown();
                return false;
            });

        })(jQuery);


    });

    $( "#2_concession_chk" ).click(function ()
          {
              var user={{$user['id']}};
              var dataa=this.value;
            $.ajax({
                url: "/get-concession",
                data:{user},

                success: function(result)
                {
                    $("#concession-types").html(result);

                }});
           })



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
    function clsTeacher(chk){
        if(chk==true)
        {
            $('#clstchr_batch').show();
            $('#clstchr_class').show();
            $('#clstchr_div').show();
        }else{
            $('#clstchr_batch').hide();
            $('#clstchr_class').hide();
            $('#clstchr_div').hide();
        }
    }
    function userAclModule(){
        var enabled_modules =['view_attendance','view_event','view_timetable','view_result','create_leave','view_leave','view_homework','create_message','delete_message','view_message'];
        var route='/user-module-acl-edit/{!! $user->parent_id !!}';
        $.get(route,function(res){

            var str;

            var allModAclArr=res['allModAclArr'];

            var arr1= $.map(allModAclArr,function(index,value){
                return [value];
            });

            var allAcls=res['allAcls'];
            var arr2= $.map(allAcls,function(index,value){
                return [index];
            });

            var userModAclArr=res['userModAclArr'];

            var allModules=res['allModules'];

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

                    if($.inArray(arr2[j]['slug']+'_'+arr1[i],enabled_modules)==-1){
                        str+='<input type="checkbox" id="'+arr2[j]['slug']+'_'+arr1[i]+'" disabled value="" >'+
                            '<label for="'+arr2[j]['slug']+'_'+arr1[i]+'"></label>';

                    }else{
                        if($.inArray(arr2[j]['slug']+'_'+arr1[i],userModAclArr)!=-1)
                        {

                            str+='<input type="checkbox" id="'+arr2[j]['slug']+'_'+arr1[i]+'" name="acls[]" value="'+arr2[j]['id']+'_'+allModules[i]['id']+'"  checked>'+
                                '<label for="'+arr2[j]['slug']+'_'+arr1[i]+'"></label>';
                        }else{
                            str+='<input type="checkbox" id="'+arr2[j]['slug']+'_'+arr1[i]+'" name="acls[]" value="'+arr2[j]['id']+'_'+allModules[i]['id']+'" >'+
                                '<label for="'+arr2[j]['slug']+'_'+arr1[i]+'"></label>';
                        }
                    }
                    str+='</div>'+
                        '</td>';
                }

                str+="</tr>";
            }

            $('#aclMod').html(str);
        });
    }





    $('#roll_number').on('keyup',function(){
        var roll_number = this.value;
        var division = $('#division').val();
        var userId = $('#userId').val();
        var route='/check-roll-number';

        $.post(route,{roll_number:roll_number,division:division},function(res){
            for(var i=0; i<res.length; i++){
                var confirmation =confirm("For Selected Batch Class Division "+res[i]['first_name']+"  "+ res[i]['last_name']+" is having this Roll number .Do you want to change ?");
                if(confirmation == false){
                    $('#roll_number').val("");
                }
            }
        });
    });


</script>
<script>
    $( "select" )
        .change(function () {

            $id=$("#user-id").val();
            var str = this.value;


            $.ajax({
                url: "/student-fee-installment",
                data:{str1 : str,str2 : $id},
                success: function(response)
                {
                    $("#installment_table").html(response);
                }
            });



        })

</script>
@stop














