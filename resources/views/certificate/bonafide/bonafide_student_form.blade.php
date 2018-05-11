<?php
/**
 * Created by Nishank Rathod.
 * Date: 4/16/18
 * Time: 10:34 AM
 */
?>
@if($studentData == null)
    <legend style="color: darkred"> No Student Available for entered GRN </legend>
@elseif($studentData == "lcCreated")
    <legend style="color: darkred"> Leaving Certificate Generated For this Student </legend>
 @else
    <hr>
    <legend>
        Please fill the Information for {{$studentData['first_name']}} {{$studentData['last_name']}}
    </legend>
    <div class="container-fluid container-fullw bg-white">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="" role="form" id="bonafideStudentForm">
                    <input type="hidden" id="grn" value="{{$studentData['grn']}}" name="grn">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">
                                    Taluka <span class="symbol required"></span>
                                </label>
                                <input type="text" class="form-control" name="taluka" id="taluka" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">
                                    District <span class="symbol required"></span>
                                </label>
                                <input type="text" class="form-control" name="district" id="district" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">
                                    From date <span class="symbol required"></span>
                                </label>
                                <input type="date" class="form-control" name="from_date" id="from_date" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">
                                    To Date <span class="symbol required"></span>
                                </label>
                                <input type="date" class="form-control" name="to_date" id="to_date" required="required">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">&nbsp;
                            </label>
                            <div class="form-group">
                                <button class="btn btn-primary btn-wide" id="submit" type="submit">
                                    Create <i class="fa fa-arrow-circle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/vendor/modernizr/modernizr.js"></script>
    <script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/vendor/switchery/switchery.min.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <script src="/vendor/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
    <script src="/vendor/moment/moment.min.js"></script>
    <script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <script src="/assets/js/certificates/bonafide.js"></script>


<script>
    $('#submit').click(function(){
        $('#submit').hide();
    })

</script>