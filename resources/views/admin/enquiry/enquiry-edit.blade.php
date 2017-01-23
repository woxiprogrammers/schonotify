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

                <div id="message-error-div"></div>
                <section id="page-title" class="padding-top-15 padding-bottom-15">
                    <div class="row">
                        <div class="col-sm-7">
                            <h1 class="mainTitle">Student</h1>
                            <span class="mainDescription">Enquiry Form</span>
                        </div>

                    </div>
                </section>
                <!-- end: DASHBOARD TITLE -->
                <!-- start: DYNAMIC TABLE -->
                @include('alerts.errors')
                <div class="col-md-12">
                    <form method="post" action="/edit-enquiry/{{$enquiryInfo['id']}}" role="form" id="studentEnquiry">
                        <fieldset>
                            <legend>
                                Name of Father/Mother/Guardian
                            </legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            First Name <span class="symbol required"></span>
                                        </label>
                                        <input type="text" placeholder="Enter your First Name" class="form-control" name="guardian_first_name" value="{{$enquiryInfo['guardian_first_name']}}"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Middle Name
                                        </label>
                                        <input type="text" placeholder="Enter your Middle Name" class="form-control" name="guardian_middle_name" value="{{$enquiryInfo['guardian_middle_name']}}"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Last Name
                                        </label>
                                        <input type="text" placeholder="Enter your Last Name" class="form-control" name="guardian_last_name" value="{{$enquiryInfo['guardian_last_name']}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Email
                                        </label>
                                        <input type="text" placeholder="Enter Email" class="form-control" name="email" value="{{$enquiryInfo['email']}}"/>
                                    </div>
                                </div>
                            </div>

                        </fieldset>
                        <fieldset>
                            <legend>
                                Name of prospective student
                            </legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            First Name <span class="symbol required"></span>
                                        </label>
                                        <input type="text" placeholder="Enter your First Name" class="form-control" name="student_first_name" value="{{$enquiryInfo['student_first_name']}}"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Middle Name
                                        </label>
                                        <input type="text" placeholder="Enter your Middle Name" class="form-control" name="student_middle_name" value="{{$enquiryInfo['student_middle_name']}}"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Last Name
                                        </label>
                                        <input type="text" placeholder="Enter your Last Name" class="form-control" name="student_last_name" value="{{$enquiryInfo['student_last_name']}}"/>
                                    </div>
                                </div>
                            </div>

                        </fieldset>
                        <fieldset>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> <!-- Date input -->
                                        <label class="control-label" for="dob">Date Of Birth <span class="symbol required"></span></label>
                                        <input class="form-control" id="dob" name="dob" placeholder="MM/DD/YYY" type="text" value="{{$enquiryInfo['dob']}}" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> <!-- Date input -->
                                        <label class="control-label">Presently studying in class</label>
                                        <input class="form-control" id="current_class" name="current_class" placeholder="Enter Current Class" type="text"  value="{{$enquiryInfo['current_class']}}"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> <!-- Date input -->
                                        <label class="control-label">School Name</label>
                                        <input class="form-control" id="school_name" name="school_name" placeholder="Enter School Name" type="text" disabled value="{{$enquiryInfo['school_name']}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> <!-- Date input -->
                                        <label class="control-label">Seeking admission to class <span class="symbol required"></span></label>
                                        <input class="form-control" id="admission_to_class" name="admission_to_class" placeholder="Seeking admission to class" type="text" value="{{$enquiryInfo['admission_to_class']}}"/>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>
                                Contact details
                            </legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> <!-- Date input -->
                                        <label class="control-label">Mobile Number <span class="symbol required"></span></label>
                                        <input class="form-control" id="mobile_number" name="mobile_number" placeholder="Enter Mobile Number" type="text" value="{{$enquiryInfo['mobile_number']}}" />
                                    </div>
                                    <div class="form-group"> <!-- Date input -->
                                        <label class="control-label">Alternate Mobile Number </span></label>
                                        <input class="form-control" id="alt_contact_no" name="alt_contact_no" placeholder="Enter Mobile Number" type="text" value="{{$enquiryInfo['alt_contact_no']}}" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="control-label">
                                        Address
                                    </label>

                                    <div class="form-group">
                                        <div class="note-editor">
                                            <textarea class="form-control autosize area-animated" name="address" data-autosize-on="true" style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px; cursor: url('/assets/images/pen.png') 0 32, auto;">{{$enquiryInfo['address']}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>
                                WRITTEN TEST DETAILS
                            </legend>
                            <div class="form-group">

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                       <label class="control-label">
                                           Scheduled on
                                         </label>
                                         <div class='input-group date' id='datetimepicker1'>
                                          <input type='text' class="form-control" id="written_test_scheduled_on" name="written_test_scheduled_on" value="{{$enquiryInfo['written_test_scheduled_on']}}"/>
                                                <span class="input-group-addon">
                                                  <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                         </div>

                                </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Conducted By
                                        </label>
                                        <select class="form-control" name="written_test_conducted_by" id="written_test_conducted_by" value="{{$enquiryInfo['written_test_conducted_by']}}" >



                                            @if($enquiryInfo['written_test_conducted_by']==NULL)
                                                <option value="">Select...</option>
                                                @foreach($interviewUser as $data)
                                                <option value="{!! $data['id'] !!}" >{!! $data['first_name'] !!}</option>
                                                @endforeach
                                            @else
                                                @foreach($interviewUser as $data)
                                                <option value="{{ $data['id'] }}" @if($enquiryInfo['written_test_conducted_by']==$data['id']) selected='selected' @endif>{{ $data['first_name'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Test Status:
                                        </label>
                                        <select class="form-control" name="written_test_status" id="written_test_status" value="{{$enquiryInfo['written_test_status']}}">

                                            @if($enquiryInfo['written_test_status'] != null)
                                                <option value="pass" @if($enquiryInfo['written_test_status']=="pass") selected='selected' @endif>Pass</option>
                                                <option value="fail" @if($enquiryInfo['written_test_status']=="fail") selected='selected' @endif>Fail</option>
                                            @else
                                                <option value="">Select ..</option>
                                                <option value="pass">Pass</option>
                                                <option value="fail">Fail</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Remarks
                                        </label>
                                        <div class="note-editor">
                                            <textarea  name="written_test_remark" data-autosize-on="true" style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px ;width:100%; cursor: url('/assets/images/pen.png') 0 32, auto;">{{$enquiryInfo['written_test_remark']}}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>
                                INTERVIEW DETAILS
                            </legend>
                            <div class="container">

                            </div>
                            <div class="row">

                                    <div class='col-md-6'>
                                        <div class="form-group">
                                            <label class="control-label">
                                                Scheduled on
                                            </label>
                                            <div class='input-group date' id='datetimepicker2'>
                                                <input type='text' class="form-control" value="{{$enquiryInfo['interview_scheduled_on']}}" id="interview_scheduled_on" name="interview_scheduled_on"/>
                                                <span class="input-group-addon">
                                                  <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Conducted By
                                        </label>
                                        <select class="form-control" name="interview_conducted_by" value="{{$enquiryInfo['interview_conducted_by']}}" id="interview_conducted_by" >
                                            @if($enquiryInfo['interview_conducted_by']==NULL)
                                            <option value="">Select...</option>
                                            @foreach($interviewUser as $data)
                                            <option value="{!! $data['id'] !!}" >{!! $data['first_name'] !!}</option>
                                            @endforeach
                                            @else
                                            @foreach($interviewUser as $data)
                                            <option value="{{ $data['id'] }}" @if($enquiryInfo['interview_conducted_by']==$data['id']) selected='selected' @endif>{{ $data['first_name'] }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Interview Status:
                                        </label>
                                        <select class="form-control" name="interview_status" value="{{$enquiryInfo['interview_status']}}" id="interview_status" >

                                            @if($enquiryInfo['interview_status'] != null)
                                            <option value="pass" @if($enquiryInfo['interview_status']=="pass") selected='selected' @endif>Pass</option>
                                            <option value="fail" @if($enquiryInfo['interview_status']=="fail") selected='selected' @endif>Fail</option>
                                            @else
                                            <option value="">Select ..</option>
                                            <option value="pass">Pass</option>
                                            <option value="fail">Fail</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">
                                        Remarks
                                    </label>
                                    <div class="form-group">
                                        <div class="note-editor">
                                            <textarea  name="interview_remark"  data-autosize-on="true" style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px;width:100%; cursor: url('/assets/images/pen.png') 0 32, auto;">{{$enquiryInfo['interview_remark']}}</textarea>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>
                                DOCUMENT DETAILS
                            </legend>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Interview Status:
                                        </label>
                                        <select class="form-control" name="document_status" value="{{$enquiryInfo['document_status']}}" id="document_status" >

                                            @if($enquiryInfo['document_status'] != null)
                                            <option value="clear" @if($enquiryInfo['document_status']=="clear") selected='selected' @endif>Clear</option>
                                            <option value="unclear" @if($enquiryInfo['document_status']=="unclear") selected='selected' @endif>Unclear</option>
                                            @else
                                            <option value="">Select ..</option>
                                            <option value="clear">clear</option>
                                            <option value="unclear">unclear</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">
                                        Remarks
                                    </label>
                                    <div class="form-group">
                                        <div class="note-editor">
                                            <textarea  name="document_remark" data-autosize-on="true"  style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px;width:100%; cursor: url('/assets/images/pen.png') 0 32, auto;">{{$enquiryInfo['document_remark']}}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">
                                        Final admission Status:
                                    </label>
                                    <select class="form-control" name="final_status" value="{{$enquiryInfo['final_status']}}" id="final_status" >

                                        @if($enquiryInfo['final_status'] != null)
                                        <option value="pass" @if($enquiryInfo['final_status']=="pass") selected='selected' @endif>Pass</option>
                                        <option value="fail" @if($enquiryInfo['final_status']=="fail") selected='selected' @endif>Fail</option>
                                        @else
                                        <option value="">Select ..</option>
                                        <option value="pass">Pass</option>
                                        <option value="fail">Fail</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                        </fieldset>

                        <div class="row">
                            <div class="col-md-8">
                                <a href="/manage">
                                    Back
                                </a>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary btn-wide pull-right" type="submit">
                                    Admit
                                </button>
                            </div>

                        </div>
                    </form>
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

<!-- start: MAIN JAVASCRIPTS -->
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/vendor/modernizr/modernizr.js"></script>
<script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/vendor/switchery/switchery.min.js"></script>
<script src="/vendor/selectFx/classie.js"></script>
<script src="/vendor/selectFx/selectFx.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="/vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="/assets/js/main.js"></script>





<script src="/vendor/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
<script src="/vendor/moment/moment.min.js"></script>
<script src="/vendor/fullcalendar/fullcalendar.min.js"></script>
<script src="/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="/assets/js/pages-calendar.js"></script>







<script src="/assets/js/custom-project.js"></script>
<script src="/vendor/ckeditor/ckeditor.js"></script>
<script src="/vendor/ckeditor/adapters/jquery.js"></script>
<script src="/assets/js/form-validation.js"></script>
<script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="/assets/js/enquiry-form.js"></script>
<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();
        Calendar.init();
        var date_input=$('input[name="dob"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
            endDate: '+0d',
        })
    });

    $('#current_class').blur(function() {
        if($(this).val()=="") {
            $('#school_name').attr("disabled", "disabled");
        }else{
            $("#school_name").removeAttr("disabled");
        }
    });
</script>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker({ format:'YYYY-MM-DD hh:mm:00 a' });
    });
</script>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker2').datetimepicker({ format:'YYYY-MM-DD hh:mm:00 a' });
    });
</script>
@stop


