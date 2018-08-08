<div class="form-group" id="EnableDisableBlock">
    <label class="control-label">
        User Status select
    </label>
    <select class="form-control" id="enabledisable" name="enabledisable" style="-webkit-appearance: menulist;">
        <option value="">Please select</option>
        <option value="enable">Enable</option>
        <option value="disable">Disable</option>
    </select>
</div>
<script>
    $(document).ready(function(){
        $('#enabledisable').change(function(){
            $('div#loadmoreajaxloader').show();
            var Division= $('#Divisiondropdown').val();
            var EnableDisable = $('#enabledisable').val();
            var route='studentSearch';
            $.ajax({
                method: "get",
                url: route,
                data: { Division,EnableDisable }
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