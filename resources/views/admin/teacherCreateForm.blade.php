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
<form action="#" role="form" class="smart-wizard" id="registrationForm" enctype="multipart/form-data">
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
            <span class="stepDesc"><small> Assign Modules </small></span>
        </a>
    </li>
    <li>
        <a href="#step-3">
            <div class="stepNumber">
                3
            </div>
            <span class="stepDesc"> <small> Complete </small> </span>
        </a>
    </li>
</ul>
<div id="step-1">
    <div class="row">
        <input type="hidden" id="role" name="role" value="2">
        <input type="hidden" id="role_name" name="role_name" value="teacher">
        <div class="col-md-8 col-md-offset-2">
            <fieldset>
                <legend>
                    Personal Information (teacher)
                </legend>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">
                                First Name <span class="symbol required"></span>
                            </label>
                            <input type="text" placeholder="Enter your First Name" class="form-control" name="firstName"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">
                                Middle Name
                            </label>
                            <input type="text" placeholder="Enter your Middle Name" class="form-control" name="middleName"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">
                                Last Name
                            </label>
                            <input type="text" placeholder="Enter your Last Name" class="form-control" name="lastName"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!--<div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                User Name <span class="symbol required"></span>
                            </label>
                            <input type="text" placeholder="Enter a User Name" class="form-control" name="userName" id="userName"/>
                            <div id="userNameFeedback"><div class="" id="feedback" ></div></div>
                        </div>
                    </div>-->
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
                        <div class="form-group"> <!-- Date input -->
                            <label class="control-label" for="dob">Date Of Birth</label>
                            <input class="form-control" id="dob" name="dob" placeholder="MM/DD/YYY" type="text" value="{!! date('d/m/Y', time());!!}"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="form-field-select-2">
                                Marital Status <span class="symbol required"></span>
                            </label>
                            <select class="form-control" id="martial_status" style="-webkit-appearance: menulist;" name="martial_status">
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                                <option value="divorced">Divorced</option>
                                <option value="separated">Separated</option>
                                <option value="widowed">Widowed</option>
                            </select>
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
                                Email <span class="symbol required"></span>
                            </label>
                            <input type="email" placeholder="Enter a valid E-mail" class="form-control" name="email" id="email">
                            <div id="emailIdfeedback"><div class="" id="emailfeedback" ></div></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                Allow For <em>(select at least One)</em> <span class="symbol required"></span>
                            </label>
                            <div class="checkbox clip-check check-primary">
                                <input  type="checkbox" value="web" name="access[]" id="checkbox6" checked>
                                <label class="control-label" for="checkbox6">
                                    Web Access
                                </label>
                            </div>
                            <div class="checkbox clip-check check-primary">
                                <input type="checkbox" value="mobile" name="access[]" id="checkbox7" checked>
                                <label class="control-label" for="checkbox7">
                                    Mobile Access
                                </label>
                            </div>
                            <div >
                                <input style="opacity:0; position:absolute;" type="checkbox" value="" name="access[]" id="checkbox8">
                            </div>
                        </div>
                       </div>
                </div>
                <!--<div class="row">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                Address <span class="symbol required"></span>
                            </label>
                            <div class="note-editor">
                                <textarea class="form-control autosize area-animated" name="address" data-autosize-on="true" style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px; cursor: url('/assets/images/pen.png') 0 32, auto;">
                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>-->
                <div class="row">
                    <div class="col-md-6">
                        <label class="control-label">
                            Employee Type <span class="symbol required"></span>
                        </label>
                        <div class="form-group">
                            <select class="form-control" id="emp_type" name="emp_type" style="-webkit-appearance: menulist;">
                                <option value="full_time">Full Time  </option>
                                <option value="part_time">Part Time</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                Make Class Teacher
                            </label>
                            <div class="checkbox clip-check check-primary">
                                <input type="checkbox" id="checkbox9" value="1" onchange="clsTeacher(this.checked)" name="class-teacher">
                                <label for="checkbox9">
                                    Approve
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="clstchr_batch" style="display:none;">
                            <label class="control-label">
                                Select Batch
                            </label>
                            <select class="form-control" name="batch" style="-webkit-appearance: menulist;" id="batch">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="clstchr_class" style="display:none;" >
                            <label class="control-label">
                                Select Class
                            </label>
                            <select class="form-control" name="class" style="-webkit-appearance: menulist;" id="class">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="clstchr_div" style="display:none;">
                            <label class="control-label">
                                Select Division
                            </label>
                            <select class="form-control" name="division" style="-webkit-appearance: menulist;" id="division">
                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>
                    Name of Spouse
                </legend>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label  class="control-label">
                                First Name
                            </label>
                            <input type="text" placeholder="Enter your First Name" class="form-control" name="spouse_first_name"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                Middle Name
                            </label>
                            <input type="text" placeholder="Enter your Middle Name" class="form-control" name="spouse_middle_name"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                Last Name
                            </label>
                            <input type="text" placeholder="Enter your Last Name" class="form-control" name="spouse_last_name"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                Issues
                            </label>
                            <input type="text" placeholder="Enter Issues" class="form-control" name="issues"/>
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
                                <textarea class="form-control autosize area-animated" name="permanent_address" data-autosize-on="true" style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px; cursor: url('/assets/images/pen.png') 0 32, auto;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label  class="control-label">
                                Communication Address <span class="symbol required"></span>
                            </label><br>
                            <input type="checkbox" name="teacher_communication_address" id="teacher_communication_address" checked> Same as Permanent Address
                            <div class="note-editor" id="communication_address_teacher">
                                <textarea class="form-control autosize area-animated" name="communication_address_teacher" data-autosize-on="true" style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px; cursor: url('/assets/images/pen.png') 0 32, auto;">
                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label  class="control-label">
                                Pan Card No.
                            </label>
                            <input type="text" placeholder="Enter Pan Card No." class="form-control" name="pan_card"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                Aadhar Card No.
                            </label>
                            <input type="text" placeholder="Aadhar Card Number " class="form-control" name="aadhar_number"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label  class="control-label">
                                Designation
                            </label>
                            <input type="text" placeholder="Enter Designation" class="form-control" name="designation"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"> <!-- Date input -->
                            <label class="control-label" for="joining_date">Date Of Joining</label>
                            <input class="form-control" id="joining_date" name="joining_date" placeholder="MM/DD/YYY" type="text" value="{!! date('d/m/Y', time());!!}"/>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>
                    EDUCATIONAL QUALIFICATIONS
                </legend>
                <INPUT type="button" value="Add Row" onclick="addRowEducationlQualification('dataTable')" />
                <TABLE id="dataTable" width="350px" border="1">
                    <TR>
                        <TH>Certificate/Degree </TH>
                        <TH> Passing Year </TH>
                        <TH>  University/Board</TH>
                        <TH> Subject(s) </TH>
                    </TR>
                    <TR>
                        <TD> <INPUT type="text" name="qualification[0][certificate]" placeholder="Certificate/Degree"/> </TD>
                        <TD> <INPUT type="text" name="qualification[0][passing_year]" placeholder="Passing Year"/> </TD>
                        <TD> <INPUT type="text" name="qualification[0][university]" placeholder="University/Board"/> </TD>
                        <TD> <INPUT type="text" name="qualification[0][subjects]" placeholder="Subject(s)"/> </TD>
                    </TR>
                </TABLE>

            </fieldset>
            <fieldset>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label  class="control-label">
                                Methods in B.Ed.
                            </label>
                            <input type="text" placeholder="Enter Methods in B.Ed." class="form-control" name="b_ed_methods"/>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>
                    WORK EXPERIENCE
                </legend>
                <INPUT type="button" value="Add Row" onclick="addRowWorkExperience('work_experience')" />
                <TABLE id="work_experience" width="350px" border="1">
                    <TR>
                        <TH>Organisation</TH>
                        <TH>Designation </TH>
                        <TH>Duration</TH>
                    </TR>
                    <TR>
                        <TD> <INPUT type="text" name="work_experience[0][organisation]" placeholder="Organisation"/> </TD>
                        <TD> <INPUT type="text" name="work_experience[0][designation]" placeholder="Designation"/> </TD>
                        <TD> <INPUT type="text" name="work_experience[0][duration]" placeholder="Duration"/> </TD>
                    </TR>
                </TABLE>

            </fieldset>
            <fieldset>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label  class="control-label">
                                Work Experience (in years)
                            </label>
                            <input type="text" placeholder="Enter Work Experience (in years)" class="form-control" name="total_work_experience"/>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>
                    REFERENCE AND THEIR CONTACT DETAILS
                </legend>
                <INPUT type="button" value="Add Row" onclick="addRowReference('references')" />
                <TABLE id="references"  border="1">
                    <TR>
                        <TH>Reference Name</TH>
                        <TH>Contact Number </TH>
                        <TH>Address</TH>
                    </TR>
                    <TR>
                        <TD> <INPUT type="text" name="reference[0][reference_name]" placeholder="Reference Name"/> </TD>
                        <TD> <INPUT type="text" name="reference[0][contact_no]" placeholder="Contact Number"/> </TD>
                        <TD> <INPUT type="text" name="reference[0][address]" placeholder="Address"/> </TD>
                    </TR>
                </TABLE>
            </fieldset>

            <fieldset>
                <legend>
                    DOCUMENTS
                </legend>
                <INPUT type="button" value="Add Row" onclick="addRowUploadDoc('upload_doc')" />
                <TABLE id="upload_doc"  border="1">
                    <TR>
                        <TD> <INPUT type="file" name="upload_doc[]"/> </TD>
                    </TR>
                </TABLE>
            </fieldset>
            <div class="form-group">
                <button class="btn btn-primary btn-o next-step btn-wide pull-right" id="checkUser" disabled>
                    Next <i class="fa fa-arrow-circle-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<div id="step-2">
    <div class="row">
        <div class="col-md-12">
            <fieldset>
                <div class="panel-body">
                    <div id="panel_module_assigned" class="tab-pane">
                        <div class="panel-body">
                            <div class="col-sm-10">

                                <table class="table table-responsive" id="aclModCreate">

                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="form-group">
                <button class="btn btn-primary btn-o back-step btn-wide pull-left">
                    <i class="fa fa-circle-arrow-left"></i> Back
                </button>
                <div id="loadmoreajaxloader" style="display:none;"><center><img src="assets/images/loader1.gif" /></center></div>
                <button class="btn btn-primary btn-o finish-step btn-wide pull-right" id="submitStep" onclick="this.disabled = true">
                    Next <i class="fa fa-arrow-circle-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<div id="step-3">
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
                <a class="btn btn-primary btn-o" href="teacherCreate">
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
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>

