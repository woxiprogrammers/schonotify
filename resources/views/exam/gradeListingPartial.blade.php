
<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
    <thead>
    <tr>
        <th width="10%">Minimum Marks </th>
        <th width="10%"> Maximum Marks</th>
        <th width="10%">Grades </th>
    </tr>
    </thead>
    @foreach($gradeList  as $grade)
        <tbody>
        <td>{!!  $grade['min'] !!}</td>
        <td>{!!  $grade['max'] !!}</td>
        <td>{!!  $grade['grade'] !!}</td>
        </tbody>
    @endforeach
</table>
<script>
    jQuery(document).ready(function(){
        TableData.init();
    })
</script>
