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
                            <h1 class="mainTitle">Attendance</h1>
                        </div>
                    </div>
                </section>
                <!-- end: DASHBOARD TITLE -->
                <div class="container-fluid container-fullw bg-white">

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <form action="/mark-attendance" method="post" role="form" id="markAttendance">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="errorHandler alert alert-danger no-display">
                                            <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                                        </div>
                                        <div class="successHandler alert alert-success no-display">
                                            <i class="fa fa-ok"></i> Your form validation is successful!
                                        </div>
                                    </div>

                                    @if ($dropDownData != null)
                                      @if (Auth::User()->role_id == 2)
                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <label for="form-field-select-2">
                                                        Select Batch
                                                    </label>
                                                    <select class="form-control" name="batch-select" id="batch-select"  style="-webkit-appearance: menulist;">
                                                        <option value="">Please select batch</option>
                                                        @foreach($dropDownData['batch'] as $row)
                                                        <option value="{!!$row['batch_id']!!}" >{!!$row['batch_name']!!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4"  id="class-select-div">
                                                    <label for="form-field-select-2">
                                                        Select Class
                                                    </label>
                                                    <select class="form-control" name="class-select" id="class-select" style="-webkit-appearance: menulist;">
                                                      <option value="">Please select class</option>
                                                        <option value="{!!$dropDownData['class_id']!!}">{!!$dropDownData['class_name']!!}</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4" id="division-select-div">
                                                    <label for="form-field-select-2">
                                                        Select Division
                                                    </label>
                                                    <select class="form-control" name="division-select" id="division-select" style="-webkit-appearance: menulist;">
                                                      <option value="">Please select division</option>
                                                        <option value="{!!$dropDownData['division_id']!!}">{!!$dropDownData['division_name']!!}</option>
                                                    </select>
                                                </div>
                                            </div>
                                      @else
                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <label for="form-field-select-2">
                                                        Select Batch
                                                    </label>
                                                    <select class="form-control" id="batch-select"  name="batch-select" style="-webkit-appearance: menulist;">
                                                        <option value="">Please select batch</option>
                                                        @foreach($dropDownData['batch'] as $row)
                                                        <option value="{!!$row['batch_id']!!}" >{!!$row['batch_name']!!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4" id="class-select-div" >
                                                    <label for="form-field-select-2">
                                                        Select Class
                                                    </label>
                                                    <select class="form-control" id="class-select" name="class-select" style="-webkit-appearance: menulist;">
                                                    </select>
                                                    <div id="loadmoreajaxloaderClass" style="display:none;"><center><img src="assets/images/loader1.gif" /></center></div>
                                                </div>
                                                <div class="form-group col-sm-4" id="division-select-div">
                                                    <label for="form-field-select-2">
                                                        Select Division
                                                    </label>
                                                    <select class="form-control" id="division-select"  name="division-select" style="-webkit-appearance: menulist;">
                                                    </select>
                                                    <div id="loadmoreajaxloaderDivision" style="display:none;"><center><img src="assets/images/loader1.gif" /></center></div>

                                                </div>
                                            </div>
                                    @endif
                                    @else
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="form-field-select-2">
                                                Select Batch
                                            </label>

                                            <select class="form-control" name="batch-select" id="batch-select"  style="-webkit-appearance: menulist;">

                                                <option value="" >no record found</option>

                                            </select>
                                        </div>
                                        <div class="form-group col-sm-4"  id="class-select-div">
                                            <label for="form-field-select-2">
                                                Select Class
                                            </label>
                                            <select class="form-control" name="class-select" id="class-select" style="-webkit-appearance: menulist;">
                                                <option value="">no record found</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-4" id="division-select-div">
                                            <label for="form-field-select-2">
                                                Select Division
                                            </label>
                                            <select class="form-control" name="division-select" id="division-select" style="-webkit-appearance: menulist;">
                                                <option value="">no record found</option>
                                            </select>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Select Date <span class="symbol required"></span>
                                                </label>
                                                <input class="form-control datepicker" type="text" name="datePiker" id="datePiker" value="{!! date('m/d/Y', time());!!}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 form-group" id="tableContent2">
                                        <div class="row" style="margin-bottom: 8px;margin-top: 8px;">
                                            <label>Unmark Students who Are absent:</label>
                                        </div>
                                        <div id="loadmoreajaxloaderStudent" style="display:none;"><center><img src="assets/images/loader1.gif" /></center></div>

                                        <table  class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>Roll No.</th>
                                                <th>Name</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @if(!empty($dropDownData['student_list']))
                                            @if(isset($dropDownData['student_list']))
                                            @foreach($dropDownData['student_list'] as $row)
                                            <tr>
                                                <td>
                                                    @if($row['student_attendance_status'] == 1  )
                                                    <input type="checkbox"  name="student[]" id="{!! $row['student_id'] !!}" value="{!! $row['student_id'] !!}"  checked/> <label for="{!! $row['student_id'] !!}"></label>
                                                    @else
                                                    <input type="checkbox"   name="student[]" id="{!! $row['student_id'] !!}" value="{!! $row['student_id'] !!}"  /><label for="{!! $row['student_id'] !!}"></label>
                                                    @endif
                                                </td>
                                                <td>{!! $row['roll_number'] !!}</td>
                                                <td>{!! $row['student_name'] !!} &nbsp; &nbsp; @if($row['student_leave_status'] == 1  ) <span class="label label-default label-text-yellow">Leave Applied</span> @elseif($row['student_leave_status'] == 2 )<span class="label label-default label-text-orange">Leave Approved</span> @endif  </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <button class="btn btn-primary btn-wide" type="button" id="btnSubmit">
                                            Cancel
                                        </button>
                                        <button class="btn btn-wide btn-primary ladda-button pull-right"  data-style="expand-left" id="saveButton" type="submit">
                                            <span class="ladda-label">Save</span>
                                            <span class="ladda-spinner"></span><span class="ladda-spinner"></span>
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
<script src="/assets/js/main.js"></script>
<script src="/assets/js/form-elements.js"></script>
<script src="/vendor/ladda-bootstrap/spin.min.js"></script>
<script src="/vendor/ladda-bootstrap/ladda.min.js"></script>
<script src="/assets/js/ui-buttons.js"></script>
<script src="/assets/js/custom-project.js"></script>
<script src="/vendor/ckeditor/ckeditor.js"></script>
<script src="/vendor/ckeditor/adapters/jquery.js"></script>
<script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="/assets/js/form-validation.js"></script>
<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();

        $('#allCheckedStud-label img').css('border','1px solid');
        if ($('.allCheckedStud').prop('checked') == true)
        {
            $('#allCheckedStud-label img').prop('src','assets/images/tick.png');
            var i=0;
            $('.checkedStud').each(function() { //loop through each checkbox
                if (this.checked == true){
                    $('#'+this.className+this.id).prop('src','assets/images/tick.png');
                }else{
                    $('#'+this.className+this.id).prop('src','assets/images/cross.png');
                }
                i++;
            });
        }
        $('#sample_2').DataTable(
            { scrollY: 450,
                paging: false,
                ordering:true
            });

        FormElements.init();
        UIButtons.init();
        $(document).ready(function () {
            $('#datePiker').on('change', function(){
                $('#datePiker').datepicker("hide");
            });
          var role = {!! Auth::User()->role_id !!};
          if( role == 1 ) {
                var batchSelected=$('#batch-select').val();
                if(batchSelected!="")
                {
                    getClasses(batchSelected);
                }
          }
        });
        var endDate = new Date();
        $('#datePiker').datepicker('setEndDate', endDate);

    });
    $('#btnSubmit').click(function(){
        var date=$('#datePiker').val();
        var division=$('#division-select').val();
        dateChange(date,division);
    });
    $("#markAttendance").submit(function(e)
    {
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        $.ajax(
            {   url : formURL,
                type: "POST",
                data : postData,
                success:function(res)
                {
                    if (res == "1" )
                    {
                         $(window).scrollTop(0);
                        $('#message-error-div').html('');
                        var str='<div class="alert alert-success alert-dismissible" role="alert">'+
                            'Attendance successfully saved .'+
                    '<button type="button" class="close" data-dismiss="alert" area-lebel="close">'+
                        '<span area-hidden="true">&times;</span>'+
                    '</button>';
                        $('#message-error-div').html(str);
                    } else {
                         $(window).scrollTop(0);
                        $('#message-error-div').html('');
                        var str='<div class="alert alert-success alert-dismissible" role="alert">'+
                            'Attendance edited successfully'+
                            '<button type="button" class="close" data-dismiss="alert" area-lebel="close">'+
                            '<span area-hidden="true">&times;</span>'+
                            '</button>';
                        $('#message-error-div').html(str);
                    }
                }
            });
        e.preventDefault();
    });
     $('.allCheckedStud').change(function(){
        if ($(this).prop('checked') == true)
        {
            $('#allCheckedStud-label img').prop('src','assets/images/tick.png');
            $('.checkedStud').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
                $('#'+this.className+this.id).prop('src','assets/images/tick.png');
            });
        } else {
            $('.checkedStud').each(function() { //loop through each checkbox
                this.checked = false;  //select all checkboxes with class "checkbox1"
                $('#'+this.className+this.id).prop('src','assets/images/cross.png');

            });
            $('#allCheckedStud-label img').prop('src','assets/images/cross.png');
        }
    });

    $('.checkedStud').change(function(){

        if (this.checked==true)
        {
            $('#'+this.className+this.id).prop('src','assets/images/tick.png');

        } else {
            $('#'+this.className+this.id).prop('src','assets/images/cross.png');
        }
    });

      $('.datepicker').datepicker()
        .on('changeDate', function(ev){
              $('#message-error-div').html('');
            var date=$('#datePiker').val();
            var division=$('#division-select').val();
            dateChange(date,division);
        });
    /**
     * Function Name: dateChange
     * @param:date,division
     * @return retrun all student related to division on date change event
     * Desc:it will retrun all student related to division on date change event
     * Date: 22/2/2016
     * author manoj chaudahri
     */

    function dateChange(value,division){
        $('div#loadmoreajaxloaderStudent').show();
        $.ajax({
            url: 'mark-attendance',
            type: "get",
            data: {value,division},
            success: function(data){
                var res= $.map(data['student_list'],function(value){
                    return value;
                });
                if(data['student_list'] != null) {
                var str='<table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">'+
                         '<thead>'+
                                 '<tr>'+
                                    '<th>'+

                                    '</th>'+
                                    '<th> Roll No'+
                                    '</th>'+
                                    '<th> Name'+
                                    '</th>'+
                                 '</tr>'+
                         '</thead>'+
                         '<tbody>';
                                for(var i=0; i<res.length; i++)
                                 {
                            str +='<tr>'+
                                    '<td>';
                                         if(res[i]['student_attendance_status'] == 1  ){
                                             str += '<input type="checkbox"   name="student[]" id="'+res[i]['student_id']+'" value="'+res[i]['student_id']+'"  checked/>'+
                                                       '<label for="'+res[i]['student_id']+'">'+

                                                       '</label>';
                                          }else{
                                             str += '<input type="checkbox"   name="student[]" id="'+res[i]['student_id']+'" value="'+res[i]['student_id']+'"  />'+
                                                    '<label for="'+res[i]['student_id']+'">'+

                                                    '</label>';
                                          }
                             str += '</td>'+
                                    '<td>'+res[i]['roll_number']+'</td>'+
                                    '<td>'+res[i]['student_name']+" "+" ";
                                          if(res[i]['student_leave_status'] == 1  ) {
                                                str += '<span class="label label-default label-text-yellow"> Leave Applied '+
                                                       '</span>';
                                          }
                                          else if(res[i]['student_leave_status'] == 2 ){
                                                str += '<span class="label label-default label-text-orange"> Leave Approved '+
                                                       '</span>';
                                          }
                              str+= '</td>'+
                                  '</tr>';
                             }
                  str +='</tbody>'+
                '</table>';
                    $('#tableContent2').html(str);
                    $('div#loadmoreajaxloaderStudent').hide();
                } else {
                    $('#tableContent2').html('');
                    $('div#loadmoreajaxloaderStudent').hide();
                }


                $('#allCheckedStud-label img').css('border','1px solid');
                if ($('.allCheckedStud').prop('checked') == true)
                {

                    $('#allCheckedStud-label img').prop('src','assets/images/tick.png');
                    var i=0;
                    $('.checkedStud').each(function() { //loop through each checkbox
                        if (this.checked == true){
                            $('#'+this.className+this.id).prop('src','assets/images/tick.png');
                        }else{
                            $('#'+this.className+this.id).prop('src','assets/images/cross.png');
                        }
                        i++;
                    });
                }
                $('#sample_2').DataTable(
                    {
                        scrollY: 450,
                        paging: false,
                        ordering:true
                    });
                $('.checkedStud').change(function(){

                    if(this.checked==true)
                    {
                        $('#'+this.className+this.id).prop('src','assets/images/tick.png');

                    }else{
                        $('#'+this.className+this.id).prop('src','assets/images/cross.png');
                    }
                });
                $('.allCheckedStud').change(function(){
                    if ($(this).prop('checked') == true)
                    {
                        $('#allCheckedStud-label img').prop('src','assets/images/tick.png');
                        $('.checkedStud').each(function() { //loop through each checkbox
                            this.checked = true;  //select all checkboxes with class "checkbox1"
                            $('#'+this.className+this.id).prop('src','assets/images/tick.png');
                        });
                    } else {
                        $('.checkedStud').each(function() { //loop through each checkbox
                            this.checked = false;  //select all checkboxes with class "checkbox1"
                            $('#'+this.className+this.id).prop('src','assets/images/cross.png');

                        });
                        $('#allCheckedStud-label img').prop('src','assets/images/cross.png');
                    }
                });
            }

        });

    }

    $('#batch-select').change(function(){
        var id=this.value;
        var route='get-all-classes/'+id;
        $('div#loadmoreajaxloaderClass').show();
        $.get(route,function(res){
            if (res.length == 0)
            {
                $('#class-select').html("no record found");
                $('div#loadmoreajaxloaderClass').hide();
            } else {
                var str='<option value="">Please select class</option>';
                for(var i=0; i<res.length; i++)
                {
                    str+='<option value="'+res[i]['class_id']+'">'+res[i]['class_name']+'</option>';
                }
                $('#class-select').html(str);
                $('div#loadmoreajaxloaderClass').hide();
            }
        });
    });
    $("#class-select").change(function() {
        var id = this.value;
        var route='get-all-division/'+id;
        $('div#loadmoreajaxloaderDivision').show();
        $.get(route,function(res) {
            if(res.length == 0)
            {
                    $('#division-select').html("no record found");
                    $('div#loadmoreajaxloaderDivision').hide();
            } else {
                    var str='<option value="">Please select division</option>';
                    for(var i=0; i<res.length; i++)
                    {
                        str+='<option value="'+res[i]['division_id']+'">'+res[i]['division_name']+'</option>';
                    }
                    $('#division-select').html(str);
                    $('div#loadmoreajaxloaderDivision').hide();
            }
        });
    });

    $("#division-select").change(function() {
        var date=$('#datePiker').val();
        var division=$('#division-select').val();
        dateChange(date,division);
    });

    $('#batch-select').change(function(){

        $('#class-select').val('');
        $('#division-select').val('');
        $('#tableContent2').html('');

    })

    $('#batch-select').change(function(){
        var batch=$(this).val();
        getClasses(batch);

    });

    $('#class-select').change(function(){
        var classId=$(this).val();
        getDivisions(classId);
    });
    /**
     * Function Name: getDivisions
     * @param:classId
     * @return retrun all divisions related user
     * Desc:it will return list of divisions of releated user
     * Date: 22/2/2016
     * author manoj chaudahri
     */
    function getDivisions(classId)
    {
        var batch = $('#batch-select').val();
        var route="/get-attendance-division/"+classId+'/'+batch;
        $('div#loadmoreajaxloaderDivision').show();
        $.get(route,function(res){
            var str="";
            if (res.length != 0)
            {
                 var str='<option value="">Please select division</option>';
                for(var i=0;i<res.length; i++)
                {
                    str+="<option value='"+res[i]['division_id']+"'>"+res[i]['division_name']+"</option>"
                }
            } else {
                str+="<option value='0'>No divisions found</option>";
                $('div#loadmoreajaxloaderDivision').hide();
            }
            $('#division-select').html(str);
            $('div#loadmoreajaxloaderDivision').hide();
            var divisionSelected=$('#division-select').val();
        });
    }
    /**
     * Function Name: getClasses
     * @param:batchId
     * @return retrun all classes related user
     * Desc:it will return list of classes of releated user
     * Date: 22/2/2016
     * author manoj chaudahri
     */
    function getClasses(batchId)
    {
        var route="/get-attendance-classes/"+batchId;
        $('div#loadmoreajaxloaderClass').show();
        $.get(route,function(res){
            var str="";
            if (res.length != 0)
            {
                var str='<option value="">Please select class</option>';
                for(var i=0;i<res.length; i++)
                {
                    str+="<option value='"+res[i]['class_id']+"'>"+res[i]['class_name']+"</option>"
                }
            } else {
                str+="<option>No classes found</option>";
                $('div#loadmoreajaxloaderClass').hide();
            }
            $('#class-select').html(str);
            $('div#loadmoreajaxloaderClass').hide();
            var classSelected=$('#class-select').val();
            if(classSelected!="")
            {
                getDivisions(classSelected);
            }
        });
    }
</script>

@stop
