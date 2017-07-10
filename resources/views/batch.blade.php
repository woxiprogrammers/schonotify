<div class="form-group">
    <label class="control-label">
        Batch
    </label>
    <select class="form-control" id="Batchdropdown" name="Batchdropdown" style="-webkit-appearance: menulist;">
        <option value="">Select Batch</option>
        @if(!empty($batches))
        @foreach($batches as $batch)
            <option value="{!! $batch->id !!}">{!! $batch->name !!}</option>
            @endforeach
        @endif
    </select>
</div>
<script>
    $(document).ready(function(){
        $('#Batchdropdown').change(function(){
            $('div#loadmoreajaxloader').show();
            var batch=this.value;
            var route='/get-classes-search';
            $.ajax({
                method: "get",
                url: route,
                data: { batch }
            })
                .done(function(res){
                    $('#ClassSearch').html(res);
                    $('div#loadmoreajaxloader').hide();
                })
        })
    })
</script>
