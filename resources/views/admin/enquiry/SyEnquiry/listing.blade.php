
<!DOCTYPE html>
<!-- Template Name: Clip-Two - Responsive Admin Template build with Twitter Bootstrap 3.x | Author: ClipTheme -->
<!--[if IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- start: HEAD -->
<head>
    <title>VEZA- Waiting/Merit Form Listing</title>
    <!-- start: META -->
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- end: META -->
    <!-- start: GOOGLE FONTS -->
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
    <!-- end: GOOGLE FONTS -->
    <!-- start: MAIN CSS -->
    <link rel="stylesheet" href="/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/vendor/themify-icons/themify-icons.min.css">
    <link href="/vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
    <link href="/vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
    <link href="/vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
    <!-- end: MAIN CSS -->
    <!-- start: CLIP-TWO CSS -->
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/plugins.css">
    <link rel="stylesheet" href="/assets/css/themes/theme-1.css" id="skin_color" />
    <!-- end: CLIP-TWO CSS -->
    <!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
    <link href="/vendor/select2/select2.min.css" rel="stylesheet" media="screen">
    <link href="/vendor/DataTables/css/DT_bootstrap.css" rel="stylesheet" media="screen">
    <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
</head>
<!-- end: HEAD -->
<body>
<div id="app">
    <!-- sidebar -->
@include('sidebar')
<!-- / sidebar -->
    <div class="app-content">
        <!-- start: TOP NAVBAR -->
    @include('header')
    <!-- end: TOP NAVBAR -->
        <div class="main-content" >
            <div class="wrap-content container" id="container">
                <!-- start: PAGE TITLE -->

                <!-- end: PAGE TITLE -->
                <!-- start: DYNAMIC TABLE -->
                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="over-title margin-bottom-15"><h2>SY Waiting/Merit Listing</h2></h5>
                            @include('alerts.errors')
                            <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                                <thead>
                                <tr>
                                    <th width="10%"> Form No </th>
                                    <th width="30%"> Name </th>
                                    <th width="20%"> Class </th>
                                    <th width="10%"> Actions </th>
                                    <th width="10%"> Result </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($masterEnquiry as $enquiry)
                                    <tr>
                                        <td>{!! $enquiry['form_no'] !!}</td>
                                        <td>{!! $enquiry['first_name'] !!}&nbsp;{!! $enquiry['last_name'] !!}</td>
                                        @if($enquiry['class_applied'] == 'FYBBA')
                                            <td>FYBBAMAIN</td>
                                        @else
                                            <td>{!! $enquiry['class_applied'] !!}</td>
                                        @endif
                                        <td>{!! $enquiry['action'] !!}</td>
                                        @if($enquiry['final_status'] != null)
                                            @if($enquiry['final_status'] == 'fail')
                                                <td>Disapprove</td>
                                            @else
                                                <td>Approve</td>
                                            @endif
                                        @else <td></td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end: DYNAMIC TABLE -->
                <!-- start: DYNAMIC TABLE -->

            </div>
        </div>
    </div>
    <!-- start: FOOTER -->
@include('footer')
<!-- end: FOOTER -->

</div>
<!-- start: MAIN JAVASCRIPTS -->
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/vendor/modernizr/modernizr.js"></script>
<script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/vendor/switchery/switchery.min.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="/vendor/select2/select2.min.js"></script>
<script src="/vendor/DataTables/jquery.dataTables.min.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="/assets/js/main.js"></script>
<!-- start: JavaScript Event Handlers for this page -->
<script src="/assets/js/table-data.js"></script>
<script>
    jQuery(document).ready(function() {
        Main.init();
        TableData.init();
    });
</script>
<script>
    function studentResultStatus(result,form_no)
    {

        if(result==fail)
        {

            var route='deactive/'+form_no;

            $.get(route,function(res){
                if(res['final_status']==403)
                {
                    var route= "/enquiry_listing";

                    window.location.replace(route);

                }else{
                    swal({
                        title: "Failed!",
                        text: "User has been failed!",
                        type: "error",
                        confirmButtonColor: "#DD6B55",
                        closeOnCancel: false
                    });
                }

            });

        }else
        {

            var route='active/'+form_no;

            $.get(route,function(res){

                if(res['final_status']==403)
                {
                    var route= "/enquiry_listing";

                    window.location.replace(route);

                } else if(res['final_status'] == 401) {

                    var route= "/enquiry_listing";

                    window.location.replace(route);

                }else{
                    swal("Activated!", "User has been Passed.", "success");
                }

            });

        }

    }
</script>
<!-- end: JavaScript Event Handlers for this page -->
<!-- end: CLIP-TWO JAVASCRIPTS -->
</body>
</html>
