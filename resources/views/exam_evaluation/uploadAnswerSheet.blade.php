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
                                <h1 class="mainTitle">Upload</h1>
                                <span class="mainDescription">Upload Student Answer Sheet</span>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <fieldset>
                            <div class="row">
                                <div class="col-md-3 ">
                                    <label class="control-label">
                                        Batch <span class="symbol required"></span>
                                    </label>
                                    <select class="form-control" name="batch" id="batchDrpdn" style="-webkit-appearance: menulist;">
                                        <option>Select Batch</option>
                                        @foreach($batches as $batch)
                                            <option value="{!! $batch['id'] !!}">{!! $batch['name'] !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3" id="class-select-div" >
                                    <label class="control-label">
                                        Select Class <span class="symbol required"></span>
                                    </label>
                                    <select class="form-control" id="class-select" name="class_select" style="-webkit-appearance: menulist;">
                                    </select>
                                </div>
                                <div class="col-md-3" id="exam-select-div" >
                                    <label class="control-label">
                                        Select Exam <span class="symbol required"></span>
                                    </label>
                                    <select class="form-control" id="exam-select" name="exam-select" style="-webkit-appearance: menulist;">
                                        <option>Please Select Exam</option>
                                        <option value="First Term Exam 2018-19">First Term Exam 2018-19</option>
                                        <option value="Second Term Exam 2018-19">Second Term Exam 2018-19</option>
                                    </select>
                                </div>
                                <div class="col-md-3" id="subject-select-div" >
                                    <label class="control-label">
                                        Select Subject<span class="symbol required"></span>
                                    </label>
                                    <select class="form-control" id="subject-select" name="subject-select" style="-webkit-appearance: menulist;">
                                        <option>Select Paper Set</option>
                                        <option value="Math">Math</option>
                                        <option value="English">English</option>
                                        <option value="Biology">Biology</option>
                                        <option value="Chemistry">Chemistry</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <div class="row" id="table-div">
                            <table class="table table-striped table-bordered table-hover table-full-width dataTable no-footer" id="sample_2" role="grid" aria-describedby="sample_2_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="sample_2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Result: activate to sort column descending" style="width: 40px;">Check</th>
                                    <th class="sorting" tabindex="0" aria-controls="sample_2" rowspan="1" colspan="1" aria-label="GRN No.: activate to sort column ascending" style="width: 29px;">GRN No.</th>
                                    <th class="sorting" tabindex="0" aria-controls="sample_2" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 68px;">Name</th>
                                    <th class="sorting" tabindex="0" aria-controls="sample_2" rowspan="1" colspan="1" aria-label="Roll No: activate to sort column ascending" style="width: 33px;">Roll No</th>
                                    <th class="sorting" tabindex="0" aria-controls="sample_2" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 41px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr role="row" class="odd">
                                    <td class="sorting_1"><input type="checkbox" class="result_status" onchange="return result(this)" value="775"></td>
                                    <td>007</td>
                                    <td>Aaditya Margaj</td>
                                    <td>0</td>
                                    <td><input type="file" id="imageUpload4"></td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td class="sorting_1"><input type="checkbox" class="result_status" onchange="return result(this)" value="775"></td>
                                    <td>009</td>
                                    <td>Aaradhya Nagraj</td>
                                    <td>1</td>
                                    <td><input type="file"></td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td class="sorting_1"><input type="checkbox" class="result_status" onchange="return result(this)" value="775"></td>
                                    <td>074</td>
                                    <td>Vaidehi Gupta</td>
                                    <td>2</td>
                                    <td><input type="file"></td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td class="sorting_1"><input type="checkbox" class="result_status" onchange="return result(this)" value="775"></td>
                                    <td>023</td>
                                    <td>Shubhangi Gaikwad</td>
                                    <td>3</td>
                                    <td><input type="file"></td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td class="sorting_1"><input type="checkbox" class="result_status" onchange="return result(this)" value="775"></td>
                                    <td>014</td>
                                    <td>Zade Anshul</td>
                                    <td>4</td>
                                    <td><input type="file"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                {{--<div id="loadmoreajaxloader" style="display:none;"><center><img src="/assets/images/loader1.gif" /></center></div>--}}
                                <div class="col-md-12" id="tableContent">
                                </div>
                            </div>
                        </div>

                        <div class="row pull-right">
                            <div class="form-group">
                                <button class="btn btn-primary btn-wide" type="submit">
                                    Submit
                                </button>
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
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/vendor/modernizr/modernizr.js"></script>
    <script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/vendor/switchery/switchery.min.js"></script>
    <script src="/vendor/selectFx/classie.js"></script>
    <script src="/vendor/selectFx/selectFx.js"></script>
    <script src="/vendor/ckeditor/ckeditor.js"></script>
    <script src="/vendor/ckeditor/adapters/jquery.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    {{--<script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="/vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>--}}
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <!-- start: CLIP-TWO JAVASCRIPTS -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/custom-project.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            $('#table-div').hide();
        });

        $('#batchDrpdn').change(function(){
            var id=this.value;
            var route='/get-all-classes/'+id;
            $('#loadmoreajaxloaderClass').show();
            $.get(route,function(res){
                if (res.length == 0)
                {
                    $('#class-select').html("no record found");
                    $('#loadmoreajaxloaderClass').hide();
                } else {
                    var str='<option value="">Please Select Class</option>';
                    for(var i=0; i<res.length; i++)
                    {
                        str+='<option value="'+res[i]['class_id']+'">'+res[i]['class_name']+'</option>';
                    }
                    $('#class-select').html(str);
                    $('#loadmoreajaxloaderClass').hide();
                }
            });
        });

        $('#subject-select').change(function () {
            $('#table-div').show();
        })

        $("#imageUpload4").on('change', function () {
            var imgPath = $(this)[0].value;
            var countFiles = $(this)[0].files.length;
            var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            var size = this.files[0].size/1024/1024;
            // var image_holder = $("#preview-image4");
            if(size <= 2){
                if (extn == "pdf") {
                    if (typeof (FileReader) != "undefined") {
                        for (var i = 0; i < countFiles; i++) {
                            var reader = new FileReader()
                            /*reader.onload = function (e) {
                             var imagePreview = '<div class="col-md-2"><input type="hidden" name="sliderImages[sliderImages4][slider_image]" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
                             image_holder.append(imagePreview);
                             };
                             image_holder.show();
                             reader.readAsDataURL($(this)[0].files[i]);*/
                        }
                    }else{
                        alert("It doesn't supports");
                    }
                } else {
                    alert("Select Only pdf");
                    $('#submit').hide();
                }
            }else{
                alert("please select pdf less than 2 mb");
            }
        });
    </script>
@stop