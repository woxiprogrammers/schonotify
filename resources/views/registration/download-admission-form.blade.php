@extends('master')

@section('content')

<div id="app">
<div class="sidebar app-aside" id="sidebar" style="top: 0px!important;">
    <img class="img-responsive" src="/assets/images/bodyLogo/sspss.jpg">
</div>


<div class="app-content">
<!-- start: TOP NAVBAR -->


<!-- end: TOP NAVBAR -->
<div class="main-content" >
<div class="wrap-content container" id="container">
<!-- start: DASHBOARD TITLE -->
@include('alerts.errors')
<div id="message-error-div"></div>
<section id="page-title" class="padding-top-15 padding-bottom-15">
    <div class="row">
        <div class="col-sm-7">
            <h1 class="mainTitle">Ganesh International School , Chikhali</h1>
            <span class="mainDescription"></span>
        </div>

    </div>
</section>
<!-- end: DASHBOARD TITLE -->
<!-- start: DYNAMIC TABLE -->

    <div class="row">
        <p></p>

    </div>

    <h1>You have already registered with us.
         Please contact school for further details.</h1>
    <div class="row">
        <p></p>

    </div>

    <div class="row">
        <div class="col-md-4">
        </div>
        <form method="post" action="/print-admission-form/{{$enquiryInfo['id']}}">
            <div class="col-md-4">
                <button class="btn btn-primary btn-wide ">
                    Download Admission form
                </button>
            </div>
         </form>
        <div class="col-md-4">
            <button class="btn btn-primary btn-wide ">
                Make Payment
            </button>
        </div>

    </div>

<!-- end: DYNAMIC TABLE -->


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

<script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
<script type="text/javascript" src="assets/js/jquery.autocomplete.min.js"></script>

<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>

<script src="assets/js/student-form-wizard-public-registration.js"></script>

<script src="assets/js/custom-project.js"></script>
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="assets/js/form-validation.js"></script>

<script>
    jQuery(document).ready(function() {
        Main.init();
        FormValidator.init();
        FormWizard.init();
        getParents();
        var date_input=$('input[name="dob"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
            endDate: '+0d',
        })
    });
</script>
<script type="text/javascript">

$('#communication_address').hide();

$("#student_communication_address").click(function(){
    $('#communication_address').toggle();
});

$('#communication_address_parent').hide();

$("#parent_communication_address").click(function(){
    $('#communication_address_parent').toggle();
});

$('#role-select').on('change',function(){

    var par=this.value;

    if(isNaN(par)==false)
    {
        var route= "/createUsers/"+par;

        window.location.replace(route);

    }

});

function getParents()
{
    $(function(){
        $.ajax({
            url: '/get-enquiry-parents',
            type:'get',
            dataType:'json',
            success: function (currencies) {
                $('#autocomplete').autocomplete({
                    lookup: currencies,
                    onSelect: function (suggestion) {
                        var thehtml = '<strong>Showing result for:</strong> ' + suggestion.value;
                        $('#parent_id').val(suggestion.data['userId']);
                        $('#father_first_name').attr("disabled", true);
                        $('#father_middle_name').attr("disabled", true);
                        $('#father_last_name').attr("disabled", true);
                        $('#mother_first_name').attr("disabled", true);
                        $('#mother_middle_name').attr("disabled", true);
                        $('#mother_last_name').attr("disabled", true);
                        $('#father_occupation').attr("disabled", true);
                        $('#mother_occupation').attr("disabled", true);
                        $('#father_income').attr("disabled", true);
                        $('#mother_income').attr("disabled", true);
                        $('#father_contact').attr("disabled", true);
                        $('#mother_contact').attr("disabled", true);
                        $('#permanent_address').attr("disabled", true);

                        $('#father_first_name').val(suggestion.data['father_first_name']);
                        $('#father_middle_name').val(suggestion.data['father_middle_name']);
                        $('#father_last_name').val(suggestion.data['father_last_name']);
                        $('#mother_first_name').val(suggestion.data['mother_first_name']);
                        $('#mother_middle_name').val(suggestion.data['mother_middle_name']);
                        $('#mother_last_name').val(suggestion.data['mother_last_name']);
                        $('#father_occupation').val(suggestion.data['father_occupation']);
                        $('#mother_occupation').val(suggestion.data['mother_occupation']);
                        $('#father_income').val(suggestion.data['father_income']);
                        $('#mother_income').val(suggestion.data['mother_income']);
                        $('#father_contact').val(suggestion.data['father_contact']);
                        $('#mother_contact').val(suggestion.data['mother_contact']);
                        $('#permanent_address').val(suggestion.data['permanent_address']);



                        $('#outputcontent').html(thehtml);
                        $('#tabTable').show();
                        var val3=$('#autocomplete').html(suggestion.value).text();
                        $('#autocomplete').val(val3);
                    }
                });
            }
        });

    });

}

