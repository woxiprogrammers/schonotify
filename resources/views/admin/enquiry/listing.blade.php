@extends('master')

@section('content')
<link href="/vendor/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="/vendor/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />

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
                            <h1 class="mainTitle">Search</h1>
                            <span class="mainDescription">Enquiry</span>
                        </div>
                    </div>
                </section>
                <!-- end: DASHBOARD TITLE -->





                <!-- start: DYNAMIC TABLE -->
                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        Form No.,  Name, Class appeared for, Written Exam, Interview, Documents, Action
                        <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_products">
                            <thead>
                            <tr role="row" class="heading">
                                <th width="1%">
                                    <input type="checkbox" class="group-checkable" > </th>
                                <th width="10%"> Form No </th>
                                <th width="20%"> Name </th>
                                <th width="10%"> Class appeared for </th>
                                <th width="10%">  Written Exam </th>
                                <th width="10%"> Interview </th>
                                <th width="10%"> Documents </th>
                                <th width="10%"> Actions </th>
                            </tr>
                            <tr role="row" class="filter">
                                <td> </td>
                                <td>
                                    <input type="text" class="form-control form-filter input-sm" name="item_based_sku"> </td>
                                <td>
                                    <input type="text" class="form-control form-filter input-sm" name="product_name"> </td>
                                <td>
                                    <input type="text" class="form-control form-filter input-sm" name="product_sku"> </td>

                                <td>
                                    <input type="text" class="form-control form-filter input-sm" name="product_sku"> </td>
                               <td>
                                    <input type="text" class="form-control form-filter input-sm" name="product_sku"> </td>

                                <td>
                                    <input type="text" class="form-control form-filter input-sm" name="product_sku"> </td>

                                <td>
                                    <div class="margin-bottom-5">
                                        <button class="btn btn-sm base-color filter-submit margin-bottom" id="search">
                                            <i class="fa fa-search"></i> Search</button>
                                    </div>
                                    <button class="btn btn-sm btn-default filter-cancel">
                                        <i class="fa fa-times"></i> Reset</button>
                                </td>
                            </tr>
                            </thead>
                            <tbody>
                            <td>No Product</td>
                            <td>No Product</td>
                            <td>No Product</td>
                            <td>No Product</td>
                            <td>No Product</td>
                            <td>No Product</td>
                            <td>No Product</td>
                            <td>No Product</td>
                            </tbody>
                        </table>

                    </div>

                </div>



                <!-- end: DYNAMIC TABLE -->

                <!-- start: FOURTH SECTION -->
                @include('rightSidebar')
                <!-- end: FOURTH SECTION -->
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
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="vendor/select2/select2.min.js"></script><!--
<script src="vendor/DataTables/jquery.dataTables.min.js"></script>
-->
<script src="assets/js/datatable.js" type="text/javascript"></script>
<script src="vendor/datatables/datatables.min.js" type="text/javascript"></script>
<script src="vendor/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="/assets/pages/scripts/ecommerce-products-superadmin.min.js" type="text/javascript"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="vendor/sweetalert/sweet-alert.min.js"></script>
<script src="vendor/toastr/toastr.min.js"></script>
<script src="assets/js/ui-notifications.js"></script>

<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>
<!-- start: JavaScript Event Handlers for this page -->
<script src="assets/js/table-data.js"></script>
<script src="assets/js/custom-project.js"></script>
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="assets/js/form-validation.js"></script>


<script type="text/javascript">
    $(document).ready(function(){
        getMsgCount();
        var id=$('#role-select').val();
        if(id!="")
        {
            tabUserSelect(id);
        }

        Main.init();
        FormValidator.init();
    });

    $('#role-select').change(function(){

        var par=this.value;

        tabUserSelect(par);

    });


    function tabUserSelect(par)
    {

        var route='/selectUser'+'/'+par;

        $.get(route,function(res){

            $("#tableContent").html(res);

            var switcheryHandler = function() {

                var elements = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

                elements.forEach(function(html) {
                    var switchery = new Switchery(html);
                });
            };

            switcheryHandler();

            TableData.init();

        });

    }


</script>



<script>

    function statusUser(status,id)
    {

        if(status==false)
        {

            var route='deactive/'+id;

            $.get(route,function(res){
                if(res['status']==403)
                {
                    var route= "/searchUsers";

                    window.location.replace(route);

                }else{
                    swal({
                        title: "Deactivated!",
                        text: "User has been deactivated!",
                        type: "error",
                        confirmButtonColor: "#DD6B55",
                        closeOnCancel: false
                    });
                }

            });

        }else
        {

            var route='active/'+id;

            $.get(route,function(res){

                if(res['status']==403)
                {
                    var route= "/searchUsers";

                    window.location.replace(route);

                } else if(res['status'] == 401) {

                    var route= "/searchUsers";

                    window.location.replace(route);

                }else{
                    swal("Activated!", "User has been activated.", "success");
                }

            });

        }

    }

</script>



@stop




