@extends('master')
@section('content')
<div id="app">
@include('sidebar')
<div class="app-content">
    @include('header')
    <!-- end: TOP NAVBAR -->
    <div class="main-content" >
          <div class="wrap-content container" id="container">
            @include('alerts.errors')
            <form action="/fees/create-fee-structure" method="post" role="form" id="fee_create">
            <section id="page-title" class="padding-top-15 padding-bottom-15">
                <div class="row">
                    <div class="col-sm-7">
                        <h1 class="mainTitle">Create</h1>
                        <span class="mainDescription"> Fee Structure</span>
                    </div>
                </div>
            </section>
            <div class="container-fluid container-fullw bg-white">
             <div class="form-group">
                 <label class="control-label">
                     Academic Year <span class="symbol required"></span>
                 </label>
                 <select name="myselect" id="myselect">
                     <option value="2016-2017">2016-2017</option>
                     <option value="2017-2018">2017-2018</option>
                     <option value="2018-2019">2018-2019</option>
                     <option value="2019-2020">2019-2020</option>
                 </select>
             </div>
                </div>
            <div class="container-fluid container-fullw">
            <div class="form-group">
                <label class="control-label">
                     Fee Name<span class="symbol required"></span>
                </label>
                <input type="text" class="form-control" name="fee_name" id="fee_name1" placeholder="Enter Fee Name">
            </div>
                </div>
            <div class="container-fluid container-fullw">
            <div class="form-group">
                <label class="control-label">
                    Select Classes <span class="symbol required"></span>
                </label>
                <div>
                    @foreach($batches as $batch)
                    <div>
                         <table class="table table-responsive batchClassTab" id="ClassBatchtable">
                            <tr>
                                <th>{!! $batch !!}</th>
                                <th>&nbsp;</th>
                            </tr>
                            <?php $i=0; ?>
                            @foreach($classes as $class)
                            @if($batch==$class['batch'])
                            @if($i%2==0)
                            <tr>
                                <td>
                                    @else
                                <td>
                                    @endif
                                    <div class="checkbox clip-check check-primary checkbox-inline">
                                                <input type="checkbox"  id="{!! $class['id'] !!}_chk" value="{!! $class['id'] !!}" name="class[]">
                                        <label for="{!! $class['id'] !!}_chk">{!! $class['class'] !!}</label>
                                    </div>
                                    @if($i%2==0)
                                </td>
                                @else
                                </td>
                            </tr>
                            @endif
                            @endif
                            <?php $i++;?>
                           @endforeach
                        </table>
                    </div>
                    @endforeach
                </div>
            </div>
                </div>
            <div class="container-fluid container-fullw bg-white">
             <div class="form-group">
                <label class="control-label">
                    Select Concession Types<span class="symbol required"></span>&nbsp &nbsp<h5 style="color:red">[Note : If concession amount not available then simply put 0 value in it]</h5>
                </label>
                <div>
                    @foreach($concession_types as $concessions)
                    <div class="checkbox clip-check check-primary checkbox-inline" id="check">
                        <input type="checkbox"  id="{{ $concessions['concession.id'] }}_concession_chk" value="{{ $concessions['concession.id'] }}" name="concessions[]">
                        <label for="{{ $concessions['concession.id'] }}_concession_chk">{{ $concessions['concession.name'] }}</label>
                    </div>
                    @endforeach
                </div>
                <div class="form-group">

                 </div>
            </div>
            <div class="rte" style="display: none;border: 2px">
                <input type="text" placeholder="Enter RTE concession amount" class="form-control" name="rte">
            </div>
                <br>
            <div class="special" style="display: none;border: 2px">
                <input type="text" placeholder="Enter special concession amount" class="form-control" name="special">
            </div>
                <br>
            <div class="sport" style="display: none;border: 2px ">
                <input type="text" placeholder="Enter SPORT concession amount" class="form-control" name="sport">
            </div>
                <br>
            <div class="castes" style="display: none">
                <label class="control-label">
                    Caste Categories <span class="symbol required"></span>
                </label>
                <div>
                         <table style="width:100%">
                            <tr>
                                <th>Caste</th>
                                <th>Amount</th>
                            </tr>
                            @foreach($caste_types as $castes)
                            <tr>
                                <td>
                                    <label for="{{ $castes['caste_id'] }}">{{ $castes['caste_category'] }}</label>
                                </td>
                                <td>
                                    <input type="text"  id="caste"  name="castes[{{ $castes['caste_id'] }}]" required="">
                                </td>
                            </tr>
                            @endforeach
                         </table>
                 </div>
               </div>
            </div>
            <div class="container-fluid container-fullw">
                <div class="form-group">
                    <label class="control-label">
                        Installments : <span class="symbol required"></span>
                    </label>
                    <div>
                        <select border="1" class="inst_no" id="inst_no"   name="installment_count">
                            <option  border="1">Select Total Number of Installments</option>
                            @foreach($installment_number as $installments)
                            <option value="{{ $installments['installment_id'] }}">{{ $installments['installment_number'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="loadmoreajaxloader" style="display:none;"><center><img src="/assets/images/loader1.gif" /></center></div>
                    <div class="container-fluid container-fullw">
                        <div id="installments">
                        </div>
                    </div>
                    <div class="container-fluid container-fullw bg-green" style="color:white">
                     <h3> Total fee :</h3>
                        <input type="text" id="total_fee" class="total_fee" value="" name="total_fee">
                    </div>
                    <fieldset>
                        <div class="form-group">
                            <button class="btn btn-primary btn-wide pull-right" type="submit" id="fee_structure_create">
                                Create <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>

                    </fieldset>
                </div>
                </div>
              </form>
    </div>
        @include('rightSidebar')
        </div>
     </div>
@include('footer')
</div>
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/vendor/modernizr/modernizr.js"></script>
<script src="/vendor/jquery-cookie/jquery.cookie.js"></script>4a
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
<script src="/vendor/DataTables/jquery.dataTables.min.js"></script>
<script src="/assets/js/main.js"></script>
<script src="/assets/js/form-elements.js"></script>
<script src="/assets/js/custom-project.js"></script>
<script src="/assets/js/table-data.js"></script>
<script src="/assets/js/form-validation.js"></script>
<script>
jQuery(document).ready(function() {
    Main.init();
    FormValidator.init();
    FormElements.init();
})
     $("#2_concession_chk").click(function(){
        if(this.checked)
         {
             $('.castes').show(1000);
         }
         else
         {
             $('.castes').hide(1000);
         }
     })
   $("#1_concession_chk").click(function(){
      if(this.checked)
       {
          $('.rte').show(1000);
       }
      else
       {
        $('.rte').hide(1000);
       }
    })
   $("#3_concession_chk").click(function(){
     if(this.checked)
      {
         $('.special').show(1000);
      }
     else
      {
        $('.special').hide(1000);
      }
})
$("#4_concession_chk").click(function(){
    if(this.checked)
    {
        $('.sport').show(1000);
    }
    else
    {
        $('.sport').hide(1000);
    }
})
</script>
<script>
    $( "select" ).change(function () {
            $('div#loadmoreajaxloader').show();
            var str = this.value;
            $.ajax({
                       url: "/fees/installments",
                       data:{str1 : str},
                       success: function(response)
                        {
                            $("#installments").html(response);
                            $('div#loadmoreajaxloader').hide();
                        }
                   });
      })
</script>
@stop
