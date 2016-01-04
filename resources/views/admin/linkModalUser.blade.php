<div class="modal fade bs-example-modal-sm"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Edit User</h4>
            </div>
            <form class="form-register" role="form" id="form" method="post" action="/updateUser" name="updateUser">
            <div class="modal-body">
                <div class="form-group">
                    {!! csrf_field() !!}
                        <div class="form-group">

                            <input type="hidden" name="user_id" id="user_id">

                            <div class="form-group" id="username_div">
                                <label for="username">Name</label>
                                <input type="text" class="form-control" name="username" id="username">
                            </div>
                            <div class="form-group" id="email_div">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email">
                            </div>

                            <div class="form-group">
                                <div class="checkbox clip-check check-primary" id="teacher_view_div">
                                    <input type="checkbox" value="" name="services" id="checkbox" class="web_view">
                                    <label for="checkbox">
                                        Web Access
                                    </label>
                                    <input type="checkbox" value="" name="services1" id="checkbox1" class="mobile_view">
                                    <label for="checkbox1">
                                        Mobile Access
                                    </label>
                                </div>

                            </div>

                            <div class="form-group" id="class_div">
                                <label for="class_selection">class</label>
                                <select class="form-control" name="class_selection" id="class_selection" >

                                </select>
                            </div>
                            <div class="form-group" id="division_div">
                                <label for="div_selection">division</label>
                                <select class="form-control" name="div_selection" id="div_selection">

                                </select>
                            </div>

                        </div>
                </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-o" data-dismiss="modal" onclick="$('#form')[0].reset();">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary" id="update_user">
                        Save changes
                    </button>

                </div>
            </form>

        </div>
    </div>
</div>
<!-- /Large Modal -->

@include('admin.js.userEdit')

<script src="vendor/jquery-validation/jquery.validate.min.js"></script>

<script src="assets/js/login.js"></script>

<script src="assets/js/form-elements.js"></script>

<script src="assets/js/form-validation.js"></script>
<script src="assets/js/custom-project.js"></script>

<script>

    jQuery(document).ready(function() {
        getMsgCount();
        $('#popup_valid').click(function(event){
            event.preventDefault();
            Main.init();

            FormValidator.init();
        });

    });
</script>


<script type="text/javascript">

    $('#update_user').click(function (ev) {
        var data = $('form').serialize();

        $.ajax({
            url: '/updateUser',
            type:'post',
            dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : data,
            success: function (res) {
                console.log(res);
            }
        });
        ev.preventDefault();
    });
</script>
<script>
    $('#modal').modal({
        backdrop: 'static',
        keyboard: false  // to prevent closing with Esc button (if you want this too)
    })

</script>
