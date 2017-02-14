
@extends('master')

@section('content')

<div id="app">

@include('sidebar')

<div class="app-content">

    @include('header')
    <!-- end: TOP NAVBAR -->
    <div class="main-content" >
        <div class="wrap-content container" id="container">



            <div class="form-group">

                <label class="control-label">
                    Select Classes <span class="symbol required"></span>
                </label>
                <div>

                    @foreach($batches as $batch)
                    <div>

                        <table class="table table-responsive batchClassTab">
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

            @foreach($concession_types as $concessions)

                      <div class="checkbox clip-check check-primary checkbox-inline">
                <input type="checkbox"  id="{{ $concessions['concession.id'] }}_concession_chk" value="{{ $concessions['concession.id'] }}" name="concessions[]">
                <label for="{{ $concessions['concession.id'] }}_concession_chk">{{ $concessions['concession.name'] }}</label>
            </div>

            @endforeach




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

<script src="/assets/js/main.js"></script>
<script src="/assets/js/form-elements.js"></script>
<script src="/assets/js/custom-project.js"></script>
<script>
jQuery(document).ready(function() {

    Main.init();
    FormValidator.init();
    FormElements.init();
    //userAclModule();


});





</script>


@stop














