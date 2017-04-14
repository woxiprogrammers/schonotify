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

<form action="#" role="form" class="smart-wizard" id="student-registration-form" enctype="multipart/form-data">
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
            <span class="stepDesc"><small> Parent Assigned Modules </small></span>
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
            <label class="control-label" for="dob">Date Of Birth <span class="symbol required"></span> </label>
            <input class="form-control" id="dob" name="dob" placeholder="MM/DD/YYY" type="text" value="{!! date('d/m/Y', time());!!}"/>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">
                Place of Birth <span class="symbol required"></span>
            </label>
            <input type="text" placeholder="Enter a Place of Birth" class="form-control" name="birth_place" id="birth_place"/>
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
    
	<select class="form-control" name="category" id="batch-select" style="-webkit-appearance: menulist;">
         <option value="">Please Select </option>
                <option value="SC">SC</option>
                <option value="ST">ST</option>
                <option value="VJA">VJ(A)</option>
                <option value="NTB">NT(B)</option>
                <option value="NTC">NT(C)</option>
                <option value="NTD">NT(D)</option>
                <option value="OBC">OBC</option>
                <option value="SBC">SBC</option>
                <option value="OPEN">OPEN</option>
                <option value="MARATHAESBC">MARATHA(ESBC)</option>
                <option value="MUSLIMSBCA">MUSLIM(SBC-A)</option>
    
	</select>
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
<!--<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">
                Email
            </label>
            <input type="email" placeholder="Enter a valid E-mail" class="form-control" name="email" id="stud_email">
            <div id="emailIdfeedback"><div class="" id="emailfeedback" ></div></div>
        </div>
    </div>
