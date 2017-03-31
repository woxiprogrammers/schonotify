<div class="form-group" id="DivisionBlock">
    <label class="control-label">
        Division
    </label>
    <select class="form-control" id="Divisiondropdown" name="Divisiondropdown" style="-webkit-appearance: menulist;">
        <option value="">Select Batch</option>
        @if(!empty($divisionList))
        @foreach($divisionList as $class)
        <option value="{!! $class->id !!}">{!! $class->division_name !!}</option>
        @endforeach
        @endif
    </select>
</div>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/modernizr/modernizr.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="vendor/select2/select2.min.js"></script>
<script src="vendor/DataTables/jquery.dataTables.min.js"></script>
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

<script>
    $(document).ready(function(){
         $('#Divisiondropdown').change(function(){
            $('div#loadmoreajaxloader').show();
            var Division= $('#Divisiondropdown').val();
            var route='studentSearch';
            $.ajax({
                method: "get",
                url: route,
                data: { Division }
            })
                .done(function(res){
                    $("#tableContent").html(res);
                    $('div#loadmoreajaxloader').hide();
                    var switcheryHandler = function() {

                        var elements = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

                        elements.forEach(function(html) {
                            var switchery = new Switchery(html);
                        });
                    };
                    switcheryHandler();
                    TableData.init();
                })
        })

    })

</script>