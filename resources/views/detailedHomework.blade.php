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

<div class="col-md-11 col-md-offset-1">
<div id="detail">
    <div class="col-sm-12">
        <div class="panel panel-white load1" id="panel6">
            <div class="panel-heading">
                <div class="timeline_title">
                    <i class="fa fa-book fa-2x pull-left fa-border"></i>
                    @foreach($homeworkIdss as $row)
                    <h4 class="panel-title no-margin text-primary" style="padding: 14px;">{!! $row['homework_type']!!}</h4>
                    @endforeach
                    <h5 style=" background-color: rgb(0, 122, 255);color: #fff;padding: 10px;">

                        <strong>Subject: </strong>
                        @foreach($homeworkIdss as $row)
                        <small class="label label-sm label-white">{!! $row['homework_subject']!!}</small>
                        @endforeach

                        <p class="pull-right">

                            <strong>Batch :</strong> <i>  {!! $homeworkdiv['batch'] !!}  </i>
                            <strong>Class :</strong> <i>{!! $homeworkdiv['class'] !!}  </i>


                            <strong>Div : </strong> <i>@foreach($homeworkdiv['divisions'] as $home){!! $home !!} @endforeach</i>

                        </p>

                    </h5>
                </div>
                @foreach($homeworkIdss as $row)
                <div class="panel-tools">
                    <i class="fa fa-clock-o"></i>{!! date('d M  Y', strtotime(str_replace('-', '/', $row['homework_date'])));!!}
                    <a data-original-title="Refresh" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm panel-refresh" href="#"><i class="ti-reload"></i></a>
                </div>
                @endforeach

            </div>
            <div class="panel-body">
                <div class="panel-scroll height-280 ps-container ps-active-y">
                    @foreach($homeworkIdss as $row)
                    <h4>{!!$row['homework_title']!!}  @if($row['homework_file'] != null) <a href="/download/{!!$row['homework_file']!!}"> Download <i class="fa fa-cloud-download"></i></a> @endif</h4>
                    <br>
                    <p>

                    <textarea class="form-control col-sm-8" id="description" name="description" style="min-height: 180px; margin-bottom: 8px;" readonly="yes" >{!!$row['homework_description']!!}</textarea>
                    </p>
                    <br>
                    <br>
                    <address>

                    Due Date:
                        {!! date('d M  Y', strtotime(str_replace('-', '/', $row['homework_due_date'])));!!}
                    </address>
                    @endforeach
                    <div class="col-md-12 form-group" id="tableContent2">
                        <div class="row" style="margin-bottom: 4px;">
                            <label>This Homework assigned to following students:</label>
                        </div>

                        <table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
                            <thead>
                            <tr>

                                <th>Roll No.</th>
                                <th>Name</th>
                                <th>Division</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($homeworkIdss as $row)
                            @foreach($row['homework_student_list'] as $std)
                            <tr>
                                <td>{!! $std['roll_number'] !!}</td>
                                <td>{!! $std['name'] !!}</td>
                                <td>{!! $std['division'] !!}</td>
                            </tr>
                            @endforeach
                           @endforeach

                            </tbody>

                        </table>

                    </div>

                    <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; height: 180px; right: 3px;"><div class="ps-scrollbar-y" style="top: 0px; height: 82px;"></div></div></div>
            </div>


            <div class="panel-footer col-sm-12">

                @foreach($homeworkIdss as $row)
                <h4><small>Created By: </small> {!! $row['homework_teacher_name'] !!}  </h4>

                @if($row['homework_status'] == 0 && $row['homework_is_active']==1)
                <div class="col-md-12" id="btnDiv">
                    <button class="btn btn-primary btn-wide pull-left" type="button" id="btnEdit">
                        <i class="fa fa-wrench"></i> Update
                    </button>

                    <a href="/edit-homework/{!! $row['homework_id'] !!}" class="btn btn-primary btn-wide pull-right" type="submit" id="btnSubmit" name="publish" value="publish">
                        Publish
                    </a>
                </div>
                @endif
                @endforeach


            </div>


        </div>
    </div>
