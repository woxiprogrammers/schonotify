@extends('master')
@section('content')
<div id="app">
@include('sidebar')
<div class="app-content">
<!-- start: TOP NAVBAR -->
@include('header')
<div id="app">
<div class="app-content">
<!-- start: TOP NAVBAR -->
<!-- end: TOP NAVBAR -->
<div class="main-content" >
<div class="wrap-content container" id="container">
<!-- start: DASHBOARD TITLE -->
<div id="message-error-div"></div>
<section id="page-title" class="padding-top-100 padding-bottom-15">
    <div class="row">
        <div class="col-sm-7">
            <span class="mainDescription">Waiting / Merit List Form</span>
        </div>
    </div>
</section>
<!-- end: DASHBOARD TITLE -->
<!-- start: DYNAMIC TABLE -->
    <div class="alert alert-success alert-dismissible" role="alert" id="step-2ss" style="display: none">
        <button type="button" class="close" data-dismiss="alert" area-lebel="close">
            <span area-hidden="true">&times;</span>
        </button>
    </div>
<div class="col-md-12">
    <form method="post" action="edit-enquiry" role="form" id="studentEnquiry" onsubmit="parent.scrollTo(0, 0); return true">
        <input type="hidden" value="{!!$enquiryInfo['id']!!}" name="id">
        <input type="hidden" value="{!!$enquiryInfo['final_status']!!}" name="check" id="check">
        <fieldset>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">
                            Medium <span class="symbol required"></span>
                        </label>
                            <select class="form-control" id="medium" name="medium" style="-webkit-appearance: menulist;">
                                <option value="{!!$enquiryInfo['medium']!!}" disabled>{!!$enquiryInfo['medium']!!}</option>
                                <option value='Hindi'>Hindi</option>
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
                                <option value="{!!$enquiryInfo['class_applied']!!}" disabled>{!!$enquiryInfo['class_applied']!!}</option>
                                <option value='FYBCOM'>FYBCOM</option>
                                <option value='FYBBA'>FYBBA</option>
                                <option value='FYBBAIB'>FYBBA(IB)</option>
                                <option value='FYBBACA'>FYBBA(CA)</option>
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
                      <input type="text" placeholder="Enter your Middle Name" class="form-control" name="first_name" value="{!!$enquiryInfo['first_name']!!}" />
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                      <label class="control-label">
                          Middle Name<span class="symbol required"></span>
                      </label>
                      <input type="text" placeholder="Enter your Middle Name" class="form-control" name="middle_name" value="{!!$enquiryInfo['middle_name']!!}"/>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                      <label class="control-label">
                          Last Name<span class="symbol required"></span>
                      </label>
                      <input type="text" placeholder="Enter your Middle Name" class="form-control" name="last_name" value="{!!$enquiryInfo['last_name']!!}"/>
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group"> <!-- Date input -->
                      <label class="control-label">Total Marks Obtained <span class="symbol required"></span></label>
                      <input class="form-control" id="marks_obtained" name="marks_obtained" placeholder="Enter Marks obtained" type="text" value="{!!$enquiryInfo['marks_obtained']!!}" />
                  </div>
              </div>
              <div class="col-md-6">
                      <label class="control-label">Total Marks Out of<span class="symbol required"></span></label>
                      <input class="form-control" id="outOf_marks" name="outOf_marks" placeholder="Enter Out Of Marks" type="text" value="{!!$enquiryInfo['outOf_marks']!!}"/>
              </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group"> <!-- Date input -->
                        <label class="control-label">Examination Board<span class="symbol required"></span></label>
                        <input class="form-control" id="board" name="board" placeholder="Enter board" type="text" value="{!!$enquiryInfo['board']!!}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"> <!-- Date input -->
                        <label class="control-label">Name of the Caste/subcaste <span class="symbol required"></span></label>
                        <input class="form-control" id="caste" name="caste" placeholder="Enter your caste" type="text" value="{!!$enquiryInfo['caste']!!}" />
                    </div>
                </div>
             </div>
             <div class="row">
               <div class="col-md-6">
                   <div class="form-group"> <!-- Date input -->
                       <label class="control-label">Email <span class="symbol required"></span></label>
                       <input class="form-control" id="email" name="email" placeholder="Enter email" type="email"  value="{!!$enquiryInfo['email']!!}"/>
                   </div>
               </div>
               <div class="col-md-6">
                   <div class="form-group"> <!-- Date input -->
                       <label class="control-label">SpecialCategory <span class="symbol required"></span></label>
                       <select class="form-control" id="diff_category" name="diff_category" style="-webkit-appearance: menulist;">
                               @foreach($extra_categories as $category)
                                <option value="{!! $category['slug'] !!}">{!! $category['categories'] !!}</option>
                               @endforeach
                       </select>
                   </div>
               </div>
           </div>
           <div class="row">
             <div class="col-md-6">
                 <div class="form-group"> <!-- Date input -->
                     <label class="control-label">Caste Category <span class="symbol required"></span></label>
                     <select class="form-control" name="category" id="category" style="-webkit-appearance: menulist;">
                       @foreach($categories as $category)
                       <option value="{!!$category['slug']!!}" id="{!!$category['slug']!!}">{!!$category['caste_category']!!}</option>
                        @endforeach
                   	</select>
                 </div>
             </div>
             <div class="col-md-6">
               <label class="control-label">Year of Passing <span class="symbol required"></span></label>
               <select class="form-control" id="exam_year" name="examination_year" style="-webkit-appearance: menulist;">
                   <option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option>
               </select>
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

          </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group"> <!-- Date input -->
                        <label class="control-label">Mobile Number <span class="symbol required"></span></label>
                        <input class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile Number" type="text" value="{!!$enquiryInfo['mobile']!!}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="control-label">
                        Address <span class="symbol required"></span>
                    </label>
                    <div class="form-group">
                        <div class="note-editor">
                            <textarea class="form-control autosize area-animated" name="address" data-autosize-on="true" style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px; cursor: url('/assets/images/pen.png') 0 32, auto;">{!!$enquiryInfo['address']!!}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
          <legend>
            Status
          </legend>
          <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                    <input type="radio" class="final" id="final" name="final_status" value='pass'/>
                    <label for="final"><span></span>Approve</label>
                    <input type="radio" class="status" id="status" name="final_status" value='fail'/>
                    <label for="status"><span></span>Disapprove</label>
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
        $('select[name="medium"]').find('option[value={!!$enquiryInfo['medium']!!}]').attr("selected",true);
        $('select[name="class_applied"]').find('option[value={!!$enquiryInfo['class_applied']!!}]').attr("selected",true);
        $('select[name="country"]').find('option[value={!!$enquiryInfo['country']!!}]').attr("selected",true);
        $('select[name="state"]').find('option[value={!!$enquiryInfo['state']!!}]').attr("selected",true);
        $('select[name="category"]').find('option[value={!!$enquiryInfo['category']!!}]').attr("selected",true);
        $('select[name="examination_year"]').find('option[value={!!$enquiryInfo['examination_year']!!}]').attr("selected",true);
        $('select[name="diff_category"]').find('option[value={!!$enquiryInfo['diff_category']!!}]').attr("selected",true);
        if($('#check').val() == "fail"){
          $('#status').prop("checked",true);
        }else{
            $('#final').prop("checked",true);
        }
        //$(".app-sidebar-fixed #sidebar").addClass("removePadding");
   })

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
