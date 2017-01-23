@extends('master')

@section('content')

<div id="app">

    @include('sidebar')

    <div class="app-content">
        <!-- start: TOP NAVBAR -->
        @include('header')

        <!-- end: TOP NAVBAR -->
        <div class="main-content" >
            <div>



                <div class="container" style="background-color:white">
                    <div >
                        <div >

                            <span style="font-size:30px; "> Enquiry Listing </span>
                        </div>

                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" action="/enquiry-form-data" role="form" id="studentEnquiryListing">

                             <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_orders">
                                <thead>
                                <tr role="row" class="heading">
                                    <th width="2%">
                                        <input type="checkbox" class="group-checkable"> </th>
                                    <th width="5%"> Form no</th>

                                    <th width="15%"> Name </th>

                                    <th width="10%"> Class Appeared for </th>
                                    <th width="10%"> Year </th>

                                    <th width="10%"> Actions </th>
                                </tr>
                                <tr role="row" class="filter">
                                    <td> </td>
                                    <td>
                                        <input type="text" class="form-control form-filter input-sm" name="order_id"> </td>

                                    <td>
                                        <input type="text" class="form-control form-filter input-sm" name="order_customer_name"> </td>
                                    <td>
                                        <input type="text" class="form-control form-filter input-sm" name="order_ship_to"> </td>
                                    <td>
                                        <input type="text" class="form-control form-filter input-sm" name="order_ship_to"> </td>



                                    <td>
                                        <div class="margin-bottom-5">
                                            <button class="btn btn-sm btn-success filter-submit margin-bottom">
                                                <i class="fa fa-search"></i> Search</button>
                                        </div>
                                        <button class="btn btn-sm btn-default filter-cancel">
                                            <i class="fa fa-times"></i> Reset</button>
                                    </td>


                                </thead>
                                <tbody> </tbody>
                            </table>
                            </form>
                            <a href="/enquiry-form-details">Details</a>
                        </div>
                    </div>
                </div>





            </div>
            <div class="container">

                <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Form No</th>
                        <th>First Name</th>
                        <th>Class Appeared For</th>
                        <th>Office</th>
                        <th>Start date</th>
                        <th>Salary</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Form No</th>
                        <th>First Name</th>
                        <th>Class Appeared For</th>
                        <th>Office</th>
                        <th>Start date</th>
                        <th>Salary</th>
                    </tr>
                    </tfoot>
                </table>
            </div>


        </div>
    </div>

    @include('footer')
</div>

<!-- start: MAIN JAVASCRIPTS -->
<!--<script type="text/javascript" charset="utf8" src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {

          $('#example').DataTable( {

                 "processing": true,
                   "serverSide": true,
                   "ajax": "http://school_mit.schnotify.com/enquiry-form-data",
                   "columns": [
                          { "data": "id" }

                                ]
} );
} );
</script>-->


<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/modernizr/modernizr.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<script src="vendor/selectFx/classie.js"></script>
<script src="vendor/selectFx/selectFx.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>


<script src="assets/js/custom-project.js"></script>
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="assets/js/form-validation.js"></script>
<script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="assets/js/enquiry-form.js"></script>

<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();
        var date_input=$('input[name="dob"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
            endDate: '+0d'
        })
    });

    $('#current_class').blur(function() {
        if($(this).val()=="") {
            $('#school_name').attr("disabled", "disabled");
        }else{
            $("#school_name").removeAttr("disabled");
        }
    });

</script>


<script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>


   <script>


        $(document).ready(function() {
       var table= $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
           "sPaginationType": "full_numbers",
            "ajax": {
                "url": "/enquiry-form-data",
                "type": "GET"
            }

        } );



        } );
</script>



@stop