</div>-->
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
            </label><br>
            <input type="checkbox" name="student_communication_address" id="student_communication_address" checked> Same as Permanent Address
            <div class="note-editor" id="communication_address">
                <textarea  class="form-control autosize area-animated"  name="communication_address" data-autosize-on="true" style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px; cursor: url('/assets/images/pen.png') 0 32, auto;">
                </textarea>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">
                Aadhar Card Number
            </label>
            <input type="text" placeholder="Aadhar Card Number " class="form-control" name="aadhar_number"/>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="form-field-select-2">
                Select Blood Group
            </label>
            <select class="form-control" name="blood_group" id="batch-select" style="-webkit-appearance: menulist;">
                <option value="">Please Select </option>
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
            <select class="form-control" id="highest_standard" style="-webkit-appearance: menulist;" name="highest_standard">
                <option value="">Please Select </option>
                <option value="nursery">Nursery </option>
                <option value="LKG">L KG</option>
                <option value="UKG">U KG</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="Not Attended">Not Attended</option>
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
        STUDENT'S FAMILY INFORMATION
    </legend>

    <div class="row">
        <div class="col-md-12">

            <div id="w">
                <div id="content">

                    <div id="searchfield">
                        <form>
                            <div class="form-group ">
                                <label class="control-label">
                                    Parent Email: <span class="symbol required"></span>
                                </label>
                                <input type="text" placeholder="Enter Parent Email" class="form-control" name="parent_name" id="autocomplete" tabindex="-1">
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
        <div class="col-md-4">
            <div class="form-group">
                <label  class="control-label">
                    Father’s/Guardian’s Name <span class="symbol required"></span>
                </label>
                <input type="text" placeholder="Enter your First Name" class="form-control" tabindex="-1" name="father_first_name" id="father_first_name"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">
                    Middle Name
                </label>
                <input type="text" tabindex="-1" placeholder="Enter your Middle Name" class="form-control" name="father_middle_name" id="father_middle_name"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">
                    Last Name
                </label>
                <input type="text" tabindex="-1" placeholder="Enter your Last Name" class="form-control" name="father_last_name" id="father_last_name"/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label  class="control-label">
                    Father’s/Guardian’s   Occupation <span class="symbol required"></span>
                </label>
                <input type="text" tabindex="-1" placeholder="Enter Occupation" class="form-control" name="father_occupation" id="father_occupation"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">
                    Father’s/Guardian’s     Income (P.A.) <span class="symbol required"></span>
                </label>
                <input type="text" tabindex="-1" placeholder="Enter Income" class="form-control" name="father_income" id="father_income"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">
                    Father’s/Guardian’s Contact Number <span class="symbol required"></span>
                </label>
                <input type="text" tabindex="-1" placeholder="Enter Contact Number" class="form-control" name="father_contact" id="father_contact"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label  class="control-label">
                    Mother’s/Guardian’s Name <span class="symbol required"></span>
                </label>
                <input type="text" tabindex="-1" placeholder="Enter your First Name" class="form-control" name="mother_first_name" id="mother_first_name"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">
                    Middle Name
                </label>
                <input type="text" tabindex="-1" placeholder="Enter your Middle Name" class="form-control" name="mother_middle_name" id="mother_middle_name"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">
                    Last Name
                </label>
                <input type="text" tabindex="-1" placeholder="Enter your Last Name" class="form-control" name="mother_last_name" id="mother_last_name"/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label  class="control-label">
                    Mother’s/Guardian’s Occupation <span class="symbol required"></span>
                </label>
                <input type="text" tabindex="-1" placeholder="Enter Occupation" class="form-control" name="mother_occupation" id="mother_occupation"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">
                    Mother’s/Guardian’s Income (P.A.) <span class="symbol required"></span>
                </label>
                <input type="text" tabindex="-1" placeholder="Enter Income" class="form-control" name="mother_income" id="mother_income"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">
                    Mother’s/Guardian’s Contact Number <span class="symbol required"></span>
                </label>
                <input type="text" tabindex="-1" placeholder="Enter Contact Number" class="form-control" name="mother_contact" id="mother_contact"/>
            </div>
        </div>
    </div>

    <!--<div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label  class="control-label">
                    Email <span class="symbol required"></span>
                </label>
                <input type="text" placeholder="Enter email" class="form-control" name="parent_email" id="parent_email"/>
            </div>
        </div>
    </div>-->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label  class="control-label">
                    Permanent Address <span class="symbol required"></span>
                </label>
                <div class="note-editor">
                    <textarea tabindex="-1" class="form-control autosize area-animated" name="permanent_address" id="permanent_address" data-autosize-on="true" style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px; cursor: url('/assets/images/pen.png') 0 32, auto;">
                    </textarea>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label  class="control-label">
                    Communication Address <span class="symbol required"></span>
                </label><br>

                <input type="checkbox" name="parent_communication_address" id="parent_communication_address" checked> Same as Permanent Address
                <div class="note-editor" id="communication_address_parent">
                    <textarea class="form-control autosize area-animated" tabindex="-1" name="communication_address_parent" data-autosize-on="true" style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px; cursor: url('/assets/images/pen.png') 0 32, auto;">
                    </textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="parentPassword">
        <div class="col-md-6">
            <div class="form-group">
                <label  class="control-label">
                    Password <span class="symbol required"></span>
                </label>
                <input type="password" tabindex="-1" placeholder="Enter Password" class="form-control" name="parent_password" id="parent_password"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    Confirm Password <span class="symbol required"></span>
                </label>
                <input type="password" tabindex="-1" placeholder="Enter Password" class="form-control" name="parent_password2" id="parent_password2"/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label  class="control-label">
                    SIBLINGS
                </label><br>
               <!-- <INPUT type="button" tabindex="-1" value="Add Row" onclick="addSibling('sibling')" />
                <TABLE id="sibling"  border="1">
                    <TR>
                        <TD> <INPUT type="text" name="sibling[0][name]" placeholder="Name"/> </TD>
                        <TD> <INPUT type="number" name="sibling[0][age]" placeholder="Age"/> </TD>
                    </TR>
                </TABLE>-->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <input tabindex="-1" type="text" placeholder="Enter Name" class="form-control" name="sibling[0][name]" id="name0"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <input tabindex="-1" type="number" placeholder="Enter Age" class="form-control" name="sibling[0][age]" id="age0"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" placeholder="Enter Name" class="form-control" name="sibling[1][name]" id="name1"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <input type="number" placeholder="Enter Age" class="form-control" name="sibling[1][age]" id="age1"/>
            </div>
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
                <input type="text" placeholder="Enter School Name" class="form-control" name="school_name"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    UDISE No.
                </label>
                <input type="text" placeholder="Enter UDISE No " class="form-control" name="udise_no"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label  class="control-label">
                    City
                </label>
                <input type="text" placeholder="Enter City" class="form-control" name="city"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    Medium of instruction
                </label>
                <input type="text" placeholder="Enter Medium of instruction" class="form-control" name="medium_of_instruction"/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label  class="control-label">
                    Name of board/examination
                </label>
                <input type="text" placeholder="Enter Name of board/examination" class="form-control" name="board_examination"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    Grades / %
                </label>
                <input type="text" placeholder="Enter Grades" class="form-control" name="grades"/>
            </div>
        </div>
    </div>

