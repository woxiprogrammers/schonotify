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