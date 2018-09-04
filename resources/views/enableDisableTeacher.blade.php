<?php
/**
 * Created by PhpStorm.
 * User: Nishank Rathod
 * Date: 9/1/18
 * Time: 6:49 PM
 */
?>
<div class="form-group" id="EnableDisableBlock">
    <label class="control-label">
        User Status select
    </label>
    <select class="form-control" id="enabledisableTeacher" name="enabledisableTeacher" style="-webkit-appearance: menulist;">
        <option value="">Please select</option>
        <option value="enable">Enable</option>
        <option value="disable">Disable</option>
    </select>
</div>
<script>
    $(document).ready(function(){
        var id = $('#role-select').val();
        $('#enabledisableTeacher').change(function(){
            $('div#loadmoreajaxloader').show();
            var EnableDisable = $('#enabledisableTeacher').val();
            var route='/selectUser'+'/'+id;
            $.ajax({
                method: "get",
                url: route,
                data: { EnableDisable,id}
            })
                .done(function(res){
                    $('#tableContent').show();
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