</div>
<div id="update">

    <form action="/edit-homework-detail" role="form" method="post" id="form24" onsubmit="return validate();" enctype="multipart/form-data">
    <input type="hidden" name="homework_id" id="homework_id" value="@foreach($homeworkIdss as $work){!! $work['homework_id']!!}@endforeach"/>
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
                        @foreach($homeworkIdss as $work)
                        @if($work['homework_subject_id'] == $home['subject_id'])
                        <option value="{!! $work['homework_subject_id'] !!}" selected>{!! $work['homework_subject'] !!}</option>
                        @else
                        <option value="{!! $home['subject_id'] !!}" >{!! $home['subjects'] !!}</option>
                        @endif
                        @endforeach
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">
                        Homework Type <span class="symbol required"></span>
                    </label>
                    <select class="form-control" style="-webkit-appearance: menulist;" name="homeworkType">
                        @foreach($homeworkTypes as $home)
                        @foreach($homeworkIdss as $work)
                        @if($work['homework_type_id'] == $home['type_id'])
                        <option value="{!! $work['homework_type_id'] !!}" selected>{!! $work['homework_type'] !!}</option>
                        @else
                        <option value="{!! $home['type_id'] !!}">{!! $home['type_slug'] !!}</option>
                        @endif
                        @endforeach
                        @endforeach
                    </select>
                </div>
                @foreach($homeworkIdss as $row)
                <div class="form-group">
                    <label class="control-label">
                        Title <span class="symbol required"></span>
                    </label>
                    <input type="text" placeholder="Insert Title" class="form-control" id="title" name="title" value="{!!$row['homework_title']!!}">
                </div>

                <div class="form-group">
                    <label class="control-label">
                        Description <span class="symbol required"></span>
                    </label>
                    <textarea class="form-control col-sm-8" id="description" name="description" style="min-height: 180px; margin-bottom: 8px;">{!!$row['homework_description']!!}</textarea>
                </div>

                <div>
                    <label class="control-label">
                        Upload Document
                    </label>
                    <div id="wrapper" class="form-group">

                        <input  id="pdfFile" size="1" type="file" class="demoInputBox" onchange="return validate();"  name="pdfFile" value="{!!$row['homework_file']!!}" accept=".pdf" /><span id="file_error"></span>

                        </br>
                        </br>
                        <div id="hwtitle">
                            <p>{!!$row['homework_file']!!}
                            @if($row['homework_file'] != null )
                            <a onclick="deleteFile('{!! $row['homework_file']!!}','{!! $row['homework_id']!!}');"  class="btn btn-primary btn-red fileDelBtn"><i class="glyphicon glyphicon-trash"></i></a>
                            @endif
                            </p>
                        </div>

                    </div>

                </div>
                @endforeach
            </div>
            <div class="form-group">
                <div class="col-sm-6">
                    @foreach($homeworkIdss as $row)
                    <div class="form-group">
                        <label class="control-label">
                            Due Date <span class="symbol required"></span>
                        </label>
                        <input class="form-control datepicker" name="dueDate" id="dueDate" type="text" value="{!! $row['homework_due_date']!!}">
                    </div>
                    @endforeach
                    <h4>Assign Homework to: </h4>
                    <div class="form-group">
                        <label for="form-field-select-2">
                            Select Batch
                        </label>
                        <div id="batch-select-div"></div>

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
            <div class="col-md-10 form-group" id="tableContent2">
                <label>Select Students to assign homework</label>
                <div id="tableData"></div>
            </div>

            <div class="col-md-12">
                <button class="btn btn-primary btn-wide pull-left" type="button" id="btnCancel">
                    Cancel <i class="fa fa-times-circle-o"></i>
                </button>
                <button class="btn btn-primary btn-wide pull-right" type="submit" id="btnUpdate" name="btnUpdate" >
                    Update
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

</div>