$('#autocomplete').keyup(function(e){
    if(e.keyCode != 13)
    {
        $('#parent_id').val('');
        $('#father_first_name').attr("disabled", false);
        $('#father_middle_name').attr("disabled", false);
        $('#father_last_name').attr("disabled", false);
        $('#mother_first_name').attr("disabled", false);
        $('#mother_middle_name').attr("disabled", false);
        $('#mother_last_name').attr("disabled", false);
        $('#father_occupation').attr("disabled", false);
        $('#mother_occupation').attr("disabled", false);
        $('#father_income').attr("disabled", false);
        $('#mother_income').attr("disabled", false);
        $('#father_contact').attr("disabled", false);
        $('#mother_contact').attr("disabled", false);
        $('#permanent_address').attr("disabled", false);
        $('#father_first_name').val('');
        $('#father_middle_name').val('');
        $('#father_last_name').val('');
        $('#mother_first_name').val('');
        $('#mother_middle_name').val('');
        $('#mother_last_name').val('');
        $('#father_occupation').val('');
        $('#mother_occupation').val('');
        $('#father_income').val('');
        $('#mother_income').val('');
        $('#father_contact').val('');
        $('#mother_contact').val('');
        $('#permanent_address').val('');
    }
});



function addRow(tableID) {
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    var cell3 = row.insertCell(0);
    var element2 = document.createElement("input");
    element2.type = "text";
    element2.name = "hobbies[]";
    cell3.appendChild(element2);
}

function addRowSpecialAptitude(tableID){
    var table = document.getElementById(tableID);

    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    var cell2 = row.insertCell(0);
    var element2 = document.createElement("input");
    element2.type = "text";
    element2.placeholder = "Test";
    element2.name = "special_aptitude["+rowCount+"][test]";
    cell2.appendChild(element2);

    var cell3 = row.insertCell(1);
    var element3 = document.createElement("input");
    element3.type = "number";
    element3.placeholder = "Score";
    element3.name = "special_aptitude["+rowCount+"][score]";
    cell3.appendChild(element3);
}
function addRowUploadDoc(tableID){
    var table = document.getElementById(tableID);

    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    var cell3 = row.insertCell(0);
    var element2 = document.createElement("input");
    element2.type = "file";
    element2.name = "upload_doc[]";
    cell3.appendChild(element2);
}

function addSibling(tableID){
    var table = document.getElementById(tableID);

    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    var cell2 = row.insertCell(0);
    var element2 = document.createElement("input");
    element2.type = "text";
    element2.placeholder = "Name";
    element2.name = "sibling["+rowCount+"][name]";
    cell2.appendChild(element2);

    var cell3 = row.insertCell(1);
    var element3 = document.createElement("input");
    element3.type = "number";
    element3.placeholder = "Age";
    element3.name = "sibling["+rowCount+"][age]";
    cell3.appendChild(element3);
}

</script>

@stop
