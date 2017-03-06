<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
    <thead>
    <tr>
        <th width="10%"> Fee No </th>
        <th width="20%"> Fee Name </th>
        <th width="10%"> Total Amount </th>
        <th width="10%">  Year </th>
    </tr>
    </thead>
    <tbody>
    @foreach($fees as $fee)
    <tr>
        <td>{!! $fee->id !!}</td>
        <td>{!! $fee->fee_name !!}</td>
        <td>{!! $fee->total_amount !!}</td>
        <td>{!! $fee->year !!}</td>
    </tr>
    @endforeach
    </tbody>
</table>

<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/vendor/modernizr/modernizr.js"></script>
<script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/vendor/switchery/switchery.min.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="/vendor/select2/select2.min.js"></script>
<script src="/vendor/DataTables/jquery.dataTables.min.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="/assets/js/main.js"></script>
<!-- start: JavaScript Event Handlers for this page -->
<script src="/assets/js/table-data.js"></script>
<script>
    jQuery(document).ready(function()
    {
        Main.init();
        TableData.init();

    })

</script>