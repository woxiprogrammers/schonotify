@extends('master')
@section('content')
<div id="app">
<div class="sidebar app-aside" id="sidebar" style="top: 0px!important;">
    <img class="img-responsive" src="/assets/images/bodyLogo/wadia.jpg">
</div>
<div class="app-content">
<!-- start: TOP NAVBAR -->
<!-- end: TOP NAVBAR -->
<div class="main-content" >
<div class="wrap-content container" id="container">
<!-- start: DASHBOARD TITLE -->
<div id="message-error-div"></div>
<section id="page-title" class="padding-top-15 padding-bottom-15">
    <div class="row">
        <div class="col-sm-7">
            <h1 class="mainTitle"> Ness Wadia College of Commerce</h1>
            <span class="mainDescription">Enquiry Form</span>
        </div>
    </div>
</section>
<!-- end: DASHBOARD TITLE -->
<!-- start: DYNAMIC TABLE -->
    <div class="alert alert-success alert-dismissible" role="alert" id="step-2ss" style="display: none">
        <button type="button" class="close" data-dismiss="alert" area-lebel="close">
            <span area-hidden="true">&times;</span>
        </button>
        <p class="text-large"> Congratulations..!! Your form has been submitted. Kindly contact college for further queries. </p>
    </div>
<div class="col-md-12">
    <form method="post" action="/store-student-enquiry-without-login" role="form" id="studentEnquiry" onsubmit="parent.scrollTo(0, 0); return true">
        <fieldset>
            <legend>
                Personal info
            </legend>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">
                            Medium <span class="symbol required"></span>
                        </label>
                            <select class="form-control" id="medium" name="medium" style="-webkit-appearance: menulist;">
                                <option value='Hindi'>Hindi</option>
                                <option value='English'>English</option>
                                <option value='Marathi'>Marathi</option>
                            </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">
                            Class applied <span class="symbol required"></span>
                        </label>
                            <select class="form-control" id="class_applied" name="class_applied" style="-webkit-appearance: menulist;">
                                <option value='BCOM'>B.COM.</option>
                                <option value='BA'>B.A.</option>
                            </select>
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                  <div class="form-group">
                      <label class="control-label">
                          First Name<span class="symbol required"></span>
                      </label>
                      <input type="text" placeholder="Enter your Middle Name" class="form-control" name="first_name"/>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                      <label class="control-label">
                          Middle Name<span class="symbol required"></span>
                      </label>
                      <input type="text" placeholder="Enter your Middle Name" class="form-control" name="middle_name"/>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                      <label class="control-label">
                          Last Name<span class="symbol required"></span>
                      </label>
                      <input type="text" placeholder="Enter your Middle Name" class="form-control" name="last_name"/>
                  </div>
              </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>
              Academic info
            </legend>
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group"> <!-- Date input -->
                      <label class="control-label">Marks Obtained <span class="symbol required"></span></label>
                      <input class="form-control" id="marks_obtained" name="marks_obtained" placeholder="Enter Marks obtained" type="number" />
                  </div>
              </div>
              <div class="col-md-6">
                      <label class="control-label">Out of Marks <span class="symbol required"></span></label>
                      <input class="form-control" id="outOf_marks" name="outOf_marks" placeholder="Enter Out Of Marks" type="number" />
              </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group"> <!-- Date input -->
                        <label class="control-label">Board <span class="symbol required"></span></label>
                        <input class="form-control" id="board" name="board" placeholder="Enter board" type="text" />
                    </div>
                </div>
                <div class="col-md-6">
                        <label class="control-label">Country <span class="symbol required"></span></label>
                        <select class="form-control" id="country" name="country" style="-webkit-appearance: menulist;">
                            <option value='India'>India</option>
                            <option value='Other'>Other</option>
                        </select>
                </div>
             </div>
             <div class="row">
               <div class="col-md-6" id="toggle" style="display:none">
                   <div class="form-group"> <!-- Date input -->
                       <label class="control-label">State <span class="symbol required"></span></label>
                       <input class="form-control" id="state" name="state" placeholder="Enter state" type="text" />
                   </div>
               </div>
               <div class="col-md-6" id="toggle1" >
                   <div class="form-group"> <!-- Date input -->
                       <label class="control-label">State <span class="symbol required"></span></label>
                       <select class="form-control" id="state1" name="state" style="-webkit-appearance: menulist;">
                        <option value="AndamanandNicobarIslands">Andaman and Nicobar Islands</option>
                        <option value="AndhraPradesh">Andhra Pradesh</option>
                        <option value="ArunachalPradesh">Arunachal Pradesh</option>
                        <option value="Assam">Assam</option>
                        <option value="Bihar">Bihar</option>
                        <option value="Chandigarh">Chandigarh</option>
                        <option value="Chhattisgarh">Chhattisgarh</option>
                        <option value="DadraandNagarHaveli">Dadra and Nagar Haveli</option>
                        <option value="DamanandDiu">Daman and Diu</option>
                        <option value="Delhi">Delhi</option>
                        <option value="Goa">Goa</option>
                        <option value="Gujarat">Gujarat</option>
                        <option value="Haryana">Haryana</option>
                        <option value="HimachalPradesh">Himachal Pradesh</option>
                        <option value="JammuandKashmir">Jammu and Kashmir</option>
                        <option value="Jharkhand">Jharkhand</option>
                        <option value="Karnataka">Karnataka</option>
                        <option value="Kerala">Kerala</option>
                        <option value="Lakshadweep">Lakshadweep</option>
                        <option value="MadhyaPradesh">Madhya Pradesh</option>
                        <option value="Maharashtra">Maharashtra</option>
                        <option value="Manipur">Manipur</option>
                        <option value="Meghalaya">Meghalaya</option>
                        <option value="Mizoram">Mizoram</option>
                        <option value="Nagaland">Nagaland</option>
                        <option value="Orissa">Orissa</option>
                        <option value="Pondicherry">Pondicherry</option>
                        <option value="Punjab">Punjab</option>
                        <option value="Rajasthan">Rajasthan</option>
                        <option value="Sikkim">Sikkim</option>
                        <option value="TamilNadu">Tamil Nadu</option>
                        <option value="Tripura">Tripura</option>
                        <option value="Uttaranchal">Uttaranchal</option>
                        <option value="UttarPradesh">Uttar Pradesh</option>
                        <option value="WestBengal">West Bengal</option>
                       </select>
                   </div>
              </div>
           </div>
           <div class="row">
             <div class="col-md-6">
                 <div class="form-group"> <!-- Date input -->
                     <label class="control-label">Caste <span class="symbol required"></span></label>
                     <input class="form-control" id="caste" name="caste" placeholder="Enter your caste" type="text" />
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="form-group"> <!-- Date input -->
                     <label class="control-label">Category <span class="symbol required"></span></label>
                     <select class="form-control" name="category" id="category" style="-webkit-appearance: menulist;">
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
                <div class="form-group"> <!-- Date input -->
                    <label class="control-label">Date<span class="symbol required"></span></label>
                    <input class="form-control" id="date" name="date" placeholder="Select date" type="date" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group"> <!-- Date input -->
                    <label class="control-label">Examination Year<span class="symbol required"></span></label>
                    <input class="form-control" id="exam_year" name="examination_year" placeholder="Enter exam year" type="number" />
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
                        <input class="form-control" id="mobile_number" name="mobile_number" placeholder="Enter Mobile Number" type="text" />
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="control-label">
                        Address <span class="symbol required"></span>
                    </label>
                    <div class="form-group">
                        <div class="note-editor">
                            <textarea class="form-control autosize area-animated" name="address" data-autosize-on="true" style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px; cursor: url('/assets/images/pen.png') 0 32, auto;"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary btn-wide pull-left" id="btn_submit" type="submit">
                    Submit
                </button>
            </div>
        </div>
        <div class="row">
            <p></p>
        </div>
    </form>
</div>
<!-- end: DYNAMIC TABLE -->
<!-- start: FOURTH SECTION -->
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
<script src="/vendor/ckeditor/ckeditor.js"></script>
<script src="/vendor/ckeditor/adapters/jquery.js"></script>
<script src="/assets/js/form-validation.js"></script>
<script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="/assets/js/enquiry-form.js"></script>
<script>
    jQuery(document).ready(function() {
        Main.init();
        FormValidator.init();
        $("#app").addClass("removePadding");
        //$(".app-sidebar-fixed #sidebar").addClass("removePadding");
        $("#country").change(function(){
          $("#toggle").toggle();
          $("#toggle1").toggle();
        })
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
    $("#state1").change(function(){
       if($("#state1").val() != "Maharashtra"){
         $("#category").attr("disabled", 'disabled');
         $("#category").val('OPEN');
       }else {
         $("#category").removeAttr("disabled", 'disabled');
       }
    });
    $('#current_class').blur(function() {
        if($(this).val()=="") {
            $('#school_name').attr("disabled", "disabled");
        }else{
            $("#school_name").removeAttr("disabled");
        }
    });
</script>
@stop
