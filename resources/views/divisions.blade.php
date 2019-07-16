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
             $('#generate-student-report-button').show()
            var route='/get-enable-disable-students';
            $.ajax({
                method: "get",
                url: route
            })
                .done(function(res){
                    $("#EnableDisableSearch").html(res);
                    $('div#loadmoreajaxloader').hide();
                })
        })

    })

</script>