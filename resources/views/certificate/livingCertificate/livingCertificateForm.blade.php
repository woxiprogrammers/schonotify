<?php
/**
 * Created by Nishank Rathod.
 * Date: 4/16/18
 * Time: 10:34 AM
 */
?>
@if($studentData != null)
<hr>
<legend>
    Please fill the Information for {{$studentData['first_name']}} {{$studentData['last_name']}}
</legend>
<div class="container-fluid container-fullw bg-white">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="" role="form" id="livingCertificateStudentForm">
                <input type="hidden" id="grn" value="{{$studentData['grn']}}" name="grn">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">
                                Aadhar Card No. <span class="symbol required"></span>
                            </label>
                            @if($studentData['aadhar_number'] != "" && $studentData['aadhar_number'] != null)
                                <input type="text" class="form-control" name="aadharCard" id="aadharCard" required="required">
                              @else
                                <input type="text" class="form-control" name="aadharCard" id="aadharCard" value="{{$studentData['aadhar_number']}}" required="required">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">
                                Last School Attended  <span class="symbol required"></span>
                            </label>
                            <input type="text" class="form-control" name="lastSchool" id="lastSchool" required="required">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">
                                Date of Admission <span class="symbol required"></span>
                            </label>
                            <input type="date" class="form-control" name="admissionDate" id="admissionDate" required="required">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">
                                Progress <span class="symbol required"></span>
                            </label>
                            <input type="text" class="form-control" name="progress" id="progress" required="required">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">
                                Conduct <span class="symbol required"></span>
                            </label>
                            <input type="text" class="form-control" name="conduct" id="conduct" required="required">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">
                                Date of living School <span class="symbol required"></span>
                            </label>
                            <input type="date" class="form-control" name="livingSchoolDate" id="livingSchoolDate" required="required">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">
                                Std. in which studying from when <span class="symbol required"></span>
                            </label>
                            <input type="text" class="form-control" name="standard_studying_from_when" id="standard_studying_from_when" required="required">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">
                                Reason of leaving School <span class="symbol required"></span>
                            </label>
                            <input type="text" class="form-control" name="reason" id="reason" required="required">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">
                                Remarks <span class="symbol required"></span>
                            </label>
                            <input type="text" class="form-control" name="remark" id="remark" required="required">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="control-label">&nbsp;
                        </label>
                        <div class="form-group">
                            <button class="btn btn-primary btn-wide" id="create" type="submit">
                                Create <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@else
    <legend style="color: darkred">No Students Available For Entered GRN</legend>
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
<script src="/assets/js/certificates/livingcertificate.js"></script>
<script>

</script>