</fieldset>

<fieldset>
    <legend>
        SPECIAL APTITUDE
    </legend>
    <!--<INPUT type="button" value="Add Row" onclick="addRowSpecialAptitude('dataTable')" />
    <TABLE id="dataTable"  border="1">
        <TR>
            <TD><INPUT type="text" name="special_aptitude[0][test]" placeholder="Test"/></TD>
            <TD><INPUT type="number" name="special_aptitude[0][score]" placeholder="Score"/></TD>

        </TR>
    </TABLE>-->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" placeholder="Enter Test" class="form-control" name="special_aptitude[0][test]" id="test0"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <input type="number" placeholder="Enter Score" class="form-control" name="special_aptitude[0][score]" id="score0"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" placeholder="Enter Test" class="form-control" name="special_aptitude[1][test]" id="test1"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <input type="number" placeholder="Enter Score" class="form-control" name="special_aptitude[1][score]" id="score1"/>
            </div>
        </div>
    </div>

</fieldset>
<fieldset>
    <legend>
        INTEREST / HOBBIES
    </legend>
    <!--<INPUT type="button" value="Add Row" onclick="addRow('hobbies')" />
    <TABLE id="hobbies"  border="1">
        <TR>
            <TD> <INPUT type="text" name="hobbies[]"/> </TD>
        </TR>
    </TABLE>-->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" placeholder="Enter Hobby" class="form-control" name="hobbies[]" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" placeholder="Enter Hobby" class="form-control" name="hobbies[]"/>
            </div>
        </div>
    </div>

</fieldset>
<fieldset>
    <legend>
        DOCUMENTS SUBMITTED &nbsp [Note: If submitted then please tick the box]
    </legend>
   <!-- <INPUT type="button" value="Add Row" onclick="addRowUploadDoc('upload_doc')" />
    <TABLE id="upload_doc"  border="1">
        <TR>
            <TD> <INPUT type="file" name="upload_doc[]"/> </TD>
        </TR>
    </TABLE>-->
    @foreach($documents as $document)

    <div class="row">
        <div class="col-md-6">
            <input type="checkbox" value="{{$document['id']}}" name="documents[]">
            <div class="form-group">
                <label class="control-label">
                    {{$document['document_name']}}
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <input type="file" name="upload_doc[{{$document['id']}}]" accept='image/jpeg,image/gif,image/png,application/pdf'/>
            </div>
        </div>
    </div>
    @endforeach
