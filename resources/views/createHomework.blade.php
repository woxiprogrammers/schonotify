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
            <h1 class="mainTitle">Homework</h1>
        </div>
    </div>
</section>
<!-- end: DASHBOARD TITLE -->
<div class="container-fluid container-fullw bg-white">

<div class="row">
<div class="col-md-10 col-md-offset-1">
    <form action="/create-homework" method="post" role="form" id="form24" enctype="multipart/form-data" onsubmit="return validate();">
        <div class="row">
            <div class="col-md-12">
                <div class="errorHandler alert alert-danger no-display">
                    <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                </div>
                <div class="successHandler alert alert-success no-display">
                    <i class="fa fa-ok"></i> Your form validation is successful!
                </div>
            </div>
            <div class="col-md-10">
                <div class="form-group">
                    <label for="form-field-select-2">
                        Select Subject
                    </label>
                    <select class="form-control" id="subjectsDropdown" style="-webkit-appearance: menulist;" name="subjectsDropdown">
                        <option value="">select subject</option>
                        @foreach($homework as $home)
                        <option value="{!! $home['subject_id'] !!}">{!! $home['subjects'] !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">
                        Homework Type <span class="symbol required"></span>
                    </label>
                    <select class="form-control" style="-webkit-appearance: menulist;" name="homeworkType">
                        @foreach($homeworkTypes as $home)
                        <option value="{!! $home['type_id'] !!}">{!! $home['type_slug'] !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">
                        Title <span class="symbol required"></span>
                    </label>
                    <input type="text" placeholder="Insert Title" class="form-control" id="title" name="title">
                </div>
                <div class="form-group">
                    <label class="control-label">
                        Description <span class="symbol required"></span>
                    </label>
                    <textarea class="form-control col-sm-8" id="description" name="description" style="min-height: 180px; margin-bottom: 8px;"></textarea>

                </div>
                <div class="form-group col-sm-8">
                    <label class="control-label">
                        Upload Document
                    </label>
                    <div id="wrapper">
                        <input id="pdfFile" class="demoInputBox" size="1" onchange="return validate();" accept=".pdf" type="file" name="pdfFile" /><span id="file_error"></span>

                    </div>
                    <br>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">
                            Due Date <span class="symbol required"></span>
                        </label>
                        <input class="form-control datepicker" type="text" name="dueDate" id="dueDate"  >
                    </div>
                    <h4>Assign Homework to: </h4>
                    <div class="form-group">
                        <label for="form-field-select-2">
                            Select Batch
                        </label>
                        <select class="form-control" id="batch-select" style="-webkit-appearance: menulist;" name="batch">



                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Class <span class="symbol required"></span>
                        </label>
                        <select class="form-control" style="-webkit-appearance: menulist;" name="classDropdown" id="classDropdown">



                        </select>
                    </div>
                    <div class="form-group">
                        <div id="division"></div>

                    </div>
                </div>
            </div>
            <div class="col-md-12 form-group" id="tableContent2">
                <div class="row" style="margin-bottom: 4px;">
                    <label>Select Students to assign homework</label>
                </div>
                <div id="tableData"></div>

            </div>
                <div class="col-md-12 form-group">

                        <button class="btn btn-wide btn-primary " type="submit" name="buttons" value="save" id="saveSubmit">
                            <span class="">Save</span>
                            </button>
                        <button class="btn btn-primary btn-wide pull-right" type="submit" id="btnSubmit" name="buttons" value="publish">
                            Publish
                        </button>
                </div>
        </div>
    </form>
</div>
</div>
</div>
</div>
</div>

</div>

@include('footer')

@include('rightSidebar')


</div>
<!-- start: MAIN JAVASCRIPTS -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/modernizr/modernizr.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="vendor/autosize/autosize.min.js"></script>
<script src="vendor/selectFx/selectFx.js"></script>
<script src="vendor/select2/select2.min.js"></script>
<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
<script src="vendor/selectFx/classie.js"></script>
<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

<script src="vendor/DataTables/jquery.dataTables.min.js"></script>
<script src="assets/js/table-data.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>
<script src="assets/js/form-elements.js"></script>
<script src="vendor/ladda-bootstrap/spin.min.js"></script>
<script src="vendor/ladda-bootstrap/ladda.min.js"></script>
<script src="assets/js/ui-buttons.js"></script>
<script src="assets/js/custom-project.js"></script>
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="assets/js/form-validation.js"></script>
<script src="vendor/jquery-validation/additional-methods.js"></script>
<!-- start: JavaScript Event Handlers for this page -->
<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();
        FormElements.init();
        TableData.init();
        var startDate = new Date();
        $('#dueDate').datepicker('setStartDate', startDate);
    });


    $('.classFirst').change(function(){
        if($(this).prop('checked') == true)
        {
            $('.FirstDiv').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
            });
        }else{
            $('.FirstDiv').each(function() { //loop through each checkbox
                this.checked = false;  //select all checkboxes with class "checkbox1"
            });
        }
    });

    $('.classSecond').change(function(){
        if($(this).prop('checked') == true)
        {
            $('.SecondDiv').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
            });
        }else{
            $('.SecondDiv').each(function() { //loop through each checkbox
                this.checked = false;  //select all checkboxes with class "checkbox1"
            });
        }
    });
    function validate() {
        $("#file_error").html("");
        $(".demoInputBox").css("border-color","#F0F0F0");
        var file_size = $('#pdfFile')[0].files[0].size;
        if(file_size>26214400) {
            $("#file_error").html("File size is greater than 25MB");
            $(".demoInputBox").css("border-color","#FF0000");
            return false;
        }
        return true;
    }
    $('#subjectsDropdown').change(function(){
        $('#btnSubmit').attr('disabled','true');
        $('#saveSubmit').attr('disabled','true');
        var id=this.value;
        var route='get-subject-batches/'+id;
        $.get(route,function(res){
            //console.log(res);
            var batch= $.map(res,function(value,index){
                return value;
            });
            if(batch.length == 0)
            {
                $('#batch-select').html("no record found");
            }
            else{
            var str='<option value="">Select Batch</option>';
            for(var i=0; i<batch.length; i++)
            {
                str+='<option value="'+batch[i]['batch_id']+'">'+batch[i]['batch']+'</option>';
            }
            $('#batch-select').html(str);

            }
        });
    });
    $('#batch-select').change(function(){
      var id=this.value;
      var subject_id= $('#subjectsDropdown').val();
      var route='get-subject-classes/'+id+'/'+subject_id;
      $.get(route,function(res){
          if(Object.keys(res).length == 0)
          {
              $('#classDropdown').html("no record found");
          }
          else{
              var str='<option value="">please select class</option>';
              $.each(res, function( key, value ) {
                   str+='<option value="'+value['class_id']+'">'+value['class_name']+'</option>';
              });
              $('#classDropdown').html(str);
          }
          });
    });
    $("#classDropdown").change(function() {
        var id = this.value;
        var subject_id= $('#subjectsDropdown').val();
        var batch_id= $('#batch-select').val();
        var route='get-subject-divisions/'+id+'/'+subject_id+'/'+batch_id;
        $.get(route,function(res){
            var str = "";

            var arrStr= $.map(res,function(value){
                return value;
            });
            if(arrStr.length == 0)
            {
                $('#division').html("no record found");
            }
            else{
                for(var i=0; i<arrStr.length; i++){

                    str+='<div class="checkbox clip-check check-primary checkbox-inline">'+

                        '<input type="checkbox" value="'+arrStr[i]['div_id']+'" class="FirstDiv" onchange="Selectallcheckbox()" id="'+arrStr[i]['div_id']+'" name="divisions[]">'+
                        '<label for="'+arrStr[i]['div_id']+'">'+
                        ''+arrStr[i]['division_name']+''+
                        '</label>'+
                        '</div>';
                }
                $('#division').html(str);

                $('#btnSubmit').removeAttr('disabled');
                $('#saveSubmit').removeAttr('disabled');
            }
        });

    });

    function Selectallcheckbox(){
        var all_location_id = document.querySelectorAll('input[name="divisions[]"]:checked');

        var aIds = [];

        for(var x = 0, l = all_location_id.length; x < l;  x++)
        {
            aIds.push(all_location_id[x].value);
        }
        var route='get-division-students';
        var divisions=aIds;
        $.post(route,{id:divisions},function(res){

            if(res.length == 0)
            {
                $('#tableData').html("no record found"+'<input type="hidden"  name="studentinfo[]" value=""/>');
            }else{
            var str = "";
            var str="<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>"+
                "<thead>"+
                "<tr>"+
                "<th><input type='checkbox' id='selectAll' class='allCheckedStud1' data-set='#sample_2 .checkedStud1' checked/> <span class='position-absolute padding-left-5'><b>Select </b></span></th>"+
                "<th>Roll No.</th>"+
                "<th>Name</th>"+
                "<th>Division</th>"+
            "</tr>"+
            "</thead>"+
            "<tbody id='studentList'>";


                for(var i=0; i<res.length; i++){
                    str+=' <tr>'+
                        '<td><input type="checkbox"  name="studentinfo[]" class="checkedStud1" value="'+res[i]['user_id']+'"/></td>'+
                        '<td>'+res[i]['roll_number']+'</td>'+
                        '<td>'+res[i]['first_name']+' '+res[i]['last_name']+'</td>'+
                        '<td>'+res[i]['division_name']+'</td>'+
                        '</tr>';
                }

            str += '</tbody>'+
            '</table>';
            $('#tableData').html(str);

            }

            jQuery(document).ready(function() {
                TableData.init();
            });
            $('.allCheckedStud1').change(function(){

                if($(this).prop('checked') == true)
                {
                    $('.checkedStud1').each(function() { //loop through each checkbox
                        this.checked = true;  //select all checkboxes with class "checkbox1"
                    });
                }else{
                    $('.checkedStud1').each(function() { //loop through each checkbox
                        this.checked = false;  //select all checkboxes with class "checkbox1"
                    });
                }
            });
            if($('.allCheckedStud1').prop('checked') == true)
            {
                $('.checkedStud1').each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"
                });
            }

            $("#tableData").dataTable().fnDestroy();

        });



    }

    $('#subjectsDropdown').change(function(){

        $('#division').val('');
    });





</script>


<!-- start: MAIN JAVASCRIPTS -->

@stop
