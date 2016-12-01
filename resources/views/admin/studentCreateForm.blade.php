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
            <h1 class="mainTitle">Create</h1>
            <span class="mainDescription">Users</span>
        </div>

    </div>
</section>
<!-- end: DASHBOARD TITLE -->
<!-- start: DYNAMIC TABLE -->

<div class="col-md-12">

    @include('admin.userRoleDropdownCreate')
</div>

<form action="#" role="form" class="smart-wizard" id="student-registration-form">
<div id="wizard" class="swMain col-sm-12">
<!-- start: WIZARD SEPS -->
<div id="error-div"></div>
<ul>
    <li>
        <a href="#step-1">
            <div class="stepNumber">
                1
            </div>
            <span class="stepDesc"><small> Personal Information </small></span>
        </a>
    </li>
    <li>
        <a href="#step-2">
            <div class="stepNumber">
                2
            </div>
            <span class="stepDesc"><small> Complete </small></span>
        </a>
    </li>
</ul>
<div id="step-1">
<div class="row">
    <input type="hidden" id="role" name="role" value="3">
    <input type="hidden" id="role_name" name="role_name" value="student">
<div class="col-md-8 col-md-offset-2">
<fieldset>
    <legend>
        Personal Information (student)
    </legend>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    Select Batch
                </label>
                <select class="form-control" name="batch" style="-webkit-appearance: menulist;" id="batch">
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    Select class
                </label>
                <select class="form-control" name="class" style="-webkit-appearance: menulist;" id="class">
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    Select division
                </label>
                <select class="form-control" name="division" style="-webkit-appearance: menulist;" id="division">
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div id="w">
                <div id="content">

                    <div id="searchfield">
                        <form>
                            <div class="form-group ">
                                <label class="control-label">
                                    Parent Name: <span class="symbol required"></span>
                                </label>
                                <input type="text" placeholder="Enter Parent Name" class="form-control" name="parent_name" id="autocomplete">
                                <input type='hidden' name='parent_id' id='parent_id'>
                                <br>
                                <div class="form-group" id="outputcontent"></div>
                            </div>
                        </form>
                    </div><!-- @end #searchfield -->
                </div><!-- @end #content -->
            </div><!-- @end #w -->
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    GRN <span class="symbol required"></span>
                </label>
                <input type="text" placeholder="Enter a GRN" class="form-control" name="grn" id="grn"/>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-4">

            <div class="form-group">
                <label  class="control-label">
                    First Name <span class="symbol required"></span>
                </label>
                <input type="text" placeholder="Enter your First Name" class="form-control" name="firstName"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">
                    Middle Name <span class="symbol required"></span>
                </label>
                <input type="text" placeholder="Enter your Middle Name" class="form-control" name="middleName"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">
                    Last Name <span class="symbol required"></span>
                </label>
                <input type="text" placeholder="Enter your Last Name" class="form-control" name="lastName"/>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    User Name <span class="symbol required"></span>
                </label>
                <input type="text" placeholder="Enter a User Name" class="form-control" name="userName" id="userName"/>
                <div id="userNameFeedback"><div class="" id="feedback" ></div></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group"> <!-- Date input -->
                <label class="control-label" for="dob">Date Of Birth</label>
                <input class="form-control" id="dob" name="dob" placeholder="MM/DD/YYY" type="text" value="{!! date('m/d/Y', time());!!}"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    Place of Birth <span class="symbol required"></span>
                </label>
                <input type="text" placeholder="Enter a Place of Birth" class="form-control" name="bith_place" id="bith_place"/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label  class="control-label">
                    Nationality <span class="symbol required"></span>
                </label>
                <input type="text" placeholder="Enter Nationality" class="form-control" name="nationality"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    Religion
                </label>
                <input type="text" placeholder="Enter Religion" class="form-control" name="religion"/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label  class="control-label">
                    Caste
                </label>
                <input type="text" placeholder="Enter Caste" class="form-control" name="caste"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    Category
                </label>
                <input type="text" placeholder="Enter Category" class="form-control" name="category"/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    Password <span class="symbol required"></span>
                </label>
                <input type="password" placeholder="Enter a Password" class="form-control" name="password" id="password"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    Repeat Password <span class="symbol required"></span>
                </label>
                <input type="password" placeholder="Repeat Password" class="form-control" name="password2"/>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    Mobile Number <span class="symbol required"></span>
                </label>
                <input type="text" placeholder="Enter a Mobile Number" class="form-control" name="mobile"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    Alternate Contact Number
                </label>
                <input type="text" placeholder="Enter a Alternate Contact Number" class="form-control" name="alt_number"/>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    Email
                </label>
                <input type="email" placeholder="Enter a valid E-mail" class="form-control" name="email" id="stud_email">
                <div id="emailIdfeedback"><div class="" id="emailfeedback" ></div></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="block">
                    Gender
                </label>
                <div class="clip-radio radio-primary">
                    <input type="radio" id="wz-female" name="gender" value="F">
                    <label for="wz-female">
                        Female
                    </label>
                    <input type="radio" id="wz-male" name="gender" value="M" checked>
                    <label for="wz-male">
                        Male
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-6">
            <div class="form-group">
                <label  class="control-label">
                    Permanent Address <span class="symbol required"></span>
                </label>
                <div class="note-editor">
                    <textarea class="form-control autosize area-animated" name="address" data-autosize-on="true" style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px; cursor: url('/assets/images/pen.png') 0 32, auto;">
                    </textarea>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label  class="control-label">
                    Communication Address <span class="symbol required"></span>
                </label>
                <div class="note-editor">
                    <textarea class="form-control autosize area-animated" name="communication_address" data-autosize-on="true" style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px; cursor: url('/assets/images/pen.png') 0 32, auto;">
                    </textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    Aadhar Card Number <span class="symbol required"></span>
                </label>
                <input type="text" placeholder="Aadhar Card Number " class="form-control" name="aadhar_number"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="form-field-select-2">
                    Select Blood Group
                </label>
                <select class="form-control" id="batch-select" style="-webkit-appearance: menulist;">
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    Mother Tongue <span class="symbol required"></span>
                </label>
                <input type="text" placeholder="Enter a Mother Tongue" class="form-control" name="mother_tongue"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    Other Languages spoken/written
                </label>
                <input type="text" placeholder="Enter a Other Languages spoken/written" class="form-control" name="other_language"/>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="form-field-select-2">
                    Highest Standard Passed
                </label>
                <select class="form-control" id="batch-select" style="-webkit-appearance: menulist;">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                   Roll Number
                </label>
                <input type="text" placeholder="Enter a Roll Number" class="form-control" name="roll_number"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    Academic session applied to
                </label>
                <input type="text" class="form-control" name="academic_to"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    Academic session applied from
                </label>
                <input type="text"  class="form-control" name="academic_from"/>
            </div>
        </div>
    </div>
