<div class="form-group">
    <label class="control-label">
        Class
    </label>

    <select class="form-control" id="Classdropdown" name="Classdropdown" style="-webkit-appearance: menulist;">
        <option value="">Select Batch</option>
        @if(!empty($classList))
        @foreach($classList as $class)
        <option value="{!! $class->id !!}">{!! $class->class_name !!}</option>
        @endforeach
        @endif
    </select>
</div>
<script>
    $(document).ready(function(){
        $('#Classdropdown').change(function(){
            $('div#loadmoreajaxloader').show();
            var classs=this.value;
            var route='/get-divisions-search';
            $.ajax({
                method: "get",
                url: route,
                data: { classs }
            })
                .done(function(res){
                    $('#DivSearch').html(res);
                    $('div#loadmoreajaxloader').hide();
                })
            var route1='/reports/get-class-subjects';
            $.ajax({
                method: "get",
                url: route1,
                data: { classs }
            })
                .done(function(res){
                    $('#ClassSubjectSearch').html(res);
                    $('div#loadmoreajaxloader').hide();
                })
        })

    })

</script>
