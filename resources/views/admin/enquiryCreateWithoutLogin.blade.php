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
            <span class="mainDescription">Waiting / Merit List Form</span>
            <br>
            <h5 style="color:red">If you are already registered ,then <a href="http://nesswadia.veza.co.in/check-enquiry">Click Here</a></h5>
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
    <form method="post" action="/store-student-enquiry-without-login" role="form" id="studentEnquiry" onsubmit="parent.scrollTo(0, 0); return true" enctype="multipart/form-data">
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
	                        <option value='FYBCOM'>FY BCOM</option>
                                <option value='FYBBAIB'>FY BBA (IB)</option>
                                <option value='FYBBACA'>FY BBA (CA)</option>
                                <option value='FYBBA'>FY BBA</option>  
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
                    <input class="form-control" id="marks_obtained" name="marks_obtained" placeholder="Enter Marks obtained" type="text" />
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
		<option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option>
		<option value="2018">2018</option>
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
                       <label class="control-label">Mobile Number <span class="symbol required"></span></label>
                       <input class="form-control" id="mobile_number" name="mobile_number" placeholder="Enter Mobile Number" type="text" />
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
             <div class="col-md-6">
                 <div class="form-group"> <!-- Date input -->
                     <div class="form-group"> <!-- Date input -->
                         <label class="control-label">Caste / Special Category <span class="symbol required"></span></label>
                         <select class="form-control" name="category" id="category" style="-webkit-appearance: menulist;">
                             <option value="" selected>Please Select Category</option>
                             @foreach($categories as $category)
                                 <option value="{!!$category['slug']!!}" id="{!!$category['slug']!!}">{!!$category['name']!!}</option>
                             @endforeach
                         </select>
                     </div>
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
              <div class="col-md-6">

              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                  <fieldset style="border: 1px solid #c2c2c2; !important;">
                      <legend>Document Uploads</legend>
                      <label class="control-label">
                          <i>
                              Please use files less than <b>200KB</b>.<br>
                              Supported file Formats : <b>JPEG,JPG,PNG,BMP</b>
                          </i>
                      </label>
                      <hr style="border-top: 1px solid #ccc; margin: 10px !important;">
                      <div class="row">
                          <div class="col-md-12">
                              <div class="form-group"> <!-- Date input -->
                                  <label class="control-label">
                                      10th Marksheet <span class="symbol required"></span>
                                  </label>
                                  <div class="form-group">
                                      <input type="file" name="ssc_certificate" accept=".jpg,.jpeg,.png,.bmp">
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12">
                              <div class="form-group"> <!-- Date input -->
                                  <label class="control-label">
                                      12th Marksheet <span class="symbol required"></span>
                                  </label>
                                  <div class="form-group">
                                      <input type="file" name="hsc_certificate" accept=".jpg,.jpeg,.png,.bmp">
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="row" id="caste_doc" hidden>
                          <div class="col-md-12">
                              <div class="form-group"> <!-- Date input -->
                                  <label class="control-label">
                                      <span id="caste_doc_label"></span> <span class="symbol required"></span>
                                  </label>
                                  <div class="form-group">
                                      <input type="file" id="caste_doc_file" accept=".jpg,.jpeg,.png,.bmp">
                                  </div>
                              </div>
                          </div>
                      </div>
                  </fieldset>

              </div>
          </div>
      </fieldset>
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
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        $("#category").on('change', function(){
            var selectedCategory = $(this).val();
            if((selectedCategory == 'open' || selectedCategory == 'other_state' || selectedCategory == '')){
                $("#caste_doc").hide();
                $("#caste_doc_file").removeAttr('name');
                $("#caste_doc_file").rules('remove');
                $("#caste_doc_label").text('');
            }else{
                $("#caste_doc").show();
                $("#caste_doc_file").attr('name','caste_certificate');
                $("#caste_doc_file").rules('add',{
                    required: true,
                    custom_file_size: true
                });
                if(selectedCategory == 'defence' || selectedCategory == 'differently_abled'){
                    var title = $("#category option:selected").text();
                    $("#caste_doc_label").text(title + ' Certificate');
                }else{
                    $("#caste_doc_label").text('Caste Certificate');
                }
            }
        });
    });
    $("#state").change(function(){
              if($('#state').val() == "Maharashtra"){
                  $("#other_state").css("display","none");
               	$("#category option").each(function(){
                        if(!($(this).attr('value') == 'other_state')){
                                $(this).show();
                        }else{
				$(this).hide();
			} 
                });

		   $('#category').val('');
               
                  $('#category').css('pointer-events','true');
              }else{
                $("#other_state").css("display","true");
		$("#category option").each(function(){
			if(!($(this).attr('value') == 'defence' || $(this).attr('value') == 'differently_abled' || $(this).attr('value') == 'other_state')){
				$(this).hide();
			}else{
				$(this).show();
			} 
		});
                $('#category').val('other_state');
                //$('#category').css('pointer-events','none');
              }
    })
    </script>
@stop