</fieldset>


    <fieldset>
        <legend>
            FAMILY INFORMATION (student)
        </legend>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label  class="control-label">
                        Father’s/Guardian’s First Name <span class="symbol required"></span>
                    </label>
                    <input type="text" placeholder="Enter your First Name" class="form-control" name="fatherFirstName"/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">
                        Middle Name
                    </label>
                    <input type="text" placeholder="Enter your Middle Name" class="form-control" name="fatherMiddleName"/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">
                        Last Name
                    </label>
                    <input type="text" placeholder="Enter your Last Name" class="form-control" name="fatherLastName"/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label  class="control-label">
                        Father’s/Guardian’s Occupation <span class="symbol required"></span>
                    </label>
                    <input type="text" placeholder="Enter Occupation" class="form-control" name="fatherOccuption"/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">
                        Father’s/Guardian’s Income <span class="symbol required"></span>
                    </label>
                    <input type="text" placeholder="Enter Income" class="form-control" name="fatherIncome"/>P.A.
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">
                        Father’s/Guardian’s Contact Number <span class="symbol required"></span>
                    </label>
                    <input type="text" placeholder="Enter Contact Number" class="form-control" name="fatherContactNo"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label  class="control-label">
                        Mother’s/Guardian’s First Name <span class="symbol required"></span>
                    </label>
                    <input type="text" placeholder="Enter your First Name" class="form-control" name="motherFirstName"/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">
                        Middle Name
                    </label>
                    <input type="text" placeholder="Enter your Middle Name" class="form-control" name="motherMiddleName"/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">
                        Last Name
                    </label>
                    <input type="text" placeholder="Enter your Last Name" class="form-control" name="motherLastName"/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label  class="control-label">
                        Mother’s/Guardian’s Occupation <span class="symbol required"></span>
                    </label>
                    <input type="text" placeholder="Enter Occupation" class="form-control" name="motherOccuption"/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">
                        Mother’s/Guardian’s Income <span class="symbol required"></span>
                    </label>
                    <input type="text" placeholder="Enter Income" class="form-control" name="motherIncome"/>P.A.
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">
                        Mother’s/Guardian’s Contact Number <span class="symbol required"></span>
                    </label>
                    <input type="text" placeholder="Enter Contact Number" class="form-control" name="motherContactNo"/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label  class="control-label">
                        Email <span class="symbol required"></span>
                    </label>
                    <input type="text" placeholder="Enter email" class="form-control" name="parentemail"/>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label  class="control-label">
                        Permanent Address <span class="symbol required"></span>
                    </label>
                    <div class="note-editor">
                        <textarea class="form-control autosize area-animated" name="parent_address" data-autosize-on="true" style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px; cursor: url('/assets/images/pen.png') 0 32, auto;">
                        </textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label  class="control-label">
                        Communication Address <span class="symbol required"></span>
                    </label>
                    <div class="note-editor">
                        <textarea class="form-control autosize area-animated" name="parent_communication_address" data-autosize-on="true" style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px; cursor: url('/assets/images/pen.png') 0 32, auto;">
                        </textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <label  class="control-label col-md-3">
                SIBLINGS <span class="symbol required"></span>
            </label>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" placeholder="Name" class="form-control" >
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" placeholder="Age" class="form-control" >
                </div>
            </div>
            <div class="col-md-3 ">
                <button type="submit" class="btn btn-primary" id="addBatch"><i class="ti-plus"></i></button>
            </div>
        </div>

    </fieldset>

    <fieldset>
        <legend>
            DETAILS OF PREVIOUS SCHOOL ATTENDED
        </legend>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label  class="control-label">
                        School Name
                    </label>
                    <input type="text" placeholder="Enter School Name" class="form-control" name="schoolName"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">
                        UDISE No.
                    </label>
                    <input type="text" placeholder="Enter your Middle Name" class="form-control" name="udise_no"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label  class="control-label">
                        City
                    </label>
                    <input type="text" placeholder="Enter School Name" class="form-control" name="city"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">
                        Medium of instruction
                    </label>
                    <input type="text" placeholder="Enter your Middle Name" class="form-control" name="mediumOfInstruction"/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label  class="control-label">
                        Name of board/examination
                    </label>
                    <input type="text" placeholder="Enter School Name" class="form-control" name="board_examination"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">
                        Grades / %
                    </label>
                    <input type="text" placeholder="Enter your Middle Name" class="form-control" name="grades"/>
                </div>
            </div>
        </div>

    </fieldset>

        <fieldset>
            <legend>
                SPECIAL APTITUDE
            </legend>


        </fieldset>
        <fieldset>
            <legend>
                INTEREST / HOBBIES
            </legend>


        </fieldset>

        <fieldset>
            <legend>
                DOCUMENTS SUBMITTED
            </legend>


        </fieldset>
