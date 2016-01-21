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
                <section id="page-title" class="padding-top-15 padding-bottom-15">
                    <div class="row">
                        <div class="col-sm-7">
                            <h1 class="mainTitle">Assign Subject</h1>
                        </div>

                    </div>
                </section>

                <div class="container-fluid container-fullw">
                    <div class="row">
                        <div class="col-md-11 col-md-offset-1">

                            <form method="post" action="create-relation" role="form" id="subjectTeacher">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="errorHandler alert alert-danger no-display">
                                            <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                                        </div>
                                        <div class="successHandler alert alert-success no-display">
                                            <i class="fa fa-ok"></i> Your form validation is successful!
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label class="control-label">
                                                Select Subject <span class="symbol required"></span>
                                            </label>
                                            <select class="form-control" id="subjectDropdown" name="subjectDropdown" style="-webkit-appearance: menulist;">
                                                <option value=""> Please select subjects...</option>
                                                @foreach($subjects as $subject)
                                                <option value="{!! $subject->id !!}">{!! $subject->subject !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Batch <span class="symbol required"></span>
                                                </label>
                                                <select class="form-control" id="batchDropdown" name="batchDropdown" style="-webkit-appearance: menulist;">
                                                    <option value="">Select Batch...</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Class <span class="symbol required"></span>
                                                </label>
                                                <select class="form-control" id="classDropdown" name="classDropdown" style="-webkit-appearance: menulist;">
                                                    <option value="">Select Class...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Division <span class="symbol required"></span>
                                                </label>
                                                <select class="form-control" id="divisionDropdown" name="divisionDropdown" style="-webkit-appearance: menulist;">
                                                    <option value="">Select Division...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Teacher <span class="symbol required"></span>
                                                </label>
                                                <select class="form-control" id="teacherDropdown" name="teacherDropdown" style="-webkit-appearance: menulist;">
                                                    <option value="">Select Teacher...</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-wide pull-right" type="submit">
                                            Add <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="row">
                                <label>Related Teachers</label>
                            </div>
                            <table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
                                <thead>
                                <tr>
                                    <th>Batch</th>
                                    <th>Class</th>
                                    <th>Division</th>
                                    <th>Subject</th>
                                    <th>Teacher Name (Username)</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($associations as $association)
                                <tr>
                                    <td>{!! $association->batch !!}</td>
                                    <td>{!! $association->class !!}</td>
                                    <td>{!! $association->division !!}</td>
                                    <td>{!! $association->subject !!}</td>
                                    <td>{!! $association->teacherFirstName !!} {!! $association->teacherLastName !!} ({!! $association->teacherUsername !!})</td>
                                    <td><a onclick="deleteConfirm({!! $association->id !!});">Delete</a></td>
                                </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>


                </div>
            </div>

            @include('rightSidebar')
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
<script src="/vendor/selectFx/selectFx.js"></script>
<script src="/vendor/select2/select2.min.js"></script>

<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="/vendor/DataTables/jquery.dataTables.min.js"></script>
<script src="/assets/js/table-data.js"></script>
<script src="assets/js/main.js"></script>

<script src="assets/js/form-wizard.js"></script>

<script src="assets/js/form-validation.js"></script>
<script src="assets/js/custom-project.js"></script>

<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormWizard.init();
        FormValidator.init();
        TableData.init();

    });

    $('#subjectDropdown').change(function(){
        var id=this.value;
        getSubjectBatches(id);
    });

    $('#batchDropdown').change(function(){
        var id=this.value;
        getSubjectClasses(id);
    });

    $('#classDropdown').change(function(){
        var id=this.value;
        getSubjectDivisions(id);
    });

    $('#divisionDropdown').change(function(){
        var id=this.value;
        getDivisionTeachers(id);
    });

    function getSubjectBatches(val)
    {
        if(val!="")
        {
            var route="/get-sub-batches/"+val;
            $.get(route,function(res){
                var str="<option value=''>Select Batch</option>";
                for(var i=0; i<res.length; i++)
                {
                    str+="<option value='"+res[i]['id']+"'>"+res[i]['batch']+"</option>"
                }
                $('#batchDropdown').html(str);
            });
        }else{
            $('#batchDropdown').html('<option value="">Select Batch...</option>');
        }

    }

    function getSubjectClasses(val)
    {
        if(val!="")
        {
            var subject=$('#subjectDropdown').val();
            var route="/get-sub-classes/"+val+"/"+subject;
            $.get(route,function(res){
                var str="<option value=''>Select Class</option>";
                for(var i=0; i<res.length; i++)
                {
                    str+="<option value='"+res[i]['id']+"'>"+res[i]['class']+"</option>"
                }
                $('#classDropdown').html(str);
            });
        }else{
            $('#classDropdown').html('<option value="">Select Class...</option>');
        }
    }
    function getSubjectDivisions(val)
    {
        if(val!="")
        {
            var route="/get-sub-divisions/"+val;
            $.get(route,function(res){
                var str="<option value=''>Select Division</option>";
                for(var i=0; i<res.length; i++)
                {
                    str+="<option value='"+res[i]['id']+"'>"+res[i]['division']+"</option>"
                }
                $('#divisionDropdown').html(str);
            });
        }else{
            $('#divisionDropdown').html('<option value="">Select Division...</option>');
        }
    }

    function getDivisionTeachers(val)
    {
        if(val!="")
        {
            var subject=$('#subjectDropdown').val();
            var route="/get-sub-teachers/"+val+"/"+subject;
            $.get(route,function(res){
                var str="<option value=''>Select Teacher</option>";
                for(var i=0; i<res.length; i++)
                {
                    str+="<option value='"+res[i]['id']+"'>"+res[i]['firstname']+""+res[i]['lastname']+","+res[i]['username']+"</option>"
                }
                $('#teacherDropdown').html(str);
            });
        }else{
            $('#teacherDropdown').html('<option value="">Select Teacher...</option>');
        }
    }

    function deleteConfirm(val)
    {
        var confirmVal=confirm('Do you want to delete this Association !');
        if(confirmVal==true)
        {
            window.location.href='/delete-relation/'+val;
        }
    }

    $('#teacherDropdown').change(function(){
        var teacher=this.value;
        var name=$('#teacherDropdown :selected').text();

        var div=$('#divisionDropdown').val();
        var subject=$('#subjectDropdown').val();

        route="/check-sub-teacher/"+subject+"/"+div;

        $.get(route,function(res){
            if(res==1)
            {
                var confirmVal=confirm('teacher '+name+' already assigned to this subject do you want to change it? !');
                if(confirmVal==false)
                {
                    $('#teacherDropdown option:eq(0)').attr('selected','selected');
                }
            }
        });
    });


</script>

@stop


