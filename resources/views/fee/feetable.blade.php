<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
    <thead>
    <tr>
        <th width="10%"> No </th>
        <th width="20%"> Fee Name </th>
        <th width="10%"> Total Amount </th>
        <th width="10%">  Year </th>
        <th width="10%"> Late Fee</th>
    </tr>
    </thead>
    <tbody>
    @foreach($fees as $fee)
        <tr>
            <td>{!! $fee['id'] !!}</td>
            <td>{!! $fee['fee_name'] !!}</td>
            <td>{!! $fee['total_amount'] !!}</td>
            <td>{!! $fee['year'] !!}</td>
            <td>{!! $fee['late_fee_per_day'] !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
jQuery(document).ready(function(){
      TableData.init();
  })
</script>
