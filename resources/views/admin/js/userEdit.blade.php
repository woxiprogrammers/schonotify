<script type="text/javascript">
    function userEdit(val)
    {
        var route='/'+val+'/edit';
        //debugger;
        $.get(route,function(res){

            console.log(res);

            if(res[0]['user_role'] === 'admin'){
                $('#user_id').val(res[0]['id']);
                $('#user_id').hide();
                $('#username').val(res[0]['user_name']);
                $('#email').val(res[0]['email']);
                $('#teacher_view_div').hide();
                $('#class_div').hide();
                $('#division_div').hide();

                if(res[0]['is_active']==1)
                {
                    $('.is_active').attr('checked',true);
                }else{
                    $('.is_active').attr('checked',false);
                }

            }else
            if(res[0]['user_role'] === 'teacher'){
                $('#user_id').val(res[0]['id']);
                $('#user_id').hide();
                $('#username').val(res[0]['user_name']);
                $('#email').val(res[0]['email']);
                $('#teacher_view_div').show();
                $('#class_div').hide();
                $('#division_div').hide();
                if(res[0]['mobile_view']==1)
                {
                    $('.mobile_view').attr('checked',true);
                }else{
                    $('.mobile_view').attr('checked',false);
                }
                if(res[0]['web_view']==1)
                {
                    $('.web_view').attr('checked',true);
                }else{
                    $('.web_view').attr('checked',false);
                }


                if(res[0]['is_active']==1)
                {
                    $('.is_active').attr('checked',true);
                }else{
                    $('.is_active').attr('checked',false);
                }

            }else
            if(res[0]['user_role'] === 'student'){
                $('#user_id').val(res[0]['id']);
                $('#user_id').hide();
                $('#username').val(res[0]['user_name']);
                $('#email').val(res[0]['email']);
                $('#teacher_view_div').hide();
                $('#class_div').show();
                $('#division_div').show();
                $('#class_selection option').remove();
                $.each(res[1][0], function(i,obj)
                {
                    $('#class_selection').append(
                        $('<option></option>')
                            .val(obj['id'])
                            .html(obj['name']+' (batch'+obj['batch_id']+')')
                    );

                    $('#class_selection').val(res[0]['class_id']);

                });

                $('#class_selection').change(function(){

                    $('#div_selection option').remove();
                    var cls=this.value;

                    $.each(res[1][1],function(i,obj){
                        if(obj['class_id']==cls)
                        {
                                console.log(obj['name']);

                            $('#div_selection').append(
                                $('<option></option>')
                                    .val(obj['id'])
                                    .html(obj['name'])
                            );
                        }

                        });


                });

                if(res[0]['is_active']==1)
                {
                    $('.is_active').attr('checked',true);
                }else{
                    $('.is_active').attr('checked',false);
                }

            }else
            if(res[0]['user_role'] === 'parent'){
                $('#user_id').val(res[0]['id']);
                $('#user_id').hide();
                $('#username').val(res[0]['user_name']);
                $('#email').val(res[0]['email']);
                $('#teacher_view_div').hide();
                $('#class_div').hide();
                $('#division_div').hide();

                if(res[0]['is_active']==1)
                {
                    $('.is_active').attr('checked',true);
                }else{
                    $('.is_active').attr('checked',false);
                }

            }else
            if(res[0]['user_role'] === 'accountant'){
                $('#user_id').val(res[0]['id']);
                $('#user_id').hide();
                $('#username').val(res[0]['user_name']);
                $('#email').val(res[0]['email']);
                $('#teacher_view_div').hide();
                $('#class_div').hide();
                $('#division_div').hide();
                if(res[0]['is_active']==1)
                {
                    $('.is_active').attr('checked',true);
                }else{
                    $('.is_active').attr('checked',false);
                }
            }

        });
    }

</script>