</fieldset>
<fieldset>
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
<script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
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
        userAclModule();
        getMsgCount();
        Main.init();
        FormValidator.init();
        FormWizard.init();
        getParents();
        getbatches();
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
</script>
<script type="text/javascript">
function userAclModule()
{
    $('div#loadmoreajaxloader').show();
    var disableModules = ['create_timetable','update_timetable','delete_timetable','publish_timetable','create_user','view_user','update_user','delete_user','publish_user','delete_homework','publish_homework','update_homework','create_homework','delete_user','update_message','delete_message','publish_message','delete_leave','update_leave','publish_leave','publish_attendance','update_attendance','delete_attendance','create_attendance','update_announcement','delete_announcement','publish_announcement','create_announcement','delete_achievement','create_achievement','publish_achievement','update_achievement','create_subject','view_subject','update_subject','publish_subject','delete_subject','create_class','publish_class','view_class','delete_class','update_class','create_event','update_event','publish_event','delete_event'];
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
        /////////////////////Leave///////////
        $('.leave').change(function(){
            if($.inArray(this.id,["create_leave"]) !== -1)
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
    });
}
$('#communication_address').hide();
$("#student_communication_address").click(function(){
    $('#communication_address').toggle();
});
$('#communication_address_parent').hide();
$("#parent_communication_address").click(function(){
    $('#communication_address_parent').toggle();
});
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
                        $('#parent_id').val(suggestion.data['userId']);
                        $('#father_first_name').attr("disabled", true);
                        $('#father_middle_name').attr("disabled", true);
                        $('#father_last_name').attr("disabled", true);
                        $('#mother_first_name').attr("disabled", true);
                        $('#mother_middle_name').attr("disabled", true);
                        $('#mother_last_name').attr("disabled", true);
                        $('#father_occupation').attr("disabled", true);
                        $('#mother_occupation').attr("disabled", true);
                        $('#father_income').attr("disabled", true);
                        $('#mother_income').attr("disabled", true);
                        $('#father_contact').attr("disabled", true);
                        $('#mother_contact').attr("disabled", true);
                        $('#permanent_address').attr("disabled", true);
                        $('#parentPassword').css("display","none");
                        $('#parent_password').css("display","none");
                        $('#parent_password2').css("display","none");
                        $('#father_first_name').val(suggestion.data['father_first_name']);
                        $('#father_middle_name').val(suggestion.data['father_middle_name']);
                        $('#father_last_name').val(suggestion.data['father_last_name']);
                        $('#mother_first_name').val(suggestion.data['mother_first_name']);
                        $('#mother_middle_name').val(suggestion.data['mother_middle_name']);
                        $('#mother_last_name').val(suggestion.data['mother_last_name']);
                        $('#father_occupation').val(suggestion.data['father_occupation']);
                        $('#mother_occupation').val(suggestion.data['mother_occupation']);
                        $('#father_income').val(suggestion.data['father_income']);
                        $('#mother_income').val(suggestion.data['mother_income']);
                        $('#father_contact').val(suggestion.data['father_contact']);
                        $('#mother_contact').val(suggestion.data['mother_contact']);
                        $('#permanent_address').val(suggestion.data['permanent_address']);
                        $('#parent_password').val('null');
                        $('#parent_password2').val('null');
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
        $('#father_first_name').attr("disabled", false);
        $('#father_middle_name').attr("disabled", false);
        $('#father_last_name').attr("disabled", false);
        $('#mother_first_name').attr("disabled", false);
        $('#mother_middle_name').attr("disabled", false);
        $('#mother_last_name').attr("disabled", false);
        $('#father_occupation').attr("disabled", false);
        $('#mother_occupation').attr("disabled", false);
        $('#father_income').attr("disabled", false);
        $('#mother_income').attr("disabled", false);
        $('#father_contact').attr("disabled", false);
        $('#mother_contact').attr("disabled", false);
        $('#permanent_address').attr("disabled", false);
        $('#father_first_name').val('');
        $('#father_middle_name').val('');
        $('#father_last_name').val('');
        $('#mother_first_name').val('');
        $('#mother_middle_name').val('');
        $('#mother_last_name').val('');
        $('#father_occupation').val('');
        $('#mother_occupation').val('');
        $('#father_income').val('');
        $('#mother_income').val('');
        $('#father_contact').val('');
        $('#mother_contact').val('');
        $('#permanent_address').val('');
    }
});
function addRow(tableID) {
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    var cell3 = row.insertCell(0);
    var element2 = document.createElement("input");
    element2.type = "text";
    element2.name = "hobbies[]";
    cell3.appendChild(element2);
}
function addRowSpecialAptitude(tableID){
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    var cell2 = row.insertCell(0);
    var element2 = document.createElement("input");
    element2.type = "text";
    element2.placeholder = "Test";
    element2.name = "special_aptitude["+rowCount+"][test]";
    cell2.appendChild(element2);
    var cell3 = row.insertCell(1);
    var element3 = document.createElement("input");
    element3.type = "number";
    element3.placeholder = "Score";
    element3.name = "special_aptitude["+rowCount+"][score]";
    cell3.appendChild(element3);
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
function addSibling(tableID){
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    var cell2 = row.insertCell(0);
    var element2 = document.createElement("input");
    element2.type = "text";
    element2.placeholder = "Name";
    element2.name = "sibling["+rowCount+"][name]";
    cell2.appendChild(element2);
    var cell3 = row.insertCell(1);
    var element3 = document.createElement("input");
    element3.type = "number";
    element3.placeholder = "Age";
    element3.name = "sibling["+rowCount+"][age]";
    cell3.appendChild(element3);
}
</script>

@stop