@include('footer')

@include('rightSidebar')


</div>
<!-- start: MAIN JAVASCRIPTS -->
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/vendor/modernizr/modernizr.js"></script>
<script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/vendor/switchery/switchery.min.js"></script>
<script src="/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="/vendor/autosize/autosize.min.js"></script>
<script src="/vendor/selectFx/selectFx.js"></script>
<script src="/vendor/select2/select2.min.js"></script>
<script src="/vendor/maskedinput/jquery.maskedinput.min.js"></script>
<script src="/vendor/selectFx/classie.js"></script>
<script src="/vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
<script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="/vendor/DataTables/jquery.dataTables.min.js"></script>
<script src="/assets/js/table-data.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="/assets/js/main.js"></script>
<script src="/assets/js/form-elements.js"></script>
<script src="/assets/js/custom-project.js"></script>
<script src="/vendor/ckeditor/ckeditor.js"></script>
<script src="/vendor/ckeditor/adapters/jquery.js"></script>
<script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="/assets/js/form-validation.js"></script>
<script src="/vendor/jquery-validation/additional-methods.js"></script>

<!-- start: JavaScript Event Handlers for this page -->
<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();
        FormElements.init();
       // TableData.init();
        var startDate = new Date();
        $('#dueDate').datepicker('setStartDate', startDate);

        $('#update').hide();
        $('#btnStatus').hide();
        if($('.allCheckedStud1').prop('checked') == true)
        {
            $('.checkedStud1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
            });
        }

        var sub=$('#subjectsDropdown').val();
        if(sub!="")
        {
            var id=sub;
            var route='/get-subject-batches/'+id;
            console.log(route);
            $.get(route,function(res){
                var batch= $.map(res,function(value,index){
                    return value;
                });
                if(batch.length == 0)
                {
                    $('#batch-select').html("no record found");
                }
                else{
                var str='<select class="form-control" id="batch-select" style="-webkit-appearance: menulist;" name="batch" >';
                @foreach($editHomeworkBatch as $row)

                for(var i=0; i<batch.length; i++)
                {
                    if(batch[i]['batch_id'] == "{!! $row['batch_id'] !!}" )
                        {
                            str+='<option selected value="'+batch[i]['batch_id']+'" >'+batch[i]['batch']+'</option>';
                        }
                }

                 @endforeach


                $('#batch-select-div').html(str);
                }

                $val=$('#batch-select').val();
                    var route='/get-subject-classes/'+$val+'/'+id;
                    $.get(route,function(res){
                        if(res.length == 0)
                        {
                            $('#classDropdown').html("no record found");
                        }
                        else{
                        var str='<option value="">please select class</option>';
                       @foreach($editHomeworkClass as $row)
                        for(var i=0; i<res.length; i++)
                        {
                            if(res[i]['class_id'] == "{!! $row['class_id'] !!}" )
                            {
                            str+='<option value="'+res[i]['class_id']+'" selected>'+res[i]['class_name']+'</option>';
                            }
                        }
                         @endforeach

                        $('#classDropdown').html(str);

                        }

                        var val1=$('#classDropdown').val();


                        var route='/get-subject-divisions/'+val1+'/'+id+'/'+$val;


                        $.get(route,function(res5){
                            var str = "";

                            var arrStr= $.map(res5,function(value){
                                return value;
                            });
                            console.log(arrStr);

                            var hrId=$('#homework_id').val();

                            var route1='/get-edit-data/'+hrId;


                            $.get(route1,function(res7){
                                if(res5.length == 0)
                                {
                                    $('#division').html("no record found");
                                }
                                else{
                                var arr1=[];
                                for(var i=0; i<res7.length; i++)
                                {
                                    arr1[i]=res7[i]['division_id'];
                                }


                                for(var i=0; i<arrStr.length; i++){

                                   if($.inArray(arrStr[i]['div_id'],arr1)!=-1)
                                    {
                                        str+='<div class="checkbox clip-check check-primary checkbox-inline">'+

                                            '<input type="checkbox" value="'+arrStr[i]['div_id']+'" class="FirstDiv" onchange="Selectallcheckbox()" id="'+arrStr[i]['div_id']+'" name="divisions[]" checked>'+
                                            '<label for="'+arrStr[i]['div_id']+'">'+
                                            ''+arrStr[i]['division_name']+''+
                                            '</label>'+
                                            '</div>';
                                    }else{
                                        str+='<div class="checkbox clip-check check-primary checkbox-inline">'+

                                            '<input type="checkbox" value="'+arrStr[i]['div_id']+'" class="FirstDiv" onchange="Selectallcheckbox()" id="'+arrStr[i]['div_id']+'" name="divisions[]" >'+
                                            '<label for="'+arrStr[i]['div_id']+'">'+
                                            ''+arrStr[i]['division_name']+''+
                                            '</label>'+
                                            '</div>';
                                    }

                                }

                                $('#division').html(str);
                                }



                            var divID =res7;
                            var sample= jQuery.map(divID, function(n,i){
                               return n.division_id;
                            });

                                var route='/get-division-students';
                                $.post(route,{id:sample},function(res1){


                                        var route3='/get-edit-division-students';
                                        var hrId=$('#homework_id').val();
                                        var str1="";
                                    var str1="<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>"+
                                        "<thead>"+
                                        "<tr>"+
                                        "<th><input type='checkbox' id='selectAll' class='allCheckedStud1' data-set='#sample_2 .checkedStud1'/> <span class='position-absolute padding-left-5'><b>Select </b></span></th>"+
                                        "<th>Roll No.</th>"+
                                        "<th>Name</th>"+
                                        "<th>Division</th>"+
                                        "</tr>"+
                                        "</thead>"+
                                        "<tbody id='studentList'>";
                                            $.post(route3,{id:sample,homework_id:hrId},function(res2){

                                                var arrStr= $.map(res2,function(value){
                                                    return value['user_id'];
                                                });

                                                for(var i=0;i<res1.length;i++)
                                                {


                                                    if($.inArray(res1[i]['user_id'],arrStr)!=-1){

                                                       str1+=' <tr>'+
                                                           '<td><input type="checkbox"  name="studentinfo[]" class="checkedStud1" value="'+res1[i]['user_id']+'" checked/></td>'+
                                                           '<td>'+res1[i]['roll_number']+'</td>'+
                                                           '<td>'+res1[i]['first_name']+' '+res1[i]['last_name']+'</td>'+
                                                           '<td>'+res1[i]['division_name']+'</td>'+
                                                           '</tr>';


                                                   }else{
                                                        str1+=' <tr>'+
                                                            '<td><input type="checkbox"  name="studentinfo[]" class="checkedStud1" value="'+res1[i]['user_id']+'" /></td>'+
                                                            '<td>'+res1[i]['roll_number']+'</td>'+
                                                            '<td>'+res1[i]['first_name']+' '+res1[i]['last_name']+'</td>'+
                                                            '<td>'+res1[i]['division_name']+'</td>'+
                                                            '</tr>';
                                                    }

                                                }
                                                str1 += '</tbody>'+
                                                    '</table>';
                                                $('#tableData').html(str1);
                                                TableData.init();
                                                if($('.allCheckedStud1').prop('checked') == true)
                                                {
                                                    $('.checkedStud1').each(function() { //loop through each checkbox
                                                        this.checked = true;  //select all checkboxes with class "checkbox1"
                                                    });
                                                }
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

                                            });


                                });


                        });


                });






                    });



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
    $('#btnEdit').click(function(){
        $('#detail').hide();
        $('#update').show();
    });

    $('#btnCancel').click(function(){
        $('#update').hide();
        $('#detail').show();

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


    $('#subjectsDropdown').change(function(){
        $('#btnSubmit').attr('disabled','true');
        $('#btnEdit').attr('disabled','true');
        var id=this.value;
        var route='/get-subject-batches/'+id;
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
        var route='/get-subject-classes/'+id+'/'+subject_id;
        $.get(route,function(res){

            if(res.length == 0)
            {
                $('#classDropdown').html("no record found");
            }
            else{

                var str='<option value="">please select class</option>';
                for(var i=0; i<res.length; i++)
                {
                    str+='<option value="'+res[i]['class_id']+'">'+res[i]['class_name']+'</option>';
                }
                $('#classDropdown').html(str);
            }
        });
    });

    $("#classDropdown").change(function() {
        var id = this.value;
        var subject_id= $('#subjectsDropdown').val();
        var batch_id= $('#batch-select').val();
        var route='/get-subject-divisions/'+id+'/'+subject_id+'/'+batch_id;
        $.get(route,function(res){
            $('#division').html(" ");
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

                        '<input type="checkbox" value="'+arrStr[i]['div_id']+'" id="'+arrStr[i]['div_id']+'" class="FirstDiv" class="input-checkbox" onchange="Selectallcheckbox()" name="divisions[]">'+
                        '<label for="'+arrStr[i]['div_id']+'">'+
                        ''+arrStr[i]['division_name']+''+
                        '</label>'+
                        '</div>';
                }
                $('#division').html(str);
                $('#btnSubmit').removeAttr('disabled');
                $('#btnEdit').removeAttr('disabled');
                FormElements.init();
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
        var route='/get-division-students';
        $.post(route,{id:aIds},function(res1){

        var route3='/get-edit-division-students';
        var hrId=$('#homework_id').val();
        var str1="";
            var str1="<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>"+
                "<thead>"+
                "<tr>"+
                "<th><input type='checkbox' id='selectAll' class='allCheckedStud1' data-set='#sample_2 .checkedStud1' /> <span class='position-absolute padding-left-5'><b>Select </b></span></th>"+
                "<th>Roll No.</th>"+
                "<th>Name</th>"+
                "<th>Division</th>"+
                "</tr>"+
                "</thead>"+
                "<tbody id='studentList'>";
        $.post(route3,{id:aIds,homework_id:hrId},function(res2){

            var arrStr= $.map(res2,function(value){
                return value['user_id'];
            });

            for(var i=0;i<res1.length;i++)
            {


                if($.inArray(res1[i]['user_id'],arrStr)!=-1){

                    str1+=' <tr>'+
                        '<td><input type="checkbox"  name="studentinfo[]" class="checkedStud1" value="'+res1[i]['user_id']+'" checked/></td>'+
                        '<td>'+res1[i]['roll_number']+'</td>'+
                        '<td>'+res1[i]['first_name']+' '+res1[i]['last_name']+'</td>'+
                        '<td>'+res1[i]['division_name']+'</td>'+
                        '</tr>';


                }else{


                    str1+=' <tr>'+
                        '<td><input type="checkbox"  name="studentinfo[]" class="checkedStud1" value="'+res1[i]['user_id']+'" /></td>'+
                        '<td>'+res1[i]['roll_number']+'</td>'+
                        '<td>'+res1[i]['first_name']+' '+res1[i]['last_name']+'</td>'+
                        '<td>'+res1[i]['division_name']+'</td>'+
                        '</tr>';
                }

            }
            str1 += '</tbody>'+
                '</table>';
            $('#tableData').html(str1);

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
        });


    }

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

    $('#subjectsDropdown').change(function(){

        $('#classDropdown').val('');
        $('#batch-select').val('');
        $('#division').html('');
        $('#studentList').html('');
        FormElements.init();
    });

    $('#classDropdown').change(function(){
        FormElements.init();
    });

    function deleteFile(file,homework){
        var route="/delete-file/"+file+"/"+homework;
        $.get(route,function(res){
           if(res=="true")
           {
                $('#hwtitle').html("");
                $('.fileDelBtn').hide();
           }
        });
    }

</script>



<!-- start: MAIN JAVASCRIPTS -->

@stop