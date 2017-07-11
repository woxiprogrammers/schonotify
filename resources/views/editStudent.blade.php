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
                                <fieldset id="hide">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="control-label">
                                                Batch
                                            </label>
                                            <select class="form-control" id="Batchdropdown" name="Batchdropdown" style="-webkit-appearance: menulist;">
                                                <option value="">Select Batch</option>
                                                @if(!empty($batches))
                                                @foreach($batches as $batch)
                                                <option value="{!! $batch->id !!}">{!! $batch->name !!}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-4" id="ClassSearchStudent">
                                        </div>
                                        <div class="col-md-4" id="DivSearch">
                                        </div>
                                    </div>
                                </fieldset>
                             @foreach($student_info as $student_info)
                                <fieldset>
                                <div class="col-md-12">
                                    <div >
                                        <label >
                                            GRN <span class="symbol required"></span>
                                        </label>
                                        <input type="text" placeholder="Enter a GRN" class="form-control" name="grn" id="grn" value="{!! $grn !!}"/>
                                    </div>
                                </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    First name: <span class="symbol required">
                                                </label>
                                                <input type="text" value="{!! $user->first_name !!}" class="form-control" id="firstname" name="firstname">
                                            </div>
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
                                                <label class="control-label">Date of Birth: <span class="symbol required"> </label>
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
                                                    Nationality: <span class="symbol required">
                                                </label>
                                                <input type="text" value="{!! $student_info->nationality !!}"  class="form-control" id="nationality" name="nationality">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Caste
                                                </label>
                                                <input type="text" value="{!!$caste!!}"  class="form-control" id="caste" name="caste">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Phone : <span class="symbol required">
                                                </label>
                                                <input type="text" placeholder="{!! $user->mobile !!}" value="{!! $user->mobile !!}" class="form-control" id="mobile" name="mobile">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Address
                                                </label>
                                                <input type="text" value="{!! $user->address !!}" class="form-control" id="address" name="address">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Aadhar Card Number
                                                </label>
                                                <input type="text" placeholder="Aadhar Card Number " class="form-control" value="{!! $student_info->aadhar_number!!}" name="aadhar_number"/>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Mother Tongue <span class="symbol required"></span>
                                                </label>
                                                <input type="text" placeholder="Enter a Mother Tongue" class="form-control" value="{!! $student_info->mother_tongue!!}" name="mother_tongue"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="form-field-select-2">
                                                    Highest Standard Passed
                                                </label>
                                                <input type="hidden" id="highest_standard_hidden" value="{!!$student_info->highest_standard !!}" >
                                                <select class="form-control" id="highest_standard" style="-webkit-appearance: menulist;" name="highest_standard">
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
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Roll Number
                                                </label>
                                                <input type="text" value="{!! $user->roll_number !!}"  class="form-control" id="roll_number" name="roll_number">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Academic session applied to
                                                </label>
                                                <input type="text" class="form-control" value="{!! $student_info->academic_to !!}" name="academic_to"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Last Name
                                                </label>
                                                <input type="text" value="{!! $user->last_name !!}" class="form-control" id="lastname" name="lastname">
                                            </div>
                                            <div class="form-group">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Place Of Birth: <span class="symbol required">
                                                </label>
                                                <input type="text" value="{!! $student_info['birth_place'] !!}"  class="form-control" id="birth_place" name="birth_place">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Religion
                                                </label>
                                                <input type="text" value="{!! $religion !!}"  class="form-control" id="religion" name="religion">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Category
                                                </label>
                                                <input type="hidden" name="selected_category" id="selected_category" value="{!! $student_info->category !!}">
                                                <select class="form-control" name="category" id="batch-select" style="-webkit-appearance: menulist;">
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
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Alternate number
                                                </label>
                                                <input type="text" placeholder="{!! $user->alternate_number !!}" value="{!! $user->alternate_number !!}" class="form-control" id="alternate_number" name="alternate_number">
                                            </div>
                                            <div class="form-group">
                                                <label for="form-field-select-2">
                                                    Select Blood Group
                                                </label>
                                                <input type="hidden" id="blood_group_hideen" value="{!!$student_info->blood_group!!}">
                                                <select class="form-control" name="blood_group" id="blood_group" style="-webkit-appearance: menulist;">
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
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Other Languages spoken/written
                                                </label>
                                                <input type="text" value="{!! $student_info->other_language !!}" placeholder="Enter a Other Languages spoken/written" class="form-control" name="other_language"/>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Academic session applied from
                                                </label>
                                                <input type="text"  value="{!! $student_info->academic_from !!}" class="form-control" name="academic_from"/>
                                            </div>
                                            <div class="form-group">
                                                <label  class="control-label">
                                                    Communication Address <span class="symbol required"></span>
                                                </label><br>
                                                <input type="checkbox" name="student_communication_address" id="student_communication_address"  checked> Same as Student Address
                                                <div class="note-editor" id="communication_address_student">
                                                    <textarea class="form-control autosize area-animated" tabindex="-1" name="communication_address_student" data-autosize-on="true"  style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px; cursor: url('/assets/images/pen.png') 0 32, auto;">{!! $student_info->communication_address !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
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
                                                            @if(!empty($school))
                                                            <input type="text" value="{!! $school['name'] !!}" placeholder="Enter School Name" class="form-control" name="school_name"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                UDISE No.
                                                            </label>
                                                            <input type="number" placeholder="Enter UDISE No " class="form-control" value="{!! $school['udise_no']!!}" name="udise_no"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label  class="control-label">
                                                                City
                                                            </label>
                                                            <input type="text" value="{!! $school['city'] !!}" placeholder="Enter City" class="form-control" name="city"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                Medium of instruction
                                                            </label>
                                                            <input type="text" value="{!! $school['medium_of_instruction'] !!}" placeholder="Enter Medium of instruction" class="form-control" name="medium_of_instruction"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label  class="control-label">
                                                                Name of board/examination
                                                            </label>
                                                            <input type="text" value="{!! $school['board_examination'] !!}" placeholder="Enter Name of board/examination" class="form-control" name="board_examination"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                Grades / %
                                                            </label>
                                                            <input type="number" placeholder="Enter Grades" value="{!! $school['grades'] !!}" class="form-control" name="grades"/>
                                                            @endif
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
                                                    @if(!empty($aptitude))
                                                    @foreach($aptitude as $apti)
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                           <input type="text" value="{!! $apti->special_aptitude !!}" placeholder="Enter Test" class="form-control"  name="special_aptitude[0][test]" id="test0"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="number" value="{!! $apti->score !!}" placeholder="Enter Score" class="form-control" name="special_aptitude[0][score]" id="score0"/>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <legend>
                                                    INTEREST / HOBBIES
                                                </legend><h6>Seperate by comma (,) if there are more than one hobby.</h6>
                                                <!--<INPUT type="button" value="Add Row" onclick="addRow('hobbies')" />
                                                <TABLE id="hobbies"  border="1">
                                                    <TR>
                                                        <TD> <INPUT type="text" name="hobbies[]"/> </TD>
                                                    </TR>
                                                </TABLE>-->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            @if(!empty($hobbies))
                                                            <input type="text" placeholder="Enter Hobby" value="{!! $hobbies['hobby'] !!}" class="form-control" name="hobbies[]" />
                                                            @endif
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
                                                        @if(in_array($document['id'],$doc))
                                                            <input type="checkbox" value="{{$document['id']}}" name="documents[]" checked>
                                                        @else
                                                            <input type="checkbox" value="{{$document['id']}}" name="documents[]">
                                                        @endif
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
                                        </div>
                                    </div>
                                    <fieldset>
                                        <legend>
                                            FEE STRUCTURE
                                        </legend>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    Assign Fee Structure :
                                                </label>
                                                <div>
                                                    <select name="student_fee" style="width:60%;-webkit-appearance: menulist;">
                                                        @if(!empty($fees))
                                                        @foreach($fees as $fee_details)
                                                        <option id="{{$fee_details['id']}}" class="form-control assign_fee_structure" value="{{$fee_details['id']}}" >{{$fee_details['fee_name']}}&nbsp &nbsp &nbsp {{$fee_details['year']}}</option>
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
                                                    Select Concession Types :
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
                                        <div class="col-md-12" style="display: none" id="CasteSelect">
                                            <div class="form-group">
                                                <label>
                                                    Assign Fee Concession :
                                                </label>
                                                <div>
                                                    <select name="caste1"  style="-webkit-appearance: menulist;">
                                                        @foreach($queryn as $castes)
                                                        <option id="{{$castes['id']}}" class="form-control castes_list" value="{{$castes['id']}}">{{$castes['caste_category']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="row">
                                        <div class="col-md-6">
                                        </div>
                                        <div class="col-md-6">
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
                                </fieldset>
                                @endforeach
                                <div class="row">
                                    <div class="col-md-4">
                                        <button class="btn btn-primary pull-right" type="submit" id="updateUserInfo" >
                                            Update <i class="fa fa-arrow-circle-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="panel_edit_Parent" class="tab-pane fade in">
                            <div class="panel-body">
                                 <form id="formEditAccount" method="post" action="/edit-parent/{!! $user->parent_id !!}"  enctype="multipart/form-data">
                                <input name="_method" type="hidden" value="PUT">
                                <input type="hidden" name="userId" id="userPerentId" value="{!! $user->parentUserId !!}">
                                <fieldset>
                                <legend>
                                    STUDENT'S FAMILY INFORMATION
                                </legend>
                                <div class="row">
                                    <div class="col-md-12">
                                            <div id="w">
                                            <div id="content">
                                                <div id="searchfield">
                                                        <div class="form-group ">
                                                            <label class="control-label">
                                                                Parent Email: <span class="symbol required"></span>
                                                            </label>
                                                            <input type="text" placeholder="Enter Parent Email" class="form-control" name="email" id="autocomplete" tabindex="-1" value="{{trim($parent_email)}}" readonly>
                                                            <input type='hidden' name='parent_id' id='parent_id'>
                                                            <br>
                                                            <div class="form-group" id="outputcontent"></div>
                                                        </div>
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
                                            <input type="text" placeholder="Enter your First Name" class="form-control" tabindex="-1" name="father_first_name" id="father_first_name" value="{!!  $family_info['father_first_name'] !!}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Middle Name
                                            </label>
                                            <input type="text" tabindex="-1" placeholder="Enter your Middle Name" class="form-control" name="father_middle_name" id="father_middle_name" value="{!!  $family_info['father_middle_name'] !!}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Last Name
                                            </label>
                                            <input type="text" tabindex="-1" placeholder="Enter your Last Name" class="form-control" name="father_last_name" id="father_last_name" value="{!!  $family_info['father_last_name'] !!}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label  class="control-label">
                                                Father’s/Guardian’s   Occupation <span class="symbol required"></span>
                                            </label>
                                            <input type="text" tabindex="-1" placeholder="Enter Occupation" class="form-control" name="father_occupation" id="father_occupation" value="{!!  $family_info['father_occupation'] !!}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Father’s/Guardian’s     Income (P.A.) <span class="symbol required"></span>
                                            </label>
                                            <input type="text" tabindex="-1" placeholder="Enter Income" class="form-control" name="father_income" id="father_income" value="{!!  $family_info['father_income'] !!}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Father’s/Guardian’s Contact Number <span class="symbol required"></span>
                                            </label>
                                            <input type="text" tabindex="-1" placeholder="Enter Contact Number" class="form-control" name="father_contact" id="father_contact" value="{!!  $family_info['father_contact'] !!}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label  class="control-label">
                                                Mother’s/Guardian’s Name <span class="symbol required"></span>
                                            </label>
                                            <input type="text" tabindex="-1" placeholder="Enter your First Name" class="form-control" name="mother_first_name" id="mother_first_name" value="{!!  $family_info['mother_first_name'] !!}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Middle Name
                                            </label>
                                            <input type="text" tabindex="-1" placeholder="Enter your Middle Name" class="form-control" name="mother_middle_name" id="mother_middle_name" value="{!!  $family_info['mother_middle_name'] !!}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Last Name
                                            </label>
                                            <input type="text" tabindex="-1" placeholder="Enter your Last Name" class="form-control" name="mother_last_name" id="mother_last_name" value="{!!  $family_info['mother_last_name'] !!}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label  class="control-label">
                                                Mother’s/Guardian’s Occupation <span class="symbol required"></span>
                                            </label>
                                            <input type="text" tabindex="-1" placeholder="Enter Occupation" class="form-control" name="mother_occupation" id="mother_occupation" value="{!!  $family_info['mother_occupation'] !!}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Mother’s/Guardian’s Income (P.A.) <span class="symbol required"></span>
                                            </label>
                                            <input type="text" tabindex="-1" placeholder="Enter Income" class="form-control" name="mother_income" id="mother_income" value="{!!  $family_info['mother_income'] !!}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Mother’s/Guardian’s Contact Number <span class="symbol required"></span>
                                            </label>
                                            <input type="text" tabindex="-1" placeholder="Enter Contact Number" class="form-control" name="mother_contact" id="mother_contact" value="{!!  $family_info['mother_contact'] !!}"/>
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
                                                Permanent Address: <span class="symbol required"></span>
                                            </label>
                                            <div class="note-editor">
                                                <textarea tabindex="-1" class="form-control autosize area-animated" name="permanent_address" id="permanent_address" data-autosize-on="true"  style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px; cursor: url('/assets/images/pen.png') 0 32, auto;">{!!$family_info['permanent_address']!!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label  class="control-label">
                                                Communication Address <span class="symbol required"></span>
                                            </label><br>
                                            <input type="checkbox" name="parent_communication_address" id="parent_communication_address"  checked> Same as Permanent Address
                                            <div class="note-editor" id="communication_address_parent">
                                                <textarea class="form-control autosize area-animated" tabindex="-1" name="communication_address_parent" data-autosize-on="true"  style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px; cursor: url('/assets/images/pen.png') 0 32, auto;">{!!$family_info['communication_address']!!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="row">
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
                                             </TABLE>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" placeholder="Enter Name" class="form-control" name="sibling[0][name]" id="name0"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="number" placeholder="Enter Age" class="form-control" name="sibling[0][age]" id="age0" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" placeholder="Enter Name" class="form-control" name="sibling[1][name]" id="name1" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="number" placeholder="Enter Age" class="form-control" name="sibling[1][age]" id="age1"/>
                                        </div>
                                    </div>
                                </div>-->
                                </fieldset>
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
                                                    Alternate Contact Number
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
                                                             <option selected>Select installment</option>
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
                                        <hr>                                        <div class="row">
                                            <div class="col-md-12">
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
                                                            Voucher No / NEFT  no /Transaction Id::<span class="symbol required"></span>
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
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                Installment Id:<span class="symbol required"></span>
                                                            </label>
                                                            <div>
                                                                <select name="installment_id" id="installment_id" style="width: 20%">
                                                                    @foreach($installmentIds as $id)
                                                                        <option value="{{$id['installment_id']}}"> {{$id['installment_id']}} </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4 col-md-offset-7">
                                                            <button class="btn btn-primary pull-right" type="submit" >
                                                                Update <i class="fa fa-arrow-circle-right"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-md-offset-5">
                                                &nbsp;&nbsp;&nbsp;<h4>OR</h4>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-md-offset-4">
                                                    <a class="btn btn-primary btn-wide" style="margin-left: 20%" href="/fees/billing-page">
                                                        Make Payment
                                                    </a>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            Installment Id:<span class="symbol required"></span>
                                                        </label>
                                                        <div>
                                                            <select name="installment_id" id="installment_id" style="width: 20%">
                                                                @foreach($installmentIds as $id)
                                                                <option value="{{$id['installment_id']}}"> {{$id['installment_id']}} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-7">
                                                        <button class="btn btn-primary pull-right" type="submit" >
                                                            Update <i class="fa fa-arrow-circle-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
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
        if({!!$divisionStudent!!} != null){
            $('#hide').hide();
        }else{
        $('#hide').show();
        }
        var category = $("#selected_category").val();
        var blood= $("#blood_group_hideen").val();
        var std=$("#highest_standard_hidden").val();
        $("option[value='"+std+"']").prop('selected',true);
        $("option[value='"+category+"']").prop('selected',true);
        $("option[value='"+blood+"']").prop('selected',true);
        $(".caste-checkbox input[value='{{$caste_concession_type_edit}}']").attr('checked', true);
        $(".assign_fee_structure input[value='{{$assigned_fee}}']").attr('selected', true);
        getMsgCount();
        if({!!$chkstatus!!} != "null"){
        var chkstatus = {!!$chkstatus!!};
        if(chkstatus != null){
          for(var i = 0; i< chkstatus.length; i++){
             $('#'+chkstatus[i]+'_concession_chk').prop('checked', true);
          }
        }
        }
        $('#2_concession_chk').change(function(){
           if($('#2_concession_chk').is(":checked")){
               $('#CasteSelect').show();
           }else{
               $('#CasteSelect').hide();
           }
        });
        Main.init();
        FormValidator.init();
        FormElements.init();
        TableData.init();
        userAclModule();
    $('#communication_address_student').hide();
    $("#student_communication_address").click(function(){
        $('#communication_address_student').toggle();
    });
    $('#communication_address_parent').hide();
    $("#parent_communication_address").click(function(){
        $('#communication_address_parent').toggle();
    });
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
    $('#Batchdropdown').change(function(){
        $('div#loadmoreajaxloader').show();
        var batch=this.value;
        var route='/get-classes-search';
        $.ajax({
            method: "get",
            url: route,
            data: { batch }
        })
        .done(function(res){
                $('#ClassSearchStudent').html(res);
                $('div#loadmoreajaxloader').hide();
        })
    })
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
    function clsTeacher(chk){
        if(chk==true)
        {
            $('#clstchr_batch').s{!! $student_info->blood_group !!}how();
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
                        if($.inArray(arr2[j]['slug']+'_'+arr1[i],userModAclArr)!=-1){

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
    $( "select[name='installment_number']" )
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
<script src="/assets/js/student-edit.js" ></script>
@stop
