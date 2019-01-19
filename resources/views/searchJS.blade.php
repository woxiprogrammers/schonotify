<!-- start: MAIN JAVASCRIPTS -->
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
<script type="text/javascript">
    $(document).ready(function(){
        getMsgCount();
        var id=$('#role-select').val();
        if(id!="")
        {
            $('#EnableDisableTeacher').show();
            var route2='/enable-disable-teacher';
            $.get(route2,function(res){
                $('#EnableDisableTeacher').html(res);
                $('div#loadmoreajaxloader').hide();
            });
        }
        $('option#4').hide();
        Main.init();
        FormValidator.init();
    });
    $('#checkbox').change(function(){
        $('div#loadmoreajaxloader').show();
        var Division= "-1";
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
    $('#role-select').change(function(){
        $('div#loadmoreajaxloader').show();
        var par=this.value;
        if(par == 3)
        {
            $('#tableContent').show();
            $('#UserSearch').show(1000);
            $('#Student_without_division').show(1000);
            $('#ClassSearch').show(1000);
            $('#EnableDisableSearch').show(1000);
            $('#DivisionBlock').show(1000);
            $('#EnableDisableTeacher').hide(1000);
            var route1='/search-batch';
            $.get(route1,function(res){
                $('#UserSearch').html(res);
                $('div#loadmoreajaxloader').hide();
            });
        }
        else
        {
            $('#tableContent').hide();
            $('div#loadmoreajaxloader').hide();
            $('#UserSearch').hide(1000);
            $('#Student_without_division').hide(1000);
            $('#ClassSearch').hide(1000);
            $('#DivisionBlock').hide(1000);
            $('#EnableDisableSearch').hide(1000);
            $('#shuffle_row').hide(1000);
            $('#EnableDisableTeacher').show(1000);
            var route2='/enable-disable-teacher';
            $.get(route2,function(res){
                $('#EnableDisableTeacher').html(res);
                $('div#loadmoreajaxloader').hide();
            });
        }
    });
</script>
