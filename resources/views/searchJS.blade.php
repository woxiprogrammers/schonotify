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

        Main.init();
        FormValidator.init();
    });

    $('#role-select').change(function(){

        var par=this.value;
        if(par == 3)
        {
            $('#UserSearch').show(1500);
            $('#ClassSearch').show(1500);
            $('#Divisiondropdown').show(1500);
            var route1='/search-batch';
            $.get(route1,function(res){
                $('#UserSearch').html(res);
            });
        }
        else
        {
            $('#UserSearch').hide(1500);
            $('#ClassSearch').hide(1500);
            $('#Divisiondropdown').hide(1500);
        }
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