<script src="assets/js/form-wizard.js"></script>
<script src="assets/js/custom-project.js"></script>
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="assets/js/form-validation.js"></script>

<script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script>
    jQuery(document).ready(function() {
        userAclModule();
        getbatches();
        getMsgCount();
        Main.init();
        FormValidator.init();
        FormWizard.init();
        $('option#4').hide();

        var date_input=$('input[name="dob"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
            endDate: '+0d',
        })


        var date_input=$('input[name="joining_date"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        })
    });
</script>
<script type="text/javascript">


function addRowEducationlQualification(tableID){
    var table = document.getElementById(tableID);

    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    var cell2 = row.insertCell(0);
    var element2 = document.createElement("input");
    element2.type = "text";
    element2.placeholder = "Certificate/Degree";
    element2.name = "qualification["+rowCount+"][certificate]";
    cell2.appendChild(element2);

    var cell3 = row.insertCell(1);
    var element3 = document.createElement("input");
    element3.type = "text";
    element3.placeholder = "Passing Year";
    element3.name = "qualification["+rowCount+"][passing_year]";
    cell3.appendChild(element3);

    var cell4 = row.insertCell(2);
    var element4 = document.createElement("input");
    element4.type = "text";
    element4.placeholder = "University/Board";
    element4.name = "qualification["+rowCount+"][university]";
    cell4.appendChild(element4);

    var cell5 = row.insertCell(3);
    var element5 = document.createElement("input");
    element5.type = "text";
    element5.placeholder = "Subject(s)";
    element5.name = "qualification["+rowCount+"][subjects]";
    cell5.appendChild(element5);
}

