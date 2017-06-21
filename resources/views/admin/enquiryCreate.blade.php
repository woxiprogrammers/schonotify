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
<section id="page-title" class="padding-top-100">
    <div class="row">
        <div class="col-sm-7">
            <span class="mainDescription">Waiting / Merit List Form</span>
            <br>
            <h5 style="color:red">If you are already registered ,then <a href="http://nesswadia.woxi.co.in/check-enquiry">Click Here</a></h5>
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
    <form method="post" action="/store-student-enquiry" role="form" id="studentEnquiry" onsubmit="parent.scrollTo(0, 0); return true">
        <fieldset>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">
                            Medium <span class="symbol required"></span>
                        </label>
                            <select class="form-control" id="medium" name="medium" style="-webkit-appearance: menulist;">
                                <option value='English'>English</option>
                                <option value='Marathi'>Marathi</option>
                            </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">
                            Class <span class="symbol required"></span>
                        </label>
                            <select class="form-control" id="class_applied" name="class_applied" style="-webkit-appearance: menulist;">
                                <option value='FYBCOM'>FYBCOM</option>
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
                      <input type="text" placeholder="Enter your First Name" class="form-control" name="first_name"/>
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
                          Surname<span class="symbol required"></span>
                      </label>
                      <input type="text" placeholder="Enter your SurName" class="form-control" name="last_name"/>
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group"> <!-- Date input -->
                      <label class="control-label">Total Marks Obtained <span class="symbol required"></span></label>
                      <input class="form-control" id="marks_obtained" name="marks_obtained" placeholder="Enter Marks obtained" type="text"/>
                  </div>
              </div>
              <div class="col-md-6">
                      <label class="control-label">Total Marks Out of <span class="symbol required"></span></label>
                      <input class="form-control" id="outOf_marks" name="outOf_marks" placeholder="Enter Out Of Marks" type="text" />
              </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group"> <!-- Date input -->
                        <label class="control-label">Examination Board <span class="symbol required"></span></label>
                        <input class="form-control" id="board" name="board" placeholder="Enter board" type="text" />
                    </div>
                </div>
                <div class="col-md-6">
                      <label class="control-label">Year of Passing <span class="symbol required"></span></label>
                      <select class="form-control" id="exam_year" name="examination_year" style="-webkit-appearance: menulist;">
                          <option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option>
                      </select>
                </div>
                </div>
             <div class="row">
               <div class="col-md-6">
                   <div class="form-group"> <!-- Date input -->
                       <label class="control-label">Email <span class="symbol required"></span></label>
                       <input class="form-control" id="email" name="email" placeholder="Enter email" type="email" />
                   </div>
               </div>
               <div class="col-md-6">
                   <div class="form-group"> <!-- Date input -->
                       <div class="form-group"> <!-- Date input -->
                           <label class="control-label">Special Category <span class="symbol required"></span></label>
                           <select class="form-control" id="diff_categories" name="diff_categories" style="-webkit-appearance: menulist;">
                                   <option value="" selected>Please select category</option>
                                   @foreach($extra_categories as $category)
                                    <option value="{!! $category['slug'] !!}">{!! $category['categories'] !!}</option>
                                   @endforeach
                           </select>
                       </div>
                   </div>
               </div>

           </div>
           <div class="row">
             <div class="col-md-6">
                 <div class="form-group"> <!-- Date input -->
                     <label class="control-label">State from which XII Std. passed <span class="symbol required"></span></label>
                     <select class="form-control" id="state" name="state" style="-webkit-appearance: menulist;" required>
                      <option value="">Please select state</option>
                      <option value="Maharashtra">Maharashtra</option>
                      <option value="Other State">Other State</option>
                     </select>
                 </div>
            </div>
             <div class="col-md-6" id="Cat">
                 <div class="form-group"> <!-- Date input -->
                     <label class="control-label">Caste Category<span class="symbol required"></span></label>
                     <select class="form-control" name="category" id="category" style="-webkit-appearance: menulist;">
                                   <option value="" selected>Please select caste category</option>
                                   @foreach($categories as $category)
                                   <option value="{!!$category['slug']!!}" id="{!!$category['slug']!!}">{!!$category['caste_category']!!}</option>
                                    @endforeach
                    </select>
                 </div>
            </div>
        </div>
        <div class="row">
         <div class="col-md-6">
             <div class="form-group"> <!-- Date input -->
                 <label class="control-label">Name of the Caste / SubCaste <span class="symbol required"></span></label>
                 <input class="form-control" id="caste" name="caste" placeholder="Enter your caste" type="text" />
             </div>
         </div>
        </div>
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
<script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="/assets/js/enquiry-form.js"></script>
<script>
    jQuery(document).ready(function() {
        Main.init();
        FormValidator.init();
        $("#app").addClass("removePadding");
        //$(".app-sidebar-fixed #sidebar").addClass("removePadding");
    });
    $("#state").change(function(){
              if($('#state').val() == "Maharashtra"){
                  $("#other_state").css("display","none");
                  $('#category').val('');
                  $('#category').css('pointer-events','true');
              }else{
                $("#other_state").css("display","true");
                $('#category').val('other_state');
                $('#category').css('pointer-events','none');
              }
    })
</script>
@stop