<div class="form-group">
    <button class="btn btn-primary btn-o next-step btn-wide pull-right" id="checkUser" >
        Next <i class="fa fa-arrow-circle-right"></i>
    </button>
</div>
</div>
</div>
</div>
<div id="step-2">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                <h1 class=" ti-check block text-primary"></h1>
                <h2 class="StepTitle">Congratulations!</h2>
                <p class="text-large">
                    You have created new user.
                </p>
                <p class="text-small">
                    User will get the mail confirmation about his/her account. This mail includes link for login and his/her login credentials.
                </p>
                <a class="btn btn-primary btn-o" href="studentCreate">
                    Back to first step
                </a>
            </div>
        </div>
    </div>
</div>
</div>
</form>

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
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/modernizr/modernizr.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<script src="vendor/selectFx/classie.js"></script>
<script src="vendor/selectFx/selectFx.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
<script type="text/javascript" src="assets/js/jquery.autocomplete.min.js"></script>

<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>

<script src="assets/js/student-form-wizard.js"></script>

<script src="assets/js/custom-project.js"></script>
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="assets/js/form-validation.js"></script>

<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();
        FormWizard.init();
        getParents();
        getbatches();
        var date_input=$('input[name="dob"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'mm/dd/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        })
    });
</script>
<script type="text/javascript">

    $('#role-select').on('change',function(){

        var par=this.value;

        if(isNaN(par)==false)
        {
            var route= "/createUsers/"+par;

            window.location.replace(route);

        }

    });
    function getbatches()
    {
        var route='get-batches';
        $.get(route,function(res){
            var str = "<option value=''>Please Select Batch</option>";
            for(var i=0; i<res.length; i++){
                str+='<option value='+res[i]['id']+'>'+res[i]['name']+'</option>';
            }
            $('#batch').html(str);
        });
    }

    $("#batch").change(function() {
        var id = this.value;
        var route='get-classes/'+id;
        $.get(route,function(res){
            var str = "<option value=''>Please Select Class</option>";
            for(var i=0; i<res.length; i++){
                str+='<option value='+res[i]['id']+'>'+res[i]['class_name']+'</option>';
            }
            $('#class').html(str);
        });
    });

    $("#class").change(function() {
        var id = this.value;
        var route='get-divisions/'+id;
        $.get(route,function(res){
            var str = "<option value=''>Please Select Division</option>";
            for(var i=0; i<res.length; i++){
                str+='<option value='+res[i]['id']+'>'+res[i]['division_name']+'</option>';
            }
            $('#division').html(str);
        });
    });

    function getParents()
    {
        $(function(){
            $.ajax({
                url: '/get-parents',
                type:'get',
                dataType:'json',
                success: function (currencies) {
                    $('#autocomplete').autocomplete({
                        lookup: currencies,
                        onSelect: function (suggestion) {
                            var thehtml = '<strong>Showing result for:</strong> ' + suggestion.value;
                            $('#parent_id').val(suggestion.data);
                            $('#outputcontent').html(thehtml);
                            $('#tabTable').show();
                            var val3=$('#autocomplete').html(suggestion.value).text();
                            $('#autocomplete').val(val3);
                        }
                    });
                }
            });

        });

    }

    $('#autocomplete').keyup(function(e){
        if(e.keyCode != 13)
        {
            $('#parent_id').val('');
        }
    });

</script>

@stop