function addRowWorkExperience(tableID){
    var table = document.getElementById(tableID);

    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    var cell2 = row.insertCell(0);
    var element2 = document.createElement("input");
    element2.type = "text";
    element2.placeholder = "Organisation	  ";
    element2.name = "work_experience["+rowCount+"][organisation]";
    cell2.appendChild(element2);

    var cell3 = row.insertCell(1);
    var element3 = document.createElement("input");
    element3.type = "text";
    element3.placeholder = "Designation";
    element3.name = "work_experience["+rowCount+"][designation]";
    cell3.appendChild(element3);

    var cell4 = row.insertCell(2);
    var element4 = document.createElement("input");
    element4.type = "text";
    element4.placeholder = "Duration";
    element4.name = "work_experience["+rowCount+"][duration]";
    cell4.appendChild(element4);
}

function addRowReference(tableID){
    var table = document.getElementById(tableID);

    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    var cell2 = row.insertCell(0);
    var element2 = document.createElement("input");
    element2.type = "text";
    element2.placeholder = "Reference Name	  ";
    element2.name = "reference["+rowCount+"][reference_name]";
    cell2.appendChild(element2);

    var cell3 = row.insertCell(1);
    var element3 = document.createElement("input");
    element3.type = "text";
    element3.placeholder = "Contact Number";
    element3.name = "reference["+rowCount+"][contact_no]";
    cell3.appendChild(element3);

    var cell4 = row.insertCell(2);
    var element4 = document.createElement("input");
    element4.type = "text";
    element4.placeholder = "Address";
    element4.name = "reference["+rowCount+"][address]";
    cell4.appendChild(element4);
}
function addRowUploadDoc(tableID){
    var table = document.getElementById(tableID);

    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    var cell3 = row.insertCell(0);
    var element2 = document.createElement("input");
    element2.type = "file";
    element2.name = "upload_doc[]";
    cell3.appendChild(element2);
}




