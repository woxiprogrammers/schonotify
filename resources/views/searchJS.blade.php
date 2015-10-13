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
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>
<!-- start: JavaScript Event Handlers for this page -->
<script src="assets/js/table-data.js"></script>



<script type="text/javascript">
    $(document).ready(function(){

        tabUserSelect(3);

        Main.init();

    });



    $('#role-select').change(function(){

        var par=this.value;

        tabUserSelect(par);

    });


    function tabUserSelect(par)
    {

        var route='/'+par+'/selectUser';

        $.get(route,function(res){

            //console.log(res);

            $("#tableContent").html(res);

            TableData.init();

            var switcheryHandler = function() {
                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

                elems.forEach(function(html) {
                    var switchery = new Switchery(html);
                });
            };

            switcheryHandler();

        });

    }

    function statusUser(status,id)
    {
        console.log(status+''+id);

        if(status==false)
        {
            if(confirm('Do you want to deactive this user.')== true)
            {
                var route='deactive/'+id;

                $.get(route,function(res){
                    console.log(res);
                });
            }else{
                $('#status'+id).prop('checked', true);
            }
        }else
        if(confirm('Do you want to active this user.')== true)
        {
            var route='active/'+id;

            $.get(route,function(res){
                console.log(res);
            });
        }else{
            $('#status'+id).prop('checked', false);
        }

    }


</script>
