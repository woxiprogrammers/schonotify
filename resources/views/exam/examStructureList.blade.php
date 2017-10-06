
<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
    <thead>
    <tr>
        <th width="10%"> Subject </th>
        <th width="10%"> Sub Subject </th>
        <th width="10%">Academic Year </th>
        <th width="5%">Action</th>
    </tr>
    </thead>
    @foreach($structure_lists  as $structure)
        <tbody>
        <td>{!!  $structure['name'] !!}</td>
        <td>{!!  $structure['sub_subject_name'] !!}</td>
        <td>{!!  $structure['start_year'] !!}-{!! $structure['end_year'] !!}</td>
        <td><a href="/exam/edit/{{$structure['id']}}" class="edit-row" id="edit_structure">Edit</a></td>
        </tbody>
    @endforeach
</table>
<script>
    jQuery(document).ready(function(){
        TableData.init();
    })
</script>