$('#communication_address_teacher').hide();

$("#teacher_communication_address").click(function(){
    $('#communication_address_teacher').toggle();
});
    $('#role-select').on('change',function(){

        var par=this.value;

        if(isNaN(par)==false)
        {
            var route= "/createUsers/"+par;

            window.location.replace(route);

        }

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
    function userAclModule()
    {

        var disableModules = ['create_class','delete_homework','publish_homework','delete_user','publish_user','update_message','delete_message','delete_leave','update_leave','create_leave','publish_attendance','delete_attendance','publish_announcement','publish_achievement','delete_subject','update_subject','publish_subject','delete_class','publish_class','update_class','publish_event','delete_event','publish_message','publish_achievement','delete_achievement','publish_announcement','delete_announcement','publish_timetable'];

        $('div#loadmoreajaxloader').show();
        var route='user-module-acl';
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
                        '<div class="checkbox form-group clip-check check-primary checkbox-inline">';

                    if($.inArray(arr2[j]['slug']+'_'+arr1[i],disableModules) === -1) {
                        str+='<input type="checkbox" class="'+arr1[i]+'" value="'+arr2[j]['slug']+'_'+arr1[i]+'" id="'+arr2[j]['slug']+'_'+arr1[i]+'" name="modules[]">'+
                            '<label for="'+arr2[j]['slug']+'_'+arr1[i]+'"></label>';
                    } else {
                        str+="--";
                    }

                    str+='</div>'+
                        '</td>';
                }

                str+="</tr>";
            }

            $('#aclModCreate').html(str);
            $('div#loadmoreajaxloader').hide();

            ///////////user///////////


            $('.user').change(function(){

                if($.inArray(this.id,["create_user","update_user"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.user').each(function() {

                            if(this.id == "view_user") {
                                this.checked = true;
                            }

                        });
                    } else {
                        $('.user').each(function() {

                            if(this.id == "view_user") {
                                this.checked = false;
                            }

                        });
                    }

                } else if($(this).prop('checked') == false && this.id == "view_user") {
                    $('.user').each(function() {

                        if($.inArray(this.id,["create_user","update_user"]) !== -1) {
                            this.checked = false;
                        }

                    });
                }

            });

            /////////////////////Homework///////////

            $('.homework').change(function(){

                if($.inArray(this.id,["create_homework","update_homework"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.homework').each(function() {

                            this.checked = true;

                        });
                    } else {
                        $('.homework').each(function() {

                            this.checked = false;


                        });
                    }

                } else if($(this).prop('checked') == false && this.id == "view_homework") {
                    $('.homework').each(function() {

                        this.checked = false;

                    });
                }

            });

            /////////////////////Leave///////////

            $('.leave').change(function(){

                if($.inArray(this.id,["publish_leave"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.leave').each(function() {

                            this.checked = true;

                        });
                    } else {
                        $('.leave').each(function() {

                            this.checked = false;

                        });
                    }

                } else if($(this).prop('checked') == false && this.id == "view_leave") {
                    $('.leave').each(function() {

                        this.checked = false;

                    });
                }

            });

            /////////////////////Class///////////

            $('.class').change(function(){

                if($.inArray(this.id,["create_class"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.class').each(function() {

                            if(this.id == "view_class") {

                                this.checked = true;

                            }

                        });
                    } else {
                        $('.class').each(function() {

                            this.checked = false;

                        });
                    }

                } else if($(this).prop('checked') == false && this.id == "view_class") {
                    $('.class').each(function() {

                        this.checked = false;

                    });
                }

            });

            /////////////////////Subject///////////

            $('.subject').change(function(){

                if($.inArray(this.id,["create_subject"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.subject').each(function() {

                            if(this.id == "view_subject") {

                                this.checked = true;

                            }

                        });
                    } else {
                        $('.subject').each(function() {

                            this.checked = false;

                        });
                    }

                } else if($(this).prop('checked') == false && this.id == "view_subject") {
                    $('.subject').each(function() {

                        this.checked = false;

                    });
                }

            });


            /////////////////////Message///////////

            $('.message').change(function(){

                if($.inArray(this.id,["create_message"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.message').each(function() {

                            this.checked = true;

                        });
                    } else {
                        $('.message').each(function() {

                            this.checked = false;

                        });
                    }

                } else if($(this).prop('checked') == false && this.id == "view_message") {
                    $('.message').each(function() {

                        this.checked = false;

                    });
                }

            });


            /////////////////////Announcement///////////

            $('.announcement').change(function(){

                if($.inArray(this.id,["create_announcement","update_announcement"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.announcement').each(function() {

                            this.checked = true;

                        });
                    } else {
                        $('.announcement').each(function() {

                            this.checked = false;


                        });
                    }

                } else if($(this).prop('checked') == false && this.id == "view_announcement") {
                    $('.announcement').each(function() {

                        this.checked = false;

                    });
                }

            });

            /////////////////////Achievement///////////

            $('.achievement').change(function(){

                if($.inArray(this.id,["create_achievement","update_achievement"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.achievement').each(function() {

                            this.checked = true;

                        });
                    } else {
                        $('.achievement').each(function() {

                            this.checked = false;


                        });
                    }

                } else if($(this).prop('checked') == false && this.id == "view_achievement") {
                    $('.achievement').each(function() {

                        this.checked = false;

                    });
                }

            });

            /////////////////////Timetable///////////

            $('.timetable').change(function(){

                if($.inArray(this.id,["create_timetable","update_timetable","delete_timetable"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.timetable').each(function() {

                            if(this.id == "view_timetable") {
                                this.checked = true;
                            }

                        });
                    }else if($(this).prop('checked') == false) {
                        $('.timetable').each(function() {

                            if(this.id == "view_timetable") {
                                this.checked = true;
                            }

                        });
                    } else {
                        $('.timetable').each(function() {

                            if(this.id == "view_timetable") {

                                this.checked = false;

                            }

                        });
                    }

                } else if($(this).prop('checked') == false && this.id == "view_timetable") {
                    $('.timetable').each(function() {

                        this.checked = false;

                    });
                }

            });


            /////////////////////Attendance///////////

            $('.attendance').change(function(){

                if($.inArray(this.id,["create_attendance","update_attendance"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.attendance').each(function() {

                            this.checked = true;

                        });
                    } else {
                        $('.attendance').each(function() {

                            this.checked = false;


                        });
                    }

                } else if($(this).prop('checked') == false && this.id == "view_attendance") {
                    $('.attendance').each(function() {

                        this.checked = false;

                    });
                }

            });

            /////////////////////Event///////////

            $('.event').change(function(){

                if($.inArray(this.id,["create_event","update_event"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.event').each(function() {

                            this.checked = true;

                        });
                    } else {
                        $('.event').each(function() {

                            this.checked = false;


                        });
                    }

                } else if($(this).prop('checked') == false && this.id == "view_event") {
                    $('.event').each(function() {

                        this.checked = false;

                    });
                }

            });

        });
    }


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

    $("#division").change(function() {
        var id = this.value;
        var route='check-class-teacher/'+id;
        $.get(route,function(res){
            for(var i=0; i<res.length; i++){
               var confirmation =confirm("For Selected Batch Class Division "+res[i]['first_name']+"  "+ res[i]['last_name']+" is class teacher .Do you want to change ?");
                if(confirmation == false){
                    $('#batch').prop('selectedIndex',0);
                    $('#class').prop('selectedIndex',0);
                    $('#division').prop('selectedIndex',0);
                }
            }
        });
    });
</script>

@stop
