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
                                <h1 class="mainTitle">Student Listing</h1>
                                <span class="mainDescription">Student listing</span>
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
                                        <option>Select Subject</option>
                                        <option value="Math">Math</option>
                                        <option value="English">English</option>
                                        <option value="Biology">Biology</option>
                                        <option value="Chemistry">Chemistry</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="row">
                                <div class="col-md-4" id="teacher-select-div" >
                                    <label class="control-label">
                                        Select Teacher<span class="symbol required"></span>
                                    </label>
                                    <select class="form-control" id="teacher-select" name="teacher-select" style="-webkit-appearance: menulist;">
                                        <option>Select Teacher</option>
                                        <option value="Prof. A.V">Prof. A.V</option>
                                        <option value="Prof. A.G">Prof. A.G</option>
                                        <option value="Prof. D.k">Prof. D.k</option>
                                        <option value="Prof. G.P">Prof. G.P</option>
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
                                    <th class="sorting" tabindex="0" aria-controls="sample_2" rowspan="1" colspan="1" aria-label="Roll No: activate to sort column ascending" style="width: 33px;">Roll No</th>
                                    <th class="sorting" tabindex="0" aria-controls="sample_2" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 41px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr role="row" class="odd">
                                    <td class="sorting_1"><input type="checkbox" class="result_status" onchange="return result(this)" value="775"></td>
                                    <td>007</td>
                                    <td>0</td>
                                    <td><a href="enter-marks"><button>Fill Marks</button></a></td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td class="sorting_1"><input type="checkbox" class="result_status" onchange="return result(this)" value="775"></td>
                                    <td>009</td>
                                    <td>1</td>
                                    <td><a href="enter-marks"><button>Fill Marks</button></a></td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td class="sorting_1"><input type="checkbox" class="result_status" onchange="return result(this)" value="775"></td>
                                    <td>074</td>
                                    <td>2</td>
                                    <td><a href="enter-marks"><button>Fill Marks</button></a></td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td class="sorting_1"><input type="checkbox" class="result_status" onchange="return result(this)" value="775"></td>
                                    <td>023</td>
                                    <td>3</td>
                                    <td><a href="enter-marks"><button>Fill Marks</button></a></td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td class="sorting_1"><input type="checkbox" class="result_status" onchange="return result(this)" value="775"></td>
                                    <td>014</td>
                                    <td>4</td>
                                    <td><a href="enter-marks"><button>Fill Marks</button></a></td>
                                </tr>
                                </tbody>
                            </table>
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

        $('#teacher-select').change(function () {
            $('#table-div').show();
        })
    </script>
@stop
