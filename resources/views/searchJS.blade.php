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
            tabUserSelect(id);
        }
        $('option#4').hide();
        Main.init();
        FormValidator.init();
    });

    $('#role-select').change(function(){
        $('div#loadmoreajaxloader').show();
        var par=this.value;
        if(par == 3)
        {
            $('#UserSearch').show(1000);
            $('#ClassSearch').show(1000);
            $('#DivisionBlock').show(1000);
            var route1='/search-batch';
            $.get(route1,function(res){
                $('#UserSearch').html(res);
                $('div#loadmoreajaxloader').hide();
            });
        }
        else
        {   $('div#loadmoreajaxloader').hide();
            $('#UserSearch').hide(1000);
            $('#ClassSearch').hide(1000);
            $('#DivisionBlock').hide(1000);
        }
        tabUserSelect(par);
    });
   function tabUserSelect(par)
    {
        $('div#loadmoreajaxloader').show();
        var route='/selectUser'+'/'+par;
         $.get(route,function(res){
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
        });
    }
</script>
