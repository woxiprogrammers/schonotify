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
                <section id="page-title" class="padding-top-15 padding-bottom-15">
                    <div class="row">
                        <div class="col-sm-7">
                            <h1 class="mainTitle">Create</h1>
                            <span class="mainDescription">Users</span>
                        </div>

                    </div>
                </section>
                <!-- end: DASHBOARD TITLE -->
                <!-- start: DYNAMIC TABLE -->


                <div class="col-md-12">
                    @include('admin.userRoleDropdown')
                </div>

                <form action="#" role="form" class="smart-wizard" id="form">
                <div id="wizard" class="swMain">
                <!-- start: WIZARD SEPS -->
                <ul>
                    <li>
                        <a href="#step-1">
                            <div class="stepNumber">
                                1
                            </div>
                            <span class="stepDesc"><small> Personal Information </small></span>
                        </a>
                    </li>
                    <li>
                        <a href="#step-2">
                            <div class="stepNumber">
                                2
                            </div>
                            <span class="stepDesc"> <small> Complete </small> </span>
                        </a>
                    </li>
                </ul>
                <div id="step-1">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="padding-30">
                                <h2 class="StepTitle"><i class="ti-face-smile fa-2x text-primary block margin-bottom-10"></i> Enter your personal information</h2>
                                <p>
                                    This is an added measure against fraud and to help with billing issues.
                                </p>
                                <p class="text-small">
                                    Enter security questions in case you lose access to your account.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <fieldset>
                                <legend>
                                    Personal Information (users)
                                </legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                First Name <span class="symbol required"></span>
                                            </label>
                                            <input type="text" placeholder="Enter your First Name" class="form-control" name="firstName"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Last Name <span class="symbol required"></span>
                                            </label>
                                            <input type="text" placeholder="Enter your Last Name" class="form-control" name="lastName"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="block">
                                                Gender
                                            </label>
                                            <div class="clip-radio radio-primary">
                                                <input type="radio" id="wz-female" name="gender" value="female">
                                                <label for="wz-female">
                                                    Female
                                                </label>
                                                <input type="radio" id="wz-male" name="gender" value="male">
                                                <label for="wz-male">
                                                    Male
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                Choose your country or region
                                            </label>
                                            <select class="form-control" name="country">
                                                <option value="">&nbsp;</option>
                                                <option value="AL">Alabama</option>
                                                <option value="AK">Alaska</option>
                                                <option value="AZ">Arizona</option>
                                                <option value="AR">Arkansas</option>
                                                <option value="CA">California</option>
                                                <option value="CO">Colorado</option>
                                                <option value="CT">Connecticut</option>
                                                <option value="DE">Delaware</option>
                                                <option value="FL">Florida</option>
                                                <option value="GA">Georgia</option>
                                                <option value="HI">Hawaii</option>
                                                <option value="ID">Idaho</option>
                                                <option value="IL">Illinois</option>
                                                <option value="IN">Indiana</option>
                                                <option value="IA">Iowa</option>
                                                <option value="KS">Kansas</option>
                                                <option value="KY">Kentucky</option>
                                                <option value="LA">Louisiana</option>
                                                <option value="ME">Maine</option>
                                                <option value="MD">Maryland</option>
                                                <option value="MA">Massachusetts</option>
                                                <option value="MI">Michigan</option>
                                                <option value="MN">Minnesota</option>
                                                <option value="MS">Mississippi</option>
                                                <option value="MO">Missouri</option>
                                                <option value="MT">Montana</option>
                                                <option value="NE">Nebraska</option>
                                                <option value="NV">Nevada</option>
                                                <option value="NH">New Hampshire</option>
                                                <option value="NJ">New Jersey</option>
                                                <option value="NM">New Mexico</option>
                                                <option value="NY">New York</option>
                                                <option value="NC">North Carolina</option>
                                                <option value="ND">North Dakota</option>
                                                <option value="OH">Ohio</option>
                                                <option value="OK">Oklahoma</option>
                                                <option value="OR">Oregon</option>
                                                <option value="PA">Pennsylvania</option>
                                                <option value="RI">Rhode Island</option>
                                                <option value="SC">South Carolina</option>
                                                <option value="SD">South Dakota</option>
                                                <option value="TN">Tennessee</option>
                                                <option value="TX">Texas</option>
                                                <option value="UT">Utah</option>
                                                <option value="VT">Vermont</option>
                                                <option value="VA">Virginia</option>
                                                <option value="WA">Washington</option>
                                                <option value="WV">West Virginia</option>
                                                <option value="WI">Wisconsin</option>
                                                <option value="WY">Wyoming</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <p>
                                    <a href="javascript:void(0)" data-content="Your personal information is not required for unlawful purposes, but only in order to proceed in this tutorial" data-title="Don't worry!" data-placement="top" data-toggle="popover">
                                        Why do you need my personal information?
                                    </a>
                                </p>
                            </fieldset>
                            <fieldset>
                                <legend>
                                    Security question
                                </legend>
                                <p>
                                    Enter security questions in case you lose access to your account. <span class="text-small block">Be sure to pick questions that you will remember the answers to.</span>
                                </p>
                                <div class="panel-group accordion" id="accordion">
                                    <div class="panel panel-white">
                                        <div class="panel-heading">
                                            <h5 class="panel-title">
                                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                    <i class="icon-arrow"></i> What was the name of your first stuffed animal?
                                                </a></h5>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="stuffedAnimal" placeholder="Enter the the name of your first stuffed animal">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-white">
                                        <div class="panel-heading">
                                            <h5 class="panel-title">
                                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                                    <i class="icon-arrow"></i> What is your grandfather's first name?
                                                </a></h5>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="grandfatherName" placeholder="Enter your grandfather's first name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-white">
                                        <div class="panel-heading">
                                            <h5 class="panel-title">
                                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                                    <i class="icon-arrow"></i> In what city your grandmother live?
                                                </a></h5>
                                        </div>
                                        <div id="collapseThree" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="grandmotherCity" placeholder="Enter your grandmother's city">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group">
                                <button class="btn btn-primary btn-o next-step btn-wide pull-right">
                                    Next <i class="fa fa-arrow-circle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="step-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <h1 class=" ti-check block text-primary"></h1>
                                <h2 class="StepTitle">Congratulations!</h2>
                                <p class="text-large">
                                    Your tutorial is complete.
                                </p>
                                <p class="text-small">
                                    Thank you for your registration. Your transaction has been completed, and a receipt for your purchase has been emailed to you.  You may log into your account to view details of this transaction.
                                </p>
                                <a class="btn btn-primary btn-o go-first" href="javascript:void(0)">
                                    Back to first step
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                </form>




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
<script src="vendor/selectFx/classie.js"></script>
<script src="vendor/selectFx/selectFx.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>

<script src="assets/js/form-wizard.js"></script>
<script>
    jQuery(document).ready(function() {
        Main.init();
        FormWizard.init();
    });
</script>
<script type="text/javascript">


    $('#role-select').on('change',function(){

        var par=this.value;

        if(isNaN(par)==false)
        {
            var route= "/createUsers/"+par;

             //console.log(route);
            //debugger;
            window.location.replace(route);


        }

    });

</script>


@stop


